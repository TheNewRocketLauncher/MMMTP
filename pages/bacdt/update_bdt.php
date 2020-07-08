<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');

global $COURSE;

// Course ID, item ID
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/bacdt/update_bdt.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$bacdt = get_bacdt_byID($id);
$navbar_name = 'Bậc ĐT';
$title_heading = 'ĐT';
if ($founded_id == true) {
    $navbar_name = $bacdt->ten;
    $title_heading = $bacdt->ten;
} else {
    // Do anything here
}

// Navar
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật Bậc ' . $title_heading);
$PAGE->set_heading('Cập nhật Bậc ' . $title_heading);

// Print header
echo $OUTPUT->header();

// Import form
require_once('../../form/bacdt/qlbac_form.php');
$mform = new qlbac_form();

// Process form
if ($mform->is_cancelled()) {
    echo '<h2>Hủy cập nhật</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_bacdt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Insert */
    // $param
    $param1 = new stdClass();
    $param1->id = $fromform->idbac; // The data object must have the property "id" set.
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ten = $mform->get_data()->tenbac;
    $param1->mota = $mform->get_data()->mota;
    
    update_bacdt($param1);

    // Hiển thị thêm thành côngz
    echo '<h2>Cập nhật thành công!</h2>';
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
    /* Default when page loaded*/

    //Set default data from DB
    $toform;
    $toform->idbac = $bacdt->id;
    
    $toform->mabac = $bacdt->ma_bac;
    $toform->tenbac = $bacdt->ten;
    $toform->mota = $bacdt->mota;
    $mform->set_data($toform);

    // Displays form
    $mform->display();
}

// Footer
echo $OUTPUT->footer();