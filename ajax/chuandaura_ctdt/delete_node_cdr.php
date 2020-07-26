<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/chuandaura_ctdt_model.php');
require_once('../../controller/auth.php');
require_permission("chuandaura_ctdt", "edit");
$id = required_param('id', PARAM_INT);
$id_con = required_param('id_con', PARAM_NOTAGS);

$cdr = get_cdr_byID($id);

if(can_edit_cdr($cdr->ma_cdr)){
    delete_cdrcon_byID($id_con);
    echo json_encode(['error' => 0]);
} else{
    echo json_encode(['error' => 1, 'errorMess' => 'Chuẩn đầu ra đang được sử dụng']);
}





exit;
