<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');
require_once('../../model/caykkt_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;

$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("caykkt", "edit");




///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/newkkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_caykhoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/caykkt/index.php'));
$PAGE->navbar->add('Thêm cây mới');
// Title.
$PAGE->set_title('Thêm cây mới');
$PAGE->set_heading('Thêm cây mới');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/caykkt/newcaykkt_form.php');

//FORM tạo mới khối kiến thức
$mform = new newcaykkt_form_editable();
if ($mform->is_cancelled()) {
} else if ($mform->no_submit_button_pressed()) {
} else if ($fromform = $mform->get_data()) {
    $caykkt_global = get_newcaykkt_global();
    $caykkt_global['tencay'] = $fromform->txt_tencay;
    $caykkt_global['mota'] = $fromform->txt_mota;
    update_newcaykkt_global($caykkt_global);
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/add_caykkt.php");
} else {
    $toform = new stdClass();
    $data = get_newcaykkt_info();
    $toform->txt_tencay = $data->tencay;
    $toform->txt_mota = $data->mota;
    $mform->set_data($toform);
}
$mform->display();
// Footer
echo $OUTPUT->footer();


///-------------------------------------------------------------------------------------------------------///
//FUNCTION

function get_newcaykkt_info()
{
    global $USER;
    get_adding_list();
    $current_data = get_global($USER->id)['newcaykkt'];
    $result = new stdClass();
    $result->tencay = $current_data['tencay'];
    $result->mota = $current_data['mota'];
    return $result;
}

function get_newcaykkt_global()
{
    global $USER;
    get_adding_list();
    return $current_data = get_global($USER->id)['newcaykkt'];
}

function update_newcaykkt_global($newdata)
{
    global $USER;
    $current_global = get_global($USER->id);
    $current_global['newcaykkt']['tencay'] = $newdata['tencay'];
    $current_global['newcaykkt']['mota'] = $newdata['mota'];
    set_global($USER->id, $current_global);
}

function reset_global()
{
    global $USER;
    $arr = get_global($USER->id);
    $arr['newcaykkt'] = array();
    set_global($USER->id, $arr);
}
