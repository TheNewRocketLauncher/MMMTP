<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

// Form Add & Update
class qlbac_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        // Header
        $mform->addElement('header', 'general', 'Quản lý thông tin');
        
        $mform->addElement('hidden', 'idbac', '');

        // Mã bậc
        $mform->addElement('text', 'mabac', 'Mã bậc đào tạo', 'size="70"');
        $mform->addRule('mabac', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        // Tên bậc
        $mform->addElement('text', 'tenbac', 'Tên bậc đào tạo', 'size="70"');
        $mform->addRule('tenbac', get_string('error'), 'required', 'extraruledata', 'server', false, false);
    
        // Mô tả
        $mota = array();
        $mota[] = &$mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
        $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);

        // Button
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Thực hiện');
        $buttonarray[] = $mform->createElement('cancel', null, 'Hủy');
        $mform->addGroup($buttonarray, 'buttonarr', ' ', ' ', false);
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


// Form search
class bacdt_seach extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $bacdt_seach = array();
        // $bacdt_seach[] = &$mform->createElement('text', 'bacdt_seach', 'none',  array('size'=>'40', 'onkeydown'=>"return event.key != 'Enter';"));
        $bacdt_seach[] = &$mform->createElement('text', 'bacdt_seach', 'none',  array('size' => '40'));
        $bacdt_seach[] = &$mform->createElement('submit', 'btn_bacdt_seach', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($bacdt_seach, 'bacdt_seach_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
