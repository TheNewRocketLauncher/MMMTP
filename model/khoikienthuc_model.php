<?php
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . './global_model.php');
require_once('../../model/global_model.php');

function insert_kkt($param_khoi, $arr_mon)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $DB->insert_record('block_edu_khoikienthuc', $param_khoi);
    }
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
        $table->data[] = [$checkbox, (string) $stt, (string) $ibacdt->id_khoikienthuc, (string) $ibacdt->ma_khoi, (string) $ibacdt->id_loai_ktt, (string) $ibacdt->ten_khoi, (string) $ibacdt->mota];
        $stt = $stt + 1;
    }
    return $table;
}