<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class qlnganh_form extends moodleform
{
  public function definition()
  {
    global $CFG, $DB;
    $mform = $this->_form;

    // Header
    // $mform->addElement('header', 'createuserandpass', '');

    $mform->addElement('hidden', 'idnganh', '');    
    
    // Mã ngành
    $mform->addElement('text', 'manganh', 'Mã ngành đào tạo', 'size="70"');
    $mform->addRule('manganh', get_string('error'), 'required', 'extraruledata', 'server', false, false);

    // Tên ngành
    $mform->addElement('text', 'tennganh', 'Tên ngành đào tạo', 'size="70"');
    $mform->addRule('tennganh', get_string('error'), 'required', 'extraruledata', 'server', false, false);

    // Mô tả
    $mota = array();
    $mota[] = &$mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
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
class nganhdt_search extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $nganhdt_search = array();
        $nganhdt_search[] = &$mform->createElement('text', 'nganhdt_search', 'none',  array('size'=>'40'));
        $nganhdt_search[] = &$mform->createElement('submit', 'btn_nganhdt_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($nganhdt_search, 'nganhdt_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}

class them_ctdt_vao_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Select CTDT
        $ctdt_select = array();
        $allctdts = $DB->get_records('eb_ctdt', []);
        $arr_mactdt = array();
        $arr_mactdt += ['' => 'Chọn chương trình đào tạo...'];

        foreach ($allctdts as $ictdt) {
            $arr_mactdt += [$ictdt->ma_ctdt => $ictdt->ma_ctdt . ' ('.$ictdt->mota. ')'];
        }
        $ctdt_select[] = &$mform->createElement('select', 'mactdt', 'select:', $arr_mactdt, array());
        $ctdt_select[] = &$mform->createElement('submit', 'btn_ctdt_select', 'Thêm vào ngành đào tạo', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($ctdt_select, 'ctdt_select_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }

    function get_value() {
        $mform = & $this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }
}
