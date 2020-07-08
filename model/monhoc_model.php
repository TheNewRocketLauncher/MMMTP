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

function insert_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_monhoc', $param);
}

function update_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_monhoc', $param);
}

function get_monhoc_table($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Mã môn học', 'Tên môn hoc', 'Trạng thái' ,'Số tín chỉ','Loại học phần');
   $alldatas = $DB->get_records('block_edu_monhoc', []);
   $stt = 1 + $page * 5;
   foreach ($alldatas as $idata) {
      if (findContent($idata->tenmonhoc_vi, $key_search) || $key_search == '') {
            
         // url
         $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $idata->id]);
         $ten_url = \html_writer::link($url, $idata->tenmonhoc_vi);

        

         if ($page < 0) { // Get all data without page
			$lopmo;
      
		      if ($imonhoc->lopmo == 1){
		         $lopmo= "Đã mở" ; 
		      }
		      else{
		         $lopmo= "Chưa mở";
		      }
            // checkbox
            $checkbox = html_writer::tag('input', ' ', array('class' => 'monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_monhoc($idata->id)"));

            // add table
            $table->data[] = [$checkbox, (string) $stt, (string) $idata->mamonhoc, $ten_url, $lopmo, (string) $idata->sotinchi,(string)$idata->loaihocphan];
            $stt = $stt + 1;
         } else if ($pos_in_table >= $page * 5 && $pos_in_table < $page * 5 + 5) {
			$lopmo;
      
		      if ($imonhoc->lopmo == 1){
		         $lopmo= "Đã mở" ; 
		      }
		      else{
		         $lopmo= "Chưa mở";
		      }
            // checkbox
            $checkbox = html_writer::tag('input', ' ', array('class' => 'monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_monhoc($idata->id)"));

            // add table
            $table->data[] = [$checkbox, (string) $stt, (string) $idata->mamonhoc, $ten_url,$lopmo, (string) $idata->sotinchi,(string)$idata->loaihocphan];
            $stt = $stt + 1;
         }
         $pos_in_table = $pos_in_table + 1;
      }
   }
   return $table;
}

function get_monhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_monhoc', array('mamonhoc' => $mamonhoc));
}

function get_monhoc_by_id_monhoc($id)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_monhoc', array('id' => $id));
}


function get_muctieu_monmhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Mục tiêu', 'Mô tả', 'Chuẩn đầu ra');
   $alldatas = $DB->get_records('block_edu_muctieumonhoc', array('mamonhoc' => $mamonhoc));
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_muctieumonhoc.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link($url, $idata->muctieu);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'muctieumonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'muctieumonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_muctieumonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->mota, (string) $idata->danhsach_cdr];
      $stt = $stt + 1;
   }
   return $table;
}
function get_muctieu_monmhoc_by_madc($ma_decuong, $ma_ctdt, $mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Mục tiêu', 'Mô tả', 'Chuẩn đầu ra');
   $alldatas = $DB->get_records('block_edu_muctieumonhoc', array('ma_decuong' => $ma_decuong));
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_muctieu_monhoc.php', ['id' => $idata->id, 'ma_decuong'=>$ma_decuong, 'ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc]);
      $ten_url = \html_writer::link($url, $idata->muctieu);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'muctieumonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'muctieumonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_muctieumonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->mota, (string) $idata->danhsach_cdr];
      $stt = $stt + 1;
   }
   return $table;
}
function get_muctieu_monmhoc_by_madc_1($ma_decuong, $ma_ctdt, $mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   
   $arr = array();
   $alldatas = $DB->get_records('block_edu_muctieumonhoc', array('ma_decuong' => $ma_decuong));
   
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
   return $DB->get_record('block_edu_muctieumonhoc', array('id' => $id_monhoc));
}
function update_muctieumonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_muctieumonhoc', $param);
}

