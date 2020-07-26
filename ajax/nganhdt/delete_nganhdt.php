<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("nganhdt", "edit");
function delete_nganhdt($id)
{
    global $DB;
    $ma_nganh = $DB->get_record('eb_nganhdt', array('id' => $id))->ma_nganh;
    $isUsed = false;
    $message = 'Success';

    // Kiểm tra điều kiện
    if ($DB->count_records('eb_nganh_thuoc_nienkhoa', array('ma_nganh' => $ma_nganh))) {
        $isUsed = true;
        $message = 'Ngành đang được sử dụng (table eb_nganh_thuoc_nienkhoa)';
    }
    // if ($DB->count_records('eb_cnganh_kkt', array('ma_chuyennganh' => $ma_nganh))) {
    //     $isUsed = true;
    //     $message = 'Ngành đang được sử dụng (table eb_cnganh_kkt)';
    // }

    // Nếu chưa được sử dụng, xóa khóa tuyển
    if ($isUsed) {
        //
    } else {
        $DB->delete_records('eb_nganhdt', array('id' => $id));
    }
    return $message;
}

// Xóa ngành đào tạo có id truyền vào
$output = delete_nganhdt($id);
// return
echo $output;
exit;