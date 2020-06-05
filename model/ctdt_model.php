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