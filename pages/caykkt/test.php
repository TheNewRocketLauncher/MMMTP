<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');
require_once('../../model/caykkt_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;
define("EDIT_MODE_EDIT", 0);
define("EDIT_MODE_CLONE", 1);

$ma_khoi = optional_param('ma_khoi', 0, PARAM_ALPHANUMEXT);
$edit_mode = optional_param('edit_mode', EDIT_MODE_EDIT, PARAM_INT);

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));
$PAGE->navbar->add(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php'));
// Title.
$PAGE->set_title(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

$mform = new test_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/index.php");
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    // Submit form này làm cho page reload nhưng vẫn chạy setDefault ở bên dưới -> Mất sạch toàn bộ form data trước, 
    // Có lẽ data mất mát này được truyền sang page mới dưới dạng $_SESSION hoặc bằng $_POST ?!
    
    $ma_cay = '2caykkt1594176760';
    delete_caykkt_byMaCay($ma_cay);
    $mform->display();
} else {
    $mform->display();
}

 // Footer
echo $OUTPUT->footer();

///----------------------------------------------------------------------------------------------------------------------///        
/// FUNCTION
