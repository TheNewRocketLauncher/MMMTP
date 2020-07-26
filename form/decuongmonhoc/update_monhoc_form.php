<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class update_monhoc_form extends moodleform
{
    public $id = 0;
    public function definition()
    {
        global $CFG;
        //Group thong tin chung
        $mform = $this->_form;
        $mform->addElement('header', 'general_thong_tin_monhoc', 'Thông tin cập nhật');

        $mform->addElement('hidden', 'idmonhoc', '');

        
        $mform->addElement('text', 'mamonhoc',  get_string('mamonhoc_chitiet', 'block_educationpgrs'), 'size=50');
        $mform->addRule('mamonhoc', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('text', 'tenmonhoc_vi', get_string('tenmonhoc1_thongtinchung', 'block_educationpgrs'), 'size=50');
        $mform->addRule('tenmonhoc_vi', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('text', 'tenmonhoc_en', get_string('tenmonhoc2_thongtinchung', 'block_educationpgrs'), 'size=50');
        $mform->addRule('tenmonhoc_en', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('select', 'loaihocphan', get_string('loaihocphan', 'block_educationpgrs'), array('BB', 'TC'));
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

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_submit_update_monhoc', 'Cập nhật');
        $eGroup[] = &$mform->createElement('cancel', null, 'Hủy');
        $mform->addGroup($eGroup, 'thongtinchung_group16', '', array(' '),  false);
    }

    function validation($data, $files)
    {
        return array();
    }
    public function getID()
    {
        return $id;
    }
    public function setID($x)
    {
        $id = $x;
    }
}
