<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_khoi = required_param('ma_khoi', PARAM_NOTAGS);
$courseid = required_param('course', PARAM_INT);
require_once('../../model/khoikienthuc_model.php');
require_once('../../controller/auth.php');
require_permission("khoikienthuc", "edit");

delete_kkt_byMaKhoi($ma_khoi);
// return
exit;

