<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');


 function insert_chuyennganhdt($param) {
     
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_chuyennganhdt', $param);
 }
 function get_chuyennganhdt() {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Tên chuyên ngành đào tạo', 'Mô tả');
    $allchuyennganhdts = $DB->get_records('block_edu_chuyennganhdt', []);
    $stt = 1;
    foreach ($allchuyennganhdts as $ichuyennganhdt) {
        $table->data[] = [(string)$stt,(string)$ichuyennganhdt->ten_chuyennganh,(string)$ichuyennganhdt->mota];
        $stt = $stt+1;
    }
    return $table;
 }
 function get_table_chuyennganhdt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Tên chuyên ngành đào tạo', 'Mô tả');
    $chuyennganhdt = $DB->get_record('block_edu_chuyennganhdt', ['id_chuyennganh' => $id]);
    $table->data[] = [(string)$id,(string)$chuyennganhdt->ten_chuyennganh,(string)$chuyennganhdt->mota];
    return $table;
 }

 function get_chuyennganhdt_byID($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $chuyennganhdt = $DB->get_record('block_edu_chuyennganhdt', ['id_chuyennganh' => $id]);
    return $chuyennganhdt;
 }
 
