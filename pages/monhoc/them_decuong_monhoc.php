﻿
<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
require_once('../../js.php');
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

class simplehtml_form extends moodleform{
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
global $COURSE, $USER;
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
// $PAGE->navbar->add($chitietmh->ten_monhoc_vi, new moodle_url('/blocks/educationpgrs/pages/monhoc/chitiet_monhoc.php?id='.$chitietmh->id));
// $PAGE->navbar->add('Thêm đề cương môn học', new moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuong_monhoc.php?id='.$chitietmh->id));
$PAGE->navbar->add('Thêm đề cương môn học');
// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs'));
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();


//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/decuong_monhoc/them_decuong_monhoc_form.php');




$a = $chitietmh->ma_monhoc;
echo $USER->id;

///===========================================================================
//THONG TIN CHUNG
$mform1 = new thong_tin_chung_decuong_monhoc_form();


if ($mform1->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if($mform1->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform1->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    // Thực hiện insert
    $param1 = new stdClass();
    // $param
    $param1->id = $mform->get_data()->idhe; // The data object must have the property "id" set.
    //
    $index_mabac = $mform->get_data()->mabac;    
    // $param1->ma_bac = $mform->get_data()->mabac;
    $allbacdts = $DB->get_records('block_edu_bacdt', []);
    $param1->ma_bac = $allbacdts[$index_mabac + 1 ]->ma_bac;
    // echo $allbacdts[$index_mabac +1]->ma_bac;    
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ten = $mform->get_data()->tenhe;
    $param1->mota = $mform->get_data()->mota;
    update_hedt($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    //edit file index.php tương ứng trong thư mục page. trỏ đến đường dẫn chứa file đó
    $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_hedt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    // $mform->display();


} else if ($mform1->is_submitted()) {
    //
} else {
    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->maso_monhoc_thongtin_chung = $chitietmh->ma_monhoc;
    $toform->ten_monhoc1_thongtin_chung = $chitietmh->ten_monhoc_vi;
    $toform->ten_monhoc2_thongtin_chung = $chitietmh->ten_monhoc_en;
    $toform->loai_hocphan = $chitietmh->loai_hocphan;
    // $toform->thuoc_khoi_kienthuc_thongtin_chung = $chitietmh->thuoc_khoi;
    $toform->so_tinchi_thongtin_chung = $chitietmh->so_tinchi;
    $toform->tiet_lythuyet_thongtin_chung = $chitietmh->sotiet_lythuyet;
    $toform->tiet_thuchanh_thongtin_chung = $chitietmh->sotiet_thuchanh;
    
    $mform1->set_data($toform);

    // displays the form
    $mform1->display();
}


///===========================================================================
//MUC TIEU MON HOC
$table2 = get_muctieu_monmhoc_by_ma_monhoc($a);
echo '<br>';
$mform2 = new muctieu_monhoc_decuong_monhoc_form();
if ($mform2->is_cancelled()) {

} else if($mform2->no_submit_button_pressed()){
    
    // if($mform2->get_submit_value('btn_submit_muctieu_monhoc')){

        
    // }
    

} else if ($fromform = $mform2->get_data()) {
    
    $param2 = new stdClass();
    $param2->ma_monhoc = $fromform->ma_monhoc;
    $param2->muctieu = $fromform->muctieu_muctieu_monhoc;
    $param2->mota = $fromform->mota_muctieu_muctieu_monhoc;
    $param2->danhsach_cdr = $fromform->chuan_daura_cdio_muctieu_monhoc;
    

    insert_muctieu_monhoc_table($param2);
    
    $table2 = get_muctieu_monmhoc_by_ma_monhoc($param2->ma_monhoc);


    echo html_writer::table($table2);
    echo \html_writer::tag(
        'button',
        'Xóa Muc Tieu',
        array('id' => 'btn_delete_muctieumonhoc'));
    
    echo '<br>';
    $mform2->display();
} else {

    //Set default data from DB
    $toform;
    $toform->ma_monhoc = $chitietmh->ma_monhoc;
    
    $mform2->set_data($toform);
    


    echo html_writer::table($table2);
    echo \html_writer::tag(
        'button',
        'Xóa Muc Tieu',
        array('id' => 'btn_delete_muctieumonhoc'));
    
    echo '<br>';
    $mform2->display();
}

///================================================================================
//CHUAN DAU RA MON HOC
$table3 = get_chuan_daura_monmhoc_by_ma_monhoc($a);
echo '<br>';
$mform3 = new chuan_daura_decuong_monhoc_form();

if ($mform3->is_cancelled()) {
} else if($mform3->no_submit_button_pressed()){
    
    // if($mform3->get_submit_value('btn_submit_muctieu_monhoc')){

        
    // }
    

} else if ($fromform = $mform3->get_data()) {
    
    $param2 = new stdClass();
    $param2->ma_monhoc = $fromform->ma_monhoc;
    $param2->ma_cdr = $fromform->chuan_daura;
    $param2->mota = $fromform->mota_chuan_daura;
    $param2->mucdo_utilize = $fromform->mucdo_itu_chuan_daura;
    $param2->mucdo_teach = 1;
    $param2->mucdo_introduce = 1;
    
    
    insert_chuandaura_table($param2);
    
    $table3 = get_chuan_daura_monmhoc_by_ma_monhoc($param2->ma_monhoc);
    echo html_writer::table($table3);
    echo \html_writer::tag(
        'button',
        'Xóa chuẩn đầu ra',
        array('id' => 'btn_delete_chuandauramonhoc'));
    
    echo '<br>';
    $mform3->display();
} else {
    $toform;
    $toform->ma_monhoc = $chitietmh->ma_monhoc;
    
    $mform3->set_data($toform);

    echo html_writer::table($table3);
    echo \html_writer::tag(
        'button',
        'Xóa chuẩn đầu ra',
        array('id' => 'btn_delete_chuandauramonhoc'));
    
    echo '<br>';
    $mform3->display();
}



//=================================================================================
//KE HOACH GIANG DAY LY THUYET
$table4 = get_kehoach_giangday_LT_by_ma_monhoc($a);
echo '<br>';
$mform4 = new giangday_LT_decuong_monhoc_form();

if ($mform4->is_cancelled()) {
} else if($mform4->no_submit_button_pressed()){
    
    // if($mform4->get_submit_value('btn_submit_muctieu_monhoc')){

        
    // }
    

} else if ($fromform = $mform4->get_data()) {
    
    $param2 = new stdClass();
    $param2->ma_monhoc = $fromform->ma_monhoc;
    $param2->ten_chude = $fromform->chude_giangday;
    $param2->danhsach_cdr = $fromform->danhsach_cdr;
    $param2->hoatdong_gopy = $fromform->hoatdong_giangday;
    $param2->hoatdong_danhgia = $fromform->hoatdong_danhgia;

    
    
    insert_kehoach_giangday_LT_table($param2);
    
    $table4 = get_kehoach_giangday_LT_by_ma_monhoc($param2->ma_monhoc);
    echo html_writer::table($table4);
    echo \html_writer::tag(
        'button',
        'Xóa kế hoạch giảng dạy',
        array('id' => 'btn_delete_khgdltmonhoc'));
    
    echo '<br>';
    $mform4->display();
} else {

    $toform;
    $toform->ma_monhoc = $chitietmh->ma_monhoc;
    
    $mform4->set_data($toform);


    echo html_writer::table($table4);
    echo \html_writer::tag(
        'button',
        'Xóa kế hoạch giảng dạy',
        array('id' => 'btn_delete_khgdltmonhoc'));
    
    echo '<br>';
    $mform4->display();
}
echo '<br>';

//=================================================================================
//DANH GIA MON HOC
$table5 = get_danhgia_monhoc_by_ma_monhoc($a);
echo '<br>';
$mform5 = new danhgia_decuong_monhoc_form();
if ($mform5->is_cancelled()) {
} else if($mform5->no_submit_button_pressed()){
    
    // if($mform5->get_submit_value('btn_submit_muctieu_monhoc')){

        
    // }
    

} else if ($fromform = $mform5->get_data()) {
    
    $param2 = new stdClass();
    $param2->ma_monhoc = $fromform->ma_monhoc;
    $param2->ma_danhgia = $fromform->ma_danhgia;
    $param2->ten_danhgia = $fromform->ten_danhgia;
    $param2->mota_danhgia = $fromform->mota_danhgia;
    $param2->chuan_daura_danhgia = $fromform->cac_chuan_daura_danhgia;
    $param2->tile_danhgia = $fromform->tile_danhgia;

    
    
    insert_danhgia_monhoc_table($param2);
    
    $table5 = get_danhgia_monhoc_by_ma_monhoc($fromform->ma_monhoc);
    echo html_writer::table($table5);
    echo \html_writer::tag(
        'button',
        'Xóa đánh giá môn học',
        array('id' => 'btn_delete_danhgiamonhoc'));
    
    echo '<br>';
    $mform5->display();

} else {

    $toform;
    $toform->ma_monhoc = $chitietmh->ma_monhoc;
    
    $mform5->set_data($toform);

    echo html_writer::table($table5);
    echo \html_writer::tag(
        'button',
        'Xóa đánh giá môn học',
        array('id' => 'btn_delete_danhgiamonhoc'));
    
    echo '<br>';
    $mform5->display();
}
echo '<br>';
//=================================================================================
//TAI NGUYEN MON HOC
$mform6 = new tainguyen_monhoc_decuong_monhoc_form();
echo '<br>';
$table6 = get_tainguyen_monhoc_by_ma_monhoc($a);
echo '<br>';
if ($mform6->is_cancelled()) {
} else if($mform6->no_submit_button_pressed()){
    
    // if($mform6->get_submit_value('btn_submit_muctieu_monhoc')){

        
    // }
    

} else if ($fromform = $mform6->get_data()) {
    
    $param2 = new stdClass();
    $param2->ma_monhoc = $fromform->ma_monhoc;
    $param2->loai_tainguyen = $fromform->loai_tainguyen;
    $param2->mota_tainguyen = $fromform->mota_tainguyen;
    $param2->link_tainguyen = $fromform->link_tainguyen;

    
    
    insert_tainguyen_monhoc_table($param2);
    
    $table6 = get_tainguyen_monhoc_by_ma_monhoc($fromform->ma_monhoc);
    echo html_writer::table($table6);
    echo \html_writer::tag(
        'button',
        'Xóa tài nguyên môn học',
        array('id' => 'btn_delete_tainguyenmonhoc'));
    
    echo '<br>';
    $mform6->display();

} else {

    $toform;
    $toform->ma_monhoc = $chitietmh->ma_monhoc;
    
    $mform6->set_data($toform);

    echo html_writer::table($table6);
    echo \html_writer::tag(
        'button',
        'Xóa tài nguyên môn học',
        array('id' => 'btn_delete_tainguyenmonhoc'));
    
    echo '<br>';
    $mform6->display();
}

//=================================================================================
//QUY DINH CHUNG
$mform7 = new quydinh_chung_decuong_monhoc_form();
echo '<br>';
$table7 = get_quydinh_chung_by_ma_monhoc($a);

if ($mform7->is_cancelled()) {
} else if($mform7->no_submit_button_pressed()){
    
    // if($mform7->get_submit_value('btn_submit_muctieu_monhoc')){

        
    // }
    

} else if ($fromform = $mform7->get_data()) {
    
    $param2 = new stdClass();
    $param2->ma_monhoc = $fromform->ma_monhoc;
    $param2->mota_quydinh_chung = $fromform->mota_quydinh_chung;

    
    
    insert_quydinh_chung_monhoc_table($param2);
    
    $table7 = get_quydinh_chung_by_ma_monhoc($fromform->ma_monhoc);
    echo html_writer::table($table7);
    echo \html_writer::tag(
        'button',
        'Xóa quy định chung môn học',
        array('id' => 'btn_delete_quydinhchungmonhoc'));
    
    echo '<br>';
    $mform7->display();

} else {

    $toform;
    $toform->ma_monhoc = $chitietmh->ma_monhoc;
    
    $mform7->set_data($toform);


    echo html_writer::table($table7);
    echo \html_writer::tag(
        'button',
        'Xóa quy định chung môn học',
        array('id' => 'btn_delete_quydinhchungmonhoc'));
    
    echo '<br>';
    $mform7->display();
}
echo '<br>';



$btn_export = html_writer::tag('button','Go', array('onClick' => ""));
echo $btn_export;
 
echo $OUTPUT->footer();
?>
