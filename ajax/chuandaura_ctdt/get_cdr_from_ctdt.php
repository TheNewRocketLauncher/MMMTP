<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_ctdt = required_param('ma_ctdt', PARAM_ALPHANUMEXT);
function get_cdr_from_ctdt($ma_ctdt) {
    global $DB, $USER, $CFG, $COURSE;
    $hdt = $DB->get_records('block_edu_chuandaura_ctdt', array('ma_ctdt' => $ma_ctdt));
    return $hdt;
}
$ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt' => $ma_ctdt]);

    $data = array();
    $data['ma_cdr'] = array();
    $data['ten_ctdt'] = $ctdt->mota;
    $rows = get_cdr_from_ctdt($ma_ctdt);    
    foreach ($rows as $item) {
        
        $data['ma_cdr'][] =& $item->ma_cdr;
      }
    // Trả về kết quả với json_encode
    echo json_encode($data);
    exit;
 
