<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class mo_lopmo_form extends moodleform
{
    public function definition()
    {
        global $CFG,$DB;
        //Group thong tin chung
        $mform1 = $this->_form;
        $mform1->addElement('header', 'general_thongtinchung', get_string('group_thongtinchung', 'block_educationpgrs'));

        $mform1->addElement('hidden', 'idlopmo', '');

    
        $rows = $DB->get_records('eb_ctdt', []);
        $arr_ma_ctdt = array();
        $arr_ma_ctdt += [""=> "Chọn chương trình đào tạo"];

        foreach ($rows as $item) {
            $arr_ma_ctdt += [$item->ma_ctdt => $item->ma_ctdt];
        }
        $mform1->addElement('select', 'ma_ctdt', 'Mã CTDT', $arr_ma_ctdt, array());
        $mform1->addRule('ma_ctdt', get_string('error'), 'required', 'extraruledata', 'server', false, false);
    

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'bacdt', '', 'size=50');
        $mform1->addGroup($eGroup, 'bacdt', 'Bậc đào tạo', array(' '), false);
        $mform1->disabledIf('bacdt', '');


        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'hedt', '', 'size=50');
        $mform1->addGroup($eGroup, 'hedt', 'Hệ đào tạo', array(' '), false);
        $mform1->disabledIf('hedt', '');

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'nienkhoa', '', 'size=50');
        $mform1->addGroup($eGroup, 'nienkhoa', 'Niên khóa', array(' '), false);
        $mform1->disabledIf('nienkhoa', '');

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'nganh', '', 'size=50');
        $mform1->addGroup($eGroup, 'nganh', 'Ngành', array(' '), false);
        $mform1->disabledIf('nganh', '');

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'chuyennganh', '', 'size=50');
        $mform1->addGroup($eGroup, 'chuyennganh', 'Chuyên ngành', array(' '), false);
        $mform1->disabledIf('chuyennganh', '');

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'mota_ctdt', '', 'size=50');
        $mform1->addGroup($eGroup, 'mota_ctdt', 'Mô tả CTĐT', array(' '), false);
        $mform1->disabledIf('mota_ctdt', '');
        

        $monhocs = $DB->get_records('eb_monhoc', []);
        $arr_mamonhoc = array();
        foreach ($monhocs as $item) {
            $arr_mamonhoc += [$item->mamonhoc => $item->mamonhoc];
        }

        $arr_mamonhoc += [""=> "Chọn mã môn học"];

        $mform1->addElement('select', 'mamonhoc1', 'Mã môn học', $arr_mamonhoc, array());
        $mform1->addRule('mamonhoc1', get_string('error'), 'required', 'extraruledata', 'server', false, false);



        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'amount', '', 'size=50');
        $mform1->addGroup($eGroup, 'amount', 'Nhập số lượng lớp muốn mở', array(' '), false);
        $mform1->setDefault('amount', '1'); 

        $mform1->addElement('text', 'fullname', 'Tên đầy đủ', 'size="50"');
        $mform1->addRule('fullname', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        


        $eGroup = array();  
        $eGroup[] = &$mform1->createElement('text', 'shortname', '', 'size=50');
        $mform1->addGroup($eGroup, 'shortname', 'Tên rút gọn', array(' '), false);

        $mform1->addElement('text', 'start_year', 'Năm học bắt đầu', 'size=50');
        $mform1->addRule('start_year', get_string('error'), 'required', 'extraruledata', 'server', false, false);


        $arr = array();
        $arr += [""=> "Chọn học kì bắt đầu"];
        for ($x=1 ; $x<=4 ; $x++){
            $arr += [$x => $x];
        }
        $mform1->addElement('select', 'start_semester', 'Học kì bắt đầu',  $arr, array());
        $mform1->addRule('start_semester', get_string('error'), 'required', 'extraruledata', 'server', false, false);



        $rows = $DB->get_records('user', []);
        $arr = array();
        $arr += [""=> "Chọn giáo viên"];

        foreach ($rows as $item) {
            $arr += [$item->id => $item->firstname];
        }
        $mform1->addElement('select', 'assign_to','Giáo viên phụ trách', $arr, array());
        $mform1->addRule('assign_to', get_string('error'), 'required', 'extraruledata', 'server', false, false);

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
}



class lopmo_search extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $lopmo_search = array();
        // $lopmo_search[] = &$mform->createElement('text', 'lopmo_search', 'none',  array('size'=>'40', 'onkeydown'=>"return event.key != 'Enter';"));
        $lopmo_search[] = &$mform->createElement('text', 'lopmo_search', 'none',  array('size'=>'40'));
        $lopmo_search[] = &$mform->createElement('submit', 'btn_lopmo_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($lopmo_search, 'lopmo_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}


