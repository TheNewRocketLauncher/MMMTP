<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once('../../model/global_model.php');
// require_once('./cay_kkt_model.php');

//Sample data
    // $param = new stdClass();
    // $param->ma_khoi = "DHCQ16_CNTT_KTPM";
    // $param->id_loai_kkt = 1;
    // $param->co_dieukien = 0;
    // $param->ma_dieukien = "DHCQ16";
    // $param->ten_khoi = "DHCQ";
    // $param->mota = "DH";


//insert into ctdt table
function insert_kkt($param) {
    global $DB, $USER, $CFG, $COURSE;    
    
    if(userIsAdmin()){
        $DB->insert_record('block_edu_khoikienthuc', $param);
    }
}

function get_list_kkt(){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $listkkt = $DB->get_records('block_edu_khoikienthuc', []);
    } else{
        $listkkt = NULL;
    }

    return $listkkt;
}

function get_list_kkt_byFather($ma_khoi_cha){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $listkkt = $DB->get_records('block_edu_khoikienthuc', []);
    } else{
        $listkkt = NULL;
    }

    return $listkkt;
}

function get_kkt_byID($id){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $kkt = $DB->get_records('block_edu_khoikienthuc', ['id' => $id]);
    } else{
        $kkt = NULL;
    }   

    return $kkt;
}

function get_kkt_byMa($ma_ctdt){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $kkt = $DB->get_records('block_edu_khoikienthuc', array('ma_ctdt' => $ma_ctdt));
    } else{
        $kkt = NULL;
    }

    return $kkt;
}

function delete_kkt($id){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $DB->delete_records('block_edu_khoikienthuc', array('id' => $id));
    } else{
        $kkt = NULL;
    }
}

function update_kkt($param){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $DB->update_record('block_edu_ctdt', $param, $bulk=false);
    } else{
        return false;
    }
    return true;
}

// Checking if file linked
// function checking(){
//     if(userIsAdmin()){
//         return true;
//     }
//     return false;
// }


?>