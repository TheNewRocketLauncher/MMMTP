<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class chuandaura_ctdt_form extends moodleform
{
    public function definition()
    {
        global $CFG,$DB;
        //Group thong tin chung
        $mform1 = $this->_form;
        $mform1->addElement('header', 'general_thongtinchung', get_string('group_thongtinchung', 'block_educationpgrs'));

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('hidden', 'id', '', 'size=50');
        $mform1->addGroup($eGroup, 'id', '', array(' '), false);


        $ma_ctdt = array();
        $rows = $DB->get_records('block_edu_ctdt', []);
        $arr_ma_ctdt = array();
        $arr_ma_ctdt += ["0"=> "Chọn chương trình đào tạo"];
        foreach ($rows as $item) {
            $arr_ma_ctdt += [$item->ma_ctdt => $item->ma_ctdt];
        }
        $ma_ctdt[] = &$mform1->createElement('select', 'ma_ctdt_cdr', 'test select:', $arr_ma_ctdt, array());
        $mform1->addGroup($ma_ctdt, 'ma_ctdt', 'Mã CTĐT', array(' '), false);
        $mform1->addRule('ma_ctdt', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'ten_ctdt', '', 'size=50');
        $mform1->addGroup($eGroup, 'ten_ctdt', 'Tên chương trình đào tạo', array(' '), false);
        $mform1->disabledIf('ten_ctdt', '');


        $ma_cdr_cha = array();
        $rows = $DB->get_records('block_edu_chuandaura_ctdt', []);
        $arr_ma_cdr_cha = array();
        $arr_ma_cdr_cha += ["0"=> "Chọn chuẩn đầu ra"];
        foreach ($rows as $item) {
            $arr_ma_cdr_cha += [$item->ma_cdr => $item->ma_cdr];
        }
        $ma_cdr_cha[] = &$mform1->createElement('select', 'ma_cdr_cha', 'test select:', $arr_ma_cdr_cha, array());
        $mform1->addGroup($ma_cdr_cha, 'ma_cdr_cha', 'Mã chuẩn đầu ra cha', array(' '), false);
        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'ten_cdr', '', 'size=50');
        $mform1->addGroup($eGroup, 'ten_cdr', 'Tên chuẩn đầu ra', array(' '), false);
        $mform1->disabledIf('ten_cdr', '');



        // $eGroup = array();
        $mform1->addElement('text', 'ten', 'Tên đầy đủ', 'size=50');
        $mform1->addRule('ten', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        // $mform1->addGroup($eGroup, 'ten', 'Tên đầy đủ', array(' '), false);

        // $mform->addElement('text', 'chudegiangday', get_string('chudegiangday', 'block_educationpgrs'), 'size=50');
        // $mform->addRule('chudegiangday', get_string('error'), 'required', 'extraruledata', 'server', false, false);


        $eGroup = array();
        $eGroup[] = &$mform1->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
        $mform1->addGroup($eGroup, 'mota', 'Mô tả', array(' '), false);
      
        $buttonarray = array();
        $buttonarray[] = $mform1->createElement('submit', 'submitbutton', 'Thực hiện');
        $buttonarray[] = $mform1->createElement('cancel', null, 'Hủy');
        $mform1->addGroup($buttonarray, 'buttonar', '', ' ', false);
    }
    
    function validation($data, $files)
    {
        return array();
    }
    function get_submit_value($elementname)
    {
        $mform = $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}



class chuandaura_ctdt_search extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $lopmo_search = array();
        // $lopmo_search[] = &$mform->createElement('text', 'lopmo_search', 'none',  array('size'=>'40', 'onkeydown'=>"return event.key != 'Enter';"));
        $lopmo_search[] = &$mform->createElement('text', 'chuandaura_ctdt_search', 'none',  array('size'=>'40'));
        $lopmo_search[] = &$mform->createElement('submit', 'btn_chuandaura_ctdt_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($lopmo_search, 'chuandaura_ctdt_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
