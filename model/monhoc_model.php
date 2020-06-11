﻿<?php
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
      $ten_url = \html_writer::link($url, $imonhoc->ten_monhoc_vi);
      
      $url1 = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $imonhoc->id]);
      $ten_url1 = \html_writer::link($url1, 'update');
      
      $table->data[] = [(string)$stt,(string)$imonhoc->ma_monhoc, $ten_url, (string)$imonhoc->so_tinchi, $ten_url1];
      $stt = $stt+1;
   }
   return $table;
}
function get_monhoc_by_id_monhoc($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_monhoc',array('id' => $id_monhoc));
   
}


function get_muctieu_monmhoc_by_ma_monhoc($ma_monhoc) {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT', 'Mục tiêu', 'Mô tả', 'Chuẩn đầu ra');
   $alldatas = $DB->get_records('block_edu_muctieu_monhoc', array('ma_monhoc' => $ma_monhoc));

   $stt = 1;
   foreach ($alldatas as $idata) {

      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_muctieu_monhoc.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link( $url, $idata->muctieu);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'muctieu_monhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'muctieu_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_muctieu_monhoc($idata->id)"));   
      // $btn_update = html_writer::tag('button', 'update', array('onClick'=>'')); 
      $table->data[] = [$checkbox,(string)$stt, $ten_url, (string)$idata->mota, (string)$idata->danhsach_cdr];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_muctieu_monmhoc_by_ma_monhoc_1($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_muctieu_monhoc',array('id' => $id_monhoc));
}
function update_muctieu_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_muctieu_monhoc', $param);
}

function get_chuan_daura_monmhoc_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT', 'Chuẩn đầu ra', 'Mô tả(Mức chi tiết-hành động)', 'Mức độ(I/T/U)');
   $alldatas = $DB->get_records('block_edu_chuandaura', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_chuan_daura.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link( $url, $idata->ma_cdr);

	  $checkbox = html_writer::tag('input', ' ', array('class' => 'chuandaura_monhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'chuandaura_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_chuandaura_monhoc($idata->id)"));   
      $table->data[] = [$checkbox, (string)$stt, $ten_url, (string)$idata->mota, (string)$idata->mucdo_utilize];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_chuan_daura_monmhoc_by_ma_monhoc_1($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_chuandaura',array('id' => $id_monhoc));
   
}
function update_chuan_daura_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_chuandaura', $param);
}  

function get_kehoach_giangday_LT_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $alldatas = $DB->get_records('block_edu_kh_giangday_lt', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {

      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_kehoach_giangday_lt.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link( $url, $idata->ten_chude);

	$checkbox = html_writer::tag('input', ' ', array('class' => 'kehoach_giangday_LT_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoach_giangday_LT' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoach_giangday_LT($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, $ten_url, (string)$idata->danhsach_cdr, (string)$idata->hoatdong_gopy, (string)$idata->hoatdong_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_kehoach_giangday_LT_by_ma_monhoc_1($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_kh_giangday_lt',array('id' => $id_monhoc));
   
}
function update_kehoach_giangday_lt_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_kh_giangday_lt', $param);
}  

function get_kehoach_giangday_TH_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT','Tuần', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $alldatas = $DB->get_records('block_edu_kh_giangday_th', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'kehoach_giangday_TH_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoach_giangday_TH' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoach_giangday_TH($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, (int)$idata->tuan, (string)$idata->ten_chude, (string)$idata->danhsach_cdr, (string)$idata->hoatdong_gopy, (string)$idata->hoatdong_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}


function get_danhgia_monhoc_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT','Mã', 'Tên', 'Mô tả (gợi ý)', 'Các chuẩn', 'Tỷ lệ (%)');
   $alldatas = $DB->get_records('block_edu_danhgia_monhoc', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {

      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_danhgia_monhoc.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link( $url, $idata->ten_danhgia);

	$checkbox = html_writer::tag('input', ' ', array('class' => 'danhgia_monhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'danhgia_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_danhgia_monhoc($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, (string)$idata->ma_danhgia, $ten_url, (string)$idata->mota_danhgia,(string)$idata->chuan_daura_danhgia, (string)$idata->tile_danhgia];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_danhgia_monhoc_by_ma_monhoc_1($id_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   return $DB->get_record('block_edu_danhgia_monhoc',array('id' => $id_monhoc));
   
}
function update_danhgia_monhoc_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_danhgia_monhoc', $param);
}  



function get_tainguyen_monhoc_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT','Loại tài nguyên', 'Mô tả (gợi ý)', 'Link đính kèm');
   $alldatas = $DB->get_records('block_edu_tainguyen_monhoc', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'tainguyen_monhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'tainguyen_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_tainguyen_monhoc($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, (string)$idata->loai_tainguyen, (string)$idata->mota_tainguyen, (string)$idata->link_tainguyen];
      $stt = $stt+1;
      
   }

   return $table;
}
function get_quydinh_chung_by_ma_monhoc($ma_monhoc){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();

   $table->head = array(' ','STT','Nội dung');
   $alldatas = $DB->get_records('block_edu_quydinh_chung', ['ma_monhoc' => $ma_monhoc]);

   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'quydinh_chung_monhoc_checkbox','type' => "checkbox", 'name' => $idata->id, 'id' => 'quydinh_chung_monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_quydinh_chung_monhoc($idata->id)"));   
      $table->data[] = [$checkbox,(string)$stt, (string)$idata->mota_quydinh_chung];
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
   $DB->insert_record('block_edu_kh_giangday_lt', $param);
}
function insert_kehoach_giangday_TH_table($param) {
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_kh_giangday_th', $param);
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