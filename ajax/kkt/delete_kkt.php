<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
require_once('../../model/khoikienthuc_model.php');


delete_kkt_byID($id);
// return
exit;

