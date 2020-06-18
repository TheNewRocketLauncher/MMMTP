<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/hedt_model.php');
require_once('../../js.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_hedt', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_hedt', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_hedt', 'block_educationpgrs'));

// Require js_call_amd
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Insert data if table is empty
if (!$DB->count_records('block_edu_hedt', [])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param->id_he = 1;
    $param1->ma_bac = 'DH';
    $param1->ma_he = 'DHCQ';
    $param1->ten = 'Đại học - Chính quy';
    $param1->mota = 'Bậc Đại học - Hệ Chính quy HCMUS';
    // $param
    $param2->ma_bac = 'DH';
    $param2->ma_he = 'DHCNTT';
    $param2->ten = 'Đại học - Cử nhân tài năng';
    $param2->mota = 'Bậc Đại học - Hệ Cử nhân tài năng HCMUS';
    // $param
    $param3->ma_bac = 'DH';
    $param3->ma_he = 'DHTC';
    $param3->ten = 'Đại học - Tại chức';
    $param3->mota = 'Bậc Đại học - Hệ Tại Chức HCMUS';
    insert_hedt($param1);
    insert_hedt($param2);
    insert_hedt($param3);
}

// Thêm mới
$url = new \moodle_url('/blocks/educationpgrs/pages/hedt/add_hdt.php', ['courseid' => $courseid]);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
echo  \html_writer::link($url, $ten_url);
echo '<br><br>';

// Create table
$table = get_hedt_checkbox($courseid);
echo html_writer::table($table);

// Button xóa
echo ' ';
echo \html_writer::tag(
    'button',
    'Xóa BDT',
    array('id' => 'btn_delete_hedt')
);
echo '<br>';

// Footer
echo $OUTPUT->footer();