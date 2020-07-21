<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/chuandaura_ctdt_model.php');

$id = required_param('id', PARAM_NOTAGS);

$cdr = get_chuandaura_ctdt_byID($id);

if(can_edit_cdr($cdr->ma_cay_cdr)){
    delete_cdr_byMaCayCRT($cdr->ma_cay_cdr);
    echo json_encode(['error' => 0]);
} else{
    echo json_encode(['error' => 1, 'errorMess' => 'Chuẩn đầu ra đang được sử dụng']);
}



exit;



