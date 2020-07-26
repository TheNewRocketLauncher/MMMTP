<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/caykkt_model.php');
require_once('../../controller/auth.php');
require_permission("caykkt", "edit");
$id = required_param('id', PARAM_NOTAGS);
$courseid = required_param('course', PARAM_INT);


delete_caykkt_byMaCay($id);
exit;
