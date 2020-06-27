<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class tao_caykkt_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        $mform->addElement('header', 'general_thongtinchung', get_string('group_thongtinchung', 'block_educationpgrs'));

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'id', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group', 'Id', array(' '), false);

        // Mã bậc            

        $manienkhoaGroup = array();
        $manienkhoaGroup[] = &$mform->createElement('text', 'ma_cay_khoikienthuc', '', 'size="100"');
        $mform->addGroup($manienkhoaGroup, 'ma_cay_khoikienthuc', "Mã cây khối kiến thức", array(' '), false);



        $mabac = array();
        $allbacdts = $DB->get_records('block_edu_khoikienthuc', []);
        $arr_mabac = array();
        
        foreach ($allbacdts as $ibacdt) {
            $arr_mabac += [$ibacdt->ma_khoi => $ibacdt->ma_khoi];
        }
        $mabac[] = &$mform->createElement('select', 'ma_khoi', 'test select:', $arr_mabac, array());
        $mform->addGroup($mabac, 'ma_khoi', 'Mã khối', array(' '), false);

        $mabac = array();
        $allbacdts = $DB->get_records('block_edu_cay_khoikienthuc', []);
        $arr_mabac = array();
        foreach ($allbacdts as $ibacdt) {
            $arr_mabac += [$ibacdt->ma_khoi => $ibacdt->ma_khoi];
        }
        $mabac[] = &$mform->createElement('select', 'ma_khoicha', 'test select:', $arr_mabac, array());
        $mform->addGroup($mabac, 'ma_khoicha', 'Mã khối cha', array(' '), false);

        // Mã hệ
      

        $tenGroup = array();
        $tenGroup[] = &$mform->createElement('text', 'ten_cay', '', 'size="100"');
        $mform->addGroup($tenGroup, 'ten_cay', "Tên cây", array(' '), false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
        $mform->addGroup($eGroup, 'thongtinchung_group', "Mô tả", array(' '), false);

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
