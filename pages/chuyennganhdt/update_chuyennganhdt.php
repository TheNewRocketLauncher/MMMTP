<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuyennganhdt_model.php');

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
    $context = \context_course::instance($courseid);
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/update_chuyennganhdt.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$chuyennganhdt = get_chuyennganhdt_byID($id);
$navbar_name = 'Chuyên ngành ĐT';
$title_heading = 'ĐT';
if ($founded_id == true) {
    $navbar_name = $chuyennganhdt->ten;
    $title_heading = $chuyennganhdt->ten;
} else {
    // Something here
}
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật chuyên ngành ' . $title_heading);
$PAGE->set_heading('Cập nhật chuyên ngành ' . $title_heading);
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Form
require_once('../../form/chuyennganhdt/qlchuyennganh_form.php');
$mform = new qlchuyennganh_form();
// Form processing
if ($mform->is_cancelled()) {
    echo '<h2>Hủy cập nhật</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_chuyennganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */    
    // Param
    $param1 = new stdClass();
    $param1->id = $fromform->idchuyennganh; // The data object must have the property "id" set.
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ma_nienkhoa=$mform->get_data()->manienkhoa;
    $param1->ma_nganh = $mform->get_data()->manganh;
    $param1->ma_chuyennganh = $mform->get_data()->machuyennganh;
    $param1->ten = $mform->get_data()->tenchuyennganh;
    $param1->mota = $mform->get_data()->mota;
    update_chuyennganhdt($param1);
    // Hiển thị thêm thành côngz
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
    $url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_chuyennganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Something here
    echo '<h2>Nhập sai thông tin</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_chuyennganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else {
    //Set default data from DB
    $toform;
    $toform->idchuyennganh = $chuyennganhdt->id;
    $toform->mabac = $chuyennganhdt->ma_bac;
    $toform->mahe = $chuyennganhdt->ma_he;
    $toform->manienkhoa = $chuyennganhdt->ma_nienkhoa;
    $toform->manganh = $chuyennganhdt->ma_nganh;
    $toform->machuyennganh = $chuyennganhdt->ma_chuyennganh;
    $toform->tenchuyennganh = $chuyennganhdt->ten;
    $toform->mota = $chuyennganhdt->mota;

    //echo($toform->manganh);
    $toform->mabac;
    $toform->mahe;
    $toform->manienkhoa;
    $toform->manganh;
    global $DB;

    $bacdt = $DB->get_record('block_edu_bacdt', ['ma_bac'=> $toform->mabac]);
    $toform->bacdt = $bacdt->ten;
    $hedt = $DB->get_record('block_edu_hedt', ['ma_he'=> $toform->mahe]);
    $toform->hedt = $hedt->ten;
    $nienkhoadt=$DB->get_Record('block_edu_nienkhoa',['ma_nienkhoa'=>$toform->manienkhoa]);
    $toform->nienkhoa=$nienkhoadt->ten_nienkhoa;
    $nganhdt = $DB->get_record('block_edu_nganhdt', ['ma_nganh'=> $toform->manganh]);
    $toform->nganhdt = $nganhdt->ten;
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();