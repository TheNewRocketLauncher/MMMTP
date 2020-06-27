<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../js.php');


function vn_to_str($str)
{
   $unicode = array(
      'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
      'd' => 'đ|Đ',
      'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
      'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
      'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
      'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
      'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
   );
   foreach ($unicode as $nonUnicode => $uni) {
      $str = preg_replace("/($uni)/i", $nonUnicode, $str);
   }
   $str = str_replace(' ', '_', $str);
   return strtolower($str);
}

function findContent($str, $key)
{
   $result = false;
   $_str = vn_to_str($str);
   $_key = vn_to_str($key);
   if (strstr($_str, $_key)) {
      $result = true;
   } else {
      $result = false;
   }
   return $result;
}



function insert_lopmo($param)
{   
   global $DB, $USER, $CFG, $COURSE;
   $ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt' => $param->ma_ctdt]);
   $monhoc = $DB->get_record('block_edu_monhoc', ['mamonhoc' => $param->mamonhoc]);
   $monhoc->lopmo = 1;
   $DB->update_record('block_edu_monhoc', $monhoc, $bulk = false);
   $param->ma_nienkhoa = $ctdt->ma_nienkhoa;
   $param->ma_nganh = $ctdt->ma_nganh;
   $DB->insert_record('block_edu_lop_mo', $param);
}

function get_lopmo_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $lopmo = $DB->get_record('block_edu_lop_mo', ['id' => $id]);
   return $lopmo;
}

function get_lopmo_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('', 'STT', 'Tên khóa học', 'Giáo viên phụ trách', 'Mô tả');
   $alllopmos = $DB->get_records('block_edu_lop_mo', []);
   $stt = 1 + $page * 5;
   $pos_in_table = 1;

   foreach ($alllopmos as $item) {
      if (findContent($item->full_name, $key_search) || $key_search == '') {

      $checkbox = html_writer::tag('input', ' ', array('class' => 'lopmocheckbox', 'type' => "checkbox", 'name' => $item->id, 'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
      $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/update.php', [ 'id' => $item->id]);
      $ten_url = \html_writer::link($url, $item->full_name);


      if ($page < 0) { // Get all data without page
         $table->data[] = [$checkbox, (string) $item->id, $ten_url, (string) $item->assign_to, (string) $item->mota];
         $stt = $stt + 1;
      } else if ($pos_in_table > $page * 5 && $pos_in_table <= $page * 5 + 5) {
         $table->data[] = [$checkbox, (string) $item->id, $ten_url, (string) $item->assign_to, (string) $item->mota];
         $stt = $stt + 1;
      }
      $pos_in_table = $pos_in_table + 1;

      }
   }
   return $table;
}



function update_lopmo($param)
{   
   global $DB, $USER, $CFG, $COURSE;
   $ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt' => $param->ma_ctdt]);
   $param->ma_nienkhoa = $ctdt->ma_nienkhoa;
   $param->ma_nganh = $ctdt->ma_nganh;
   $DB->update_record('block_edu_lop_mo', $param, $bulk = false);
}



function get_kkt_byMaKhoi($ma_khoi)
{
   global $DB, $USER, $CFG, $COURSE;
   if (userIsAdmin()) {

   $kkt = $DB->get_record('block_edu_khoikienthuc', ['ma_khoi' => $ma_khoi]);
   }else{
       $kkt = NULL;
}
   return $kkt;
}


function get_makhoi_from_mactdt($ma_ctdt){
   global $DB;
   $ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt' => $ma_ctdt]);
   $caykkt = $DB->get_record('block_edu_cay_khoikienthuc' , ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);
   $ma_khoi = $caykkt->ma_khoi;
   return $ma_khoi;
}

function get_list_monhoc_from_makhoi($ma_khoi){
   global $DB;
   $listmonhoc = $DB->get_records('block_edu_monthuockhoi', ['ma_khoi' => $ma_khoi]);
   return $listmonhoc;
}

function get_ctdt_by_mactdt($ma_ctdt){
   global $DB;


   $data = array();
   $ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt' => $ma_ctdt]);
    

   $tenbac = $DB->get_record('block_edu_bacdt', ['ma_bac' => $ctdt->ma_bac]);
   $data[] =& $tenbac->ten;

   $hedt = $DB->get_record('block_edu_hedt', ['ma_he' => $ctdt->ma_he]);
   $data[] =& $hedt->ten;

   $nienkhoa = $DB->get_record('block_edu_nienkhoa', ['ma_nienkhoa' => $ctdt->ma_nienkhoa]);
   $data[] =& $nienkhoa->ten_nienkhoa;

   $nganhdt = $DB->get_record('block_edu_nganhdt', ['ma_nganh' => $ctdt->ma_nganh]);
   $data[] =& $nganhdt->ten;

   $chuyennganh = $DB->get_record('block_edu_chuyennganhdt', ['ma_chuyennganh' => $ctdt->ma_chuyennganh]);
   $data[] =& $chuyennganh->ten;

   $data[] =& $ctdt->mota;
   return $data;
}