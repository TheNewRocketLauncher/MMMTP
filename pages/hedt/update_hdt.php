<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/hedt_model.php');
require_once('../../controller/validate.php');

global $COURSE, $DB;
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT)) {
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("hedt", "edit");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/hedt/update_hdt.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Quản lý hệ đào tạo', new moodle_url('/blocks/educationpgrs/pages/hedt/index.php'));

$hedt = get_hedt_byID($id);
$navbar_name = 'Hệ ĐT';
$title_heading = 'ĐT';
if ($founded_id == true) {
    $navbar_name = $hedt->ten;
    $title_heading = $hedt->ten;
} else {
    // Something here
}
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật Hệ ' . $title_heading);
$PAGE->set_heading('Cập nhật Hệ ' . $title_heading);

// Print header
echo $OUTPUT->header();

// Form
require_once('../../form/hedt/qlhe_form.php');
$mform = new qlhe_form();

// Form processing
if ($mform->is_cancelled()) {
    //Handle form cancel operation
    // echo '<h2>Hủy cập nhật</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
    // $linktext = get_string('label_hedt', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/hedt/index.php?courseid=' . $courseid);
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    // Param
    $param1 = new stdClass();
    $param1->id = $fromform->idhe; // The data object must have the property "id" set.
    $param1->ma_bac = $mform->get_data()->mabac;
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ten = $mform->get_data()->tenhe;
    $param1->mota = $mform->get_data()->mota;

    $data = array();
    $data['ma_bac'] = $param1->ma_bac;
    $data['ma_he'] = $param1->ma_he;
    $arr_data = array();
    $arr_data = $DB->get_records('eb_hedt', []);
    $current_data = $DB->get_record('eb_hedt', ['id' => $param1->id]);
    $check_current_data;
    if ($current_data->ma_bac == $param1->ma_bac && $current_data->ma_he == $param1->ma_he) {
        $check_current_data = 1;
    } else {
        $check_current_data = 0;
    }

    if (is_check($arr_data, $data['ma_bac'],  $data['ma_he'], '', '', '') == true || $check_current_data == 1) {
        update_hedt($param1);
        // Hiển thị thêm thành công
        echo '<h2>Cập nhật thành công!</h2>';
        echo '<br>';
    } else {
        echo "<strong>Dữ liệu đã tồn tại</strong>";
        echo '<br>';
    }




    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
    $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_hedt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Process button submitted
    // echo '<h2>Nhập sai thông tin</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
    // $linktext = get_string('label_hedt', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    $mform->display();
} else {
    //Set default data from DB
    $toform;
    $toform->idhe = $hedt->id;
    $toform->mabac = $hedt->ma_bac;
    $toform->mahe = $hedt->ma_he;
    $toform->tenhe = $hedt->ten;
    $toform->mota = $hedt->mota;
    $toform->mabac;
    $bacdt = $DB->get_record('eb_bacdt', ['ma_bac' => $toform->mabac]);
    $toform->bacdt = $bacdt->ten;
    $mform->set_data($toform);
    $mform->display();
}

// Footer
echo $OUTPUT->footer();