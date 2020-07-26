<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');

global $COURSE;

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
// Form
require_once('../../form/chuandauractdt/create_cdr_form.php');
$mform = new create_cdr_form();

// Process form
if ($mform->is_cancelled()) {
        redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/index.php');
} else if ($mform->no_submit_button_pressed()) {
    if($mform->get_submit_value('btn_create')){
        
    }
} else if ($data = $mform->get_data()) {

    $param = new stdClass();
    $param->ma_cdr = mt_rand();

    while(exist_ma_cdr($param->ma_cdr)){
        $param->ma_cdr = mt_rand();
    }

    $param->ten = $data->ten;
    $param->ma_loai = $data->ma_loai;
    $param->level = 1;
    $param->mota = $data->mota;

    $id = insert_cdr($param);
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/chuandauractdt/add_cdr.php?id=".$id);
} else if ($mform->is_submitted()) {
    
} else {
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();
