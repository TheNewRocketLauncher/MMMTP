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

function insert_bacdt($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_bacdt', $param);
}

function update_bacdt($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_bacdt', $param, $bulk = false);
}

function get_bacdt()
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Bậc đào tạo', 'Mô tả');
   $allbacdts = $DB->get_records('block_edu_bacdt', []);
   $stt = 1;
   foreach ($allbacdts as $ibacdt) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/update_bdt.php', ['id' => $ibacdt->id]);
      $ten_url = \html_writer::link($url, $ibacdt->ten);
      $table->data[] = [(string) $stt, $ten_url, (string) $ibacdt->mota];
      $table->data[$stt]->attributes['style'] = "width: 100%; text-align: center; border: 1px solid black";
      $stt = $stt + 1;
   }
   $table->attributes['style'] = "width: 100%; border: 1px solid red";

   return $table;
}

function get_table_bacdt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Bậc đào tạo old', 'Mô tả');
   $bacdt = $DB->get_record('block_edu_bacdt', ['id' => $id]);
   $table->data[] = [(string) $id, (string) $bacdt->ten, (string) $bacdt->mota];
   return $table;
}

function get_bacdt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $bacdt = $DB->get_record('block_edu_bacdt', ['id' => $id]);
   return $bacdt;
}

function get_bacdt_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('', 'STT', 'Bậc đào tạo', 'Mô tả search');
   $allbacdts = $DB->get_records('block_edu_bacdt', []);
   $stt = 1 + $page * 5;
   $pos_in_table = 1;
   foreach ($allbacdts as $ibacdt) {
      if (findContent($ibacdt->ten, $key_search) || $key_search == '') {
         $checkbox = html_writer::tag('input', ' ', array('class' => 'bdtcheckbox', 'type' => "checkbox", 'name' => $ibacdt->id, 'id' => 'bdt' . $ibacdt->id, 'value' => '0', 'onclick' => "changecheck($ibacdt->id)"));
         $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/update_bdt.php', ['id' => $ibacdt->id]);
         $ten_url = \html_writer::link($url, $ibacdt->ten);
         if ($page < 0) { // Get all data without page
            $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $ibacdt->mota];
            $stt = $stt + 1;
         } else if ($pos_in_table > $page * 5 && $pos_in_table <= $page * 5 + 5) {
            $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $ibacdt->mota];
            $stt = $stt + 1;
         }
         $pos_in_table = $pos_in_table + 1;
      }
   }
   return $table;
}
