<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');

function insert_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_monhoc', $param);
}

function update_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_monhoc', $param);
}


function get_monhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_monhoc', array('mamonhoc' => $mamonhoc));
}

function get_monhoc_by_id_monhoc($id)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_monhoc', array('id' => $id));
}


function get_muctieu_monmhoc_by_madc_1($ma_decuong, $ma_ctdt, $mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   
   $arr = array();
   $alldatas = $DB->get_records('eb_muctieumonhoc', array('ma_decuong' => $ma_decuong));
   
   usort($alldatas, function($a, $b)
   {
      return strcmp($a->muctieu, $b->muctieu);
   });

   foreach ($alldatas as $idata) {
      
      $arr[] = (string)$idata->muctieu;
      
   }
   return $arr;
}

function get_muctieu_monmhoc_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_muctieumonhoc', array('id' => $id_monhoc));
}
function get_muctieu_monmhoc_by_muctieu($muctieu)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_muctieumonhoc', ['muctieu'=>$muctieu]);
}
function update_muctieumonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_muctieumonhoc', $param);
}

// function get_chuandaura_monmhoc_by_mamonhoc($mamonhoc)
// {
//    global $DB, $USER, $CFG, $COURSE;
//    $table = new html_table();
//    $table->head = array(' ', 'STT', 'Chuẩn đầu ra', 'Mô tả(Mức chi tiết-hành động)', 'Mức độ(I/T/U)');
//    $alldatas = $DB->get_records('eb_chuandaura', ['mamonhoc' => $mamonhoc]);
//    $stt = 1;
//    foreach ($alldatas as $idata) {
//       $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_chuandaura.php', ['id' => $idata->id]);
//       $ten_url = \html_writer::link($url, $idata->ma_cdr);
//       $checkbox = html_writer::tag('input', ' ', array('class' => 'chuandaura_monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'chuandaura_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_chuandaura_monhoc($idata->id)"));
//       $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->mota, (string) $idata->mucdo_utilize];
//       $stt = $stt + 1;
//    }
//    return $table;
// }


function get_chuandaura_from_id($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $a = $DB->get_record('eb_chuandaura',['id'=>$id] );   
   return $a->ma_cdr;
}
function get_chuandaura_monhoc_by_madc_ma_cdr($ma_decuong, $ma_cdr)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_chuandaura',['ma_decuong'=>$ma_decuong, 'ma_cdr'=>$ma_cdr] );   
   
}

function get_chuandaura_monmhoc_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_chuandaura', array('id' => $id_monhoc));
}

function update_chuandaura_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_chuandaura', $param);
}


function get_kehoachgiangday_LT_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_kh_giangday_lt', array('id' => $id_monhoc));
}

function update_kehoachgiangday_lt_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_kh_giangday_lt', $param);
}

// function get_kehoachgiangday_TH_by_mamonhoc($mamonhoc)
// {
//    global $DB, $USER, $CFG, $COURSE;
//    $table = new html_table();
//    $table->head = array(' ', 'STT', 'Tuần', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
//    $alldatas = $DB->get_records('eb_kh_giangday_th', ['mamonhoc' => $mamonhoc]);
//    $stt = 1;
//    foreach ($alldatas as $idata) {
//       $checkbox = html_writer::tag('input', ' ', array('class' => 'kehoachgiangday_TH_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoachgiangday_TH' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoachgiangday_TH($idata->id)"));
//       $table->data[] = [$checkbox, (string) $stt, (int) $idata->tuan, (string) $idata->ten_chude, (string) $idata->danhsach_cdr, (string) $idata->hoatdong_gopy, (string) $idata->hoatdong_danhgia];
//       $stt = $stt + 1;
//    }
//    return $table;
// }


function get_danhgiamonhoc_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_danhgiamonhoc', array('id' => $id_monhoc));
}

function update_danhgiamonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_danhgiamonhoc', $param);
}

function get_tainguyenmonhoc_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_tainguyenmonhoc', array('id' => $id_monhoc));
}
function update_tainguyenmonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_tainguyenmonhoc', $param);
}

function get_quydinhchung_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('eb_quydinhchung', array('id' => $id_monhoc));
}
function update_quydinh_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_quydinhchung', $param);
}


function insert_decuong($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_decuong', $param);
}

function insert_muctieumonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_muctieumonhoc', $param);
}

function insert_chuandaura_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_chuandaura', $param);
}

function insert_kehoachgiangday_LT_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_kh_giangday_lt', $param);
}

function insert_kehoachgiangday_TH_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_kh_giangday_th', $param);
}

function insert_danhgiamonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_danhgiamonhoc', $param);
}

function insert_tainguyenmonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_tainguyenmonhoc', $param);
}

function insert_quydinhchung_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_quydinhchung', $param);
}

function update_decuong($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_decuong',$param,$bulk=false);
}

function clone_decuong($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_decuong',$param,$bulk=false);

   $param->ma_decuong;
   

}

function check_exist_decuong($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $check=$DB->get_record('eb_decuong',['mamonhoc'=>$mamonhoc]);
   if($check==null)
      return 0;
   return 1;
}

function clone_muctieumonhoc($ma_decuong_cu,$ma_decuong_moi)
{
   global $DB, $USER, $CFG, $COURSE;
   $arr = $DB->get_records('eb_muctieumonhoc',['ma_decuong'=>$ma_decuong_cu]);

   foreach($arr as $item)
   {
      $tem = new stdClass();
      $tem->muctieu = $item->muctieu;
      $tem->mamonhoc = $item->mamonhoc;
      $tem->mota = $item->mota;
      $tem->danhsach_cdr = $item->danhsach_cdr;
      $tem->ma_decuong = $ma_decuong_moi;

      insert_muctieumonhoc_table($tem);
   }
}

