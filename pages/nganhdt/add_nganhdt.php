<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nganhdt_model.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nganhdt/add_nganhdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_nganh', 'block_educationpgrs'));

// Title.
$PAGE->set_title('Thêm ngành đào tạo ');
$PAGE->set_heading('Thêm mới ngành đào tạo ');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Form
require_once('../../form/nganhdt/qlnganh_form.php');
$mform = new qlnganh_form();

// Form processing
if ($mform->is_cancelled()) {
    // echo '<h2>Thêm không thành công</h2>';
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/nganhdt/index.php?courseid='.$courseid);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    // $param
    $param1 = new stdClass();
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ma_nienkhoa = $mform->get_data()->manienkhoa;
    $param1->ma_nganh = $mform->get_data()->manganh;
    $param1->ten = $mform->get_data()->tennganh;
    $param1->mota = $mform->get_data()->mota;
    insert_nganhdt($param1);
    // Hiển thị thêm thành công
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_nganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit
    // echo '<h2>Nhập sai thông tin</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]);
    // $linktext = get_string('label_nganh', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    $mform->display();
} else {
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();