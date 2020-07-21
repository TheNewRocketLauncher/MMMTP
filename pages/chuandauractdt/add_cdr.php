<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');

global $COURSE, $USER;

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
    $param = new stdClass();
    $param->ten = $fromform->txt_ten;
    $param->mota = $fromform->mota;
    $param->level_cdr = 0;
    $param->is_used = 0;
    $param->ma_cdr = NULL;
    $param->ma_cay_cdr = $USER->id . time();
    
    while(get_chuandaura_ctdt_byMaCayCDR($param->ma_cay_cdr) != NULL){
        $param->ma_cay_cdr++;
    }
    insert_cdr($param);
    
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/chitiet_cdr.php?ma_cay_cdr=' .$param->ma_cay_cdr);
    $linktext = 'Tiếp tục thêm node con';
    echo \html_writer::link($url, $linktext);
} else {
    $mform->display();
}

// Footer
echo $OUTPUT->footer();