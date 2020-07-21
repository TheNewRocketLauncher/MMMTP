<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_khoi = required_param('ma_khoi', PARAM_NOTAGS);
$courseid = required_param('course', PARAM_INT);
require_once('../../model/khoikienthuc_model.php');


delete_kkt_byMaKhoi($ma_khoi);
// return
exit;

