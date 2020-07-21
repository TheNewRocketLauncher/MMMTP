<?php
require_once(__DIR__ . '/../../../config.php');
require_once('global_model.php');
require_once('../../model/global_model.php');
require_once('../../model/ctdt_model.php');
require_once('../../model/caykkt_model.php');
require_once('../../model/monhoc_model.php');

function insert_kkt($param_khoi, $arr_mon, $arr_makhoi)
{
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('eb_khoikienthuc', $param_khoi);

    if($arr_mon != null){
        foreach($arr_mon as $item){
            $param_mon = new stdClass();
            $param_mon->mamonhoc = $item;
            $param_mon->ma_khoi = $param_khoi->ma_khoi;

            $DB->insert_record('eb_monthuockhoi', $param_mon);
        }
    }

    if($arr_makhoi != NULL){$firstNode = new stdClass();
        $firstNode->ma_cay_khoikienthuc = $USER->id . 'khoi' . time();
        $firstNode->ma_tt = 0;
        $firstNode->ma_khoi = $param_khoi->ma_khoi;
        $firstNode->ma_khoicha = NULL;
        $firstNode->ten_cay = $param_khoi->ten_khoi;
        $firstNode->mota = $param_khoi->mota;
        $DB->insert_record('eb_cay_khoikienthuc', $firstNode);
    
        $stt = 1;
        foreach($arr_makhoi as $item){
            $childNode = new stdClass();
            $childNode->ma_cay_khoikienthuc = $firstNode->ma_cay_khoikienthuc;
            $childNode->ma_tt = $stt;
            $childNode->ma_khoi = $item;
            $childNode->ma_khoicha = $firstNode->ma_khoi;
            $childNode->ten_cay = $firstNode->ten_cay;
            $childNode->mota = $firstNode->mota;
            $DB->insert_record('eb_cay_khoikienthuc', $childNode);
            $stt++;
        }
    }
}

function get_list_kkt()
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $listkkt = $DB->get_records('eb_khoikienthuc', []);
    } else {
        $listkkt = NULL;
    }
    return $listkkt;
}

function get_list_khoicon_byMaKhoi($ma_khoicha)
{
    global $DB, $USER, $CFG, $COURSE;
    
    
    $firstNode = $DB->get_record('eb_cay_khoikienthuc', ['ma_khoi' => $ma_khoicha, 'ma_tt' => 0, 'ma_khoicha' => NULL, ]);
    
    $all_khoi = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoicha' => $ma_khoicha, 'ma_cay_khoikienthuc' => $firstNode->ma_cay_khoikienthuc]);
    
    return $all_khoi;
}

function get_kkt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {

        $kkt = $DB->get_record('eb_khoikienthuc', ['id' => $id]);
    } else{
        $kkt = NULL;
    }
    return $kkt;
}

function get_kkt_byMaKhoi($ma_khoi)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_record('eb_khoikienthuc', ['ma_khoi' => $ma_khoi]);
    } else{
        $kkt = NULL;
    }
    return $kkt;
}

function get_kkt_byMaCTDT($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $kkt = $DB->get_records('eb_khoikienthuc', array('ma_ctdt' => $ma_ctdt));
    } else {
        $kkt = NULL;
    }
    return $kkt;
}

function delete_kkt_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    $khoi = get_kkt_byID($id);
    if (empty($khoi)) {
        return false;
    } else {
        //Delete Mon thuoc khoi
        $listmonthuockhoi = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $khoi->ma_khoi]);
        foreach($listmonthuockhoi as $item){
            
            $DB->delete_records('eb_monthuockhoi', ['id' => $item->id]);
        }
        //Delete list khoi con
        delete_caykkt_byMaKhoi($khoi->ma_khoi);
        $DB->delete_records('eb_khoikienthuc', ['id' => $id]);
    }
}

function delete_kkt_byMaKhoi($ma_khoi)
{
    global $DB, $USER, $CFG, $COURSE;
    $khoi = get_kkt_byMaKhoi($ma_khoi);
    delete_kkt_byID($khoi->id);
}

function update_kkt($param)
{
    global $DB, $USER, $CFG, $COURSE;
    if (userIsAdmin()) {
        $khoi = get_kkt_byMaKhoi($param->id);
        if (empty($khoi)) {
            return false;
        } else {
            $DB->update_record('eb_ctdt', $param, $bulk = false);
        }
    } else {
        return false;
    }
    return true;
}

