<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuyennganhdt_model.php');
require_once('../../js.php');

global $COURSE, $GLOBALS;
var_dump($_REQUEST);
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;
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

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/index.php',  ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_chuyennganh', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_chuyennganh', 'block_educationpgrs') . ' - Course ID: ' . $courseid);
$PAGE->set_heading(get_string('head_chuyenganh', 'block_educationpgrs'));

// Require js_call_amd
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();

$table = get_chuyennganhdt_checkbox($search, $page);

// Search
require_once('../../form/chuyennganhdt/qlchuyennganh_form.php');
$form_search = new chuyennganhdt_search();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->chuyennganhdt_search;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/chuyennganhdt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
    // redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuyennganhdt/index.php?search='.$search.'&amp;page='.$page);
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->chuyennganhdt_search = $search;
    $form_search->set_data($toform);
    // Displays form
    $form_search->display();
}

// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Xóa',
        array('id' => 'btn_delete_chuyennganhdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone',
        array('id' => 'btn_clone_chuyennganhdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_chuyennganhdt', 'onClick' => "window.location.href='add_chuyennganhdt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
        // array('id' => 'btn_add_chuyennganhdt', 'onClick' => "window.location.href='add_chuyennganhdt.php'", 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #1177d1; color:#fff;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

// Insert data if table is empty


// Add new chuyennganhdt
$url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/add_chuyennganhdt.php', []);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
// echo  \html_writer::link($url, $ten_url);
// echo '<br>';
echo '<br>';

// Print table
echo html_writer::table($table);
// Pagination
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_chuyennganhdt_checkbox($search, -1)->data), $page, 5, $baseurl);





echo $OUTPUT->footer();