function clone_chuandauramonhoc($ma_decuong_cu,$ma_decuong_moi)
{
   global $DB, $USER, $CFG, $COURSE;
   $arr = $DB->get_records('eb_chuandaura',['ma_decuong'=>$ma_decuong_cu]);

   foreach($arr as $item)
   {
      $tem = new stdClass();
      $tem->ma_cdr=$item->ma_cdr; 
      $tem->mamonhoc = $item->mamonhoc;
      $tem->mota = $item->mota;  
      $tem->mucdo_introduce=$item->mucdo_introduce;
      $tem->mucdo_teach=$item->mucdo_teach;
      $tem->mucdo_utilize=$item->mucdo_utilize;

      $tem->ma_decuong = $ma_decuong_moi;

      insert_chuandaura_table($tem);
   }
}

function clone_kh_gd_lt($ma_decuong_cu,$ma_decuong_moi)
{
   global $DB, $USER, $CFG, $COURSE;
   $arr = $DB->get_records('eb_kh_giangday_lt',['ma_decuong'=>$ma_decuong_cu]);

   foreach($arr as $item)
   {
      $tem = new stdClass();
      $tem->ma_khgd=$item->ma_khgd; 
      $tem->ma_loaigiangday = $item->ma_loaigiangday;
      $tem->mamonhoc = $item->mamonhoc;  
      $tem->ten_chude=$item->ten_chude;
      $tem->danhsach_cdr=$item->danhsach_cdr;
      $tem->hoatdong_gopy=$item->hoatdong_gopy;   
      $tem->hoatdong_danhgia=$item->hoatdong_danhgia;


      $tem->ma_decuong = $ma_decuong_moi;

      insert_kehoachgiangday_LT_table($tem);
   }
}

function clone_danhgia($ma_decuong_cu,$ma_decuong_moi)
{
   global $DB, $USER, $CFG, $COURSE;
   $arr = $DB->get_records('eb_danhgiamonhoc',['ma_decuong'=>$ma_decuong_cu]);

   foreach($arr as $item)
   {
      $tem = new stdClass();
      $tem->madanhgia=$item->madanhgia; 
      $tem->mamonhoc = $item->mamonhoc;
      $tem->tendanhgia = $item->tendanhgia;  
      $tem->chuandaura_danhgia=$item->chuandaura_danhgia;
      $tem->motadanhgia=$item->motadanhgia;
      $tem->tile_danhgia=$item->tile_danhgia;   


      $tem->ma_decuong = $ma_decuong_moi;

      insert_danhgiamonhoc_table($tem);
   }
}

function clone_tainguyenmonhoc($ma_decuong_cu,$ma_decuong_moi)
{
   global $DB, $USER, $CFG, $COURSE;
   $arr = $DB->get_records('eb_tainguyenmonhoc',['ma_decuong'=>$ma_decuong_cu]);

   foreach($arr as $item)
   {
      $tem = new stdClass();
      $tem->ma_tainguyen=$item->ma_tainguyen; 
      $tem->ten_tainguyen = $item->ten_tainguyen;
      $tem->mamonhoc = $item->mamonhoc;  
      $tem->loaitainguyen=$item->loaitainguyen;
      $tem->link_tainguyen=$item->link_tainguyen;
      $tem->mota_tainguyen=$item->mota_tainguyen;   


      $tem->ma_decuong = $ma_decuong_moi;

      insert_tainguyenmonhoc_table($tem);
   }
}

function clone_quydinhchung($ma_decuong_cu,$ma_decuong_moi)
{
   global $DB, $USER, $CFG, $COURSE;
   $arr = $DB->get_records('eb_quydinhchung',['ma_decuong'=>$ma_decuong_cu]);

   foreach($arr as $item)
   {
      $tem = new stdClass();
      $tem->ma_quydinhchung=$item->ma_quydinhchung; 
      $tem->mamonhoc = $item->mamonhoc;  
      $tem->mota_quydinhchung=$item->mota_quydinhchung;

      $tem->ma_decuong = $ma_decuong_moi;

      insert_quydinhchung_monhoc_table($tem);
   }
}

function is_monhoc_exist($mamonhoc){
   global $DB;
   return $DB->record_exists('eb_monhoc', ['mamonhoc' => $mamonhoc]);
}

function get_madc_from_mamonhoc($mamonhoc)
{
   $DB;
   return $DB->get_record('eb_decuong',['mamonhoc'=>$mamonhoc])->ma_decuong;
}

// //===========================================================================
// function get_name_khoikienthuc($ma_ctdt, $mamonhoc){
//    global $DB;
   
//    $ma_cay = $DB->get_record('eb_ctdt',['ma_ctdt'=>$ma_ctdt])->ma_cay_khoikienthuc;
   
//    $kkt = $DB->get_records('eb_cay_khoikienthuc',['ma_cay_khoikienthuc'=>$ma_cay]);

//    foreach($kkt as $ikhoi)
//    {
//        $a=$ikhoi->ma_khoi;
//        $monthuockhoi = $DB->get_records('eb_monthuockhoi',['ma_khoi'=>$a]);
       
//        foreach($monthuockhoi as $mon)
//        {   
           
//            if($mon->mamonhoc == $mamonhoc)
//            {
//                $khoi = $ikhoi->ma_khoi;
//                return $DB->get_record('eb_khoikienthuc',['ma_khoi'=>$khoi])->ten_khoi;
//            }
//        }

//    }

//    return "";

// }