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

  // Luu danh s�ch m� m�n h?c
  $list_mamonhoc = array();

  // L?y ra c�y kh?i ki?n th?c c?a CTDT 
  $caykkt = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);

  // V?i m?i kh?i ki?n th?c, l?y ra c�c kh?i con c� th? c�
  foreach ($caykkt as $item) {    
    // Th�m c�c m� m�n h?c thu?c kh?i v�o $list_mamonhoc
    $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $item->ma_khoi]);
    foreach ($data_records as $data) {
      $tmp = new stdClass();
      $tmp->mamonhoc = $data->mamonhoc;
      $list_mamonhoc[] = $tmp;
    }

    // Ki?m tra xem kh?i c� kh?i con hay kh�ng? �i?u ki?n: c� 1 kh?i c�ng t�n v� c� ma_tt = 0
    if ($DB->count_records('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0])) {
      $khoicha = $DB->get_record('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0]);

      // L?y ra c�c kh?i con: c� c�ng m� c�y kh?i ki?n th?c v� c� m� kh?i cha = m� kh?i c?a item
      $listkhoicon = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoicha'  => $khoicha->ma_khoi, 'ma_cay_khoikienthuc' => $khoicha->ma_cay_khoikienthuc]);

      // L?y ra c�c m� m�n h?c thu?c c�c kh?i con
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

  // Tr? v? danh s�ch m� m�n h?c
  return $list_mamonhoc;
}


$listmonhoc = getMonhocByMaCTDT($ma_ctdt);
$allMons = array();

/* L?y danh s�ch m�n - ki?m tra m�n d� du?c th�m trong data chua? */
foreach ($listmonhoc as $item) {
   $isExist = false;
   foreach ($allMons as $mon_cosan) {
     if ($item->mamonhoc == $mon_cosan) {
       $isExist = true;
     }
   }
   // Th�m v�o data n?u m�n chua c� s?n
   if (!$isExist) {
     $allMons[] = &$item->mamonhoc;
   }
 }
echo json_encode($allMons);
exit;
