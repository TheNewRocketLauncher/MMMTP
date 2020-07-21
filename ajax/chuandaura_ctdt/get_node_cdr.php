<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/chuandaura_ctdt_model.php');

$ma_cay_cdr = required_param('ma_cay_cdr', PARAM_NOTAGS);

$list_cdr = get_node_cdr_byMaCDR($ma_cay_cdr);

$list_node_cdr = array();
foreach($list_cdr as $item){
    if($item->ma_cdr != NULL){
        $list_node_cdr[] = ['text' => $item->ten, 'value' => $item->ma_cdr];
    }
}

usort($list_node_cdr, function($a, $b)
    {
        return strcmp($a['value'], $b['value']);
    });

echo json_encode($list_node_cdr);





exit;
