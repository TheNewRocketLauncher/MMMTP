<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/caykkt_model.php');
require_once('../../model/global_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}
$ma_cay_khoikienthuc = optional_param('ma_cay', 0, PARAM_ALPHANUMEXT);



///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_caykhoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/caykkt/index.php'));
// Title.
$PAGE->set_title('Chi tiết cây');
$PAGE->set_heading('Chi tiết cây');
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

// EXPORT KKT here




$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-center;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Chỉnh sửa',
        array('id' => 'btn_editmode', 'onClick' => "window.location.href='edit_caykkt_ttc.php?ma_cay=$ma_cay_khoikienthuc&edit_mode=1'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-center;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone',
        array('id' => 'btn_clone', 'onClick' => "window.location.href='edit_caykkt_ttc.php?ma_cay=$ma_cay_khoikienthuc'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-center;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Trở về',
        array('id' => 'btn_back', 'onClick' => "window.location.href='index.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>';
echo $action_form;
echo '<br>';








 // Footere
echo $OUTPUT->footer();

///----------------------------------------------------------------------------------------------------------------------///        
/// FUNCTION