function get_monthuockhoi($ma_khoi){
    global $DB, $USER, $CFG, $COURSE;
    $list_monhoc = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $ma_khoi] );
    return $list_monhoc;
}

function get_monhoc_by_kkt($ma_khoi)
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Mã môn học', 'Tên môn hoc', 'Số tín chỉ', 'Actions');


    $monthuockhois = get_monthuockhoi($ma_khoi);
    $allmonhocs = $DB->get_records('eb_monhoc',  ['mamonhoc' => $monthuockhois->mamonhoc]);


    $stt = 1;
    foreach ($allmonhocs as $imonhoc) {
        $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/chitiet_monhoc.php', ['id' => $imonhoc->id]);
        $ten_url = \html_writer::link($url, $imonhoc->tenmonhoc_vi);

        // url1
        $url1 = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $imonhoc->id]);
        $ten_url1 = \html_writer::link($url1, 'update');

        // add table
        $table->data[] = [(string) $stt, (string) $imonhoc->mamonhoc, $ten_url, (string) $imonhoc->sotinchi, $ten_url1];
        $stt = $stt + 1; 
    }   
    return $table;
}

function get_dieukien_kkt($id = NULL, $ma_dieukien = NULL, $ma_loaidieukien = NULL, $xet_tren = NULL, $giatri_dieukien = NULL, $ten_dieukien = NULL)
{    
    global $DB, $USER, $CFG, $COURSE;
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

    $loaidieukien = $DB->get_record('eb_dieukien_kkt', $arr);
    if($loaidieukien == NULL && $xet_tren != NUll && $giatri_dieukien != NULL){
        $param_dieukien_kkt = new stdClass();
        $param_dieukien_kkt->ma_dieukien = 'DK' + time();
        $param_dieukien_kkt->ma_loaidieukien = 'DK'.$xet_tren.$giatri_dieukien;
        $param_dieukien_kkt->xet_tren = $xet_tren;
        $param_dieukien_kkt->giatri_dieukien = $giatri_dieukien;
        $param_dieukien_kkt->ten_dieukien = NULL;
        $param_dieukien_kkt->mota = NULL;
        $id = insert_dieukien_kkt($param_dieukien_kkt);
        $loaidieukien = get_dieukien_kkt($id);
    }

    return $loaidieukien;
}

function insert_dieukien_kkt($param_dieukien_kkt)
{
    global $DB, $USER, $CFG, $COURSE;
    $id = $DB->insert_record('eb_dieukien_kkt', $param_dieukien_kkt);
    return $id;
}

function update_dieukien_kkt($param_dieukien_kkt)
{

}

function delete_dieukien_kkt($param_dieukien_kkt)
{

}

function can_edit_kkt($ma_khoi){
    $listcaykkt = get_list_caykkt_byMaKhoi($ma_khoi);
    foreach($listcaykkt as $item){
        $listctdt = get_list_ctdt_byMaCayKKT($item->$ma_cay_khoikienthuc);
        if($listctdt != null || empty($listctdt)){
            return false;
        }
    }
    return true;
}

function get_tong_TC_BB($ma_khoi){
    global $DB, $USER, $CFG, $COURSE;
    $result = new stdClass();
    $result->tc = 0;
    $result->bb = 0;
    $result->td = 0;
    $result->all = 0;
    $result->ghichu = '';

    $this_khoi = get_kkt_byMaKhoi($ma_khoi);
    $result->ghichu = $this_khoi->mota;

    $is_cokhoicon = khoi_cokhoicon($ma_khoi);
    $is_comonhoc = khoi_conmonhoc($ma_khoi);

    if(!$is_cokhoicon && !$is_comonhoc){
        return $result;
    } else{
        if($is_comonhoc){
            if($this_khoi->co_dieukien == 1){
                $result->tc = get_dieukien_kkt(NULL, $this_khoi->ma_dieukien)->giatri_dieukien;
            } else{
                $listmon = get_list_monthuockhoi($ma_khoi);
                foreach($listmon as $item){
                    $mon = get_monhoc_by_mamonhoc($item->mamonhoc);
                    $result->bb += $mon->sotinchi;
                }
            }
        }
        if($is_cokhoicon){
            $list_khoicon = get_list_khoicon_byMaKhoi($ma_khoi);
            foreach($list_khoicon as $item){
                $temp = get_tong_TC_BB($item->ma_khoi);
                $result->tc += $temp->tc;
                $result->bb += $temp->bb;
                $result->td += $temp->td;
            }
        }
    }

    $result->all = $result->tc + $result->bb + $result->td;
    return $result;
}

