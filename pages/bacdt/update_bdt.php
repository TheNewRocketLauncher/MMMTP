<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');
require_once('../../controller/validate.php');
global $COURSE, $DB;

// Course ID, item ID
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT)) {
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("bacdt", "edit");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/bacdt/update_bdt.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Quản lý bậc đào tạo', new moodle_url('/blocks/educationpgrs/pages/bacdt/index.php'));
$bacdt = get_bacdt_byID($id);
$navbar_name = 'Bậc ĐT';
$title_heading = 'ĐT';
if ($founded_id == true) {
    $navbar_name = $bacdt->ten;
    $title_heading = $bacdt->ten;
} else {
    // Do anything here
}

// Navar
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật Bậc ' . $title_heading);
$PAGE->set_heading('Cập nhật Bậc ' . $title_heading);

// Print header
echo $OUTPUT->header();

// Import form
require_once('../../form/bacdt/qlbac_form.php');
$mform = new qlbac_form();

// Process form
if ($mform->is_cancelled()) {
    // echo '<h2>Hủy cập nhật</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['courseid' => $courseid]);
    // $linktext = get_string('label_bacdt', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/bacdt/index.php?courseid='.$courseid);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Insert */
    // $param
    $param1 = new stdClass();
    $param1->id = $fromform->idbac; // The data object must have the property "id" set.
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ten = $mform->get_data()->tenbac;
    $param1->mota = $mform->get_data()->mota;

    $data = array();
    $data['ma_bac'] = $param1->ma_bac;
    $arr_bacdt = array();
    $arr_bacdt = $DB->get_records('eb_bacdt', []);

    $current_bacdt = $DB->get_record('eb_bacdt', ['id' => $param1->id]);

    $check_current_bacdt;
    if ($current_bacdt->ma_bac == $param1->ma_bac) {
        $check_current_bacdt = 1;
    } else {
        $check_current_bacdt = 0;
    }

    if (is_check($arr_bacdt, $data['ma_bac'], '', '', '', '') == true || $check_current_bacdt == 1) {
        update_bacdt($param1);
        // Hiển thị cập nhật thành công
        echo '<h2>Cập nhật thành công!</h2>';
        echo '<br>';
    } else {
        echo "<strong>Dữ liệu đã tồn tại</strong>";
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
    /* Default when page loaded*/

    //Set default data from DB
    $toform;
    $toform->idbac = $bacdt->id;
    
    $toform->mabac = $bacdt->ma_bac;
    $toform->tenbac = $bacdt->ten;
    $toform->mota = $bacdt->mota;
    $mform->set_data($toform);

    // Displays form
    $mform->display();
}

// Footer
echo $OUTPUT->footer();