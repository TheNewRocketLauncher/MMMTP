<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once("../../js.php");

class qlnganh_form extends moodleform
{
  public function definition()
  {
    global $CFG, $DB;
    $mform = $this->_form;

    // Header
    $mform->addElement('header', 'general', 'Quản lý thông tin');

    // ID
    $idnganh = array();
    $idnganh[] = &$mform->createElement('text', 'idnganh', 'none', 'size="10"');
    $mform->addGroup($idnganh, 'idnganh', 'ID ngành đào tạo', array(' '), false);

    $mabac = array();
    $allbacdts = $DB->get_records('block_edu_bacdt', []);
    $arr_mabac = array();
    foreach ($allbacdts as $ibacdt) {
      $arr_mabac += [$ibacdt->ma_bac => $ibacdt->ma_bac];
    }
    $mabac[] = &$mform->createElement('select', 'mabac', 'test select:', $arr_mabac, array());
    $mform->addGroup($mabac, 'mabac', 'Mã bậc đào tạo', array(' '), false);

    // Mã hệ
    $mahe = array();
    $allhedts = $DB->get_records('block_edu_hedt', []);
    $arr_mahe = array();
    foreach ($allhedts as $ihedt) {
      $arr_mahe += [$ihedt->ma_he => $ihedt->ma_he];
    }
    $mahe[] = &$mform->createElement('select', 'mahe', 'test select:', $arr_mahe, array());
    $mform->addGroup($mahe, 'mahe', 'Mã hệ đào tạo', array(' '), false);

    // Mã niên khóa
    $manienkhoa = array();
    $allnienkhoadts = $DB->get_records('block_edu_nienkhoa', []);
    $arr_manienkhoa = array();
    foreach ($allnienkhoadts as $inienkhoadt) {
      $arr_manienkhoa += [$inienkhoadt->ma_nienkhoa => $inienkhoadt->ma_nienkhoa];
    }
    $manienkhoa[] = &$mform->createElement('select', 'manienkhoa', 'test select:', $arr_manienkhoa, array());
    $mform->addGroup($manienkhoa, 'manienkhoa', 'Mã niên khóa đào tạo', array(' '), false);

    // Mã ngành
    $manganh = array();
    $manganh[] = &$mform->createElement('text', 'manganh', 'none', 'size="10"');
    $mform->addGroup($manganh, 'manganh', 'Mã ngành đào tạo', array(' '), false);

    // Tên ngành
    $tennganh = array();
    $tennganh[] = &$mform->createElement('text', 'tennganh', 'none', 'size="70"');
    $mform->addGroup($tennganh, 'tennganh', 'Tên ngành đào tạo', array(' '), false);

    // Mô tả
    $mota = array();
    $mota[] = &$mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="100"');
    $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);

    // Button
    $buttonarray = array();
    $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Cập nhật');
    $buttonarray[] = $mform->createElement('cancel', null, 'Hủy');
    $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
  }

  function validation($data, $files)
  {
    return array();
  }
}
