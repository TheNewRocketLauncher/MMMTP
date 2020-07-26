<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("hedt", "edit");
function clone_hedt($id)
{
    global $DB;
    // Clone param
    $param = $DB->get_record('eb_hedt', array('id' => $id));
    // Config param
    $ma_he = $param->ma_he . '_copy';
    $stt = 1;
    while ($DB->count_records('eb_hedt', array('ma_he' => $ma_he . (string) $stt))) {
        $stt++;
    }
    $ma_he .= (string) $stt;
    // Insert clone record
    $param->id = null;
    $param->ma_he = $ma_he;
    $DB->insert_record('eb_hedt', $param);
}
// Clone hệ đào tạo có id truyền vào
clone_hedt($id);
// return
$output = "Clone HDT has ID = " . $id . " successfully!";
echo $output;
exit;
