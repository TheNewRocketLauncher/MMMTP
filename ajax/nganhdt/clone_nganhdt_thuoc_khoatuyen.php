<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$ma_nienkhoa = required_param('ma_nienkhoa', PARAM_ALPHANUMEXT);
require_once('../../controller/auth.php');
require_permission("nganhdt", "edit");
function clone_nganhdt_thuoc_khoatuyen($id, $ma_nienkhoa)
{
    global $DB;
    // Clone param
    $param = $DB->get_record('eb_nganhdt', array('id' => $id));
    $param_nganh_khoatuyen = $DB->get_record('eb_nganh_thuoc_nienkhoa', array('ma_nganh' => $param->ma_nganh, 'ma_nienkhoa' => $ma_nienkhoa));
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

    // Config param_nganh_khoatuyen
    $param_nganh_khoatuyen->ma_nganh = $param->ma_nganh;
    $DB->insert_record('eb_nganh_thuoc_nienkhoa', $param_nganh_khoatuyen);

}
// Clone ngành đào tạo có id truyền vào
clone_nganhdt_thuoc_khoatuyen($id, $ma_nienkhoa);
// return
$output = "Clone ngành có ID = " . $id . " trong khóa tuyển " . $ma_nienkhoa ." thành công!";
echo $output;
exit;
