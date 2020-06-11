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

$id = optional_param('id', 0, PARAM_INT);
$chitietmh = get_monhoc_by_id_monhoc($id);

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
$PAGE->navbar->add(get_string('label_monhoc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php'));
$PAGE->navbar->add($chitietmh->ten_monhoc_vi, new moodle_url('/blocks/educationpgrs/pages/monhoc/chitiet_monhoc.php?id='.$chitietmh->id));
$PAGE->navbar->add('Cập nhật', new moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php?id='.$chitietmh->id));
// Title.
$PAGE->set_title('Cập nhật môn học');
$PAGE->set_heading('[' . $chitietmh->ma_monhoc . ']' . $chitietmh->ten_monhoc_vi);
echo $OUTPUT->header();


//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM

require_once('../../form/decuong_monhoc/update_monhoc_form.php');
//get ma_monhoc truoc
// $btn_them_decuong = html_writer::tag('button','Thêm đề cương môn học', array('onClick' => "window.location.href='them_decuong_monhoc.php?id = $id'"));
// echo $btn_them_decuong;

$url = new \moodle_url('them_decuong_monhoc.php', ['id' => $id]);
echo \html_writer::link($url, 'Thêm đề cương môn học');

// $btn_them_decuong = button_method_get('btn_them_decuong', '');


echo html_writer::tag( 'button', 'Xóa đề cương môn học', array('id' => 'btn_delete_decuong'));

echo '<br>';





$mform = new update_monhoc_form();

if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();
    
    $param1->id = $mform->get_data()->id;
    $param1->ma_monhoc = $mform->get_data()->ma_monhoc;
    $param1->ten_monhoc_vi = $mform->get_data()->ten_monhoc_vi;
    $param1->ten_monhoc_en = $mform->get_data()->ten_monhoc_en;
    $param1->so_tinchi = $mform->get_data()->so_tinchi;
    $param1->sotiet_lythuyet = $mform->get_data()->so_tiet_LT;
    $param1->sotiet_thuchanh = $mform->get_data()->so_tiet_TH;
    $param1->sotiet_baitap = $mform->get_data()->so_tiet_BT;
    // $param1->mota = $mform->get_data()->mota;
    $param1->loai_hocphan = $mform->get_data()->loai_hocphan;
    $param1->ghichu = $mform->get_data()->ghichu;
    update_monhoc_table($param1);

    echo '<h2>Cập nhật môn học thành công!</h2>';
    echo '<br>';

    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php', []);
    $linktext = get_string('label_monhoc', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    //
} else {
    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->ma_monhoc = $chitietmh->ma_monhoc;
    $toform->ten_monhoc_vi = $chitietmh->ten_monhoc_vi;
    $toform->ten_monhoc_en = $chitietmh->ten_monhoc_en;
    $toform->so_tinchi = $chitietmh->so_tinchi;
    $toform->so_tiet_LT = $chitietmh->sotiet_lythuyet;
    $toform->so_tiet_TH = $chitietmh->sotiet_thuchanh;
    $toform->so_tiet_BT = $chitietmh->sotiet_baitap;
    $toform->loai_hocphan = $chitietmh->loai_hocphan;
    $toform->ghichu = $chitietmh->ghichu;
    
    $mform->set_data($toform);
    
    
    // displays the form
    $mform->display();
}
 
echo $OUTPUT->footer();
?>
