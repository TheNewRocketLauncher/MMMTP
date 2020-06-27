<?php
require_once(__DIR__ . '/../../../config.php');

function insert_cay_kkt($param)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $DB->insert_record('block_edu_cay_khoikienthuc', $param);
    }
}

function get_list_kkt()
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listkkt = $DB->get_records('block_edu_cay_khoikienthuc', []);
    } else {
        $listkkt = NULL;
    }
    return $listkkt;
}

function get_list_kkt_byFather($ma_khoi_cha)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listkkt = $DB->get_records('block_edu_cay_khoikienthuc', []);
    } else {
        $listkkt = NULL;
    }
    return $listkkt;
}

function get_kkt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_records('block_edu_cay_khoikienthuc', ['id' => $id]);
    } else {
        $kkt = NULL;
    }
    return $kkt;
}

function get_kkt_byMa($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_records('block_edu_cay_khoikienthuc', array('ma_ctdt' => $ma_ctdt));
    } else {
        $kkt = NULL;
    }
    return $kkt;
}

function delete_kkt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $DB->delete_records('block_edu_cay_khoikienthuc', array('id' => $id));
    } else {
        $kkt = NULL;
    }
}

function get_cay_kkt_checkbox($courseid)
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('', 'STT', 'ID', 'Mã cây kh?i ki?n th?c', 'Mã kh?i', 'Tên cây', 'Mô t?');
    $rows = $DB->get_records('block_edu_cay_khoikienthuc', []);
    $stt = 1;
    foreach ($rows as $item) {
        if((string)$item->ma_khoicha == ""){
        $checkbox = html_writer::tag('input', ' ', array('class' => 'ckktcheckbox', 'type' => "checkbox", 'name' => $item->id,   'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
        $table->data[] = [$checkbox, (string) $stt, (string) $item->id, (string) $item->ma_cay_khoikienthuc, (string) $item->ma_khoi, (string) $item->ten_cay, (string) $item->mota];
        $stt = $stt + 1;
        }
    }
    return $table;
}


function get_cay_kkt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    return $DB->get_record('block_edu_cay_khoikienthuc', ['id' => $id]);

    if (userIsAdmin()) {
        $ckkt = $DB->get_record('block_edu_cay_khoikienthuc', ['id' => $id]);
    } else {
        $ckkt = NULL;
    }
}
