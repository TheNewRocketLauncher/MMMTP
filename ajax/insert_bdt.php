<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
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




    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param
    // $param1->id = 1;
    $param1->ma_bac = 'DHtest';
    $param1->ten = 'Đại học';
    $param1->mota = 'Bậc Đại học HCMUS';
    // $param
    // $param2->id = 2;
    $param2->ma_bac = 'CDtest';
    $param2->ten = 'Cao đẳng';
    $param2->mota = 'Bậc Cao đẳng HCMUS';
    // $param
    // $param3->id = 3;
    $param3->ma_bac = 'DTTXtest';
    $param3->ten = 'Đào tạo từ xa';
    $param3->mota = 'Bậc Đào tạo từ xa HCMUS';
    insert_bacdt($param1);
    insert_bacdt($param2);
    insert_bacdt($param3);
    // return
    $output = "Inserted successfully!";
    echo $output;
    exit;
 
