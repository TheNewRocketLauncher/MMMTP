<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../js.php');
// require_once('../factory.php');

// Create button with method post
function button_method_post($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "post"))
    .html_writer::tag('input', ' ', array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}

// Create button with method get
function button_method_get($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "get"))
    .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}

global $USER;

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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/block_edu.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));
// Title.
$PAGE->set_title(get_string('label_khoikienthuc', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('label_khoikienthuc', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/newkkt', 'init');
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/index_form.php');

$mform = new index_form();
//$mform->setDefault('hiddenID', $this->_customdata[0]);

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    
} else if ($mform->no_submit_button_pressed()) {
    if ($mform->get_submit_value('newkkt')) {
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/newkkt.php");
    }

} else if ($fromform = $mform->get_data()) {

} else if ($mform->is_submitted()) {

} else {
    $mform->set_data($toform);
    $mform->display();
}


//Table
$table = get_kkt_checkbox($courseid);
 
echo html_writer::table($table);

echo '  ';
echo \html_writer::tag(
    'button',
    'Xóa kkt',
    array('id' => 'btn_delete_kkt'));

echo '<br>';
///END Table

 // Footere
echo $OUTPUT->footer();


?>
