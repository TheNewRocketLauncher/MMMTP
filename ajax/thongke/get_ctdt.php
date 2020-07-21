<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');

$ma_ctdt = optional_param('ma_ctdt', '', PARAM_NOTAGS);

function fetch($ma_ctdt)
{

    global $DB, $USER, $CFG, $COURSE;
    $all_ctdt = $DB->get_record('eb_ctdt', array('ma_ctdt' => $ma_ctdt));

    $arr_tam = array();
    $tat_ca_ma_ctdt = $DB->get_records('eb_ctdt', array());
    foreach ($tat_ca_ma_ctdt as $itat_ca_ma_ctdt) {
        $arr_tam[] = ['ma_ctdt' => $itat_ca_ma_ctdt->ma_ctdt];
    }

    $arr_ctdt = array();
    $stt = 1;
    // foreach ($all_ctdt as $all_ctdt) {

    $chuandaura = $DB->get_records('eb_chuandaura_ctdt', ['ma_cay_cdr' => $all_ctdt->chuandaura], '', 'ma_cdr');

    $cdr_one = $DB->get_record('eb_chuandaura_ctdt', ['ma_cay_cdr' => $all_ctdt->chuandaura, 'level_cdr' => 0]);
    $arr_ctdt[] = [
        'ma_ctdt' => $all_ctdt->ma_ctdt, 'ma_bac' => $all_ctdt->ma_bac, 'ma_he' => $all_ctdt->ma_he, 'ma_nienkhoa' => $all_ctdt->ma_nienkhoa, 'ma_nganh' => $all_ctdt->ma_nganh,
        'ma_chuyennganh' => $all_ctdt->ma_chuyennganh, 'chuandaura' => $chuandaura, 'ma_cay_cdr' => $all_ctdt->chuandaura,
        'list_ctdt' => $arr_tam, 'ten_chuandaura' => $cdr_one->ten
    ];
    $stt = $stt + 1;
    // }


    return $arr_ctdt;
}


$All_ctdt = fetch($ma_ctdt);

echo json_encode($All_ctdt);
exit;
