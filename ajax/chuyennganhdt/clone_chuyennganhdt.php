<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("chuyennganhdt", "edit");
function clone_chuyennganhdt($id)
{
    global $DB, $USER, $CFG, $COURSE;
    // Clone param
    $param = $DB->get_record('eb_chuyennganhdt', array('id' => $id));
    // Config param
    $ma_chuyennganh = $param->ma_chuyennganh . '_copy';
    $stt = 1;
    while ($DB->count_records('eb_chuyennganhdt', array('ma_chuyennganh' => $ma_chuyennganh . (string) $stt))) {
        $stt++;
    }
    $ma_chuyennganh .= (string) $stt;
    // Insert clone record
    $param->id = null;
    $param->ma_chuyennganh = $ma_chuyennganh;
    $DB->insert_record('eb_chuyennganhdt', $param);
}
// Clone chuyên ngành đào tạo có id truyền vào
clone_chuyennganhdt($id);
// return
$output = "Clone chuyên ngành đt has ID = " . $id . " successfully!";
echo $output;
exit;
