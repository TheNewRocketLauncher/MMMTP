<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nienkhoa_model.php');

global $COURSE;
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT)) {
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nienkhoa/update.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$nienkhoa = get_nienkhoa_byID($id);
$navbar_name = 'Niên khóa';
$title_heading = 'Niên khóa';
if ($founded_id == true) {
    $navbar_name = $nienkhoa->ten_nienkhoa;
    $title_heading = $nienkhoa->ten_nienkhoa;
} else {
    // Something here
}
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật niên khóa ' . $title_heading);
$PAGE->set_heading('Cập nhật niên khóa ' . $title_heading);
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Form
require_once('../../form/nienkhoa/mo_nienkhoa_form.php');
$mform = new mo_nienkhoa_form();

// Form processing
if ($mform->is_cancelled()) {
    // Handle form cancel operation
    // echo '<h2>Hủy cập nhật</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php', ['courseid' => $courseid]);
    // $linktext = get_string('label_nienkhoa', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/nienkhoa/index.php?courseid='.$courseid);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    $param1 = new stdClass();
    $param1->id =  $fromform->idnienkhoa;
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ma_nienkhoa = $mform->get_data()->ma_nienkhoa;
    $param1->ten_nienkhoa = $mform->get_data()->ten_nienkhoa;
    $param1->mota = $mform->get_data()->mota;
    update_nienkhoa($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
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
    //Set default data from DB
    $toform; global $DB;

    $toform->idnienkhoa = $nienkhoa->id;
    $toform->mabac = $nienkhoa->ma_bac;
    $toform->mahe = $nienkhoa->ma_he;
    $toform->ma_nienkhoa = $nienkhoa->ma_nienkhoa;
    $toform->ten_nienkhoa = $nienkhoa->ten_nienkhoa;
    $toform->mota = $nienkhoa->mota;
    $toform->mabac;
    $toform->mahe;
    $bacdt = $DB->get_record('eb_bacdt', ['ma_bac'=> $toform->mabac]);
    $toform->bacdt = $bacdt->ten;
    $hedt = $DB->get_record('eb_hedt', ['ma_he'=> $toform->mahe]);
    $toform->hedt = $hedt->ten;
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();