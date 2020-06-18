<?php
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . './global_model.php');

function insert_ctdt($param)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $id = $DB->insert_record('block_edu_ctdt', $param);
    } else {
    	$id = NULL;
    }
	return $id;
}

function get_list_ctdt()
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listctdt =   $DB->get_records('block_edu_ctdt', []);
    } else {
        $listctdt = NULL;
    }
    return $listctdt;
}

function get_ctdt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listctdt = $DB->get_records('block_edu_ctdt', ['id' => $id]);
    } else {
        $listctdt = NULL;
    }
    return $listctdt;
}

function get_ctdt_byMa($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;

    if (userIsAdmin()) {
        $listctdt = $DB->get_records('block_edu_ctdt', array('ma_ctdt' => $ma_ctdt));
    } else {
        $listctdt = NULL;
    }
    return $listctdt;
}

function delete_ctdt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $DB->delete_records('block_edu_ctdt', array('id' => $id));
    } else {
        return false;
    }
    return true;
}

function get_ctdt($courseid)
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Mã CTĐT', 'Mã niên khóa', 'Mã ngành', 'Mã chuyên ngành', 'Thời gian đào tạo', 'Khối lượng kiến thức', 'Đối tượng tuyển sinh');
    $allbacdts = $DB->get_records('block_edu_ctdt', []);
    $stt = 1;
    foreach ($allbacdts as $ibacdt) {
        $table->data[] = [(string) $stt, (string) $ibacdt->ma_ctdt, (string) $ibacdt->ma_nienkhoa, (string) $ibacdt->ma_nganh, (string) $ibacdt->ma_chuyennganh, (string) $ibacdt->thoigia_daotao, (string) $ibacdt->khoiluong_kienthuc, (string) $ibacdt->doituong_tuyensinh];
        $stt = $stt + 1;
    }
    return $table;
}

function get_ctdt_checkbox($courseid)
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('', 'STT', 'Mã CTĐT', 'Mã niên khóa', 'Mã ngành', 'Mã chuyên ngành', 'Thời gian đào tạo', 'Khối lượng kiến thức', 'Đối tượng tuyển sinh');
    $allbacdts = $DB->get_records('block_edu_ctdt', []);
    $stt = 1;
    foreach ($allbacdts as $ibacdt) {
        $checkbox = html_writer::tag('input', ' ', array('class' => 'ctdtcheckbox', 'type' => "checkbox", 'name' => $ibacdt->id, 'id' => 'bdt' . $ibacdt->id, 'value' => '0', 'onclick' => "changecheck($ibacdt->id)"));
        $table->data[] = [$checkbox, (string) $stt, (string) $ibacdt->ma_ctdt, (string) $ibacdt->ma_nienkhoa, (string) $ibacdt->ma_nganh, (string) $ibacdt->ma_chuyennganh, (string) $ibacdt->thoigia_daotao, (string) $ibacdt->khoiluong_kienthuc, (string) $ibacdt->doituong_tuyensinh];
        $stt = $stt + 1;
    }
    return $table;
}

function update_ctdt($param)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $DB->update_record('block_edu_ctdt', $param, $bulk = false);
    } else {
        return false;
    }
    return true;
}

function checkingRef()
{
    if (userIsAdmin()) {
        return true;
    }
    return false;
}
