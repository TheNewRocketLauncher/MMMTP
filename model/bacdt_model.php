<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once('../../js.php');


 function insert_bacdt($param) {
     /*
      $param = new stdClass();
      $param->ma_bac = 'DH';
      $param->ten = 'Đại học';
      $param->mota = 'Bậc Đại học HCMUS'
     */
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_bacdt', $param);
 }
 function get_bacdt($courseid) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Bậc đào tạo', 'Mô tả');
    $allbacdts = $DB->get_records('block_edu_bacdt', []);
    $stt = 1;    
    foreach ($allbacdts as $ibacdt) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/qlbac.php', ['courseid' => $courseid, 'id' => $ibacdt->id_bac]);
      $ten_url = \html_writer::link($url, $ibacdt->ten);
        $table->data[] = [(string)$stt, $ten_url,(string)$ibacdt->mota];
        $stt = $stt+1;
    }
    return $table;
 }
 function get_table_bacdt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Bậc đào tạo', 'Mô tả');
    $bacdt = $DB->get_record('block_edu_bacdt', ['id_bac' => $id]);
    $table->data[] = [(string)$id,(string)$bacdt->ten,(string)$bacdt->mota];
    return $table;
 }

 function get_bacdt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $bacdt = $DB->get_record('block_edu_bacdt', ['id_bac' => $id]);
    return $bacdt;
 }
 
 function get_bacdt_checkbox($courseid) {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('','STT', 'Bậc đào tạo', 'Mô tả');
   $allbacdts = $DB->get_records('block_edu_bacdt', []);
   $stt = 1;    
   setcookie("arr", [0,1], time() + (86400 * 30), "/");

   foreach ($allbacdts as $ibacdt) {
      // Create checkbox
      // $check_id = 'bdt' . $ibacdt->id_bac;

      $checkbox = html_writer::tag('input', ' ', array('type' => "checkbox", 'name' => 'checkbok_name2', 'id' => 'bdt' . $ibacdt->id_bac, 'value' => $ibacdt->id_bac, 'onclick' => "changecheck($ibacdt->id_bac)"));   
      $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/qlbac.php', ['courseid' => $courseid, 'id' => $ibacdt->id_bac]);
      $ten_url = \html_writer::link($url, $ibacdt->ten);
      $table->data[] = [$checkbox, (string)$stt, $ten_url,(string)$ibacdt->mota];
      $stt = $stt+1;
   }
   return $table;
}
