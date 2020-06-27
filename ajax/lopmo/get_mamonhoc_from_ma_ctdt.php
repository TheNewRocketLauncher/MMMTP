<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$ma_ctdt = required_param('ma_ctdt', PARAM_ALPHANUMEXT);
$courseid = required_param('course', PARAM_INT);
function get_mamonhoc_from_mactdt($ma_ctdt) {
  global $DB, $USER, $CFG, $COURSE;
  $ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt' => $ma_ctdt]);
  $caykkt = $DB->get_record('block_edu_cay_khoikienthuc' , ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);
  $listmonhoc = $DB->get_records('block_edu_monthuockhoi', ['ma_khoi' => $caykkt->ma_khoi]);

  return $listmonhoc;
}

    $data = array();

    // Lấy ra các hệ ĐT
    $listmonhoc = get_mamonhoc_from_mactdt($ma_ctdt);
    $arr_monhoc = array();
    $data['monhoc'] = array();
    $data['ctdt'] = array();


    foreach ($listmonhoc as $item) {
        $data['monhoc'][] =& $item->mamonhoc;
      }


    $ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt' => $ma_ctdt]);
    

    $tenbac = $DB->get_record('block_edu_bacdt', ['ma_bac' => $ctdt->ma_bac]);
    $data['ctdt'][] =& $tenbac->ten;

    $hedt = $DB->get_record('block_edu_hedt', ['ma_he' => $ctdt->ma_he]);
    $data['ctdt'][] =& $hedt->ten;

    $nienkhoa = $DB->get_record('block_edu_nienkhoa', ['ma_nienkhoa' => $ctdt->ma_nienkhoa]);
    $data['ctdt'][] =& $nienkhoa->ten_nienkhoa;

    $nganhdt = $DB->get_record('block_edu_nganhdt', ['ma_nganh' => $ctdt->ma_nganh]);
    $data['ctdt'][] =& $nganhdt->ten;

    $chuyennganh = $DB->get_record('block_edu_chuyennganhdt', ['ma_chuyennganh' => $ctdt->ma_chuyennganh]);
    $data['ctdt'][] =& $chuyennganh->ten;

    $data['ctdt'][] =& $ctdt->mota;
    // Trả về kết quả với json_encode
    echo json_encode($data);
    exit;
 


  //   function get_makhoi_from_mactdt($ma_ctdt){
  //     global $DB, $USER, $CFG, $COURSE;
  //     $ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt' => $ma_ctdt]);
  //     $caykkt = $DB->get_record('block_edu_cay_khoikienthuc' , ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);
  //     $ma_khoi = $caykkt->ma_khoi;
  //     return $ma_khoi;
  //  }
   
  //  function get_list_monhoc_from_makhoi($ma_khoi){
  //     global $DB, $USER, $CFG, $COURSE;
  //     $listmonhoc = $DB->get_records('block_edu_monthuockhoi', ['ma_khoi' => $ma_khoi]);
  //     return $listmonhoc;
  //  }

   