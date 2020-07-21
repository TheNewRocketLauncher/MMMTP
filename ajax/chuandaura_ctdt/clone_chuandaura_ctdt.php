<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/chuandaura_ctdt_model.php');
$id = required_param('id', PARAM_INT);

$cdr = get_chuandaura_ctdt_byID($id);
$ma_cay_cdr = $cdr->ma_cay_cdr;
while(get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr) != NULL){
    $ma_cay_cdr++;
}

$listcdr = get_list_cdr_byMaCayCDR($cdr->ma_cay_cdr);
foreach($listcdr as $item){
    $item->ma_cay_cdr = $ma_cay_cdr;
    $item->is_used = 0;
    unset($item->id);
    insert_cdr($item);
}

exit;