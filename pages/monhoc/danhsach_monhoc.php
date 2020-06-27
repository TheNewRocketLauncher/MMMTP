<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');

global $COURSE;
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

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_monhoc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php'));

// Title.
$PAGE->set_title(get_string('label_monhoc', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_monhoc', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');

//searching
$form_search = new monhoc_seach();


if ($form_search->is_cancelled()) {
    
} else if ($form_search->no_submit_button_pressed()) {
    
} else if ($fromform = $form_search->get_data()) {
    
    $search = $form_search->get_data()->monhoc_content_seach;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
    
} else if ($form_search->is_submitted()) {
    
    $form_search->display();
} else {
    
    $toform;
    $toform->monhoc_content_seach = $search;
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
        'Xóa',
        array('id' => 'btn_delete_monhoc', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone BDT',
        array('id' => 'btn_clone_monhoc', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_them_monhoc', 'onClick' => "window.location.href='them_monhoc.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';


// // Thêm môn học
// $url = new \moodle_url('them_monhoc.php', []);
// echo \html_writer::link($url, 'Thêm môn học');
// echo '<br>';

// Print table
$table = get_monhoc_table($search, $page);
echo html_writer::table($table);

// // Button xóa môn học
// echo ' ';
// echo \html_writer::tag(
//     'button',
//     'Xóa môn học',
//     array('id' => 'btn_delete_monhoc')
// );
// echo '<br>';

$baseurl = new \moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_monhoc_table($search, -1)->data), $page, 5, $baseurl);


// Footer
echo $OUTPUT->footer();