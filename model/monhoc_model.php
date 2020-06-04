<?php
require_once(__DIR__ . '/../../../config.php');

 function insert_monhoc($param) {
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_monhoc', $param);
 }


 


 function get_monhoc_table() {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT0', 'Mã môn học','Tên môn hoc', 'Số tín chỉ');
    $allmonhocs = $DB->get_records('block_edu_monhoc', []);
    $stt = 1;
    $courseid = 1;
    foreach ($allmonhocs as $imonhoc) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/ql_monhoc.php', ['courseid' => $courseid, 'id' => $imonhoc->id_monhoc]);
      $ten_url = \html_writer::link($url, $imonhoc->ten_monhoc);
        $table->data[] = [(string)$stt,(string)$imonhoc->ma_monhoc,$ten_url, (string)$imonhoc->so_tinchi];
        $stt = $stt+1;
    }
    return $table;
 }
 
 function get_monhoc_byID($id) {
   global $DB, $USER, $CFG, $COURSE;    
   $monhoc = $DB->get_record('block_edu_monhoc', ['id_monhoc' => $id]);
   return $monhoc;
}
