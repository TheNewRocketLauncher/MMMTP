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

        // ID
        $idhe = array();
        $idhe[] = &$mform->createElement('text', 'idhe', 'none', 'size="70"');
        $mform->addGroup($idhe, 'idhe', 'ID', array(' '), false);

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
        $mahe[] = &$mform->createElement('text', 'mahe', 'none', 'size="70"');
        $mform->addGroup($mahe, 'mahe', 'Mã hệ đào tạo', array(' '), false);

        // Tên hệ
        $tenhe = array();
        $tenhe[] = &$mform->createElement('text', 'tenhe', 'B', 'size="70"');
        $mform->addGroup($tenhe, 'tenhe', 'Tên hệ đào tạo', array(' '), false);

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
class hedt_seach extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        // Search        
        $hedt_seach = array();
        // $bacdt_seach[] = &$mform->createElement('text', 'bacdt_seach', 'none',  array('size'=>'40', 'onkeydown'=>"return event.key != 'Enter';"));
        $hedt_seach[] = &$mform->createElement('text', 'hedt_seach', 'none',  array('size' => '40'));
        $hedt_seach[] = &$mform->createElement('submit', 'btn_hedt_seach', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($hedt_seach, 'hedt_seach_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
