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
        // if(arr_mon != null){
        //     foreach($arr_mon as $item){
        //         $param_mon = new stdClass();
        //         $param_mon->mamonhoc = $item->mamonhoc;
        //         $param_mon->ma_khoi = $item->ma_khoi;
    
        //         $DB->insert_record('block_edu_monthuockhoi', $param_mon);
        //     }
        // }
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

function get_kkt_byMaKhoi($ma_khoi){
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

function delete_kkt_byID($id){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $khoi = get_kkt_byMaKhoi($id);
        if(empty($khoi)){
            return false;
        } else{
            $DB->delete_records('block_edu_khoikienthuc', array('id' => $id));
        }
    } else{
        return false;
    }
}

function delete_kkt_byMaKhoi($ma_khoi){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $khoi = get_kkt_byMaKhoi($ma_khoi);
        if(empty($khoi)){
            return false;
        } else{
            $DB->delete_records('block_edu_khoikienthuc', array('id' => $khoi->id));
        }
    } else{
        return false;
    }
}

function update_kkt($param){
    global $DB, $USER, $CFG, $COURSE;

    if(userIsAdmin()){
        $khoi = get_kkt_byMaKhoi($param->id);
        if(empty($khoi)){
            return false;
        } else{
            $DB->update_record('block_edu_ctdt', $param, $bulk=false);
        }
    } else{
        return false;
    }
    return true;
}

function get_kkt_checkbox($courseid) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('','STT', 'ID', 'Mã khối','ID loại KKT','Tên khối','Mô tả');
    $allbacdts = $DB->get_records('block_edu_khoikienthuc', []);
    $stt = 1;    
    setcookie("arr", [0,1], time() + (86400 * 30), "/");
   
    foreach ($allbacdts as $ibacdt) {
       // Create checkbox
       // $check_id = 'bdt' . $inienkhoa->id;
   
       $checkbox = html_writer::tag('input', ' ', array('class' => 'kktcheckbox','type' => "checkbox", 'name' => $ibacdt->id, 'id' => 'bdt' . $ibacdt->id, 'value' => '0', 'onclick' => "changecheck($ibacdt->id)")); 
   

       
       $table->data[] = [$checkbox, (string)$stt , (string)$ibacdt->id_khoikienthuc ,(string)$ibacdt->ma_khoi ,(string)$ibacdt->id_loai_ktt ,(string)$ibacdt->ten_khoi ,(string)$ibacdt->mota];

       $stt = $stt+1;
    }
    return $table;
   }



















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