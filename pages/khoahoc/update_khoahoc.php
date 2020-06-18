<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoahoc_model.php');

global $COURSE;
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT)) {
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoahoc/update_khoahoc.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$khoahoc = get_khoahoc_byID($id);
$navbar_name = 'Khóa học';
$title_heading = 'Khóa học';
if ($founded_id == true) {
    $navbar_name = $khoahoc->ten_khoahoc;
    $title_heading = $khoahoc->ten_khoahoc;
} else {
    // Something here
}
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật khóa học ' . $title_heading);
$PAGE->set_heading('Cập nhật khóa học ' . $title_heading);
echo $OUTPUT->header();

// Form
require_once('../../form/khoahoc/mo_khoahoc_form.php');
$mform = new mo_khoahoc_form();

// Form processing
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    // Param
    $param1 = new stdClass();
    $param1->id =  $mform->get_data()->id;
    $param1->id_monhoc = $mform->get_data()->id_monhoc;
    $param1->ten_khoahoc = $mform->get_data()->ten_khoahoc;
    $param1->giaovien_phutrach = $mform->get_data()->giaovien_phutrach;
    $param1->mota = $mform->get_data()->mota;
    update_khoahoc($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
    $url = new \moodle_url('/blocks/educationpgrs/pages/khoahoc/danhsach_khoahoc.php', ['courseid' => $courseid]);
    $linktext = get_string('label_khoahoc', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit
} else {
    //Set default data from DB
    $toform;
    $toform->id = $khoahoc->id;
    $toform->id_monhoc = $khoahoc->id_monhoc;
    $toform->ten_khoahoc = $khoahoc->ten_khoahoc;
    $toform->giaovien_phutrach = $khoahoc->giaovien_phutrach;
    $toform->mota = $khoahoc->mota;
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();