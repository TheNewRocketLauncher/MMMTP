<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_ctdt = trim(required_param('ma_ctdt', PARAM_NOTAGS));
require_once('../../controller/auth.php');
require_permission("chuandaura_ctdt", "edit");
global $DB;
$list_ma_cdr = $DB->get_records('eb_cdr_thuoc_ctdt', ['ma_ctdt' => $ma_ctdt]);

$arr_result = array();
$stt = 1;
foreach ($list_ma_cdr as $item) {

  $item_cdr = $DB->get_record('eb_chuandaura_ctdt', ['ma_cdr' => $item->ma_cdr]);
  $item_cdr->ma_tt = $stt;
  $item_cdr->ten = $stt . " " . $item_cdr->ten;
  $arr_result[] = $item_cdr;
  if ($item_cdr->level == 1 || $item_cdr->level == '1') {


    $list_cdr_con = $DB->get_records('eb_chuandaura_ctdt', ['ma_cdr_cha' => $item->ma_cdr]);
    $stt_con = 1;
    foreach ($list_cdr_con as $item_cdr_con) {
      $item_cdr_con->ma_tt = $stt . "." . $stt_con;
      $item_cdr_con->ten = $item_cdr_con->ma_tt . " " . $item_cdr_con->ten;
      $arr_result[] = $item_cdr_con;
      $stt_con++;
    }
  }
  $stt++;
}
// $arr_result;



// global $DB;



// $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);
// $data = array();
// $data['ma_cdr'] = array();
// $data['ten_ctdt'] = $ctdt->ten;



// $arr = array();

// $arr = $DB->get_records('eb_cdr_thuoc_ctdt', ['ma_ctdt' => $ma_ctdt]);
// foreach ($arr as $item) {
//   $data['ma_cdr'][] = $item->ma_cdr;
// }

echo json_encode($arr_result);
exit;
