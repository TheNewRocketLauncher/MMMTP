<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');


 function insert_nganh($param) {
      global $DB, $USER, $CFG, $COURSE;
      $DB->insert_record('block_edu_nganhdt', $param);
 }


 function get_nganh() {
    global $DB, $USER, $CFG, $COURSE;  
    $table = new html_table();
    $table->head = array('STT', 'Mã ngành', 'Ngành đào tạo', 'Mô tả');
    $allnganhs = $DB->get_records('block_edu_nganhdt', []);
    $stt = 1;
    foreach ($allnganhs as $inganh) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/nganh/qlnganh.php', ['courseid' => $courseid, 'id' => $inganh->id_nganh]);
      $ten_url = \html_writer::link($url, $inganh->ten_nganh);
        $table->data[] = [(string)$stt,(string)$inganh->ma_nganh,$ten_url,(string)$inganh->mota];
        $stt = $stt+1;
    }
    return $table;
 }
 function get_table_nganhdt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT0', 'Mã ngành', 'Ngành đào tạo', 'Mô tả');

    $nganh = $DB->get_record('block_edu_nganhdt', ['id_nganh' => $id]);
    $table->data[] = [(string)$id,(string)$nganh->ma_nganh,(string)$nganh->ten_nganh,(string)$nganh->mota];
    return $table;
 }

 function get_nganhdt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $nganh = $DB->get_record('block_edu_nganhdt', ['id_nganh' => $id]);
    return $nganh;
 }
 
