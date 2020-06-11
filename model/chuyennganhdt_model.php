<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once('../../js.php');

 function insert_chuyennganhdt($param) {
     
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_chuyennganhdt', $param);
 }

 function update_chuyennganhdt($param) {
  
  global $DB, $USER, $CFG, $COURSE;
  $DB->update_record('block_edu_chuyennganhdt', $param, $bulk = false);
 }

 function get_chuyennganhdt() {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Chuyên ngành đào tạo', 'Mô tả');
    $allchuyennganhdts = $DB->get_records('block_edu_chuyennganhdt', []);
    $stt = 1;
    foreach ($allchuyennganhdts as $ichuyennganhdt) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/update_chuyennganhdt.php', ['courseid' => $courseid, 'id' => $ichuyennganhdt->id]);
      $ten_url = \html_writer::link($url, $ichuyennganhdt->ten);
        $table->data[] = [(string)$stt, $ten_url, (string)$ichuyennganhdt->mota];
        $stt = $stt+1;
    }
    return $table;
 }

 function get_table_chuyennganhdt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Chuyên ngành đào tạo', 'Mô tả');
    $chuyennganhdt = $DB->get_record('block_edu_chuyennganhdt', ['id' => $id]);
    $table->data[] = [(string)$id,(string)$chuyennganhdt->ten,(string)$chuyennganhdt->mota];
    return $table;
 }

 function get_chuyennganhdt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $chuyennganhdt = $DB->get_record('block_edu_chuyennganhdt', ['id' => $id]);
    return $chuyennganhdt;
 }

 function get_chuyennganhdt_checkbox($id){
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('','STT', 'Chuyên ngành đào tạo', 'Mô tả');
   $allchuyennganhdts = $DB->get_records('block_edu_chuyennganhdt', []);
   $stt = 1;    
   setcookie("arr", [0,1], time() + (86400 * 30), "/");

   foreach ($allchuyennganhdts as $ichuyennganhdt) {
      

      $checkbox = html_writer::tag('input', ' ', array('class' => 'chuyennganhdtcheckbox','type' => "checkbox", 'name' => $ichuyennganhdt->id, 'id' => 'chuyennganhdt' . $ichuyennganhdt->id, 'value' => '0', 'onclick' => "changecheck_chuyennganhdt($ichuyennganhdt->id)"));   
      $url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/update_chuyennganhdt.php', ['courseid' => $courseid, 'id' => $ichuyennganhdt->id]);
      $ten_url = \html_writer::link($url, $ichuyennganhdt->ten);
      $table->data[] = [$checkbox, (string)$stt, $ten_url,(string)$ichuyennganhdt->mota];
      $stt = $stt+1;
   }
   return $table;
 }
 
