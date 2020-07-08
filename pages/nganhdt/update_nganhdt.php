<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nganhdt_model.php');

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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nganhdt/update_nganhdt.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$nganhdt = get_nganhdt_byID($id);
$navbar_name = 'Ngành ĐT';
$title_heading = 'ĐT';
if ($founded_id == true) {
    $navbar_name = $nganhdt->ten;
    $title_heading = $nganhdt->ten;
} else {
    // Something here
}
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật ngành ' . $title_heading);
$PAGE->set_heading('Cập nhật ngành ' . $title_heading);
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Form
require_once('../../form/nganhdt/qlnganh_form.php');
$mform = new qlnganh_form();

// Form processing
if ($mform->is_cancelled()) {
    echo '<h2>Hủy cập nhật</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_nganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    // Param
    $param1 = new stdClass();
    $param1->id = $fromform->idnganh; // The data object must have the property "id" set.
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ma_nienkhoa=$mform->get_data()->manienkhoa;
    $param1->ma_nganh = $mform->get_data()->manganh;
    $param1->ten = $mform->get_data()->tennganh;
    $param1->mota = $mform->get_data()->mota;
    update_nganhdt($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
    $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_nganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit
    echo '<h2>Nhập sai thông tin</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_nganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else {
    //Set default data from DB
    $toform;global $DB;
    
    $toform->idnganh = $nganhdt->id;
    $toform->mabac = $nganhdt->ma_bac;
    $toform->mahe = $nganhdt->ma_he;
    $toform->manienkhoa=$nganhdt->ma_nienkhoa;
    $toform->manganh = $nganhdt->ma_nganh;
    $toform->tennganh = $nganhdt->ten;
    $toform->mota = $nganhdt->mota;
    

    $toform->mabac;
    $toform->mahe;
    $toform->manienkhoa;
    
    //echo($toform->mabac);

    $bacdt = $DB->get_record('block_edu_bacdt', ['ma_bac'=> $toform->mabac]);
    $toform->bacdt = $bacdt->ten;
    $hedt = $DB->get_record('block_edu_hedt', ['ma_he'=> $toform->mahe]);
    $toform->hedt = $hedt->ten;
    $nienkhoadt=$DB->get_Record('block_edu_nienkhoa',['ma_nienkhoa'=>$toform->manienkhoa]);
    $toform->nienkhoa=$nienkhoadt->ten_nienkhoa;
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();