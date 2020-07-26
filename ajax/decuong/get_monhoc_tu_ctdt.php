<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_ctdt = optional_param('ma_ctdt', '', PARAM_NOTAGS);
require_once('../../controller/auth.php');
require_permission("decuong", "edit");


function getMonhocByMaCTDT($ma_ctdt)
{
  global $DB, $USER, $CFG, $COURSE;
  $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);

  // Luu danh sách mã môn h?c
  $list_mamonhoc = array();

  // L?y ra cây kh?i ki?n th?c c?a CTDT 
  $caykkt = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);

  // V?i m?i kh?i ki?n th?c, l?y ra các kh?i con có th? có
  foreach ($caykkt as $item) {    
    // Thêm các mã môn h?c thu?c kh?i vào $list_mamonhoc
    $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $item->ma_khoi]);
    foreach ($data_records as $data) {
      $tmp = new stdClass();
      $tmp->mamonhoc = $data->mamonhoc;
      $list_mamonhoc[] = $tmp;
    }

    // Ki?m tra xem kh?i có kh?i con hay không? Ði?u ki?n: có 1 kh?i cùng tên và có ma_tt = 0
    if ($DB->count_records('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0])) {
      $khoicha = $DB->get_record('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0]);

      // L?y ra các kh?i con: có cùng mã cây kh?i ki?n th?c và có mã kh?i cha = mã kh?i c?a item
      $listkhoicon = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoicha'  => $khoicha->ma_khoi, 'ma_cay_khoikienthuc' => $khoicha->ma_cay_khoikienthuc]);

      // L?y ra các mã môn h?c thu?c các kh?i con
      foreach ($listkhoicon as $khoicon) {
        $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $khoicon->ma_khoi]);
        foreach ($data_records as $data) {
          $tmp = new stdClass();
          $tmp->mamonhoc = $data->mamonhoc;
          $list_mamonhoc[] = $tmp;
        }
      }
    }
  }

  // Tr? v? danh sách mã môn h?c
  return $list_mamonhoc;
}


$listmonhoc = getMonhocByMaCTDT($ma_ctdt);
$allMons = array();

/* L?y danh sách môn - ki?m tra môn dã du?c thêm trong data chua? */
foreach ($listmonhoc as $item) {
   $isExist = false;
   foreach ($allMons as $mon_cosan) {
     if ($item->mamonhoc == $mon_cosan) {
       $isExist = true;
     }
   }
   // Thêm vào data n?u môn chua có s?n
   if (!$isExist) {
     $allMons[] = &$item->mamonhoc;
   }
 }
echo json_encode($allMons);
exit;
