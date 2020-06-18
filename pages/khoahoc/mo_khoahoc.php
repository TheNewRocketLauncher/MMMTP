<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
require_once('../../model/khoahoc_model.php');

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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoahoc/mo_khoahoc.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_mokhoahoc', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_mokhoahoc', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_mokhoahoc', 'block_educationpgrs'));

// Print header.
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoahoc/mo_khoahoc_form.php');
$mform = new mo_khoahoc_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    // Param
    $param1 = new stdClass();
    $param1->id_monhoc = $mform->get_data()->id_monhoc;
    $param1->ten_khoahoc = $mform->get_data()->ten_khoahoc;
    $param1->giaovien_phutrach = $mform->get_data()->giaovien_phutrach;
    $param1->mota = $mform->get_data()->mota;
    insert_khoahoc($param1);
    // Hiển thị thêm thành công
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/khoahoc/danhsach_khoahoc.php', ['courseid' => $courseid]);
    $linktext = get_string('label_khoahoc', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Something here
} else {
    // Set default data
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();