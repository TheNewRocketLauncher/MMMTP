<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$mamonhoc = required_param('mamonhoc', PARAM_NOTAGS);
$ma_ctdt = required_param('ma_ctdt', PARAM_NOTAGS);
$courseid = required_param('course', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("lopmo", "edit");
function get_lopmo_from_mamonhoc($mamonhoc, $ma_ctdt)
{

  global $DB, $USER, $CFG, $COURSE;
  $ctdt = $DB->get_record('eb_ctdt', array('ma_ctdt' => $ma_ctdt));

  $lopmo = $DB->get_records('eb_lop_mo', array('mamonhoc' => $mamonhoc, 'ma_nienkhoa' => $ctdt->ma_nienkhoa, 'ma_nganh' => $ctdt->ma_nganh, 'ma_ctdt' => $ctdt->ma_ctdt));

  usort($lopmo, function ($a, $b) {
    return strcmp($a->full_name, $b->full_name);
  });


  $len2 = 1;
  if (count($lopmo)  >= 1) {
    $maxOld = 0;
    $maxResult = 0;
    $maxNew = 0;
    foreach ($lopmo as $item) {
      $fullname_split = explode("_", $item->full_name);
      // $stt = intval($fullname_split[1][1]);

      $stt = substr($fullname_split[1], 1);
      $stt = intval($stt);

      

      $maxOld = $maxNew;
      if ($stt > $maxNew) {
        $maxNew = $stt;
      }
      if (($maxNew - $maxOld) > 1 && $maxResult == 0 && $maxNew < 10) {
        $maxResult = $maxOld  + 1;
      }

      // echo "<br>";
      // echo " maxResult " . $maxResult;
      // echo "<br>";

      // echo "<br>";
      // echo " maxNew " . $maxNew;
      // echo "<br>";

      // echo "<br>";
      // echo " maxOld " . $maxOld;
      // echo "<br>";
    }



    $maxNew = $maxNew + 1;


    $len2 = ($maxResult == 0 ? $maxNew : $maxResult);

    // echo "<br>";
    // echo " len2 " . $len2;
    // echo "<br>";
  }

  $chuyennganhdts = $DB->get_records('eb_chuyennganhdt', ['ma_nganh' => $ctdt->ma_nganh]);
  $temparray = array();

  foreach ($chuyennganhdts as $item) {
    $temparray[] = &$item->ma_chuyennganh;
  }
  $currentchuyennganhdt = $DB->get_record('eb_chuyennganhdt', array('ma_chuyennganh' => $ctdt->ma_chuyennganh));
  $index = array_search($currentchuyennganhdt->ma_chuyennganh, $temparray);
  $index = $index + 1;

  $rsx =  ' ' . $ctdt->ma_nienkhoa . '_' . $index . $len2;
  return $rsx;
}
$monhoc = $DB->get_record('eb_monhoc', array('mamonhoc' => $mamonhoc));
$result = get_lopmo_from_mamonhoc($mamonhoc, $ma_ctdt);
$rsx = array();
$rsx['tenviettat'] = $mamonhoc . $result;
$rsx['ten'] = $monhoc->tenmonhoc_vi . $result;
// print_r($rsx);
echo json_encode($rsx);
exit;