<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("nganhdt", "edit");
function clone_nganhdt($id)
{
    global $DB;
    // Clone param
    $param = $DB->get_record('eb_nganhdt', array('id' => $id));
    $ma_nganh_goc = $param->ma_nganh;
    // Config param
    $ma_nganh = $param->ma_nganh . '_copy';
    $stt = 1;
    while ($DB->count_records('eb_nganhdt', array('ma_nganh' => $ma_nganh . (string) $stt))) {
        $stt++;
    }
    $ma_nganh .= (string) $stt;
    // Insert clone record
    $param->id = null;
    $param->ma_nganh = $ma_nganh;
    $DB->insert_record('eb_nganhdt', $param);
    // Insert CTĐT
    $ctdt_thuoc_nganh = $DB->get_records('eb_ctdt_thuoc_nganh', ['ma_nganh' => $ma_nganh_goc]);
    foreach($ctdt_thuoc_nganh as $item) {
        $item->ma_nganh = $param->ma_nganh;
        $DB->insert_record('eb_ctdt_thuoc_nganh', $item);        
    }
}
// Clone ngành đào tạo có id truyền vào
clone_nganhdt($id);
// return
$output = "Clone ngành có ID = " . $id . " successfully!";
echo $output;
exit;
