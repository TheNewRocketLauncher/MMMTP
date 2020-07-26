<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_nganh = required_param('ma_nganh', PARAM_NOTAGS);

require_once('../../controller/auth.php');
require_permission("ctdt", "edit");


global $DB;

$arr = $DB->get_records('eb_ctdt_thuoc_nganh', ['ma_nganh'=>$ma_nganh]);

echo json_encode($arr);



exit;