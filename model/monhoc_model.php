<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../js.php');


 function insert_monhoc_table($param) {
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_monhoc', $param);
 }
function get_monhoc_table() {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Mã môn học','Tên môn hoc', 'Số tín chỉ');
   $allmonhocs = $DB->get_records('block_edu_monhoc', []);
   $stt = 1;
   foreach ($allmonhocs as $imonhoc) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/chitiet_monhoc.php', ['id' => $imonhoc->id_monhoc]);
      $ten_url = \html_writer::link($url, $imonhoc->ten_monhoc);
      $table->data[] = [(string)$stt,(string)$imonhoc->ma_monhoc, $ten_url, (string)$imonhoc->so_tinchi];
      $stt = $stt+1;
   }
   return $table;
}
function get_monhoc_by_id_monhoc($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_monhoc',array('id_monhoc' => $id_monhoc));
   
}

function get_muctieu_monmhoc_by_ma_monhoc($ma_monhoc) {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $allmuctieus = $DB->get_records('block_edu_muctieu_monhoc', ['ma_monhoc' => $ma_monhoc]);
   $table->head = array(' ','STT10', 'Mục tiêu', 'Mô tả', 'Chuẩn đầu ra');

   $stt = 1;
   foreach ($allmuctieus as $imuctieu) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'muctieu_monhoc_checkbox','type' => "checkbox", 'name' => $imuctieu->id_muctieu, 'id' => 'muctieu_monhoc' . $imuctieu->id_muctieu, 'value' => '0', 'onclick' => "changecheck_muctieu_monhoc($imuctieu->id_muctieu)"));   
      $table->data[] = [$checkbox, (string)$stt, (string)$imuctieu->muctieu, (string)$imuctieu->mota, (string)$imuctieu->danhsach_chuan_daura];
      $stt = $stt+1;
      
   }

   return $table;
}

function get_chuan_daura_monmhoc_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array('STT', 'Chuẩn đầu ra', 'Mô tả(Mức chi tiết-hành động)', 'Mức độ(I/T/U)');
   $allmuctieus = $DB->get_records('block_edu_chuandaura', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($allmuctieus as $imuctieu) {
      $table->data[] = [(string)$stt, (string)$imuctieu->ma_cdr, (string)$imuctieu->mota, (string)$imuctieu->mucdo_utilize];
      $stt = $stt+1;
      
   }

   return $table;
}

function get_kehoach_giangday_LT_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array('STT', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $allmuctieus = $DB->get_records('block_edu_kh_giangday_lt', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($allmuctieus as $imuctieu) {
      $table->data[] = [(string)$stt, (string)$imuctieu->ten_chude, (string)$imuctieu->danhsach_cdr, (string)$imuctieu->hoatdong_gopy, (string)$imuctieu->hoatdong_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_kehoach_giangday_TH_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array('STT','Tuần', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $allmuctieus = $DB->get_records('block_edu_kh_giangday_th', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($allmuctieus as $imuctieu) {
      $table->data[] = [(string)$stt, (int)$imuctieu->tuan, (string)$imuctieu->ten_chude, (string)$imuctieu->danhsach_cdr, (string)$imuctieu->hoatdong_gopy, (string)$imuctieu->hoatdong_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_danhgia_monhoc_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array('STT','Mã', 'Tên', 'Mô tả (gợi ý)', 'Các chuẩn', 'Tỷ lệ (%)');
   $allmuctieus = $DB->get_records('block_edu_danhgia_monhoc', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($allmuctieus as $imuctieu) {
      $table->data[] = [(string)$stt, (string)$imuctieu->ma_danhgia, (string)$imuctieu->ten_danhgia, (string)$imuctieu->mota_danhgia,(string)$imuctieu->chuan_daura_danhgia, (string)$imuctieu->tile_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_tainguyen_monhoc_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array('STT','Loại tài nguyên', 'Mô tả (gợi ý)', 'Link đính kèm');
   $allmuctieus = $DB->get_records('block_edu_tainguyen_monhoc', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($allmuctieus as $imuctieu) {
      $table->data[] = [(string)$stt, (string)$imuctieu->loai_tainguyen, (string)$imuctieu->mota_tainguyen, (string)$imuctieu->link_tainguyen];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_quydinh_chung_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array('STT','Nội dung');
   $allmuctieus = $DB->get_records('block_edu_quydinh_chung', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($allmuctieus as $imuctieu) {
      $table->data[] = [(string)$stt, (string)$imuctieu->mota_quydinh_chung];
      $stt = $stt+1;
      
   }

   return $table;
}

function insert_muctieu_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_muctieu_monhoc', $param);
}
function insert_chuandaura_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_chuandaura', $param);
}
function insert_kehoach_giangday_LT_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_KH_giangday_LT', $param);
}
function insert_kehoach_giangday_TH_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_KH_giangday_TH', $param);
}
function insert_danhgia_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_danhgia_monhoc', $param);
}
function insert_tainguyen_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_tainguyen_monhoc', $param);
}
function insert_quydinh_chung_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_quydinh_chung', $param);
}