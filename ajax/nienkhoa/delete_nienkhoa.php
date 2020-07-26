<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("nienkhoa", "edit");
function delete_nienkhoa($id)
{
    global $DB;
    $ma_nienkhoa = $DB->get_record('eb_nienkhoa', array('id' => $id))->ma_nienkhoa;
    $isUsed = false;
    $message = 'Success';

    // Ki?m tra di?u ki?n
    if ($DB->count_records('eb_nganh_thuoc_nienkhoa', array('ma_nienkhoa' => $ma_nienkhoa))) {
        $isUsed = true;
        $message = 'Khóa tuy?n dang du?c s? d?ng (table eb_nganh_thuoc_nienkhoa)';
    }

    // N?u chua s? d?ng
    if ($isUsed) {
        //
    } else {
        $DB->delete_records('eb_nienkhoa', array('id' => $id));
    }
    return $message;
}

// Xóa ngành dào t?o có id truy?n vào
$output = delete_nienkhoa($id);
// return
echo $output;

exit;
