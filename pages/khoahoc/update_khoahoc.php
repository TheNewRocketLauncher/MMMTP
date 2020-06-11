<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoahoc_model.php');
// require_once('../factory.php');

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

// Định dang courseid, item_id
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoahoc/update_khoahoc.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$khoahoc = get_khoahoc_byID($id);
$navbar_name = 'Khóa học';
$title_heading = 'Khóa học';
if($founded_id == true)
{
    $navbar_name = $khoahoc->ten_khoahoc;
    $title_heading = $khoahoc->ten_khoahoc;
}
else
{
    //
}
$PAGE->navbar->add($navbar_name);
// Title.
$PAGE->set_title('Cập nhật khóa học ' . $title_heading);
$PAGE->set_heading('Cập nhật khóa học ' . $title_heading);
echo $OUTPUT->header();

 // Form
 require_once('../../form/khoahoc/mo_khoahoc_form.php');
 $mform = new mo_khoahoc_form();
 //Form processing and displaying is done here
 if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    // Thực hiện insert
    $param1 = new stdClass();
    
    $param1->id =  $mform->get_data()->id;
    $param1->id_monhoc = $mform->get_data()->id_monhoc;
    $param1->ten_khoahoc = $mform->get_data()->ten_khoahoc;
    $param1->giaovien_phutrach = $mform->get_data()->giaovien_phutrach;
    $param1->mota = $mform->get_data()->mota;



    update_khoahoc($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    //edit file index.php tương ứng trong thư mục page. trỏ đến đường dẫn chứa file đó
    $url = new \moodle_url('/blocks/educationpgrs/pages/khoahoc/danhsach_khoahoc.php', ['courseid' => $courseid]);
    $linktext = get_string('label_khoahoc', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    // $mform->display();


} else if ($mform->is_submitted()) {
    //
} else {
    //Set default data from DB
    $toform;
    $toform->id = $khoahoc->id;
    $toform->id_monhoc = $khoahoc->id_monhoc;
    $toform->ten_khoahoc = $khoahoc->ten_khoahoc;
    $toform->giaovien_phutrach = $khoahoc->giaovien_phutrach;
    $toform->mota = $khoahoc->mota;
    $mform->set_data($toform);


    $mform->display();
}

 // Footere
echo $OUTPUT->footer();


    // ?>
