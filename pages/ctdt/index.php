<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');
require_once('../../js.php');

global $COURSE, $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/ctdt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/index.php'));

// Title.
$PAGE->set_title(get_string('label_ctdt', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('label_ctdt', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/ctdt/index_form.php');
$customdata = array('hiddenID' => substr($hiddenID, 2));
$mform = new index_form();

// Form processing
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if ($mform->no_submit_button_pressed()) {
    if ($mform->get_submit_value('newctdt')) {
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/newctdt.php");
    }
    $mform->display();
} else if ($fromform = $mform->get_data()) {
} else if ($mform->is_submitted()) {
    // Button submit
} else {
    $mform->set_data($toform);
    $mform->display();
}

////////////End form
$table = get_ctdt_checkbox($courseid);
echo html_writer::table($table);
echo ' ';
echo \html_writer::tag(
    'button',
    'Xóa ctđt',
    array('id' => 'btn_delete_ctdt')
);
echo '<br>';

// Footer
echo $OUTPUT->footer();