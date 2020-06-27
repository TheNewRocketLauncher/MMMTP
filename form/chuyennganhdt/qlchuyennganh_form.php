<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once("../../js.php");

class qlchuyennganh_form extends moodleform
{
  public function definition()
  {
    global $CFG, $DB;
    $mform = $this->_form;

    // Header
    $mform->addElement('header', 'general', 'Quản lý thông tin');

    // // ID
    // $idchuyennganh = array();
    // $idchuyennganh[] = &$mform->createElement('text', 'idchuyennganh', 'none', 'size="70"');
    // $mform->addGroup($idchuyennganh, 'idchuyennganh', 'ID', array(' '), false);

    // Mã bậc
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

    //Mã ngành
    $manganh = array();
    $allnganhdts = $DB->get_records('block_edu_nganhdt', []);
    $arr_manganh = array();
    foreach ($allnganhdts as $inganhdt) {
      $arr_manganh += [$inganhdt->ma_nganh => $inganhdt->ma_nganh];
    }
    $manganh[] = &$mform->createElement('select', 'manganh', 'test select:', $arr_manganh, array());
    $mform->addGroup($manganh, 'manganh', 'Mã ngành đào tạo', array(' '), false);

    // Mã chuyên ngành
    $machuyennganh = array();
    $machuyennganh[] = &$mform->createElement('text', 'machuyennganh', 'none', 'size="10"');
    $mform->addGroup($machuyennganh, 'machuyennganh', 'Mã chuyên ngành đào tạo', array(' '), false);

    // Tên chuyên ngành
    $tenchuyennganh = array();
    $tenchuyennganh[] = &$mform->createElement('text', 'tenchuyennganh', 'none', 'size="70"');
    $mform->addGroup($tenchuyennganh, 'tenchuyennganh', 'Tên chuyên ngành đào tạo', array(' '), false);

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

// Form search
class chuyennganhdt_search extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $chuyennganhdt_search = array();
        $chuyennganhdt_search[] = &$mform->createElement('text', 'chuyennganhdt_search', 'none',  array('size'=>'40'));
        $chuyennganhdt_search[] = &$mform->createElement('submit', 'btn_chuyennganhdt_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($chuyennganhdt_search, 'chuyennganhdt_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}

