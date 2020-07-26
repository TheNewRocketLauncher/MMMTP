<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');

global $COURSE, $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$ma_dc_cu = optional_param('ma_decuong','',PARAM_ALPHANUMEXT);


// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("monhoc", "edit");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_quanly_decuong', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/decuong/index.php'));
$PAGE->navbar->add('Thêm đề cương môn học');

// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs'));
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');
$chitietmh->mamonhoc = 'csc500';
$a = $chitietmh->mamonhoc;


///==========================================================================
//TUY CHON
$mforms = new clone_decuongmonhoc_form();

if ($mforms->is_cancelled()) {
} else if ($mforms->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mforms->get_data()) {
    // $param2 = new stdClass();
    $param = new stdClass();
    $param->ma_decuong = $mforms->get_submit_value('madc');
    $param->ma_ctdt = $mforms->get_submit_value('tuychon_ctdt');
    $param->mamonhoc = $mforms->get_submit_value('tuychon_mon');
    $param->mota = $mforms->get_submit_value('mota_decuong');
    
    //Kiểm tra môn học đã có đề cương chưa
    if(check_exist_decuong($param->mamonhoc)==1)
    {
        echo "<h2>Môn học này đã có đề cương</h2>";
        $url = new \moodle_url('/blocks/educationpgrs/pages/decuong/index.php');
        echo \html_writer::link($url, 'Trang quản lý đề cương');
        echo '<br>';
        
    }
    else{
        //INSERT DECUONG
           
        insert_decuong($param);


        //clone các mục liên quan      
        clone_muctieumonhoc($fromform->ma_dc_cu, $param->ma_decuong);
        clone_chuandauramonhoc($fromform->ma_dc_cu, $param->ma_decuong);
        clone_kh_gd_lt($fromform->ma_dc_cu, $param->ma_decuong);
        clone_danhgia($fromform->ma_dc_cu, $param->ma_decuong);
        clone_tainguyenmonhoc($fromform->ma_dc_cu, $param->ma_decuong);
        clone_quydinhchung($fromform->ma_dc_cu, $param->ma_decuong);



        echo "<h2>Cập nhật đề cương</h2>";
        $url = new \moodle_url('/blocks/educationpgrs/pages/decuong/index.php');
        echo \html_writer::link($url, 'Trang quản lý đề cương');
    }
    
} else {    
    //Set default data from DB
    $toform->ma_dc_cu=$ma_dc_cu;

    $mforms->set_data($toform);
    $mforms->display();
    
}

echo $OUTPUT->footer();
?>