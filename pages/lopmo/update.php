<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');

global $COURSE;
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT))
{
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/lopmo/update.php', [ 'courseid' => $courseid,'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// $PAGE->navbar->add("Danh sách lớp mở", new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php'));

// Navbar.
$lopmo = get_lopmo_byID($id);
$ctdt = get_ctdt_by_mactdt($lopmo->ma_ctdt);


$navbar_name = 'Khóa học';
$title_heading = 'Khóa học';
if($founded_id == true)
{
    $navbar_name = $lopmo->full_name;
    $title_heading = $lopmo->full_name;
}
else
{
    //
}
$PAGE->navbar->add($navbar_name);
// Title.
$PAGE->set_title('Cập nhật khóa học ' . $title_heading);
$PAGE->set_heading('Cập nhật khóa học ' . $title_heading);
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();

 // Form
 require_once('../../form/lopmo/mo_lopmo_form.php');
 $mform = new mo_lopmo_form();
 //Form processing and displaying is done here
 if ($mform->is_cancelled()) {
    echo '<h2>Hủy cập nhật</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    $linktext = get_string('label_lopmo', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    // Thực hiện insert
    $param1 = new stdClass();
    
    $param1->id = $fromform->idlopmo;
    $param1->ma_ctdt = $fromform->ma_ctdt;
    $param1->mamonhoc = $fromform->mamonhoc;
    $param1->full_name = $fromform->fullname;
    $param1->short_name = $fromform->shortname;
    $param1->start_date = $fromform->sta_date;
    $param1->end_date = $fromform->end_date;
    $param1->assign_to = $fromform->assign_to;
    $param1->mota = $fromform->mota;
    update_lopmo($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    //edit file index.php tương ứng trong thư mục page. trỏ đến đường dẫn chứa file đó
    $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    $linktext = get_string('label_lopmo', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    // $mform->display();


} else if ($mform->is_submitted()) {
    //
    echo '<h2>Nhập sai thông tin</h2>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    $linktext = get_string('label_lopmo', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else {
    //Set default data from DB
    //get cho form disabled get từ ctdt
    $toform->bacdt = $ctdt[0];
    $toform->hedt = $ctdt[1];
    $toform->nienkhoa = $ctdt[2];
    $toform->nganh = $ctdt[3];
    $toform->chuyennganh = $ctdt[4];
    $toform->mota_ctdt = $ctdt[5];


    //get cho form khóa học
    $toform->id = $lopmo->id;
    $toform->ma_ctdt = $lopmo->ma_ctdt;
    $toform->mamonhoc = $lopmo->mamonhoc;
    $toform->fullname = $lopmo->full_name;
    $toform->shortname = $lopmo->short_name;
    $toform->start_date = $lopmo->sta_date;
    $toform->end_date = $lopmo->end_date;
    $toform->assign_to = $lopmo->assign_to;
    $toform->mota = $lopmo->mota;
    $mform->set_data($toform);
        


    $mform->display();
    
}

 // Footere
echo $OUTPUT->footer();


    // ?>
