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

    $mform->addElement('hidden', 'idchuyennganh', '');

    // Mã bậc
    $mabac = array();
    $allbacdts = $DB->get_records('eb_bacdt', []);
    $arr_mabac = array();
    $arr_mabac += [""=> "Chọn bậc đào tạo"];

    foreach ($allbacdts as $ibacdt) {
      $arr_mabac += [$ibacdt->ma_bac => $ibacdt->ma_bac];
    }
    $mform->addElement('select', 'mabac', 'Mã bậc đào tạo:', $arr_mabac, array());
    $mform->addRule('mabac', get_string('error'), 'required', 'extraruledata', 'server', false, false);

    $eGroup = array();
    $eGroup[] = &$mform->createElement('text', 'bacdt', '', 'size=50');
    $mform->addGroup($eGroup, 'bacdt', '', array(' '), false);
    $mform->disabledIf('bacdt', '');

    // Mã hệ
    $mahe = array();
    $allhedts = $DB->get_records('eb_hedt', []);
    $arr_mahe = array();
    $arr_mahe += [""=> "Chọn hệ đào tạo"];

    foreach ($allhedts as $ihedt) {
      $arr_mahe += [$ihedt->ma_he => $ihedt->ma_he];
    }
    $mform->addElement('select', 'mahe', 'Mã hệ đào tạo:', $arr_mahe, array());
    $mform->addRule('mahe', get_string('error'), 'required', 'extraruledata', 'server', false, false);

    $eGroup = array();
    $eGroup[] = &$mform->createElement('text', 'hedt', '', 'size=50');
    $mform->addGroup($eGroup, 'hedt', '', array(' '), false);
    $mform->disabledIf('hedt', '');

    // Mã khóa tuyển
    $manienkhoa = array();
    $allnienkhoadts = $DB->get_records('eb_nienkhoa', []);
    $arr_manienkhoa = array();
    $arr_manienkhoa += [""=> "Chọn khóa tuyển đào tạo"];

    foreach ($allnienkhoadts as $inienkhoadt) {
      $arr_manienkhoa += [$inienkhoadt->ma_nienkhoa => $inienkhoadt->ma_nienkhoa];
    }
    $mform->addElement('select', 'manienkhoa', 'Mã khóa tuyển đào tạo:', $arr_manienkhoa, array());
    $mform->addRule('manienkhoa', get_string('error'), 'required', 'extraruledata', 'server', false, false);
    
    $eGroup = array();
    $eGroup[] = &$mform->createElement('text', 'nienkhoa', '', 'size=50');
    $mform->addGroup($eGroup, 'nienkhoa', '', array(' '), false);
    $mform->disabledIf('nienkhoa', '');

    //Mã ngành
    $manganh = array();
    $allnganhdts = $DB->get_records('eb_nganhdt', []);
    $arr_manganh = array();
    $arr_manganh += [""=> "Chọn ngành đào tạo"];

    foreach ($allnganhdts as $inganhdt) {
      $arr_manganh += [$inganhdt->ma_nganh => $inganhdt->ma_nganh];
    }
    $mform->addElement('select', 'manganh', 'Mã ngành đào tạo:', $arr_manganh, array());
    $mform->addRule('manganh', get_string('error'), 'required', 'extraruledata', 'server', false, false);

    $eGroup = array();
    $eGroup[] = &$mform->createElement('text', 'nganhdt', '', 'size=50');
    $mform->addGroup($eGroup, 'nganhdt', '', array(' '), false);
    $mform->disabledIf('nganhdt', '');

    // Mã chuyên ngành
    $mform->addElement('text', 'machuyennganh', 'Mã chuyên ngành đào tạo', 'size="10"');
    $mform->addRule('machuyennganh', get_string('error'), 'required', 'extraruledata', 'server', false, false);
    
    // Tên chuyên ngành
    $mform->addElement('text', 'tenchuyennganh', 'Tên chuyên ngành đào tạo', 'size="70"');
    $mform->addRule('tenchuyennganh', get_string('error'), 'required', 'extraruledata', 'server', false, false);

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

