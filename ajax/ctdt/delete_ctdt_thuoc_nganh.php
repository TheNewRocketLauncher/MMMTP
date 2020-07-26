<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$ma_nganh = required_param('ma_nganh', PARAM_ALPHANUMEXT);

require_once('../../controller/auth.php');
require_permission("ctdt", "edit");

function delete_ctdt_thuoc_nganh($id, $ma_nganh)
{
    global $DB;

    // Tìm ra mã ctdt từ id
    $ma_ctdt = $DB->get_record('eb_ctdt', ['id' => $id])->ma_ctdt;
    // Xóa liên kết
    $DB->delete_records('eb_ctdt_thuoc_nganh', array('ma_nganh' => $ma_nganh, 'ma_ctdt' => $ma_ctdt));
    $message = 'Success';
    return $message;
}

// Xóa ngành đào tạo có id truyền vào
$output = delete_ctdt_thuoc_nganh($id, $ma_nganh);
// return
echo $output;
exit;