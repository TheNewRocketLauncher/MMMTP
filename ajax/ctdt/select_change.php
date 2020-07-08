<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/global_model.php');
require_once('../../model/khoikienthuc_model.php');

$type = required_param('type', PARAM_ALPHANUMEXT);
$param = required_param('param', PARAM_ALPHANUMEXT);

// type:        1: Bậc
// type:        2: Hê
// type:        3: Niên khoá
// type:        4: Ngành

mainDo($type, $param);

function mainDo($type, $param){
    $result = NULL;
    switch ($type){
        case 1:
            $result = get_he_form_bdt($param);
        break;
        case 2:
            $result = get_nienkhoa_form_he($param);
        break;
        case 3:
            $result = get_nganh_from_nienkhoa($param);
        break;
        case 4:
            $result = get_chuyennganh_form_nganh($param);
        break;
        default:
    }
    echo json_encode($result);
}

function get_he_form_bdt($ma_bac){
    global $DB;
    $allHe = $DB->get_records('block_edu_hedt', ['ma_bac' => $ma_bac]);
    $list_mahe = array();
    foreach($allHe as $item){
        if(!array_search($item->ma_he, $list_mahe)){
            $list_mahe[] =& $item->ma_he;
        }
    }
    return $list_mahe;
}

function get_nienkhoa_form_he($ma_he){
    global $DB;
    $all_nienkhoa = $DB->get_records('block_edu_nienkhoa', ['ma_he' => $ma_he]);
    $list_nienkhoa = array();
    foreach($all_nienkhoa as $item){
        if(!array_search($item->ma_nienkhoa, $list_nienkhoa)){
            $list_nienkhoa[] = $item->ma_nienkhoa;
        }
    }
    return $list_nienkhoa;
}

function get_nganh_from_nienkhoa($ma_nienkhoa){
    global $DB;
    $all_nganhdt = $DB->get_records('block_edu_nganhdt', ['ma_nienkhoa' => $ma_nienkhoa]);
    $list_nganh = array();
    foreach($all_nganhdt as $item){
        if(!array_search($item->ma_nganh, $list_nganh)){
            $list_nganh[] = $item->ma_nganh;
        }
    }
    return $list_nganh;
}

function get_chuyennganh_form_nganh($ma_nganh){
    global $DB;
    $all_chuyennganh = $DB->get_records('block_edu_chuyennganhdt', ['ma_nganh' => $ma_nganh]);
    $list_chuyennganh = array();
    foreach($all_chuyennganh as $item){
        if(!array_search($item->ma_chuyennganh, $list_chuyennganh)){
            $list_chuyennganh[] = $item->ma_chuyennganh;
        }
    }
    return $list_chuyennganh;
}








exit;