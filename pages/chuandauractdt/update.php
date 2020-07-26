<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');

$id = optional_param('id', NULL, PARAM_NOTAGS);

global $COURSE, $USER;

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/create.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add("Danh sách chuẩn đầu ra chương trình đào tạo", new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php'));
$PAGE->navbar->add('Chỉnh sửa chuẩn đầu ra chương trình đào tạo');
// Title.
$PAGE->set_title('Chỉnh sửa chuẩn đầu ra chương trình đào tạo'  );
$PAGE->set_heading('Chỉnh sửa chuẩn đầu ra chương trình đào tạo'  );
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
// Form
require_once('../../form/chuandauractdt/create_cdr_form.php');
$mform = new create_cdr_form();
require_once('../../controller/auth.php');
require_permission("chuandauractdt", "edit");

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/chuandauractdt/index.php");
} else if ($mform->no_submit_button_pressed()) {
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/chuandauractdt/index.php");
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    $cdr = get_cdr_byID($fromform->id);

    if(can_edit_cdr($cdr->ma_cdr)){
        $cdr->ten = $fromform->ten;
        $cdr->mota = $fromform->mota;
        $cdr->ma_loai = $fromform->ma_loai;
        update_chuandaura_ctdt($cdr);
        
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/chuandauractdt/add_cdr.php?id=" . $cdr->id);
    } else{
        echo '<h2>Cập nhật thất bại vì chuẩn đầu ra đang được sử dụng!</h2>';
        echo '<br>';
        $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php');
        $linktext = 'Danh sách chuẩn đầu ra';
        echo \html_writer::link($url, $linktext);
    }
    
} else {
    if($id != NULL){
        $cdr = get_cdr_byID($id);
    
        $toform = new stdClass();
        $toform->ten = $cdr->ten;
        $toform->mota = $cdr->mota;
        $toform->btn_create = "Cập nhật";
        $toform->ma_loai = $cdr->ma_loai;
        $toform->id = $id;
        $mform->set_data($toform);
        $mform->display();
    }
}

// Footer
echo $OUTPUT->footer();