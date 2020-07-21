<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class qlhe_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        // Header
        $mform->addElement('header', 'general', 'Quản lý thông tin');

        $mform->addElement('hidden', 'idhe', '');

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
        $mform->addElement('text', 'mahe', 'Mã hệ đào tạo', 'size="70"');
        $mform->addRule('mahe', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        // Tên hệ
        $mform->addElement('text', 'tenhe', 'Tên hệ đào tạo', 'size="70"');
        $mform->addRule('tenhe', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        // Mô tả
        $mota = array();
        $mota[] = &$mform->createElement('textarea', 'mota', 'C', 'wrap="virtual" rows="7" cols="75"');
        $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);

        // Button
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Thực hiện');
        $buttonarray[] = $mform->createElement('cancel', null, 'Hủy');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}

// Form search
class hedt_search extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $hedt_search = array();
        $hedt_search[] = &$mform->createElement('text', 'hedt_search', 'none',  array('size'=>'40'));
        $hedt_search[] = &$mform->createElement('submit', 'btn_hedt_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($hedt_search, 'hedt_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
