<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');
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
$PAGE->set_title(get_string('label_ctdt', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('label_ctdt', 'block_educationpgrs'));
echo $OUTPUT->header();



///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/ctdt/index_form.php');

$customdata = array('hiddenID' => substr($hiddenID, 2));
//$form = new viewlpstudent_form(null, $customdata);

$mform = new index_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($mform->no_submit_button_pressed()) {
    if ($mform->get_submit_value('newctdt')) {
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/newctdt.php");        
    }    

    $mform->display();

} else if ($fromform = $mform->get_data()) {    

} else if ($mform->is_submitted()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    
    
    

} else {

    $listctdt = get_ctdt_byID(1);
    if(empty($listctdt)){
        echo 'empty';
    }
    echo $listctdt->ma_bac;

    $toform = array(
        txt_bac => $listctdt->ma_bac
    );

    $mform->set_data($toform);
    // displays the form
    $mform->display();
}


// $btnurl = new \moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php', ['courseid' => $courseid]);
// $btnlbl = get_string('themctdt_head', 'block_educationpgrs');
// echo $OUTPUT->single_button($btnurl, $btnlbl, $get);

 // Footere
echo $OUTPUT->footer();


?>
