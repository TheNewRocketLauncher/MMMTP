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

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('hidden', 'id', '', 'size=50');
        $mform1->addGroup($eGroup, 'id', '', array(' '), false);

    
        $ma_ctdt = array();
        $rows = $DB->get_records('block_edu_ctdt', []);
        $arr_ma_ctdt = array();
        $arr_ma_ctdt += [""=> ""];

        foreach ($rows as $item) {
            $arr_ma_ctdt += [$item->ma_ctdt => $item->ma_ctdt];
        }
        $ma_ctdt[] = &$mform1->createElement('select', 'ma_ctdt', 'test select:', $arr_ma_ctdt, array());
        $mform1->addGroup($ma_ctdt, 'ma_ctdt', 'Mã CTĐT', array(' '), false);

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

        $mamonhoc = array();
        $rows = $DB->get_records('block_edu_monhoc', []);
        $arr_mamonhoc = array();
        $arr_mamonhoc += [""=> ""];

        foreach ($rows as $item) {
            $arr_mamonhoc += [$item->mamonhoc => $item->mamonhoc];
            
        }
        
        $mamonhoc[] = &$mform1->createElement('select', 'mamonhoc', 'test select:', $arr_mamonhoc, array());
        $mform1->addGroup($mamonhoc, 'mamonhoc', 'Mã môn học', array(' '), false);

        $lopmo = array();
        $rows2 = $DB->get_records('block_edu_lop_mo',['mamonhoc'=>$arr_mamonhoc[0]]);

        $arr_lopmo = array();
        foreach ($rows2 as $item) {
            $arr_lopmo += [$item->full_name => $item->full_name];
        }

        $lopmo[] = &$mform1->createElement('select', 'lopmo', 'test select:', $arr_lopmo, array());
        $mform1->addGroup($lopmo, 'lopmo', 'Danh sách lớp đã mở', array(' '), false);


        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'tenlopmo', '', 'size=50');
        $mform1->addGroup($eGroup, 'tenlopmo', 'Tên lớp mở', array(' '), false);

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('button', 'btn_get_fullname', 'GET', 'size=50');
        $mform1->addGroup($eGroup, 'btn_get_fullname', '', array(' '), false);



        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'fullname', '', 'size=50');
        $mform1->addGroup($eGroup, 'fullname', 'Tên đầy đủ', array(' '), false);
        // $mform1->disabledIf('fullname', '');


        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'shortname', '', 'size=50');
        $mform1->addGroup($eGroup, 'shortname', 'Tên rút gọn', array(' '), false);
        // $mform1->disabledIf('shortname', '');

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('date_time_selector', 'sta_date', '', 'size=50');
        $mform1->addGroup($eGroup, 'sta_date', 'Ngày bắt đầu', array(' '), false);

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('date_time_selector', 'end_date', '', 'size=50');
        $mform1->addGroup($eGroup, 'end_date', 'Ngày kết thúc', array(' '), false);

        $eGroup = array();
        $eGroup[] = &$mform1->createElement('text', 'assign_to', '', 'size=50');
        $mform1->addGroup($eGroup, 'assign_to', 'Giáo viên phụ trách', array(' '), false);

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
