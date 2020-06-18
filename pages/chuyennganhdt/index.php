<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuyennganhdt_model.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_chuyennganh', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_chuyennganh', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_chuyenganh', 'block_educationpgrs'));

// Require js_call_amd
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();

// Insert data if table is empty
if (!$DB->count_records('block_edu_chuyennganhdt', [])) {
    // Param 1&2
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param1->ten = 'Công nghệ tri thức';
    $param1->mota = 'Ngành khoa học máy tính,Hệ chính quy,Bậc đại học,khóa 2016';
    $param2->ten = 'Thị giác máy tính và khoa học Rô Bốt';
    $param2->mota = 'Ngành khoa học máy tính,Hệ chính quy,Bậc đại học,khóa 2016';
    // Insert   
    insert_chuyennganhdt($param1);
    insert_chuyennganhdt($param2);
}

// Thêm mới
$url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/add_chuyennganhdt.php', ['courseid' => $courseid]);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
echo  \html_writer::link($url, $ten_url);
echo '<br>';
echo '<br>';

// Create table
$table = get_chuyennganhdt_checkbox($courseid);
echo html_writer::table($table);

// Xóa
echo ' ';
echo \html_writer::tag(
    'button',
    'Xóa CNDT',
    array('id' => 'btn_delete_chuyennganhdt')
);
echo '<br>';

// Footer
echo $OUTPUT->footer();