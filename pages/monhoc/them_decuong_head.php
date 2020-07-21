<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
//require_once("$CFG->libdir/tcpdf/tcpdf.php");
//require_once('../../js.php');

global $COURSE, $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
// $id = optional_param('id', 0, PARAM_INT);
// $chitietmh = get_monhoc_by_id_monhoc($id);


// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_quanly_decuong', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/decuong/index.php'));
$PAGE->navbar->add('Thêm đề cương môn học');

// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs'));
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');
$chitietmh->mamonhoc = 'csc500';
$a = $chitietmh->mamonhoc;


///==========================================================================
//TUY CHON

$mforms = new tuychon_decuongmonhoc_form();

$madc = $mforms->madc;
echo '<br>';

if ($mforms->is_cancelled()) {
} else if ($mforms->no_submit_button_pressed()) {
    // Button no_submit
    $mforms->display();
} else if ($fromform = $mforms->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $mforms->get_submit_value('tuychon_mon');
    $param2->ma_decuong = $mforms->get_submit_value('madc');
    $param2->ma_ctdt = $mforms->get_submit_value('tuychon_ctdt');
    $param2->mota = $mforms->get_submit_value('mota_decuong');
    
    $mforms->madc_copy = $param2->ma_decuong;
    insert_decuong($param2);
    // $courseid = required_param('courseid', PARAM_INT);
    $url = new moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php', ['ma_ctdt'=>$param2->ma_ctdt, 'mamonhoc'=>$param2->mamonhoc, 'ma_decuong'=>$param2->ma_decuong]);
    redirect($url);
    // $mforms->display();
    
}else if ($mforms->is_submitted()) {
    $mforms->display();
}else {    
    //Set default data from DB
    $mforms->display();
}

echo $OUTPUT->footer();
?>