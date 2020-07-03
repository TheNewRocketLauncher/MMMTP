<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/hedt_model.php');
require_once('../../js.php');

global $COURSE, $GLOBALS;
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/hedt/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_hedt', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_hedt', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_hedt', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Create table
$table = get_hedt_checkbox($search, $page);

// Search
require_once('../../form/hedt/qlhe_form.php');
$form_search = new hedt_seach();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->hedt_seach;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/hedt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->hedt_seach = $search;
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
        'Xóa HDT',
        array('id' => 'btn_delete_hedt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone HDT',
        array('id' => 'btn_clone_hedt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_hedt', 'onClick' => "window.location.href='add_hdt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

// Insert data if table is empty
if (!$DB->count_records('block_edu_hedt', [])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param->id_he = 1;
    $param1->ma_bac = 'DH';
    $param1->ma_he = 'DHCQ';
    $param1->ten = 'Đại học - Chính quy';
    $param1->mota = 'Bậc Đại học - Hệ Chính quy HCMUS';
    // $param
    $param2->ma_bac = 'DH';
    $param2->ma_he = 'DHCNTT';
    $param2->ten = 'Đại học - Cử nhân tài năng';
    $param2->mota = 'Bậc Đại học - Hệ Cử nhân tài năng HCMUS';
    // $param
    $param3->ma_bac = 'DH';
    $param3->ma_he = 'DHTC';
    $param3->ten = 'Đại học - Tại chức';
    $param3->mota = 'Bậc Đại học - Hệ Tại Chức HCMUS';
    insert_hedt($param1);
    insert_hedt($param2);
    insert_hedt($param3);
}

// Print table
echo html_writer::table($table);

// Pagination
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_hedt_checkbox($search, -1)->data), $page, 5, $baseurl);

// Footer
echo $OUTPUT->footer();
