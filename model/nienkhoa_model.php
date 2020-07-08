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

function get_nienkhoa_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $nienkhoa = $DB->get_record('block_edu_nienkhoa', ['id' => $id]);
   return $nienkhoa;
}

function get_nienkhoa_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('', 'STT','Bậc đào tạo','Hệ đào tạo',  'Niên khóa đào tạo', 'Mô tả');
   $allnienkhoas = $DB->get_records('block_edu_nienkhoa', []);
   $stt = 1 + $page * 5;
   $pos_in_table = 1;
   foreach ($allnienkhoas as $inienkhoa) {
      if (findContent($inienkhoa->ten_nienkhoa, $key_search) || $key_search == '') {

      $checkbox = html_writer::tag('input', ' ', array('class' => 'nienkhoacheckbox', 'type' => "checkbox", 'name' => $inienkhoa->id, 'id' => 'bdt' . $inienkhoa->id, 'value' => '0', 'onclick' => "changecheck($inienkhoa->id)"));
      $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/update.php', ['id' => $inienkhoa->id]);
      $ten_url = \html_writer::link($url, $inienkhoa->ten_nienkhoa);


      if ($page < 0) { // Get all data without page
         $table->data[] = [$checkbox, (string) $stt,(string)$inienkhoa->ma_bac,(string)$inienkhoa->ma_he,$ten_url, (string) $inienkhoa->mota];
         $stt = $stt + 1;
      } else if ($pos_in_table > $page * 5 && $pos_in_table <= $page * 5 + 5) {
         $table->data[] = [$checkbox, (string) $stt,(string)$inienkhoa->ma_bac,(string)$inienkhoa->ma_he,$ten_url, (string) $inienkhoa->mota];
         $stt = $stt + 1;
      }
      $pos_in_table = $pos_in_table + 1;

      }
   }
   return $table;
}

function update_nienkhoa($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_nienkhoa', $param, $bulk = false);
}

function insert_nienkhoa($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_nienkhoa', $param);
}