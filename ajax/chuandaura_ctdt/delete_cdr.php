<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/chuandaura_ctdt_model.php');

$ma_cay_cdr = required_param('ma_cay_cdr', PARAM_NOTAGS);

if(can_edit_cdr($ma_cay_cdr)){
    delete_cdr_byMaCayCRT($ma_cay_cdr);
    echo json_encode(['error' => 0]);
} else{
    echo json_encode(['error' => 1, 'errorMess' => 'Chuẩn đầu ra đang được sử dụng']);
}





exit;
