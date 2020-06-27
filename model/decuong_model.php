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

function get_decuong_table($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ','STT', 'Mã đề cương', 'Mã CTDT', 'Mã khối', 'Mã môn học', 'Mô tả');
   $alldatas = $DB->get_records('block_edu_decuong', []);
   $stt = 1 + $page * 5;
   foreach ($alldatas as $idata) {
      if (findContent($idata->ma_decuong, $key_search) || $key_search == '') {
      
         $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php',  ['ma_ctdt'=>$idata->ma_ctdt, 'mamonhoc'=>$idata->mamonhoc, 'ma_decuong'=>$idata->ma_decuong]);
         $ten_url = \html_writer::link($url, $idata->ma_decuong);
         
         if ($page < 0) { // Get all data without page
         
            $checkbox = html_writer::tag('input', ' ', array('class' => 'decuong_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'decuongmonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_decuongmonhoc($idata->id)"));

            $table->data[] = [$checkbox, (string) $stt, $ten_url,(string) $idata->ma_ctdt, (string)$idata->ma_khoi,(string) $idata->mamonhoc, (string)$idata->mota];
            $stt = $stt + 1;
         } else if ($pos_in_table >= $page * 5 && $pos_in_table < $page * 5 + 5) {

            $checkbox = html_writer::tag('input', ' ', array('class' => 'decuong_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'decuongmonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_decuongmonhoc($idata->id)"));

            $table->data[] = [$checkbox, (string) $stt, $ten_url,(string) $idata->ma_ctdt, (string)$idata->ma_khoi,(string) $idata->mamonhoc, (string)$idata->mota];
            $stt = $stt + 1;
         }
         $pos_in_table = $pos_in_table + 1;

      }
   }
   return $table;
}