function get_chuandaura_monmhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Chuẩn đầu ra', 'Mô tả(Mức chi tiết-hành động)', 'Mức độ(I/T/U)');
   $alldatas = $DB->get_records('block_edu_chuandaura', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_chuandaura.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link($url, $idata->ma_cdr);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'chuandaura_monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'chuandaura_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_chuandaura_monhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->mota, (string) $idata->mucdo_utilize];
      $stt = $stt + 1;
   }
   return $table;
}
function get_chuandaura_monmhoc_by_madc($ma_decuong, $ma_ctdt, $mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Chuẩn đầu ra', 'Mô tả(Mức chi tiết-hành động)', 'Mức độ(I/T/U)');
   $alldatas = $DB->get_records('block_edu_chuandaura', ['ma_decuong' => $ma_decuong]);

   usort($alldatas, function($a, $b)
   {
      return strcmp($a->ma_cdr, $b->ma_cdr);
   });

   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_chuan_daura.php', ['id' => $idata->id, 'ma_decuong'=>$ma_decuong, 'ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc]);
      $ten_url = \html_writer::link($url, $idata->ma_cdr);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'chuandaura_monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'chuandaura_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_chuandaura_monhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->mota, (string) $idata->mucdo_utilize];
      $stt = $stt + 1;
   }

  
   return $table;
}

function get_chuandaura_monmhoc_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_chuandaura', array('id' => $id_monhoc));
}

function update_chuandaura_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_chuandaura', $param);
}

function get_kehoachgiangday_LT_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $alldatas = $DB->get_records('block_edu_kh_giangday_lt', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_kehoachgiangday_lt.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link($url, $idata->ten_chude);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'kehoachgiangday_LT_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoachgiangday_LT' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoachgiangday_LT($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->danhsach_cdr, (string) $idata->hoatdong_gopy, (string) $idata->hoatdong_danhgia];
      $stt = $stt + 1;
   }
   return $table;
}
function get_kehoachgiangday_LT_by_ma_decuong($ma_decuong, $ma_ctdt, $mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $alldatas = $DB->get_records('block_edu_kh_giangday_lt', ['ma_decuong' => $ma_decuong]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_kehoach_giangday_lt.php', ['id' => $idata->id, 'ma_decuong'=>$ma_decuong, 'ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc]);
      $ten_url = \html_writer::link($url, $idata->ten_chude);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'kehoachgiangday_LT_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoachgiangday_LT' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoachgiangday_LT($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->danhsach_cdr, (string) $idata->hoatdong_gopy, (string) $idata->hoatdong_danhgia];
      $stt = $stt + 1;
   }
   return $table;
}

function get_kehoachgiangday_LT_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_kh_giangday_lt', array('id' => $id_monhoc));
}

function update_kehoachgiangday_lt_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_kh_giangday_lt', $param);
}

function get_kehoachgiangday_TH_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Tuần', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $alldatas = $DB->get_records('block_edu_kh_giangday_th', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'kehoachgiangday_TH_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoachgiangday_TH' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoachgiangday_TH($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, (int) $idata->tuan, (string) $idata->ten_chude, (string) $idata->danhsach_cdr, (string) $idata->hoatdong_gopy, (string) $idata->hoatdong_danhgia];
      $stt = $stt + 1;
   }
   return $table;
}

function get_danhgiamonhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Mã', 'Tên', 'Mô tả (gợi ý)', 'Các chuẩn', 'Tỷ lệ (%)');
   $alldatas = $DB->get_records('block_edu_danhgiamonhoc', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_danhgiamonhoc.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link($url, $idata->tendanhgia);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'danhgiamonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'danhgiamonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_danhgiamonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, (string) $idata->madanhgia, $ten_url, (string) $idata->motadanhgia, (string) $idata->chuandaura_danhgia, (string) $idata->tile_danhgia];
      $stt = $stt + 1;
   }
   return $table;
}
function get_danhgiamonhoc_by_ma_decuong($ma_decuong, $ma_ctdt, $mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Mã', 'Tên', 'Mô tả (gợi ý)', 'Các chuẩn', 'Tỷ lệ (%)');
   $alldatas = $DB->get_records('block_edu_danhgiamonhoc', ['ma_decuong' => $ma_decuong]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_danhgia_monhoc.php', ['id' => $idata->id, 'ma_decuong'=>$ma_decuong, 'ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc]);
      $ten_url = \html_writer::link($url, $idata->madanhgia);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'danhgiamonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'danhgiamonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_danhgiamonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string)$idata->tendanhgia, (string) $idata->motadanhgia, (string) $idata->chuandaura_danhgia, (string) $idata->tile_danhgia];
      $stt = $stt + 1;
   }
   return $table;
}

