<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');

global $DB, $USER, $CFG, $COURSE;

$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT))
{
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid); 
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/chitiet_khoikienthuc.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));

$kkt = get_kkt_byID($id);
$navbar_name = 'Khối kiến thức';
$title_heading = 'Khối kiến thức';
if ($founded_id == true) {
    $navbar_name = $kkt->ma_khoi;
    $title_heading = $kkt->ma_khoi;
} else {
    // Do anything here
}
$PAGE->navbar->add($navbar_name);

$PAGE->set_title("Chi tiết khối kiến thức" );
$PAGE->set_heading("Chi tiết khối kiến thức");
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
$table2 = get_monhoc_by_kkt($kkt->ma_khoi);
echo html_writer::table($table2);
echo '  ';


$table = get_caykkt_by_kkt($kkt->ma_khoi);
 
echo html_writer::table($table);
echo '  ';

 // Footere
echo $OUTPUT->footer();


?>
