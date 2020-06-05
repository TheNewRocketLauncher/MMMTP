<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');



 function insert_hedt($param) {
     /*
     $param = new stdClass();
     $param->ma_bac = 'DH';
     $param->ma_he = 'DHCQ';
     $param->ten = 'Đại học Chính quy';
     $param->mota = 'Bậc Đại học CQ HCMUS'
     */
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_hedt', $param);
 }
 function update_hedt($param) {
   /*
    $param = new stdClass();
    $param->ma_bac = 'DH';
    $param->ten = 'Đại học';
    $param->mota = 'Bậc Đại học HCMUS'
   */
  global $DB, $USER, $CFG, $COURSE;
  $DB->update_record('block_edu_hedt', $param, $bulk = false);
}
 function get_hedt($courseid) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Bậc đào tạo', 'Hệ đào tạo', 'Mô tả');
    $allhedts = $DB->get_records('block_edu_hedt', []);
    $stt = 1;
    foreach ($allhedts as $ihedt) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/qlhe.php', ['courseid' => $courseid, 'id' => $ihedt->id]);
      $ten_url = \html_writer::link($url, $ihedt->ten);
        $table->data[] = [(string)$stt,'Đại học',$ten_url,(string)$ihedt->mota];
        $stt = $stt+1;
    }
    return $table;
 }
 function get_table_hedt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Bậc đào tạo', 'Hệ đào tạo', 'Mô tả');
    $hedt = $DB->get_record('block_edu_hedt', ['id' => $id]);
    $table->data[] = [(string)$id,'Đại học',(string)$hedt->ten,(string)$hedt->mota];
    return $table;
 }

 function get_hedt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $hedt = $DB->get_record('block_edu_hedt', ['id' => $id]);
    return $hedt;
 } 
 function get_hedt_checkbox($courseid) {
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Bậc đào tạo', 'Hệ đào tạo', 'Mô tả');
   $allhedts = $DB->get_records('block_edu_hedt', []);
   $stt = 1;
   foreach ($allhedts as $ihedt) {
     $checkbox = html_writer::tag('input', ' ', array('class' => 'hdtcheckbox','type' => "checkbox", 'name' => $ihedt->id, 'id' => 'hdt' . $ihedt->id, 'value' => '0', 'onclick' => "changecheck_hedt($ihedt->id)"));   
     $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/update_hdt.php', ['courseid' => $courseid, 'id' => $ihedt->id]);
     $ten_url = \html_writer::link($url, $ihedt->ten);
       $table->data[] = [$checkbox, (string)$stt,'Đại học',$ten_url,(string)$ihedt->mota];
       $stt = $stt+1;
   }
   return $table;
}
