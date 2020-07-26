<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$mamonhoc = optional_param('mamonhoc','', PARAM_NOTAGS);

require_once('../../controller/auth.php');
require_permission("decuong", "edit");



function getdetail_monhoc($mamonhoc) {
    global $DB;

    $chitietmonhoc = $DB->get_record('eb_monhoc', array('mamonhoc' => $mamonhoc));  
    return $chitietmonhoc;
}

    
    $monhoc = getdetail_monhoc($mamonhoc);
    
    echo json_encode($monhoc);
    exit;
 
