<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/ctdt_model.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("ctdt", "edit");

function clone_ctdt($id)
{
    global $DB;
    // Clone param
    $param = $DB->get_record('eb_ctdt', array('id' => $id));
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

}
// Clone ngành dào t?o có id truy?n vào
clone_ctdt($id);
// return
$output = "Clone CTÐT có ID = " . $id . "thành công!";
echo $output;
exit;
