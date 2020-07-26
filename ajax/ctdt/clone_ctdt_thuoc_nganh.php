<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$ma_nganh = required_param('ma_nganh', PARAM_ALPHANUMEXT);
require_once('../../controller/auth.php');
require_permission("ctdt", "edit");

function clone_ctdt_thuoc_nganh($id, $ma_nganh)
{
    global $DB;
    // Clone param
    $param = $DB->get_record('eb_ctdt', array('id' => $id));
    $param_ctdt_nganh = $DB->get_record('eb_ctdt_thuoc_nganh', array('ma_ctdt' => $param->ma_ctdt, 'ma_nganh' => $ma_nganh));
    // Config param
    $ma_ctdt = $param->ma_ctdt . '_copy';
    $stt = 1;
    while ($DB->count_records('eb_ctdt', array('ma_ctdt' => $ma_ctdt . (string) $stt))) {
        $stt++;
    }
    $ma_ctdt .= (string) $stt;
    // Insert clone record
    $param->id = null;
    $param->ma_ctdt = $ma_ctdt;
    $DB->insert_record('eb_ctdt', $param);

    // Config param_nganh_khoatuyen
    $param_ctdt_nganh->ma_ctdt = $param->ma_ctdt;
    $DB->insert_record('eb_ctdt_thuoc_nganh', $param_ctdt_nganh);

}
// Clone ngành đào tạo có id truyền vào
clone_ctdt_thuoc_nganh($id, $ma_nganh);
// return
$output = "Clone CTĐT có ID = " . $id . " trong ngành " . $ma_nganh ." thành công!";
echo $output;
exit;
