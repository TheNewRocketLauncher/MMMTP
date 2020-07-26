<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');
require_once('../../controller/validate.php');

global $COURSE, $DB;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("bacdt","edit");

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/bacdt/add_bdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Quản lý bậc đào tạo', new moodle_url('/blocks/educationpgrs/pages/bacdt/index.php'));

// Title.
$PAGE->set_title('Thêm Bậc đào tạo ');
$PAGE->set_heading('Thêm mới Bậc đào tạo ');

// Print header
echo $OUTPUT->header();

// Import form
require_once('../../form/bacdt/qlbac_form.php');
$mform = new qlbac_form();

// Process form
if ($mform->is_cancelled()) {
    // echo '<h2>Thêm không thành công</h2>';
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/bacdt/index.php?courseid='.$courseid);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Insert */

    // $param
    $param1 = new stdClass();
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ten = $mform->get_data()->tenbac;
    $param1->mota = $mform->get_data()->mota;

    $data = array();
    $data['ma_bac'] = $param1->ma_bac;
    $arr_bacdt = array();
    $arr_bacdt = $DB->get_records('eb_bacdt', []);
    if (is_check($arr_bacdt, $data['ma_bac'], '', '', '', '') == true) {
        insert_bacdt($param1);

        // Hiển thị thêm thành công
        echo '<h2>Thêm mới thành công!</h2>';
        echo '<br>';
    } else {
        echo "<strong>Dữ liệu đã tồn tại</strong>";

        $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/add_bdt.php', []);
        echo '<br>';

        $linktext = "Thêm mới bậc đào tạo";
        echo \html_writer::link($url, $linktext);
        echo '<br>';
    }
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_bacdt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Process button submitted
    // echo '<h2>Nhập sai thông tin</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['courseid' => $courseid]);
    // $linktext = get_string('label_bacdt', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    $mform->display();
} else {
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();
