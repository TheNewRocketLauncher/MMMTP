<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_ctdt = required_param('ma_ctdt', PARAM_ALPHANUMEXT);
$courseid = required_param('course', PARAM_INT);

function get_mamonhoc_from_mactdt($ma_ctdt)
{
  global $DB, $USER, $CFG, $COURSE;
  $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);

  // Lưu danh sách mã môn học
  $list_mamonhoc = array();

  // Lấy ra cây khối kiến thức của CTDT 
  $caykkt = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);

  // Với mỗi khối kiến thức, lấy ra các khối con có thể có
  foreach ($caykkt as $item) {    
    // Thêm các mã môn học thuộc khối vào $list_mamonhoc
    $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $item->ma_khoi]);
    foreach ($data_records as $data) {
      $tmp = new stdClass();
      $tmp->mamonhoc = $data->mamonhoc;
      $list_mamonhoc[] = $tmp;
    }

    // Kiểm tra xem khối có khối con hay không? Điều kiện: có 1 khối cùng tên và có ma_tt = 0
    if ($DB->count_records('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0])) {
      $khoicha = $DB->get_record('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0]);

      // Lấy ra các khối con: có cùng mã cây khối kiến thức và có mã khối cha = mã khối của item
      $listkhoicon = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoicha'  => $khoicha->ma_khoi, 'ma_cay_khoikienthuc' => $khoicha->ma_cay_khoikienthuc]);

      // Lấy ra các mã môn học thuộc các khối con
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

  // Trả về danh sách mã môn học
  return $list_mamonhoc;
}

$data = array();

/* Get dữ liệu */
$listmonhoc = get_mamonhoc_from_mactdt($ma_ctdt);
$arr_monhoc = array();
$data['monhoc'] = array();
$data['ctdt'] = array();

/* Lấy danh sách môn - kiểm tra môn đã được thêm trong data chưa? */
foreach ($listmonhoc as $item) {
  $isExist = false;
  foreach ($data['monhoc'] as $mon_cosan) {
    if ($item->mamonhoc == $mon_cosan) {
      $isExist = true;
    }
  }
  // Thêm vào data nếu môn chưa có sẵn
  if (!$isExist) {
    $data['monhoc'][] = &$item->mamonhoc;
  }
}

/* Các thông tin lấy ra từ CTDT */
$ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);

$tenbac = $DB->get_record('eb_bacdt', ['ma_bac' => $ctdt->ma_bac]);
$data['ctdt'][] = &$tenbac->ten;

$hedt = $DB->get_record('eb_hedt', ['ma_he' => $ctdt->ma_he]);
$data['ctdt'][] = &$hedt->ten;

$nienkhoa = $DB->get_record('eb_nienkhoa', ['ma_nienkhoa' => $ctdt->ma_nienkhoa]);
$data['ctdt'][] = &$nienkhoa->ten_nienkhoa;

$nganhdt = $DB->get_record('eb_nganhdt', ['ma_nganh' => $ctdt->ma_nganh]);
$data['ctdt'][] = &$nganhdt->ten;

$chuyennganh = $DB->get_record('eb_chuyennganhdt', ['ma_chuyennganh' => $ctdt->ma_chuyennganh]);
$data['ctdt'][] = &$chuyennganh->ten;

$data['ctdt'][] = &$ctdt->mota;

// Trả về kết quả với json_encode
echo json_encode($data);
exit;