function khoi_cokhoicon($ma_khoi){
    $list_khoicon = get_list_khoicon_byMaKhoi($ma_khoi);
    if(empty($list_khoicon)){
        return false;
    } else{
        return true;
    }
}

function khoi_conmonhoc($ma_khoi){
    global $DB, $USER, $CFG, $COURSE;
    $list_monhoc = get_list_monthuockhoi($ma_khoi);
    if(empty($list_monhoc)){
        return false;
    } else{
        return true;
    }
}

function get_list_monthuockhoi($ma_khoi){
    global $DB;
    $listmonhoc = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $ma_khoi]);
    return $listmonhoc;
 }

 function insert_import_kkt($list_khoi){
    global $DB, $USER, $CFG, $COURSE;
    
    foreach($list_khoi as $ma_khoi => $item){
        $param_khoi = new stdClass();
        $param_khoi->ma_khoi = $ma_khoi;
        $param_khoi->ten_khoi = $item['ten_khoi'];
        $param_khoi->mota = $item['mota'];
        $param_khoi->co_dieukien = 0;
        $param_khoi->id_loai_kkt = 0;
        $param_khoi->ma_dieukien = NULL;
        $DB->insert_record('eb_khoikienthuc', $param_khoi);
        

        $arr_khoicon = array();
        $arr_monthuockhoi = array();
        
        if($item['montc'] != NULL){
            insert_import_khoicon($ma_khoi, $item['montc']);
        }

        if($item['monbb'] != NULL){
            insert_import_monthuockhoi($ma_khoi, $item['monbb']);
        }
    }
}

function insert_import_khoicon($ma_khoicha, $list_khoicon){
    global $DB, $USER, $CFG, $COURSE;
    if($list_khoicon != NULL){
        $firstNode = new stdClass();
        $firstNode->ma_cay_khoikienthuc = 'import_' . $ma_khoicha . 'khoi' . time();
        $firstNode->ma_tt = 0;
        $firstNode->ma_khoi = $ma_khoicha;
        $firstNode->ma_khoicha = NULL;
        $firstNode->ten_cay = 'khoicon';
        $firstNode->mota = 'khoicon';
        $DB->insert_record('eb_cay_khoikienthuc', $firstNode);
    
        $stt = 1;
        foreach($list_khoicon as $key =>  $item){
            // Insert Khoicon
            $ma_khoicon = $ma_khoicha . $key;

            $param_khoi = new stdClass();
            $param_khoi->ma_khoi = $ma_khoicon;
            $param_khoi->ten_khoi = 'import_' . $ma_khoicon;
            $param_khoi->mota = $item['ghichu'];
            $param_khoi->co_dieukien = 1;
            $param_khoi->id_loai_kkt = 1;
            $param_khoi->ma_dieukien = get_dieukien_kkt(NULL, NULL, NULL, $item['xet_tren'], $item['giatri_dieukien'], NULL)->ma_dieukien;
            $DB->insert_record('eb_khoikienthuc', $param_khoi);
            // Insert mon thuoc khoi con
            insert_import_monthuockhoi($ma_khoicon, $item['listmon']);

            

            // Them khoicon vao cay
            $childNode = new stdClass();
            $childNode->ma_cay_khoikienthuc = $firstNode->ma_cay_khoikienthuc;
            $childNode->ma_tt = $stt;
            $childNode->ma_khoi = $ma_khoicon;
            $childNode->ma_khoicha = $firstNode->ma_khoi;
            $childNode->ten_cay = $firstNode->ten_cay;
            $childNode->mota = $firstNode->mota;
            $DB->insert_record('eb_cay_khoikienthuc', $childNode);
            $stt++;
        }
    }
}

function insert_import_monthuockhoi($ma_khoi, $arr_monthuockhoi){
    global $DB, $USER, $CFG, $COURSE;
    foreach($arr_monthuockhoi as $item){
        $param_mon = new stdClass();
        $param_mon->mamonhoc = $item;
        $param_mon->ma_khoi = $ma_khoi;

        $DB->insert_record('eb_monthuockhoi', $param_mon);
    }
    
}