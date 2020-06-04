<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');

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
 
