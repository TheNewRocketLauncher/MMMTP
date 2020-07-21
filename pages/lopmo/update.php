<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');

// Create button with method post
function button_method_post($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "post"))
    .html_writer::tag('input', ' ', array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}

// Create button with method get
function button_method_get($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "get"))
    .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}
class simplehtml_form extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;
        $mform->addElement('html', '        


        ');
    }
    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}

global $COURSE;
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT))
{
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
// $courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;

// Force user login in course (SITE or Course).
// if ($courseid == SITEID) {
//     require_login();
//     $context = \context_system::instance();
// } else {
//     require_login($courseid);
//     $context = \context_course::instance($courseid); // Create instance base on $courseid
// }

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/lopmo/update.php', [ 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->navbar->add("Danh sách lớp mở", new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php'));

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
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
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();

 // Form
 require_once('../../form/lopmo/mo_lopmo_form.php');
 $mform = new mo_lopmo_form();
 //Form processing and displaying is done here
 if ($mform->is_cancelled()) {
    // echo '<h2>Hủy cập nhật</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    // $linktext = get_string('label_lopmo', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/lopmo/index.php');
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
    
    // echo '<h2>Nhập sai thông tin</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    // $linktext = get_string('label_lopmo', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    $mform->display();
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
    $toform->idlopmo = $lopmo->id;
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

