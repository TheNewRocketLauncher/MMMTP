<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../js.php');

function insert_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_monhoc', $param);
}
function update_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_monhoc', $param);
}
function get_monhoc_table() {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Mã môn học','Tên môn hoc', 'Số tín chỉ', 'Actions');
   $allmonhocs = $DB->get_records('block_edu_monhoc', []);
   $stt = 1;
   foreach ($allmonhocs as $imonhoc) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/chitiet_monhoc.php', ['id' => $imonhoc->id]);
      $ten_url = \html_writer::link($url, $imonhoc->tenmonhoc_vi);
      
      $url1 = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $imonhoc->id]);
      $ten_url1 = \html_writer::link($url1, 'update');
      
      $table->data[] = [(string)$stt,(string)$imonhoc->mamonhoc, $ten_url, (string)$imonhoc->sotinchi, $ten_url1];
      $stt = $stt+1;
   }
   return $table;
}
function get_monhoc_by_id_monhoc($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_monhoc',array('id' => $id_monhoc));
   
}


function get_muctieu_monmhoc_by_mamonhoc($mamonhoc) {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT', 'Mục tiêu', 'Mô tả', 'Chuẩn đầu ra');
   $alldatas = $DB->get_records('block_edu_muctieumonhoc', array('mamonhoc' => $mamonhoc));

   $stt = 1;
   foreach ($alldatas as $idata) {

      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_muctieumonhoc.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link( $url, $idata->muctieu);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'muctieumonhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'muctieumonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_muctieumonhoc($idata->id)"));   
      // $btn_update = html_writer::tag('button', 'update', array('onClick'=>'')); 
      $table->data[] = [$checkbox,(string)$stt, $ten_url, (string)$idata->mota, (string)$idata->danhsach_cdr];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_muctieu_monmhoc_by_mamonhoc_1($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_muctieumonhoc',array('id' => $id_monhoc));
}
function update_muctieumonhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_muctieumonhoc', $param);
}

function get_chuandaura_monmhoc_by_mamonhoc($mamonhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT', 'Chuẩn đầu ra', 'Mô tả(Mức chi tiết-hành động)', 'Mức độ(I/T/U)');
   $alldatas = $DB->get_records('block_edu_chuandaura', ['mamonhoc' => $mamonhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_chuandaura.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link( $url, $idata->ma_cdr);

	  $checkbox = html_writer::tag('input', ' ', array('class' => 'chuandaura_monhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'chuandaura_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_chuandaura_monhoc($idata->id)"));   
      $table->data[] = [$checkbox, (string)$stt, $ten_url, (string)$idata->mota, (string)$idata->mucdo_utilize];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_chuandaura_monmhoc_by_mamonhoc_1($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_chuandaura',array('id' => $id_monhoc));
   
}
function update_chuandaura_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_chuandaura', $param);
}  

function get_kehoachgiangday_LT_by_mamonhoc($mamonhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $alldatas = $DB->get_records('block_edu_kh_giangday_lt', ['mamonhoc' => $mamonhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {

      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_kehoachgiangday_lt.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link( $url, $idata->ten_chude);

	$checkbox = html_writer::tag('input', ' ', array('class' => 'kehoachgiangday_LT_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoachgiangday_LT' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoachgiangday_LT($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, $ten_url, (string)$idata->danhsach_cdr, (string)$idata->hoatdong_gopy, (string)$idata->hoatdong_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_kehoachgiangday_LT_by_mamonhoc_1($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_kh_giangday_lt',array('id' => $id_monhoc));
   
}
function update_kehoachgiangday_lt_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_kh_giangday_lt', $param);
}  

function get_kehoachgiangday_TH_by_mamonhoc($mamonhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT','Tuần', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $alldatas = $DB->get_records('block_edu_kh_giangday_th', ['mamonhoc' => $mamonhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'kehoachgiangday_TH_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoachgiangday_TH' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoachgiangday_TH($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, (int)$idata->tuan, (string)$idata->ten_chude, (string)$idata->danhsach_cdr, (string)$idata->hoatdong_gopy, (string)$idata->hoatdong_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}


function get_danhgiamonhoc_by_mamonhoc($mamonhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT','Mã', 'Tên', 'Mô tả (gợi ý)', 'Các chuẩn', 'Tỷ lệ (%)');
   $alldatas = $DB->get_records('block_edu_danhgiamonhoc', ['mamonhoc' => $mamonhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {

      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_danhgiamonhoc.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link( $url, $idata->tendanhgia);

	$checkbox = html_writer::tag('input', ' ', array('class' => 'danhgiamonhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'danhgiamonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_danhgiamonhoc($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, (string)$idata->madanhgia, $ten_url, (string)$idata->motadanhgia,(string)$idata->chuandaura_danhgia, (string)$idata->tile_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_danhgiamonhoc_by_mamonhoc_1($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_danhgiamonhoc',array('id' => $id_monhoc));
   
}
function update_danhgiamonhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_danhgiamonhoc', $param);
}  



function get_tainguyenmonhoc_by_mamonhoc($mamonhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT','Loại tài nguyên', 'Mô tả (gợi ý)', 'Link đính kèm');
   $alldatas = $DB->get_records('block_edu_tainguyenmonhoc', ['mamonhoc' => $mamonhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'tainguyenmonhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'tainguyenmonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_tainguyenmonhoc($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, (string)$idata->loaitainguyen, (string)$idata->mota_tainguyen, (string)$idata->link_tainguyen];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_quydinhchung_by_mamonhoc($mamonhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT','Nội dung');
   $alldatas = $DB->get_records('block_edu_quydinhchung', ['mamonhoc' => $mamonhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'quydinhchung_monhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'quydinhchung_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_quydinhchung_monhoc($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, (string)$idata->mota_quydinhchung];
      $stt = $stt+1;
      
   }

   return $table;
}

function insert_muctieumonhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_muctieumonhoc', $param);
}
function insert_chuandaura_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_chuandaura', $param);
}
function insert_kehoachgiangday_LT_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_kh_giangday_lt', $param);
}
function insert_kehoachgiangday_TH_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_kh_giangday_th', $param);
}
function insert_danhgiamonhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_danhgiamonhoc', $param);
}
function insert_tainguyenmonhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_tainguyenmonhoc', $param);
}
function insert_quydinhchung_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_quydinhchung', $param);
}