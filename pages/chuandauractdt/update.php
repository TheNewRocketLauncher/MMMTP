<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');

$ma_cay_cdr = optional_param('ma_cay_cdr', NULL, PARAM_NOTAGS);

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
$PAGE->set_heading('Chỉnh sửa đầu ra chương trình đào tạo'  );
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
// Form
require_once('../../form/chuandauractdt/add_chuandaura_form.php');
$mform = new add_cdr_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    
    if(can_edit_cdr($fromform->ma_cay_cdr)){
        $param = get_chuandaura_ctdt_byMaCayCDR($fromform->ma_cay_cdr);
        $param->ten = $fromform->txt_ten;
        $param->mota = $fromform->mota;
        update_chuandaura_ctdt($param);
        
        echo '<h2>Cập nhật thành công!</h2>';
        echo '<br>';
        $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php');
        $linktext = 'Danh sách chuẩn đầu ra';
        echo \html_writer::link($url, $linktext);
    } else{
        echo '<h2>Cập nhật thất bại vì chuẩn đầu ra đang được sử dụng!</h2>';
        echo '<br>';
        $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php');
        $linktext = 'Danh sách chuẩn đầu ra';
        echo \html_writer::link($url, $linktext);
    }
    
} else {
    if($ma_cay_cdr != NULL){
        $cdr = get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr);
    
        $toform = new stdClass();
        $toform->txt_ten = $cdr->ten;
        $toform->mota = $cdr->mota;
        $toform->submitbutton = "Cập nhật";
        $toform->ma_cay_cdr = $ma_cay_cdr;
        $mform->set_data($toform);
        $mform->display();
    }
}

// Footer
echo $OUTPUT->footer();