function get_danhgiamonhoc_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_danhgiamonhoc', array('id' => $id_monhoc));
}

function update_danhgiamonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_danhgiamonhoc', $param);
}

function get_tainguyenmonhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Loại tài nguyên', 'Mô tả (gợi ý)', 'Link đính kèm');
   $alldatas = $DB->get_records('block_edu_tainguyenmonhoc', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'tainguyenmonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'tainguyenmonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_tainguyenmonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, (string) $idata->loaitainguyen, (string) $idata->mota_tainguyen, (string) $idata->link_tainguyen];
      $stt = $stt + 1;
   }
   return $table;
}
function get_tainguyenmonhoc_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_tainguyenmonhoc', array('id' => $id_monhoc));
}
function get_tainguyenmonhoc_by_ma_decuong($ma_decuong, $ma_ctdt, $mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT',  'Mô tả (gợi ý)','Loại tài nguyên', 'Link đính kèm');
   $alldatas = $DB->get_records('block_edu_tainguyenmonhoc', ['ma_decuong' => $ma_decuong]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_tainguyen_monhoc.php', ['id' => $idata->id, 'ma_decuong'=>$ma_decuong, 'ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc]);
      $ten_url = \html_writer::link($url, $idata->mota_tainguyen);

      $checkbox = html_writer::tag('input', ' ', array('class' => 'tainguyenmonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'tainguyenmonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_tainguyenmonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt,  $ten_url, (string) $idata->loaitainguyen, (string) $idata->link_tainguyen];
      $stt = $stt + 1;
   }
   return $table;
}
function update_tainguyenmonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_tainguyenmonhoc', $param);
}

function get_quydinhchung_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Nội dung');
   $alldatas = $DB->get_records('block_edu_quydinhchung', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'quydinhchung_monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'quydinhchung_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_quydinhchung_monhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, (string) $idata->mota_quydinhchung];
      $stt = $stt + 1;
   }
   return $table;
}
function get_quydinhchung_by_ma_decuong($ma_decuong, $ma_ctdt, $mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Nội dung');
   $alldatas = $DB->get_records('block_edu_quydinhchung', ['ma_decuong' => $ma_decuong]);
   $stt = 1;
   foreach ($alldatas as $idata) {

      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_quydinh_monhoc.php', ['id' => $idata->id, 'ma_decuong'=>$ma_decuong, 'ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc]);
      $ten_url = \html_writer::link($url, $idata->mota_quydinhchung);

      $checkbox = html_writer::tag('input', ' ', array('class' => 'quydinhchung_monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'quydinhchung_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_quydinhchung_monhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url];
      $stt = $stt + 1;
   }
   return $table;
}
function get_quydinhchung_by_mamonhoc_1($id_monhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_quydinhchung', array('id' => $id_monhoc));
}
function update_quydinh_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_quydinhchung', $param);
}


function insert_decuong($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_decuong', $param);
}

function insert_muctieumonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_muctieumonhoc', $param);
}

function insert_chuandaura_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_chuandaura', $param);
}

function insert_kehoachgiangday_LT_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_kh_giangday_lt', $param);
}

function insert_kehoachgiangday_TH_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_kh_giangday_th', $param);
}

function insert_danhgiamonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_danhgiamonhoc', $param);
}

function insert_tainguyenmonhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_tainguyenmonhoc', $param);
}

function insert_quydinhchung_monhoc_table($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_quydinhchung', $param);
}


