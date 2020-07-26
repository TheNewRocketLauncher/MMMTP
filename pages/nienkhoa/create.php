<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nienkhoa_model.php');
require_once('../../controller/validate.php');

global $COURSE, $DB;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("nienkhoa", "edit");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nienkhoa/create.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_nienkhoa', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php'));

// Title.
$PAGE->set_title(get_string('label_nienkhoa', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_nienkhoa', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Form
require_once('../../form/nienkhoa/mo_nienkhoa_form.php');
$mform = new mo_nienkhoa_form();

// Process form
if ($mform->is_cancelled()) {
    // echo '<h2>Thêm không thành công</h2>';
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/nienkhoa/index.php?courseid='.$courseid);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    $param1 = new stdClass();
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ma_nienkhoa = $mform->get_data()->ma_nienkhoa;
    $param1->ten_nienkhoa = $mform->get_data()->ten_nienkhoa;
    $param1->mota = $mform->get_data()->mota;


    $data = array();
    $data['ma_bac'] = $param1->ma_bac;
    $data['ma_he'] = $param1->ma_he;
    $data['ma_nienkhoa'] = $param1->ma_nienkhoa;

    $arr_data = array();
    $arr_data = $DB->get_records('eb_hedt', []);
    if (is_check($arr_data, $data['ma_bac'], $data['ma_he'], $data['ma_nienkhoa'], '', '') == true) {
        insert_nienkhoa($param1);
        // Hiển thị thêm thành công
        echo '<h2>Thêm mới thành công!</h2>';
        echo '<br>';
    } else {
        echo "<strong>Dữ liệu đã tồn tại</strong>";

        $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/create.php', []);
        echo '<br>';

        $linktext = "Thêm mới khóa tuyển";
        echo \html_writer::link($url, $linktext);
        echo '<br>';
    }
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_nienkhoa', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit
    // echo '<h2>Nhập sai thông tin</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php', ['courseid' => $courseid]);
    // $linktext = get_string('label_nienkhoa', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    $mform->display();
} else {
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();