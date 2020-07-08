<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class them_monhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group thong tin chung
        $mform = $this->_form;
        $mform->addElement('header', 'general_monhoc', get_string('group_monhoc', 'block_educationpgrs'));

        $mform->addElement('hidden', 'idmonhoc', '');

        $mform->addElement('text', 'mamonhoc',  get_string('mamonhoc_chitiet', 'block_educationpgrs'), 'size=50');
        $mform->addRule('mamonhoc', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('text', 'tenmonhoc_vi', get_string('tenmonhoc1_thongtinchung', 'block_educationpgrs'), 'size=50');
        $mform->addRule('tenmonhoc_vi', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('text', 'tenmonhoc_en', get_string('tenmonhoc2_thongtinchung', 'block_educationpgrs'), 'size=50');
        $mform->addRule('tenmonhoc_en', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('text', 'loaihocphan', get_string('loaihocphan', 'block_educationpgrs'), 'size=50');
        $mform->addRule('loaihocphan', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('text', 'sotinchi', get_string('sotinchi', 'block_educationpgrs'), 'size=10');
        $mform->addRule('sotinchi', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('text', 'sotiet_LT', get_string('sotiet_LT', 'block_educationpgrs'), 'size=10');
        $mform->addRule('sotiet_LT', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('text', 'sotiet_TH', get_string('sotiet_TH', 'block_educationpgrs'), 'size=10');
        $mform->addRule('sotiet_TH', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('text', 'sotiet_BT', get_string('sotiet_BT', 'block_educationpgrs'), 'size=10');
        $mform->addRule('sotiet_BT', get_string('error'), 'required', 'extraruledata', 'server', false, false);


        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'ghichu', '', 'size=50');
        $mform->addGroup($eGroup, 'ghichu', get_string('ghichu', 'block_educationpgrs'), array(' '),  false);

        $mform->addElement('textarea', 'mota', 'Mô tả', 'wrap="virtual" rows="7" cols="100"');
        $mform->addRule('mota', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        // $eGroup = array();
        // $eGroup[] = &$mform->createElement('text', 'mota', '', 'size=50');
        // $mform->addGroup($eGroup, 'ghichu', 'Mô tả', array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_submit_them_monhoc', 'Thực hiện');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }

    function validation($data, $files)
    {
        return array();
    }
}

// Form search
class _search extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        // Search
        $monhoc_search = array();
        $monhoc_search[] = &$mform->createElement('text', 'monhoc_search', 'none',  array('size'=>'40'));
        $monhoc_search[] = &$mform->createElement('submit', 'btn_monhoc_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($monhoc_search, 'monhoc_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
