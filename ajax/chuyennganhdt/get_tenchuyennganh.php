<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
//$search = trim(optional_param('search', '', PARAM_NOTAGS));
$ma_chuyennganh = trim(required_param('ma_chuyennganh', PARAM_NOTAGS));
require_once('../../controller/auth.php');
require_permission("chuyennganhdt", "edit");
$courseid = required_param('course', PARAM_INT);

$ma_chuyennganh = $DB->get_record('eb_chuyennganhdt', ['ma_chuyennganh' => $ma_chuyennganh]);

echo $ma_chuyennganh->ten;
exit;
 
