<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once('../../js.php');
// insert into bacdt table
// function insert_bacdt() {
   //     global $DB, $USER, $CFG, $COURSE, $bacDTinserted;

   //     $dataObj1 = new stdClass();
   //     $dataObj1->ma_bac = 'DH';
   //     $dataObj1->ten = 'Đại học';
   //     $dataObj1->mota = 'Bậc Đại học HCMUS';

   //     $dataObj2 = new stdClass();
   //     $dataObj2->ma_bac = 'CD';
   //     $dataObj2->ten = 'Đại học';
   //     $dataObj2->mota = 'Bậc Đại học HCMUS';

   //     $dataObj3 = new stdClass();
   //     $dataObj3->ma_bac = 'DTTX';
   //     $dataObj3->ten = 'Đại học';
   //     $dataObj3->mota = 'Bậc Đại học HCMUS';
      
   //     $DB->insert_record('block_edu_bacdt', $dataObj1);
   //     $DB->insert_record('block_edu_bacdt', $dataObj2);
   //     $DB->insert_record('block_edu_bacdt', $dataObj3);
//  }

 function insert_khoahoc($param) {
     /*
      $param = new stdClass();
      $param->ma_bac = 'DH';
      $param->ten = 'Đại học';
      $param->mota = 'Bậc Đại học HCMUS'
     */
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_khoahoc', $param);
 }




 function get_khoahoc_byID($id) {
      global $DB, $USER, $CFG, $COURSE;    
      $khoahoc = $DB->get_record('block_edu_khoahoc', ['id' => $id]);
      return $khoahoc;
 }
   

function get_khoahoc_checkbox($courseid) {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('','STT', 'Id môn học','Tên khóa học', 'Giáo viên phụ trách','Mô tả');
   $allkhoahocs = $DB->get_records('block_edu_khoahoc', []);
   $stt = 1;    
   setcookie("arr", [0,1], time() + (86400 * 30), "/");

   foreach ($allkhoahocs as $ikhoahoc) {
      // Create checkbox
      // $check_id = 'bdt' . $ikhoahoc->id;

      $checkbox = html_writer::tag('input', ' ', array('class' => 'khoahoccheckbox','type' => "checkbox", 'name' => $ikhoahoc->id, 'id' => 'bdt' . $ikhoahoc->id, 'value' => '0', 'onclick' => "changecheck($ikhoahoc->id)")); 
      

      $url = new \moodle_url('/blocks/educationpgrs/pages/khoahoc/update_khoahoc.php', ['courseid' => $courseid, 'id' => $ikhoahoc->id]);
      $ten_url = \html_writer::link($url, $ikhoahoc->ten_khoahoc);

      $table->data[] = [$checkbox, (string)$stt,(string)$ikhoahoc->id_monhoc, $ten_url, (string)$ikhoahoc->giaovien_phutrach,(string)$ikhoahoc->mota];
      $stt = $stt+1;
   }
   return $table;
 }
 function update_khoahoc($param) {
   /*
    $param = new stdClass();
    $param->ma_bac = 'DH';
    $param->ten = 'Đại học';
    $param->mota = 'Bậc Đại học HCMUS'
   */
  global $DB, $USER, $CFG, $COURSE;
  $DB->update_record('block_edu_khoahoc', $param, $bulk = false);
}


function get_khoahoc_table() {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Id môn học','Tên khóa học', 'Giáo viên phụ trách','Mô tả');
   $allkhoahocs = $DB->get_records('block_edu_khoahoc', []);
   $stt = 1;
   foreach ($allkhoahocs as $ikhoahoc) {
       $table->data[] = [(string)$stt,(string)$ikhoahoc->id_monhoc,(string)$ikhoahoc->ten_khoahoc, (string)$ikhoahoc->giaovien_phutrach,(string)$ikhoahoc->mota];
       $stt = $stt+1;
   }
   return $table;

 }