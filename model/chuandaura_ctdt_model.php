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

function insert_chuandaura_ctdt($param)
{   
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_chuandaura_ctdt', $param);
}
function update_chuandaura_ctdt($param)
{   
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_chuandaura_ctdt', $param, $bulk = false);
}


function get_chuandaura_ctdt_byID($id)
{
   global $DB;
   $result = $DB->get_record('block_edu_chuandaura_ctdt', ['id' => $id]);
   return $result;

}

function get_chuandaura_ctdt()
{
   global $DB;
   $result = $DB->get_records('block_edu_chuandaura_ctdt', []);
   $arr = array();
   foreach($result as $iresult){
      $arr[] = $iresult->ma_cdr;
   }
   return $arr;

}


function get_chuandaura_ctdt_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('', 'STT','Tên chuẩn đầu ra', 'Mã chuẩn đầu ra', 'Mã chương trình đào tạo', 'Mô tả');
   $allchuandaura_ctdts = $DB->get_records('block_edu_chuandaura_ctdt', []);
   $stt = 1 + $page * 5;
   $pos_in_table = 1;

   foreach ($allchuandaura_ctdts as $item) {
      if (findContent($item->ten, $key_search) || $key_search == '') {

      $checkbox = html_writer::tag('input', ' ', array('class' => 'chuandauractdtcheckbox', 'type' => "checkbox", 'name' => $item->id, 'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
      $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/update.php', [ 'id' => $item->id]);
      $ten_url = \html_writer::link($url, $item->ten);

      if ($page < 0) { // Get all data without page
         $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $item->ma_cdr,(string) $item->ma_ctdt, (string) $item->mota];
         $stt = $stt + 1;
      } else if ($pos_in_table > $page * 5 && $pos_in_table <= $page * 5 + 5) {
         $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $item->ma_cdr,(string) $item->ma_ctdt, (string) $item->mota];
         $stt = $stt + 1;
      }
      $pos_in_table = $pos_in_table + 1;

      }
   }
   return $table;
}

