<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . './global_model.php');
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
function insert_kkt($param_khoi, $arr_mon) {
    global $DB, $USER, $CFG, $COURSE;    
    
    if(userIsAdmin()){
        $DB->insert_record('block_edu_khoikienthuc', $param_khoi);
        foreach($param_mon as $item){
            $param_mon = new stdClass();
            $param_mon->ma_monhoc = $item;
            $param_mon->ma_khoi = $param_khoi->ma_khoi;

            $DB->insert_record('block_edu_monthuockhoi', $item);
        }
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


// //model mon hoc
// function get_monhoc_table() {
//     global $DB, $USER, $CFG, $COURSE;
//     $table = new html_table();
//     $table->head = array('STT', 'Mã môn học','Tên môn hoc', 'Số TC', 'Tiết BT', 'Tiết LT', 'Loại môn học');

//     $allmonhocs = get_golbal($USER->id)->list_monhoc;

//     $stt = 1;
//     foreach ($allmonhocs as $imonhoc) {
//         // get $monhoc by $imonhoc->ma_monhoc
//         // $monhoc = get_monhoc_byID($imonhoc->id);
//         $table->data[] = [(string)$stt, (string)$imonhoc->ma_monhoc, (string)$monhoc->ten_monhoc, (string)$monhoc->so_tinchi, (string)$monhoc->sotiet_lythuyet, (string)$monhoc->sotiet_thuchanh, (string)$monhoc->sotiet_baitap];
//         $table->data[] = [(string)$stt, (string)$imonhoc->ma_monhoc];
//         $stt = $stt+1;
//     }
//     return $table;
//  }
 
 
//  ///page mon hoc
 
//  $table = get_monhoc_table();
//  echo html_writer::table($table);
 
//  ///



















// function insert_cay_kkt($param) {
//     global $DB, $USER, $CFG, $COURSE;    
    
//     if(userIsAdmin()){
//         $DB->insert_record('block_edu_khoikienthuc', $param);
//     }
// }

// function get_list_caykkt(){
//     global $DB, $USER, $CFG, $COURSE;

//     if(userIsAdmin()){
//         $listkkt = $DB->get_records('block_edu_khoikienthuc', []);
//     } else{
//         $listkkt = NULL;
//     }

//     return $listkkt;
// }

// function get_list_caykkt_byFather($ma_khoi_cha){
//     global $DB, $USER, $CFG, $COURSE;

//     if(userIsAdmin()){
//         $listkkt = $DB->get_records('block_edu_khoikienthuc', ['ma_khoi_cha' => $ma_khoi_cha]);
//     } else{
//         $listkkt = NULL;
//     }

//     return $listkkt;
// }

// function get_caykkt_byID($id){
//     global $DB, $USER, $CFG, $COURSE;

//     if(userIsAdmin()){
//         $kkt = $DB->get_records('block_edu_khoikienthuc', ['id' => $id]);
//     } else{
//         $kkt = NULL;
//     }   

//     return $kkt;
// }

// function get_caykkt_byMa($ma_ctdt){
//     global $DB, $USER, $CFG, $COURSE;

//     if(userIsAdmin()){
//         $kkt = $DB->get_records('block_edu_khoikienthuc', array('ma_ctdt' => $ma_ctdt));
//     } else{
//         $kkt = NULL;
//     }

//     return $kkt;
// }

// function delete_caykkt($id){
//     global $DB, $USER, $CFG, $COURSE;

//     if(userIsAdmin()){
//         $DB->delete_records('block_edu_khoikienthuc', array('id' => $id));
//     } else{
//         $kkt = NULL;
//     }
// }

// function update_caykkt($param){
//     global $DB, $USER, $CFG, $COURSE;

//     if(userIsAdmin()){
//         $DB->update_record('block_edu_ctdt', $param, $bulk=false);
//     } else{
//         return false;
//     }
//     return true;
// }

// Checking if file linked
// function checking(){
//     if(userIsAdmin()){
//         return true;
//     }
//     return false;
// }


?>