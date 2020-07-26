<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$ma_nienkhoa = required_param('ma_nienkhoa', PARAM_ALPHANUMEXT);
require_once('../../controller/auth.php');
require_permission("nganhdt", "edit");
function delete_nganhdt_thuoc_khoatuyen($id, $ma_nienkhoa)
{
    global $DB;

    // Tìm ra mã ngành từ id
    $ma_nganh = $DB->get_record('eb_nganhdt', ['id' => $id])->ma_nganh;
    // Xóa liên kết
    $DB->delete_records('eb_nganh_thuoc_nienkhoa', array('ma_nganh' => $ma_nganh, 'ma_nienkhoa' => $ma_nienkhoa));
    $message = 'Success';
    return $message;
}

// Xóa ngành đào tạo có id truyền vào
$output = delete_nganhdt_thuoc_khoatuyen($id, $ma_nienkhoa);
// return
echo $output;
exit;