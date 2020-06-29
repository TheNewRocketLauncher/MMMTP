<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');
require_once('../../js.php');

global $COURSE, $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));

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
$mform->display();

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
    // $mform->set_data($toform);
    $mform->display();
}


//searching
$form_search = new ctdt_seach();


if ($form_search->is_cancelled()) {
    
} else if ($form_search->no_submit_button_pressed()) {
    
} else if ($fromform = $form_search->get_data()) {
    
    $search = $form_search->get_data()->ctdt_content_seach;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/ctdt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
    
} else if ($form_search->is_submitted()) {
    
    $form_search->display();
} else {
    
    $toform;
    $toform->ctdt_content_seach = $search;
    $form_search->set_data($toform);
    
    $form_search->display();
}
///////////////////////////////////////////////////////


// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Xóa ',
        array('id' => 'btn_delete_ctdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone ',
        array('id' => 'btn_clone_ctdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_ctdt', 'onClick' => "window.location.href='newctdt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';

//Danh sách CTĐT
$table = get_ctdt_checkbox($courseid);
echo html_writer::table($table);


// Footer
echo $OUTPUT->footer();