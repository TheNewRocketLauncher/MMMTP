<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/khoikienthuc_model.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("khoikienthuc", "edit");
function clone_hedt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    $khoi = $DB->get_record('eb_khoikienthuc', ['id' => $id]);

    $list_mon = get_list_monhoc($khoi->ma_khoi);
    $list_khoi = get_list_khoicon($khoi->ma_khoi);

    $ma_khoi = $khoi->ma_khoi;
    $stt = 1;
    while($DB->count_records('eb_khoikienthuc', ['ma_khoi' => $ma_khoi . '_copy' . $stt])){
        $stt++;
    }

    $khoi->ma_khoi = $ma_khoi . '_copy' . $stt;

    insert_kkt($khoi, $list_mon, $list_khoi);
}


function get_list_monhoc($ma_khoi){
    $all_monthuockhoi = get_monthuockhoi($ma_khoi);

    $listmon = array();
    foreach($all_monthuockhoi as $item){
        $listmon[] = $item->mamonhoc;
    }
    return $listmon;
}

function get_list_khoicon($ma_khoi){
    $all_khoi = get_list_khoicon_byMaKhoi($ma_khoi);

    $listkkt = array();
    foreach($all_khoi as $item){
        $listkkt[] = $item->ma_khoi;
    }
    
    return $listkkt;
}
// Clone bậc đào tạo có id truyền vào
clone_hedt($id);
// return
$output = "Clone HDT has ID = " . $id . " successfully!";
echo $output;
exit;
