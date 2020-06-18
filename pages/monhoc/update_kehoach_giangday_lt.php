<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');

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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_decuong', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
$id = optional_param('id', 0, PARAM_INT);
require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');
$chitietmh = get_kehoachgiangday_LT_by_mamonhoc_1($id);
$mform = new update_giangday_LT_decuongmonhoc_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();
    $param1->id = $fromform->id;
    $param1->mamonhoc = $fromform->mamonhoc;
    $param1->ten_chude = $fromform->chudegiangday;
    $param1->danhsach_cdr = $fromform->danhsach_cdr;
    $param1->hoatdong_gopy = $fromform->hoatdong_giangday;
    $param1->hoatdong_danhgia = $fromform->hoatdong_danhgia;
    update_kehoachgiangday_lt_table($param1);
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
} else if ($mform->is_submitted()) {
    // Button sumbit
} else {
    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $toform->chudegiangday = $chitietmh->ten_chude;
    $toform->danhsach_cdr = $chitietmh->danhsach_cdr;
    $toform->hoatdong_giangday = $chitietmh->hoatdong_gopy;
    $toform->hoatdong_danhgia = $chitietmh->hoatdong_danhgia;
    $mform->set_data($toform);
    $mform->display();
}

// Print footer
echo $OUTPUT->footer();