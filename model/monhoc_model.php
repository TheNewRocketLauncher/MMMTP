<?php
require_once(__DIR__ . '/../../../config.php');

 function insert_monhoc($param) {
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
        $table->data[] = [(string)$stt,(string)$imonhoc->ma_monhoc,(string)$imonhoc->ten_monhoc, (string)$imonhoc->so_tinchi];
        $stt = $stt+1;
    }
    return $table;
 }
