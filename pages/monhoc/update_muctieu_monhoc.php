<!-- chitiet_monhoc_form -->


<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
// require_once('../../controller/them_decuong_monhoc.controller.php');

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
        $mform1 = $this->_form;
        $mform2 = $this->_form;
        $mform3 = $this->_form;
        $mform4 = $this->_form;
        $mform5 = $this->_form;
        $mform6 = $this->_form;
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
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_decuong', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));
echo $OUTPUT->header();


//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
$id = optional_param('id', 0, PARAM_INT);
require_once('../../form/decuong_monhoc/them_decuong_monhoc_form.php');


$chitietmh = get_muctieu_monmhoc_by_ma_monhoc_1($id);

$mform = new update_muctieu_monhoc_decuong_monhoc_form();

if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();
    
    $param1->id = $mform->get_data()->id;
    $param1->ma_monhoc = $mform->get_data()->ma_monhoc;
    $param1->muctieu = $mform->get_data()->muctieu_muctieu_monhoc;
    $param1->mota = $mform->get_data()->mota_muctieu_muctieu_monhoc;
    $param1->danhsach_cdr = $mform->get_data()->chuan_daura_cdio_muctieu_monhoc;

    update_muctieu_monhoc_table($param1);

    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';

    // $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuong_monhoc.php', ['id'=>$param1->id]);
    // $linktext = get_string('label_monhoc', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    //
} else {
    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->ma_monhoc = $chitietmh->ma_monhoc;
    $toform->muctieu_muctieu_monhoc = $chitietmh->muctieu;
    $toform->mota_muctieu_muctieu_monhoc = $chitietmh->mota;
    $toform->chuan_daura_cdio_muctieu_monhoc = $chitietmh->danhsach_cdr;
    
    $mform->set_data($toform);
    
    
    // displays the form
    $mform->display();
}
 
echo $OUTPUT->footer();
?>
