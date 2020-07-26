<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("bacdt", "edit");
function clone_bacdt($id)
{
    global $DB;
    // Clone param
    $param = $DB->get_record('eb_bacdt', array('id' => $id));
    // Config param
    $ma_bac = $param->ma_bac . '_copy';
    $stt = 1;
    while ($DB->count_records('eb_bacdt', array('ma_bac' => $ma_bac . (string) $stt))) {
        $stt++;
    }
    $ma_bac .= (string) $stt;
    // Insert clone record
    $param->id = null;
    $param->ma_bac = $ma_bac;
    $DB->insert_record('eb_bacdt', $param);
}
// Clone bậc đào tạo có id truyền vào
clone_bacdt($id);
// return
$output = "Clone BDT has ID = " . $id . " successfully!";
echo $output;
exit;
