<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');
require_once('../../js.php');

global $COURSE, $USER;

$id = optional_param('id', NULL, PARAM_INT);

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/create.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add("Danh sách chuẩn đầu ra chương trình đào tạo", new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php'));
$PAGE->navbar->add('Thêm chuẩn đầu ra chương trình đào tạo');
// Title.
$PAGE->set_title('Thêm chuẩn đầu ra chương trình đào tạo'  );
$PAGE->set_heading('Thêm chuẩn đầu ra chương trình đào tạo'  );
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();
require_once('../../controller/auth.php');
require_permission("chuandauractdt", "edit");
///-------------------------------------------------------------------------------------------------------///
// Form
require_once('../../form/chuandauractdt/add_chuandaura_form.php');
$mform = new add_cdr_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/index.php');
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    
} else {
    if($id != NULL){
        $cdr = $DB->get_record('eb_chuandaura_ctdt', ['id' => $id]);
        $defaultData->txt_ten_cdr = $cdr->ten;
        $defaultData->cdr = $cdr->id;
        $defaultData->loai_cdr = $cdr->ma_loai;
        $mform->set_data($defaultData);
    } else{
        redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/index.php');
    }
    $mform->display();
}

print_review_cdr($id);

// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-start;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Xoá chuẩn đầu ra được chọn',
        array('id' => 'btn_del_node_cdr', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #fa4b1b; color:#fff;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';


// Footer
echo $OUTPUT->footer();


function print_review_cdr($id){
    global $DB;
    $cdr = $DB->get_record('eb_chuandaura_ctdt', ['id' => $id]);
    $list_cdr_lv1 = $DB->get_records('eb_chuandaura_ctdt', ['ma_cdr_cha' => $cdr->ma_cdr]);

    $table = new html_table();
    $table->head = array('', 'Tên');

    foreach($list_cdr_lv1 as $ilv1){
        $checkbox = html_writer::tag(
            'input', ' ', array('class' => 'cdr_checkbox', 'type' => "checkbox",
            'name' => $ilv1->id, 'id' => 'bdt' . $ilv1->id, 'value' => '0', 'onclick' => "changecheck($ilv1->id)"));

        $table->data[] = [$checkbox, (string) $ilv1->ten];
    }

    echo html_writer::table($table);
}