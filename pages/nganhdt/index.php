<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nganhdt_model.php');


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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_nganh', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_nganh', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_nganh', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Create table
$table = get_nganhdt_checkbox($search, $page);

// Search
require_once('../../form/nganhdt/qlnganh_form.php');
$form_search = new nganhdt_search();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->nganhdt_search;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/nganhdt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->nganhdt_search = $search;
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
        array('id' => 'btn_delete_nganhdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone',
        array('id' => 'btn_clone_nganhdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_nganhdt', 'onClick' => "window.location.href='add_nganhdt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

// Insert data if table is empty
if (!$DB->count_records('block_edu_nganhdt', [])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param->id_bac = 1;
    $param1->ma_bac = 'DH';
    $param1->ma_he = 'CQ';
    $param1->ma_nganh = '7480101';
    $param1->ten = 'Khoa học máy tính';
    $param1->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    // $param->id_bac = 2;
    $param2->ma_bac = 'DH';
    $param2->ma_he = 'CQ';
    $param2->ma_nganh = '7480103';
    $param2->ten = 'Kỹ thuật phần mềm';
    $param2->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    // $param->id_bac = 3;
    $param3->ma_bac = 'DH';
    $param3->ma_he = 'CNTN';
    $param3->ma_nganh = '7480104';
    $param3->ten = 'Hệ thống thông tin';
    $param3->mota = 'Đại học,chính quy,niên khóa: 2016 - 2020';
    insert_nganhdt($param1);
    insert_nganhdt($param2);
    insert_nganhdt($param3);
}

// Thêm mới
$url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/add_nganhdt.php', []);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
// echo  \html_writer::link($url, $ten_url);
echo '<br>';


// Print table
echo html_writer::table($table);
// Pagination
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_nganhdt_checkbox($search, -1)->data), $page, 5, $baseurl);



// Footer
echo $OUTPUT->footer();