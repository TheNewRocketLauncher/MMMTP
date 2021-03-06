<?php
require_once(__DIR__ . '/../../../config.php');

require_once('global_model.php');
require_once('decuong_model.php');
require_once('../../model/chuandaura_ctdt_model.php');

function insert_ctdt($param, $chuandaura)
{
    global $DB, $USER, $CFG, $COURSE;
    $id = $DB->insert_record('eb_ctdt', $param);

    foreach($chuandaura as $item){
        $param_cdr = new stdClass();
        $param_cdr->ma_ctdt = $param->ma_ctdt;
        $param_cdr->ma_cdr = $item;

        $DB->insert_record('eb_cdr_thuoc_ctdt', $param);
    }
	return $id;
}

function get_list_ctdt()
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listctdt =   $DB->get_records('eb_ctdt', []);
    } else {
        $listctdt = NULL;
    }
    return $listctdt;
}

function get_ctdt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    $ctdt = $DB->get_record('eb_ctdt', ['id' => $id]);
    return $ctdt;
}

function get_ctdt_byMa($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
    $ctdt = $DB->get_record('eb_ctdt', array('ma_ctdt' => $ma_ctdt));
    return $ctdt;
}

function exist_ma_ctdt($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
    return $DB->record_exists('eb_ctdt', array('ma_ctdt' => $ma_ctdt));
}

function delete_ctdt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $DB->delete_records('eb_ctdt', array('id' => $id));
    } else {
        return false;
    }
    return true;
}

function get_ctdt($courseid)
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Mã CTĐT', 'Mã khóa tuyển', 'Mã ngành', 'Mã chuyên ngành', 'Thời gian đào tạo', 'Khối lượng kiến thức', 'Đối tượng tuyển sinh');
    $allctdts = $DB->get_records('eb_ctdt', []);
    $stt = 1;
    foreach ($allctdts as $ictdt) {
        $table->data[] = [(string) $stt, (string) $ictdt->ma_ctdt, (string) $ictdt->ma_nienkhoa, (string) $ictdt->ma_nganh, (string) $ictdt->ma_chuyennganh, (string) $ictdt->thoigia_daotao, (string) $ictdt->khoiluong_kienthuc, (string) $ictdt->doituong_tuyensinh];
        $stt = $stt + 1;
    }
    return $table;
}

function update_ctdt($param, $list_newcdr)
{
    global $DB, $USER, $CFG, $COURSE;
    
    $param->id = $oldctdt->id;

    echo '<br> param ctdt new <br>';
    echo json_encode($param);
    // $DB->update_record('eb_ctdt', $param, $bulk = false);

    $list_cdr = get_list_cdr_thuoc_ctdt($old_ma_ctdt);
    foreach($list_cdr as $item){
        $item->ma_ctdt = $param->ma_ctdt;
        
        echo '<br> param cdr new <br>';
        // $DB->update_record('eb_cdr_thuoc_ctdt', $item, $bulk = false);
    }
    return true;
}

function get_list_ctdt_byMaCayKKT($ma_cay_khoikienthuc)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listctdt =   $DB->get_records('eb_ctdt', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc]);
    } else {
        $listctdt = NULL;
    }
    return $listctdt;
}

function can_edit_ctdt($id = NULL, $ma_ctdt = NULL){
    if($id == NULL && $ma_ctdt == NULL){
        return NULL;
    }

    if($id == NULL){
        $ctdt = get_ctdt_byMa($ma_ctdt);
        $id = $ctdt->id;
    }

    if(is_ctdt_used($id)){
        return false;
    }

    return true;
}

function is_ctdt_used($id){
    $ctdt = get_ctdt_byID($id);
    $list = get_list_decuong_byMaCTDT($ctdt->ma_ctdt);

    if(!empty($list)){
        return true;
    }
    // Another condition
    // if(!empty($list)){
    //     return false;
    // }

    return false;
}

function get_info_ctdtByID($id){
    global $DB, $USER, $CFG, $COURSE;
    $ctdt = get_ctdt_byID($id);
    
    $info = new stdClass();
    $info->ma_bac = $DB->get_record('eb_bacdt', ['ma_bac' => $ctdt->ma_bac])->ten;
    $info->ma_he = $DB->get_record('eb_hedt', ['ma_he' => $ctdt->ma_he])->ten;
    $info->ma_nienkhoa = $DB->get_record('eb_nienkhoa', ['ma_nienkhoa' => $ctdt->ma_nienkhoa])->ten_nienkhoa;
    $info->ma_nganh = $DB->get_record('eb_nganhdt', ['ma_nganh' => $ctdt->ma_nganh])->ten;
    $info->ma_chuyennganh = $DB->get_record('eb_chuyennganhdt', ['ma_chuyennganh' => $ctdt->ma_chuyennganh])->ten;
    
    return $info;
}