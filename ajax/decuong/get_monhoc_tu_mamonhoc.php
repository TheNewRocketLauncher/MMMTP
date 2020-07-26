<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$mamonhoc = optional_param('mamonhoc','', PARAM_ALPHANUMEXT);

require_once('../../controller/auth.php');
require_permission("decuong", "edit");


function getMonhocByMaMonhoc($mamonhoc) {
    global $DB, $USER, $CFG, $COURSE;
    
    $monhoc = $DB->get_record('eb_monhoc', array('mamonhoc' => $mamonhoc));
    
    return $monhoc;
}


    $MonHoc = getMonhocByMaMonhoc($mamonhoc);
    
    echo json_encode($MonHoc);
    exit;
 
