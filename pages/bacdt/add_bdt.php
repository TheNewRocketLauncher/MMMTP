<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');

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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/bacdt/add_bdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_bacdt', 'block_educationpgrs'));

// Title.
$PAGE->set_title('Thêm Bậc đào tạo ');
$PAGE->set_heading('Thêm mới Bậc đào tạo ');

// Print header
echo $OUTPUT->header();

// Import form
require_once('../../form/bacdt/qlbac_form.php');
$mform = new qlbac_form();

// Process form
if ($mform->is_cancelled()) {
    echo '<h2>Thêm không thành công</h2>';
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Insert */

    // $param
    $param1 = new stdClass();
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ten = $mform->get_data()->tenbac;
    $param1->mota = $mform->get_data()->mota;
    insert_bacdt($param1);

    // Hiển thị thêm thành công
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';

    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_bacdt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Process button submitted
    echo '<h2>Nhập sai thông tin</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_bacdt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else {
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();
