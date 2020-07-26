<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/chuandaura_ctdt_model.php');
require_once('../../controller/auth.php');
require_permission("chuandaura_ctdt", "edit");
$id = required_param('id', PARAM_INT);

$cdr = get_cdr_byID($id);
$list_cdrcon = get_list_cdrcon($cdr->ma_cdr);

$cdr->ma_cdr = mt_rand();
while(get_cdr_byMaCDR($cdr->ma_cdr) != NULL){
    $cdr->ma_cdr = mt_rand();
}
insert_cdr($cdr);

foreach($list_cdrcon as $item){
    $item->ma_cdr_cha = $cdr->ma_cdr;
    while(get_cdr_byMaCDR($item->ma_cdr) != NULL){
        $item->ma_cdr++;
    }
    unset($item->id);
    insert_cdr($item);
}

exit;