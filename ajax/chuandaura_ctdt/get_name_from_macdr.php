<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_cdr = required_param('ma_cdr', PARAM_NOTAGS);
require_once('../../controller/auth.php');
require_permission("chuandaura_ctdt", "edit");
$cdr = $DB->get_record('eb_chuandaura_ctdt', ['ma_cdr' => $ma_cdr]);
    $data = $cdr->ten;
    // Trả về kết quả với json_encode
    echo json_encode($data);
    exit;
 
