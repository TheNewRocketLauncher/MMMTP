<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');

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

 function insert_nienkhoa($param) {
     
    //  $param = new stdClass();
    //  $param->id_he = '3';
    //  $param->ma_nienkhoa='AB';
    //  $param->ten='phong dep trai3';
    //  $param->mota = 'hello';
     
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_nienkhoa', $param);
 }
 function get_nienkhoa() {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Niên khóa', 'Mô tả');
    $allbacdts = $DB->get_records('block_edu_nienkhoa', []);
    $stt = 1;
    foreach ($allbacdts as $inienkhoa) {
        $table->data[] = [(string)$stt,(string)$inienkhoa->ten_nienkhoa,(string)$inienkhoa->mota];
        $stt = $stt+1;
    }
    return $table;
 }