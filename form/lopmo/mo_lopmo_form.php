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
        $mform1->addGroup($eGroup, 'nienkhoa', 'khóa tuyển', array(' '), false);
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
        $arr_mamonhoc += ["" => "Chọn mã môn học"];

        foreach ($monhocs as $item) {
            $arr_mamonhoc += [$item->mamonhoc => $item->mamonhoc];
        }


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

/* Form mở các lớp */
class process_form extends moodleform
{
    private $list_monhoc;

    public function get_listmonhoc()
    {
        return $this->list_monhoc;
    }
    
    public function definition()
    {
        global $DB;
        $mform = $this->_form;

        // Lấy ra danh sách môn học thuộc CTDT, đọc duy nhất (distinct)
        $ma_ctdt = $this->_customdata['data']['ma_ctdt'];
        $listmonhoc = get_mamonhoc_from_mactdt($ma_ctdt);
        $distinct_listmonhoc = array();
        foreach ($listmonhoc as $item) {
            $isExist = false;
            foreach ($distinct_listmonhoc as $mon_cosan) {
                if ($item->mamonhoc == $mon_cosan) {
                    $isExist = true;
                }
            }
            // Thêm vào data nếu môn chưa có sẵn
            if (!$isExist) {
                $distinct_listmonhoc[] = &$item->mamonhoc;
            }
        }

        // Vì tạm thời chưa thể dùng CTDT, nên tải tất cả các môn học
        $distinct_listmonhoc = array();
        foreach ($DB->get_records('eb_monhoc', []) as $item) {
            $distinct_listmonhoc[] = &$item->mamonhoc;
        }
        $this->list_monhoc = $distinct_listmonhoc;

        // In ra các form với mỗi môn
        foreach ($distinct_listmonhoc as $mamonhoc) {
            // Lấy ra chi tiết môn học
            $monhoc = $DB->get_record('eb_monhoc', ['mamonhoc' => $mamonhoc]);
            // Số lớp này đã mở trong chương trình đào tạo
            $count = $DB->count_records('eb_lop_mo', ['mamonhoc' => $mamonhoc, 'ma_ctdt' => $ma_ctdt]);
            // Header
            $mform->addElement('header', $mamonhoc . '_labelmonhoc', $mamonhoc . ' - ' . $monhoc->tenmonhoc_vi . ' ('.$count.' lớp)');
            $mform->addElement('hidden', $mamonhoc . 'idlopmo', '');
            $eGroup = array();
            $eGroup[] = &$mform->createElement('text', $mamonhoc . 'amount', '', 'size=50');
            $mform->addGroup($eGroup, $mamonhoc . 'amount', 'Nhập số lượng lớp muốn mở', array(' '), false);
            $mform->setDefault($mamonhoc . 'amount', '0');
            $mform->addElement('text', $mamonhoc . 'fullname', 'Tên đầy đủ', 'size="50"');
            // $mform->addRule($mamonhoc . 'fullname', get_string('error'), 'required', 'extraruledata', 'server', false, false);
            $eGroup = array();
            $eGroup[] = &$mform->createElement('text', $mamonhoc . 'shortname', '', 'size=50');
            $mform->addGroup($eGroup, $mamonhoc . 'shortname', 'Tên rút gọn', array(' '), false);
            $mform->addElement('text', $mamonhoc . 'start_year', 'Năm học bắt đầu', 'size=50');
            // $mform->addRule($mamonhoc . 'start_year', get_string('error'), 'required', 'extraruledata', 'server', false, false);
            $arr = array();
            $arr += ["" => "Chọn học kì bắt đầu"];
            for ($x = 1; $x <= 4; $x++) {
                $arr += [$x => $x];
            }
            $mform->addElement('select', $mamonhoc . 'start_semester', 'Học kì bắt đầu',  $arr, array());
            // $mform->addRule($mamonhoc . 'start_semester', get_string('error'), 'required', 'extraruledata', 'server', false, false);
            $rows = $DB->get_records('user', []);
            $arr = array();
            $arr += ["" => "Chọn giáo viên"];
            foreach ($rows as $item) {
                $arr += [$item->id => $item->firstname];
            }
            $mform->addElement('select', $mamonhoc . 'assign_to', 'Giáo viên phụ trách', $arr, array());
            // $mform->addRule($mamonhoc . 'assign_to', get_string('error'), 'required', 'extraruledata', 'server', false, false);
            $eGroup = array();
            $eGroup[] = &$mform->createElement('textarea', $mamonhoc . 'mota', '', 'wrap="virtual" rows="7" cols="75"');
            $mform->addGroup($eGroup, $mamonhoc . 'mota', 'Mô tả', array(' '), false);
        }

        // Button
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Mở lớp');
        $buttonarray[] = $mform->createElement('cancel', null, 'Hủy');
        $mform->addGroup($buttonarray, 'buttonarr', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }

    function get_value()
    {
        $mform = &$this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }
}

/* Form chứa thanh select ctdt*/
class ctdt_select_form extends moodleform
{
    public function definition()
    {
        global $DB;
        //Group thong tin chung
        $mform = $this->_form;
        $rows = $DB->get_records('eb_ctdt', []);
        $arr_ma_ctdt = array();
        $arr_ma_ctdt += ["" => "Chọn chương trình đào tạo"];
        foreach ($rows as $item) {
            $arr_ma_ctdt += [$item->ma_ctdt => $item->ma_ctdt];
        }
        $ctdt_select = array();
        $ctdt_select[] = &$mform->createElement('select', 'ma_ctdt', 'Mã CTDT', $arr_ma_ctdt, array());
        $ctdt_select[] = &$mform->createElement('submit', 'btn_ctdt_select', 'Chọn CTĐT', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($ctdt_select, 'ctdt_select_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}

/* Hàm lấy mã môn thuộc CTDT */
function get_mamonhoc_from_mactdt($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
    $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);

    // Lưu danh sách mã môn học
    $list_mamonhoc = array();

    // Lấy ra cây khối kiến thức của CTDT 
    $caykkt = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);

    // Với mỗi khối kiến thức, lấy ra các khối con có thể có
    foreach ($caykkt as $item) {
        // Thêm các mã môn học thuộc khối vào $list_mamonhoc
        $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $item->ma_khoi]);
        foreach ($data_records as $data) {
            $tmp = new stdClass();
            $tmp->mamonhoc = $data->mamonhoc;
            $list_mamonhoc[] = $tmp;
        }

        // Kiểm tra xem khối có khối con hay không? Điều kiện: có 1 khối cùng tên và có ma_tt = 0
        if ($DB->count_records('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0])) {
            $khoicha = $DB->get_record('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0]);

            // Lấy ra các khối con: có cùng mã cây khối kiến thức và có mã khối cha = mã khối của item
            $listkhoicon = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoicha'  => $khoicha->ma_khoi, 'ma_cay_khoikienthuc' => $khoicha->ma_cay_khoikienthuc]);

            // Lấy ra các mã môn học thuộc các khối con
            foreach ($listkhoicon as $khoicon) {
                $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $khoicon->ma_khoi]);
                foreach ($data_records as $data) {
                    $tmp = new stdClass();
                    $tmp->mamonhoc = $data->mamonhoc;
                    $list_mamonhoc[] = $tmp;
                }
            }
        }
    }

    // Trả về danh sách mã môn học
    return $list_mamonhoc;
}
