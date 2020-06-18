<?php
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . './global_model.php');
require_once('../../model/global_model.php');

function insert_kkt($param_khoi, $arr_mon)
{
    echo 'param_khoi';
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $DB->insert_record('block_edu_khoikienthuc', $param_khoi);
    }

    echo 'arr_mon';
    if($arr_mon != null){
        foreach($arr_mon as $item){
            $param_mon = new stdClass();
            $param_mon->mamonhoc = $item;
            $param_mon->ma_khoi = $param_khoi->ma_khoi;

            $DB->insert_record('block_edu_monthuockhoi', $param_mon);
        }
    }
    echo 'end khoi';
}

function get_list_kkt()
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listkkt = $DB->get_records('block_edu_khoikienthuc', []);
    } else {
        $listkkt = NULL;
    }
    return $listkkt;
}

function get_list_kkt_byFather($ma_khoi_cha)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listkkt = $DB->get_records('block_edu_khoikienthuc', []);
    } else {
        $listkkt = NULL;
    }
    return $listkkt;
}

function get_kkt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_records('block_edu_khoikienthuc', ['id' => $id]);
    } else {
        $kkt = NULL;
    }

    return $kkt;
}

function get_kkt_byMaKhoi($ma_khoi)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_records('block_edu_khoikienthuc', ['id' => $id]);
    } else {
        $kkt = NULL;
    }
    return $kkt;
}

function get_kkt_byMa($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_records('block_edu_khoikienthuc', array('ma_ctdt' => $ma_ctdt));
    } else {
        $kkt = NULL;
    }
    return $kkt;
}

function delete_kkt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $khoi = get_kkt_byMaKhoi($id);
        if (empty($khoi)) {
            return false;
        } else {
            $DB->delete_records('block_edu_khoikienthuc', array('id' => $id));
        }
    } else {
        return false;
    }
}

function delete_kkt_byMaKhoi($ma_khoi)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $khoi = get_kkt_byMaKhoi($ma_khoi);
        if (empty($khoi)) {
            return false;
        } else {
            $DB->delete_records('block_edu_khoikienthuc', array('id' => $khoi->id));
        }
    } else {
        return false;
    }
}

function update_kkt($param)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $khoi = get_kkt_byMaKhoi($param->id);
        if (empty($khoi)) {
            return false;
        } else {
            $DB->update_record('block_edu_ctdt', $param, $bulk = false);
        }
    } else {
        return false;
    }
    return true;
}

function get_kkt_checkbox($courseid)
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('', 'STT', 'ID', 'Mã khối', 'ID loại KKT', 'Tên khối', 'Mô tả');
    $allbacdts = $DB->get_records('block_edu_khoikienthuc', []);
    $stt = 1;
    foreach ($allbacdts as $ibacdt) {
        $checkbox = html_writer::tag('input', ' ', array('class' => 'kktcheckbox', 'type' => "checkbox", 'name' => $ibacdt->id, 'id' => 'bdt' . $ibacdt->id, 'value' => '0', 'onclick' => "changecheck($ibacdt->id)"));
        $table->data[] = [$checkbox, (string) $stt, (string) $ibacdt->id_khoikienthuc, (string) $ibacdt->ma_khoi, (string) $ibacdt->id_loai_kkt, (string) $ibacdt->ten_khoi, (string) $ibacdt->mota];
        $stt = $stt + 1;
    }
    return $table;
}

function get_dieukien_kkt($id = NULL, $ma_dieukien = NULL, $ma_loaidieukien = NULL, $xet_tren = NULL, $giatri_dieukien = NULL, $ten_dieukien = NULL)
{    
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $arr = array();

        if($id != NULL){
            $arr += ['id' => $id];
        }
        if($ma_dieukien != NULL){
            $arr += ['ma_dieukien' => $ma_dieukien];
        }
        if($ma_loaidieukien != NULL){
            $arr += ['ma_loaidieukien' => $ma_loaidieukien];
        }
        if($xet_tren != NULL){
            $arr += ['xet_tren' => $xet_tren];
        }
        if($giatri_dieukien != NULL){
            $arr += ['giatri_dieukien' => $giatri_dieukien];
        }
        if($ten_dieukien != NULL){
            $arr += ['ten_dieukien' => $ten_dieukien];
        }
        echo json_encode($arr);

        $list_loaidieukien = $DB->get_record('block_edu_dieukien_kkt', $arr);
    } else {
        $list_loaidieukien = NULL;
    }  
    return $list_loaidieukien;
}

function insert_dieukien_kkt($param_dieukien_kkt)
{
    echo 'insert_dieukien_kkt';
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $id = $DB->insert_record('block_edu_dieukien_kkt', $param_dieukien_kkt);
        return $id;
    } else{
        return NULL;
    }
    echo 'end insert_dieukien_kkt';
}

function update_dieukien_kkt($param_dieukien_kkt)
{

}

function delete_dieukien_kkt($param_dieukien_kkt)
{

}