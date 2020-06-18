<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nganhdt_model.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_nganh', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_nganh', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_nganh', 'block_educationpgrs'));

// Require js_call_amd
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Insert data if table is empty
if (!$DB->count_records('block_edu_nganhdt', [])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param->id_bac = 1;
    $param1->ma_bac = 'DH';
    $param1->ma_he = 'CQ';
    $param1->ma_nganh = '7480101';
    $param1->ten = 'Khoa học máy tính';
    $param1->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    // $param->id_bac = 2;
    $param2->ma_bac = 'DH';
    $param2->ma_he = 'CQ';
    $param2->ma_nganh = '7480103';
    $param2->ten = 'Kỹ thuật phần mềm';
    $param2->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    // $param->id_bac = 3;
    $param3->ma_bac = 'DH';
    $param3->ma_he = 'CNTN';
    $param3->ma_nganh = '7480104';
    $param3->ten = 'Hệ thống thông tin';
    $param3->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    insert_nganhdt($param1);
    insert_nganhdt($param2);
    insert_nganhdt($param3);
}

// Thêm mới
$url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/add_nganhdt.php', ['courseid' => $courseid]);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
echo  \html_writer::link($url, $ten_url);
echo '<br><br>';

// Create table
$table = get_nganhdt_checkbox($courseid);
echo html_writer::table($table);

// Xóa ngành ĐT
echo ' ';
echo \html_writer::tag(
    'button',
    'Xóa  ngành DT',
    array('id' => 'btn_delete_nganhdt')
);
echo '<br>';


// Footer
echo $OUTPUT->footer();