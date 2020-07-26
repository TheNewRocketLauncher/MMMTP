<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("monhoc", "edit");

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/monhoc/them_monhoc.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Quản lý thông tin');

// Title.
$PAGE->set_title('Thêm môn học');
$PAGE->set_heading('Thêm môn học mới');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/decuongmonhoc/them_monhoc_form.php');
$mform = new them_monhoc_form();

// Process form
if ($mform->is_cancelled()) {
    // echo '<h2>Thêm không thành công</h2>';
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php?courseid='.$courseid);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();
    $param1->mamonhoc = $mform->get_data()->mamonhoc1;
    $param1->tenmonhoc_vi = $mform->get_data()->tenmonhoc_vi;
    $param1->tenmonhoc_en = $mform->get_data()->tenmonhoc_en;
    $param1->loaihocphan = $mform->get_data()->loaihocphan;
    $param1->sotinchi = $mform->get_data()->sotinchi;
    $param1->sotietlythuyet = $mform->get_data()->sotiet_LT;
    $param1->sotietthuchanh = $mform->get_data()->sotiet_TH;
    $param1->sotiet_baitap = $mform->get_data()->sotiet_BT;
    $param1->ghichu = $mform->get_data()->ghichu;
    $param1->mota = $mform->get_data()->mota;


    $sotiet_TH = is_numeric($param1->sotietthuchanh);
    $sotiet_LT = is_numeric($param1->sotietlythuyet);
    $sotinchi = is_numeric($param1->sotinchi);
    $sotiet_BT = is_numeric($param1->sotiet_baitap);
    if ($sotiet_TH == 1 && $sotiet_LT == 1 && $sotinchi == 1 && $sotiet_BT == 1) {
        insert_monhoc_table($param1);
        echo '<h2>Thêm môn học thành công!</h2>';
        echo '<br>';
    } else {
        echo "<h2 style ='color:red;' ><b>Thêm mới thất bại! </b></h2>";
        echo '<br>';
        echo 'Số tín chỉ phải là số';
        echo '<br>';
        echo 'Số tiết lý thuyết phải là số';
        echo '<br>';
        echo 'Số tiết thực hành phải là số';
        echo '<br>';
        echo 'Số tiêt bài tập phải là số';
        echo '<br>';
    }
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php', ['courseid' => $courseid]);
    $linktext = get_string('label_monhoc', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    $mform->display();
} else {
    $mform->set_data($toform);
    $mform->display();
}

// Print footer
echo $OUTPUT->footer();