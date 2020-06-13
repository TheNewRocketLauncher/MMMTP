<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class chitiet_monhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group thong tin chung
        $mform = $this->_form;
        $mform->addElement('header', 'general_thong_tin_monhoc', get_string('group_thong_tin_monhoc', 'block_educationpgrs'));

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'mamonhoc', '', 'size=50');
        $mform->addGroup($eGroup1, 'mamonhoc', get_string('mamonhoc_chitiet', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('mamonhoc', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'tenmonhoc_vi', '', 'size=50');
        $mform->addGroup($eGroup1, 'tenmonhoc', get_string('tenmonhoc1_thongtinchung', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('tenmonhoc_vi', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'tenmonhoc_en', '', 'size=50');
        $mform->addGroup($eGroup1, 'tenmonhoc', get_string('tenmonhoc2_thongtinchung', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('tenmonhoc_en', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'sotinchi', '', 'size=10');
        $mform->addGroup($eGroup1, 'tenmonhoc', get_string('sotinchi', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('sotinchi', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'sotiet_LT', '', 'size=10');
        $mform->addGroup($eGroup1, 'tenmonhoc', get_string('sotiet_LT', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('sotiet_LT', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'sotiet_TH', '', 'size=10');
        $mform->addGroup($eGroup1, 'tenmonhoc', get_string('sotiet_TH', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('sotiet_TH', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'sotiet_BT', '', 'size=10');
        $mform->addGroup($eGroup1, 'tenmonhoc', get_string('sotiet_BT', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('sotiet_BT', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'loaihocphan', '', 'size=50');
        $mform->addGroup($eGroup, 'loaihocphan', get_string('loaihocphan', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('loaihocphan', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'ghichu', '', 'size=50');
        $mform->addGroup($eGroup, 'ghichu', get_string('ghichu', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('ghichu', '');
    }

    function validation($data, $files)
    {
        return array();
    }
}
