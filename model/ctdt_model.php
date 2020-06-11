<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . './global_model.php');

//Sample data
    // $dataObj1 = new stdClass();
    // $dataObj1->ma_ctdt = "DHCQ16_CNTT_KTPM";
    // $dataObj1->ma_chuyennganh = "DHCQ16_CNTT_KTPM";
    // $dataObj1->ma_nganh = "DHCQ16_CNTT";
    // $dataObj1->ma_nienkhoa = "DHCQ16";
    // $dataObj1->ma_he = "DHCQ";
    // $dataObj1->ma_bac = "DH";
    // $dataObj1->thoigia_daotao = "4 năm";
    // $dataObj1->khoiluong_kienthuc = "137 tín chỉ";
    // $dataObj1->doituong_tuyensinh = "Đại học";
    // $dataObj1->quytrinh_daotao = "Hello world";
    // $dataObj1->dienkien_totnghiep = "abc";
    // $dataObj1->ma_cay_khoikienthuc = "ADS";
    // $dataObj1->mota = "Hello world";


//insert into ctdt table
function insert_ctdt($param) {
    global $DB, $USER, $CFG, $COURSE;    
    
    if(userIsAdmin()){
        $DB->insert_record('block_edu_ctdt', $param);
        // $param
        // $DB->insert_record('block_edu_muctieu_ctdt', )
    } else{

    }
    
 }

function get_list_ctdt(){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $listctdt = $DB->get_records('block_edu_ctdt', []);
    } else{
        $listctdt = NULL;
    }

    return $listctdt;
}

function get_ctdt_byID($id){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $listctdt = $DB->get_records('block_edu_ctdt', ['id_ctdt' => $id]);
    } else{
        $listctdt = NULL;
    }

    return $listctdt;
}

function get_ctdt_byMa($ma_ctdt){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $listctdt = $DB->get_records('block_edu_ctdt', array('ma_ctdt' => $ma_ctdt));
    } else{
        $listctdt = NULL;
    }

    return $listctdt;
}

function delete_ctdt($id){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $DB->delete_records('block_edu_ctdt', array('id' => $id));
    } else{
        return false;
    }
    return true;
}

//phongle
function get_ctdt($courseid) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Mã CTĐT', 'Mã niên khóa','Mã ngành','Mã chuyên ngành','Thời gian đào tạo','Khối lượng kiến thức','Đối tượng tuyển sinh');
    $allbacdts = $DB->get_records('block_edu_ctdt', []);
    $stt = 1;    
    foreach ($allbacdts as $ibacdt) {
    //   $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/qlbac.php', ['courseid' => $courseid, 'id' => $ibacdt->id_bac]);
    //   $ten_url = \html_writer::link($url, $ibacdt->ten);
        $table->data[] = [(string)$stt , (string)$ibacdt->ma_ctdt ,(string)$ibacdt->ma_nienkhoa ,(string)$ibacdt->ma_nganh ,(string)$ibacdt->ma_chuyennganh ,(string)$ibacdt->thoigia_daotao ,(string)$ibacdt->khoiluong_kienthuc ,(string)$ibacdt->doituong_tuyensinh];
        $stt = $stt+1;
    }
    return $table;

}


function get_ctdt_checkbox($courseid) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('','STT', 'Mã CTĐT', 'Mã niên khóa','Mã ngành','Mã chuyên ngành','Thời gian đào tạo','Khối lượng kiến thức','Đối tượng tuyển sinh');
    $allbacdts = $DB->get_records('block_edu_ctdt', []);
    $stt = 1;    
    setcookie("arr", [0,1], time() + (86400 * 30), "/");
   
    foreach ($allbacdts as $ibacdt) {
       // Create checkbox
       // $check_id = 'bdt' . $inienkhoa->id;
   
       $checkbox = html_writer::tag('input', ' ', array('class' => 'ctdtcheckbox','type' => "checkbox", 'name' => $ibacdt->id_ctdt, 'id' => 'bdt' . $ibacdt->id_ctdt, 'value' => '0', 'onclick' => "changecheck($ibacdt->id_ctdt)")); 
   

       
       $table->data[] = [$checkbox, (string)$stt , (string)$ibacdt->ma_ctdt ,(string)$ibacdt->ma_nienkhoa ,(string)$ibacdt->ma_nganh ,(string)$ibacdt->ma_chuyennganh ,(string)$ibacdt->thoigia_daotao ,(string)$ibacdt->khoiluong_kienthuc ,(string)$ibacdt->doituong_tuyensinh];

       $stt = $stt+1;
    }
    return $table;
}

function update_ctdt($param){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $DB->update_record('block_edu_ctdt', $param, $bulk=false);
    } else{
        return false;
    }
    return true;
}
function checkingRef(){
    if(userIsAdmin()){
        return true;
    }
    return false;
}