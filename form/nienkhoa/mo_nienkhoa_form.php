<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class mo_nienkhoa_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        // Header
        $mform->addElement('header', 'general', 'Quản lý thông tin');

        $mform->addElement('hidden', 'idnienkhoa', '');

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


        //Mã niên khóa
        $mform->addElement('text', 'ma_nienkhoa', 'Mã niên khóa', 'size=50');
        $mform->addRule('ma_nienkhoa', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        //Tên niên khóa
        $mform->addElement('text', 'ten_nienkhoa', 'Tên niên khóa', 'size="100"');
        $mform->addRule('ten_nienkhoa', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        // Mô tả
        $mota = array();
        $mota[] = &$mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
        $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Thực hiện');
        $buttonarray[] = $mform->createElement('cancel', null, 'Hủy');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
    function get_editor_options()
    {
        $editoroptions = [];
        return $editoroptions;
    }
}

class nienkhoa_search extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $nienkhoa_search = array();
        $nienkhoa_search[] = &$mform->createElement('text', 'nienkhoa_search', 'none',  array('size'=>'40'));
        $nienkhoa_search[] = &$mform->createElement('submit', 'btn_nienkhoa_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($nienkhoa_search, 'nienkhoa_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}