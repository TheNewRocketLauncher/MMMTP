<?php
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . './global_model.php');
require_once('../../model/global_model.php');

function insert_cay_kkt()
{
    global $DB, $USER, $CFG, $COURSE;
    $global_caykkt = get_global($USER->id)['newcaykkt'];

    $firstNode = new stdClass();
    $firstNode->ma_cay_khoikienthuc = $USER->id . 'caykkt' . time();
    $firstNode->ma_tt = NULL;
    $firstNode->ma_khoi = 'caykkt' . $time;
    $firstNode->ma_khoicha = NULl;
    $firstNode->ten_cay = $global_caykkt['tencay'];
    $firstNode->mota = $global_caykkt['mota'];
    $DB->insert_record('block_edu_cay_khoikienthuc', $firstNode);

    foreach($global_caykkt['value'] as $item){
        if($item['level'] == 1){
            $childNode = new stdClass();
            $childNode->ma_cay_khoikienthuc = $firstNode->ma_cay_khoikienthuc;
            $childNode->ma_tt = $item['index'];
            $childNode->ma_khoi = $item['name'];
            $childNode->ma_khoicha = $firstNode->ma_khoi;
            $childNode->ten_cay = $global_caykkt['tencay'];
            $childNode->mota = $global_caykkt['mota'];
            $DB->insert_record('block_edu_cay_khoikienthuc', $childNode);
        } else{
            $childNode = new stdClass();
            $childNode->ma_cay_khoikienthuc = $firstNode->ma_cay_khoikienthuc;
            $childNode->ma_tt = $item['index'];
            $childNode->ma_khoi = $item['name'];
            $childNode->ma_khoicha = $item['fatherName'];
            $childNode->ten_cay = $global_caykkt['tencay'];
            $childNode->mota = $global_caykkt['mota'];
            $DB->insert_record('block_edu_cay_khoikienthuc', $childNode);
        }
    }
}

function get_list_caykkt()
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listkkt = $DB->get_records('block_edu_cay_khoikienthuc', []);
    } else {
        $listkkt = NULL;
    }
    return $listkkt;
}

function get_list_caykkt_byFather($ma_khoi_cha)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listkkt = $DB->get_records('block_edu_cay_khoikienthuc', []);
    } else {
        $listkkt = NULL;
    }
    return $listkkt;
}

function get_caykkt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_record('block_edu_cay_khoikienthuc', ['id' => $id]);
    } else {
        $kkt = NULL;
    }
    return $kkt;
}

function get_list_caykkt_byMaCTDT($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_records('block_edu_cay_khoikienthuc', array('ma_ctdt' => $ma_ctdt));
    } else {
        $kkt = NULL;
    }
    return $kkt;
}

function delete_caykkt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    $caykkt = get_caykkt_byID($id);
    
    delete_caykkt_byMaCay($caykkt->ma_cay_khoikienthuc);
}

function delete_caykkt_byMaCay($ma_cay_khoikienthuc){
    global $DB, $USER, $CFG, $COURSE;

    $list_item = $DB->get_records('block_edu_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc]);

    foreach($list_item as $item){
        $DB->delete_records('block_edu_cay_khoikienthuc', ['id' => $item->id]);
    }
}

//Xoá cây khối kiến thức của khối kiến thức
function delete_caykkt_byMaKhoi($ma_khoi)
{
    global $DB, $USER, $CFG, $COURSE;

    if($ma_khoi != 'caykkt'){
        $kkt = $DB->get_record('block_edu_cay_khoikienthuc', ['ma_khoi' => $ma_khoi, 'ma_tt' => 0]);
        $list_item = get_list_caykkt_byMaCay($kkt->ma_cay_khoikienthuc);
        foreach($list_item as $item){
            $DB->delete_records('block_edu_cay_khoikienthuc', ['id' => $item->id]);
        }
    }
}

function get_list_caykkt_byMaKhoi($ma_khoi)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_records('block_edu_cay_khoikienthuc', array('ma_khoi' => $ma_khoi));
    } else {
        $kkt = NULL;
    }
    return $kkt;
}

function get_list_caykkt_byMaCay($ma_cay_khoikienthuc)
{
    global $DB, $USER, $CFG, $COURSE;
    $listcay = $DB->get_records('block_edu_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc]);
    return $listcay;
}

function can_change_caykkt($ma_cay_khoikienthuc){
    global $USER, $DB;
    $listctdt = get_list_ctdt_byMaCayKKT($ma_cay_khoikienthuc);
    if(!empty($listctdt) || $listctdt != NULL){
        return false;
    }
    
    return true;
}

// Khởi tạo khung sườn cho các chức năng thêm, sửa khối kiến thức!
function get_adding_list(){
    global $USER;
    $current_global = get_global($USER->id);
    if($current_global == null){
        $current_global = array(
            'newcaykkt' => array(
                'value' => array(),
                'tencay' => '',
                'mota' => '',
                'edit_mode' => '0',
                'ma_cay' => ''
            ),
        );
        set_global($USER->id, $current_global);
    } else if(empty($current_global)){
        $current_global[] = array(
            'newcaykkt' => array(
                'value' => array(),
                'tencay' => '',
                'mota' => '',
                'edit_mode' => '0',
                'ma_cay' => ''
            ),
        );
        set_global($USER->id, $current_global);
    } else if(array_key_exists('newcaykkt', $current_global)){
        return $current_global['newcaykkt']['value'];
    } else {
        $current_global[] = array(
            'newcaykkt' => array(
                'value' => array(),
                'tencay' => '',
                'mota' => '',
                'edit_mode' => '0',
                'ma_cay' => ''
            ),
        );
        set_global($USER->id, $current_global);
    }
    $current_global = get_global($USER->id);
    return $current_global['newcaykkt']['value'];
}