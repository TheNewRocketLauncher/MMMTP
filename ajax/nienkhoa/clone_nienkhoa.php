<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("nienkhoa", "edit");
function clone_nienkhoa($id)
{
    global $DB;
    // Clone param
    $param = $DB->get_record('eb_nienkhoa', array('id' => $id));
    $ma_nienkhoa_goc = $param->ma_nienkhoa;
    // Config param
    $ma_nienkhoa = $param->ma_nienkhoa . '_copy';
    $stt = 1;
    while ($DB->count_records('eb_nienkhoa', array('ma_nienkhoa' => $ma_nienkhoa . (string) $stt))) {
        $stt++;
    }
    $ma_nienkhoa .= (string) $stt;
    // Insert clone record
    $param->id = null;
    $param->ma_nienkhoa = $ma_nienkhoa;
    $DB->insert_record('eb_nienkhoa', $param);
    // Insert ngành
    $nganh_thuoc_nienkhoa = $DB->get_records('eb_nganh_thuoc_nienkhoa', ['ma_nienkhoa' => $ma_nienkhoa_goc]);
    foreach($nganh_thuoc_nienkhoa as $item) {
        $item->ma_nienkhoa = $param->ma_nienkhoa;
        $DB->insert_record('eb_nganh_thuoc_nienkhoa', $item);        
    }

}
clone_nienkhoa($id);
// return
$output = "Clone KT has ID = " . $id . " successfully!";
echo $output;
exit;
