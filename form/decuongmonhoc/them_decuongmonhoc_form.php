<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class them_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;
        
        $mform->closeHeaderBefore('them_decuongmonhoc_submit');
        $eGroup = $mform->addElement('submit', 'them_decuongmonhoc_submit', 'Xem trước');
    }
    function validation($data, $files)
    {
        return array();
    }
}
class tuychon_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        //Group thong tin chung
        $mform = $this->_form;

        $mform->addElement('header', 'general_tuychon', get_string('group_tuychon', 'block_educationpgrs'));

        $mform->addElement('hidden', 'madc_copy', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'madc', '', 'size=50');
        $mform->addGroup($eGroup1, 'madc', 'Mã đề cương', array(' '), false);

        $allctdts = $DB->get_records('block_edu_ctdt', []);
        $arr_mactdt = array();
        $arr_mactdt += ["0" => "Chọn chương trình đào tạo"];
        foreach ($allctdts as $ictdt) {
            $arr_mactdt += [$ictdt->ma_ctdt => $ictdt->ma_ctdt];
        }
        

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'tuychon_ctdt', '', $arr_mactdt, array());
        $mform->addGroup($eGroup, 'tuychon_ctdt', 'Chọn chương trình đào tạo', array(' '), false);

        // $allkkts = $DB->get_records('block_edu_khoikienthuc', []);
        // $arr_kkt = array();

        // foreach ($allkkts as $ikkt) {
        //     $arr_kkt += [$ikkt->ma_khoi => $ikkt->ma_khoi];
        // }
        
        // $eGroup1 = array();
        // $eGroup1[] = &$mform->createElement('select', 'tuychon_khoi', '', $arr_kkt ,array('Khoi A', 'Khoi B', 'Khoi C'));
        // $mform->addGroup($eGroup1, 'tuychon_khoi', 'Chọn khối', array(' '), false);

        $arr_monhoc = array();
        $arr_monhoc += ["0" => "Chọn môn học"];

        $eGroup2 = array();
        $eGroup2[] = &$mform->createElement('select', 'tuychon_mon', '', $arr_monhoc);
        $mform->addGroup($eGroup2, 'tuychon_mon', 'Chọn môn', array(' '), false);
        
        //////
        $eGroup4 = array();
        $eGroup4[] = &$mform->createElement('text', 'tenmonhoc1_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup4, 'tenmonhoc1_thongtinchung', get_string('tenmonhoc1_thongtinchung', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('tenmonhoc1_thongtinchung', '');

        $eGroup5 = array();
        $eGroup5[] = &$mform->createElement('text', 'tenmonhoc2_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup5, 'thongtinchung_group1', get_string('tenmonhoc2_thongtinchung', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('tenmonhoc2_thongtinchung', '');

        $eGroup6 = array();
        $eGroup6[] = &$mform->createElement('text', 'masomonhoc_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup6, 'thongtinchung_group2', get_string('masomonhoc_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('masomonhoc_thongtinchung', '');

        $eGroup7 = array();
        $eGroup7[] = &$mform->createElement('text', 'loaihocphan', '', 'size=50');
        $mform->addGroup($eGroup7, 'thongtinchung_group2', get_string('loaihocphan', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('loaihocphan', '');

        $eGroup8 = array();
        $eGroup8[] = &$mform->createElement('text', 'sotinchi_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup8, 'thongtinchung_group4', get_string('sotinchi_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('sotinchi_thongtinchung', '');

        $eGroup9 = array();
        $eGroup9[] = &$mform->createElement('text', 'tietlythuyet_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup9, 'thongtinchung_group5', get_string('tietlythuyet_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('tietlythuyet_thongtinchung', '');

        $eGroup10 = array();
        $eGroup10[] = &$mform->createElement('text', 'tietthuchanh_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup10, 'thongtinchung_group6', get_string('tietthuchanh_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('tietthuchanh_thongtinchung', '');
        ////////

        $eGroup4 = array();
        $eGroup4[] = &$mform->createElement('textarea', 'mota_decuong', 'Mô tả', 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup4, 'thongtinchung_group15', 'Mô tả đề cương', array(' '),  false);


        $eGroup3 = array();
        $eGroup3[] = &$mform->createElement('submit', 'btn_submit_decuong', 'Tạo đề cương');
        $mform->addGroup($eGroup3, 'thongtinchung_group14', '', array(' '),  false);

    }
    function validation($data, $files)
    {
        return array();
    }
    function get_submit_value($elementname){
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}
class header_decuongmonhoc_form extends moodleform{
    public function definition()
    {
        $mform = $this->_form;
        
        $mform->addElement('header', 'thong_tin_cung', 'Bạn đang thêm thông tin cho đề cương');
        $mform->addElement('text', 'ma_decuong_1', 'Mã đề cương');
        $mform->addElement('text', 'ma_ctdt_1', 'Chương trình đào tạo');
        
    }
    function validation($data, $files)
    {
        return array();
    }
}
class thongtinchung_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group thong tin chung
        $mform = $this->_form;
        

        
        $mform->addElement('header', 'general_thongtinchung', get_string('group_thongtinchung', 'block_educationpgrs'));

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'tenmonhoc1_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup1, 'tenmonhoc1_thongtinchung', get_string('tenmonhoc1_thongtinchung', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('tenmonhoc1_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tenmonhoc2_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group1', get_string('tenmonhoc2_thongtinchung', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('tenmonhoc2_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'masomonhoc_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group2', get_string('masomonhoc_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('masomonhoc_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'loaihocphan', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group2', get_string('loaihocphan', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('loaihocphan', '');


        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'thuoc_khoikienthuc_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group3', get_string('thuoc_khoikienthuc_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('thuoc_khoikienthuc_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'sotinchi_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group4', get_string('sotinchi_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('sotinchi_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tietlythuyet_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group5', get_string('tietlythuyet_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('tietlythuyet_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tietthuchanh_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group6', get_string('tietthuchanh_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('tietthuchanh_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'montienquyet_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group7', get_string('montienquyet_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('montienquyet_thongtinchung', '');
    }
    function validation($data, $files)
    {
        return array();
    }
}
class thongtinchung_decuongmonhoc_form1 extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group thong tin chung
        $mform = $this->_form;

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $eGroup1 = array();
        $eGroup1[] = &$mform->createElement('text', 'tenmonhoc1_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup1, 'tenmonhoc1_thongtinchung', get_string('tenmonhoc1_thongtinchung', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('tenmonhoc1_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tenmonhoc2_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group1', get_string('tenmonhoc2_thongtinchung', 'block_educationpgrs'), array(' '), false);
        $mform->disabledIf('tenmonhoc2_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'masomonhoc_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group2', get_string('masomonhoc_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('masomonhoc_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'loaihocphan', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group2', get_string('loaihocphan', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('loaihocphan', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'sotinchi_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group4', get_string('sotinchi_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('sotinchi_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tietlythuyet_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group5', get_string('tietlythuyet_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('tietlythuyet_thongtinchung', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tietthuchanh_thongtinchung', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group6', get_string('tietthuchanh_thongtinchung', 'block_educationpgrs'), array(' '),  false);
        $mform->disabledIf('tietthuchanh_thongtinchung', '');

    }
    function validation($data, $files)
    {
        return array();
    }
}
class mota_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group thong tin chung
        $mform = $this->_form;
        $mform->addElement('header', 'mota_decuong', get_string('group_mota_decuong', 'block_educationpgrs'));

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $eGroup=array();
        $eGroup[] =& $mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="10" cols="105"');
        $mform->setType('mota', PARAM_RAW);
        $mform->addGroup($eGroup, 'mota', '', array(' '), false);

        $mform->disabledIf('mota', '');

    }
    function validation($data, $files)
    {
        return array();
    }
}
class muctieumonhoc_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $a = array('G1', 'G2');
        //Group muc tieu mon hoc
        $mform = $this->_form;
        $mform->addElement('header', 'group_muctieumonhoc8', get_string('group_muctieumonhoc', 'block_educationpgrs'));
        $mform->setExpanded('group_muctieumonhoc8', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        
        $mform->addElement('textarea', 'mota_muctieu_muctieumonhoc', 'Nội dung', 'wrap="virtual" rows="10" cols="105"');
        $mform->addRule('mota_muctieu_muctieumonhoc', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        $eGroup = array();
        $eGroup[] = &$mform->createElement('autocomplete', 'chuandaura_cdio_muctieumonhoc', get_string('chuandaura_cdio_muctieumonhoc', 'block_educationpgrs'), $arr_chuandaura, $options );
        $eGroup[] = &$mform->createElement('button', 'fetch_chuandaura_cdio_muctieumonhoc', 'fetch', ['style'=>"margin-top: 45px; border-radius: 3px; width: 100px; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'gree4',  get_string('chuandaura_cdio_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_submit_muctieumonhoc', 'Thêm mục tiêu môn học mới');
        $mform->addGroup($eGroup, 'thongtinchung_group13', '', array(' '),  false);
    }
    function validation($data, $files)
    {
        return array();
    }
    public function get_submit_value($elementname)
    {
        $mform = &$this->_form;
        return $mform->getSubmitValue($elementname);
    }
    
}
class chuandaura_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group chuan daura monhoc
        $mform = $this->_form;
        $mform->addElement('header', 'group_chuandaura', get_string('group_chuandaura', 'block_educationpgrs'));
        $mform->setExpanded('group_chuandaura', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $arr_muctieu = array();
        $arr_muctieu += ["0" => "Chọn mục tiêu"];
        
        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'muctieu', 'Mã mục tiêu', $arr_muctieu );
        $eGroup[] = &$mform->createElement('button', 'fetch_muctieu', 'fetch',['style'=>"border-radius: 3px; width: 100px; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'thongtinchung_group133',  'Mã mục tiêu', array(' '),  false);
        
        $mform->addElement('textarea', 'mota_chuandaura', get_string('mota_chuandaura', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addRule('mota_chuandaura', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('text', 'mucdo_itu_chuandaura', get_string('mucdo_itu_chuandaura', 'block_educationpgrs'));
        $mform->addRule('mucdo_itu_chuandaura', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $eGroup = $mform->addElement('submit', 'them_chuandaura_monhoc_submit', 'Thêm chuẩn đầu ra môn học');
    }
    function validation($data, $files)
    {
        return array();
    }
    function get_submit_value($elementname){
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}
class giangday_TH_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group ke hoach giang day
        $mform = $this->_form;
        $mform->addElement('header', 'group_giangday_TH', get_string('group_giangday_TH', 'block_educationpgrs'));
        $mform->setExpanded('group_giangday_TH', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tuan_giangday', get_string('tuan_giangday', 'block_educationpgrs'), array('1', '2'));
        $mform->addGroup($eGroup, 'thongtinchung_group16', get_string('tuan_giangday', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'chudegiangday', get_string('chudegiangday', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group18', get_string('chudegiangday', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'danhsach_cdr', get_string('danhsach_cdr', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group18', get_string('danhsach_cdr', 'block_educationpgrs'), array(' '),  false);


        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'hoatdong_giangday', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group21', get_string('hoatdong_giangday', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'hoatdong_danhgia', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group21', get_string('hoatdong_danhgia', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_kehoachgiangday_TH_submit', 'Thêm kế hoạch giảng dạy');
    }
    function validation($data, $files)
    {
        return array();
    }
}
class giangday_LT_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group ke hoach giang day
        $mform = $this->_form;
        $mform->addElement('header', 'group_giangday_LT', get_string('group_giangday_LT', 'block_educationpgrs'));
        $mform->setExpanded('group_giangday_LT', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');


        $arr_chuandaura = array();
        $arr_chuandaura += [0 => "Chọn chuẩn đầu ra"];

        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        

        $eGroup = array();
        $eGroup[] = &$mform->createElement('autocomplete', 'danhsach_cdr', 'Chuẩn đầu ra', $arr_chuandaura, $options );
        $eGroup[] = &$mform->createElement('button', 'fetch_danhsach_cdr', 'fetch', ['style'=>"margin-top: 45px; border-radius: 3px; width: 100px; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'gree4e',  'Danh sách chuẩn đầu ra', array(' '),  false);

        
        $mform->addElement('text', 'chudegiangday', get_string('chudegiangday', 'block_educationpgrs'), 'size=50');
        $mform->addRule('chudegiangday', get_string('error'), 'required', 'extraruledata', 'server', false, false);
       
       
        $mform->addElement('textarea', 'hoatdong_giangday', 'Hoạt động giảng dạy/Hoạt động học', 'wrap="virtual" rows="10" cols="105"');
        $mform->addRule('hoatdong_giangday', get_string('error'), 'required', 'extraruledata', 'server', false, false);
       
       
        $mform->addElement('text', 'hoatdong_danhgia', 'Hoạt động đánh giá', 'size=50');
        // $mform->addRule('hoatdong_danhgia', get_string('error'), 'required', 'extraruledata', 'server', false, false);
       

        $eGroup = $mform->addElement('submit', 'them_kehoachgiangday_LT_submit', 'Thêm kế hoạch giảng dạy');
    }
    function validation($data, $files)
    {
        return array();
    }
    function get_submit_value($elementname){
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
   
}
class danhgia_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group danh gia
        $mform = $this->_form;
        $mform->addElement('header', 'group_danhgia', get_string('group_danhgia', 'block_educationpgrs'));
        $mform->setExpanded('group_danhgia', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $mform->addElement('text', 'madanhgia', get_string('madanhgia', 'block_educationpgrs'), array('G1.1', 'G2.2'));
        $mform->addRule('madanhgia', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('text', 'tendanhgia', 'Tên đánh giá', 'size=50');
        $mform->addRule('tendanhgia', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('textarea', 'motadanhgia', get_string('motadanhgia', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addRule('motadanhgia', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );

        $eGroup = array();
        $eGroup[] = &$mform->createElement('autocomplete', 'cacchuandaura_danhgia', 'Chuẩn đầu ra', $arr_chuandaura, $options );
        $eGroup[] = &$mform->createElement('button', 'fetch_chuandaura', 'fetch', ['style'=>"margin-top: 45px; border-radius: 3px; width: 100px; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'thongtinchung_group26', get_string('cacchuandaura_danhgia', 'block_educationpgrs'), array(' '),  false);

        $mform->addElement('text', 'tile_danhgia', 'Tỉ lệ', 'size=5');
        $mform->addRule('tile_danhgia', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'them_danhgiamonhoc_submit', 'Thêm đánh giá môn học');
        $mform->addGroup($eGroup, 'thongtinchung_group28', '', array(' '),  false);
    }
    function validation($data, $files)
    {
        return array();
    }
    function get_submit_value($elementname){
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}
class tainguyenmonhoc_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group tai nguyen mon hoc
        $mform = $this->_form;
        $mform->addElement('header', 'group_tainguyen', get_string('group_tainguyen', 'block_educationpgrs'));
        $mform->setExpanded('group_tainguyen', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');
        
        $arr_loaitainguyen = array();
        $arr_loaitainguyen += ["0" => "Chọn loại tài nguyên"];
        $arr_loaitainguyen += ["Book" => "Sách"];
        $arr_loaitainguyen += ["Internet" => "Internet"];
        $arr_loaitainguyen += ["Other" => "Khác"];

        $mform->addElement('select', 'loaitainguyen', 'Chọn loại tài nguyên', $arr_loaitainguyen);
        

        $mform->addElement('text', 'ten_tainguyen', 'Tên tài nguyên','size=50');
        
        $mform->hideIf('ten_tainguyen', 'loaitainguyen', 'eq', 'Other');

        $mform->addElement('textarea', 'mota_tainguyen', get_string('mota_tainguyen', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        

        $mform->addElement('text', 'link_tainguyen', 'Link tài nguyên', 'size=50');
        

        $mform->hideIf('link_tainguyen', 'loaitainguyen', 'neq', 'Internet');

        $eGroup = $mform->addElement('submit', 'them_tainguyenmonhoc_submit', 'Thêm tài nguyên môn học');
    }
    function validation($data, $files)
    {
        return array();
    }
    function get_submit_value($elementname){
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}
class quydinhchung_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        // mo ta quy dinh chung
        $mform = $this->_form;
        $mform->addElement('header', 'group_mota_quydinhchung', get_string('group_mota_quydinhchung', 'block_educationpgrs'));
        $mform->setExpanded('group_mota_quydinhchung', false);

        
        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');
        

        // $eGroup = array();
        $mform->addElement('textarea', 'mota_quydinhchung', get_string('mota_quydinhchung', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addRule('mota_quydinhchung', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        // $mform->addGroup($eGroup, 'thongtinchung_group32', get_string('mota_quydinhchung', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_quydinhchung_submit', 'Thêm quy định chung');
    }
    function validation($data, $files)
    {
        return array();
    }
}

class update_muctieumonhoc_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $a = array('G1', 'G2');
        //Group muc tieu mon hoc
        $mform = $this->_form;
        $mform->addElement('header', 'update_muctieumonhoc', get_string('update_muctieumonhoc', 'block_educationpgrs'));
        // $mform->setExpanded('group_muctieumonhoc8', false);

        
        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'muctieu_muctieumonhoc', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group9', get_string('muctieu_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'mota_muctieu_muctieumonhoc', get_string('mota_muctieu_muctieumonhoc', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group14', get_string('mota_muctieu_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'chuandaura_cdio_muctieumonhoc', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group12', get_string('chuandaura_cdio_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

        // $eGroup = $mform->addElement('submit', 'them_muctiru_monhoc_submit', 'Thêm mục tiêu môn học');

        $eGroup = array();
        // $mform->registerNoSubmitButton('btn_submit_muctieumonhoc');
        $eGroup[] = &$mform->createElement('submit', 'btn_submit_muctieumonhoc', 'Cập nhật mục tiêu');
        $mform->addGroup($eGroup, 'thongtinchung_group13', '', array(' '),  false);
    }
    function validation($data, $files)
    {
        return array();
    }
    public function get_submit_value($elementname)
    {
        $mform = &$this->_form;
        return $mform->getSubmitValue($elementname);
    }
}
class update_chuandaura_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group chuan daura monhoc
        $mform = $this->_form;
        $mform->addElement('header', 'update_chuandaura', get_string('update_chuandaura', 'block_educationpgrs'));
        //  $mform->setExpanded('group_chuandaura', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $mform->addElement('hidden', 'id', '');

        // $eGroup = array();
        // $eGroup[] = &$mform->createElement('select', 'chuandaura', get_string('chuandaura', 'block_educationpgrs'), array('G1.1', 'G2.2'));
        // $mform->addGroup($eGroup, 'thongtinchung_group13', get_string('chuandaura', 'block_educationpgrs'), array(' '),  false);
        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'chuandaura', get_string('chuandaura', 'block_educationpgrs'));
        $mform->addGroup($eGroup, 'thongtinchung_group133', get_string('chuandaura', 'block_educationpgrs'), array(' '),  false);


        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'mota_chuandaura', get_string('mota_chuandaura', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group14', get_string('mota_chuandaura', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'mucdo_itu_chuandaura', get_string('Mucdo_ITU_chuandaura', 'block_educationpgrs'));
        $mform->addGroup($eGroup, 'thongtinchung_group15', get_string('Mucdo_ITU_chuandaura', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_chuandaura_monhoc_submit', 'Cập nhật chuẩn đầu ra');
    }
    function validation($data, $files)
    {
        return array();
    }
}
class update_giangday_TH_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group ke hoach giang day
        $mform = $this->_form;
        $mform->addElement('header', 'update_kehoachgiangday_th_monhoc', get_string('update_kehoachgiangday_th_monhoc', 'block_educationpgrs'));
        // $mform->setExpanded('group_giangday_TH', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tuan_giangday', get_string('tuan_giangday', 'block_educationpgrs'), array('1', '2'));
        $mform->addGroup($eGroup, 'thongtinchung_group16', get_string('tuan_giangday', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'chudegiangday', get_string('chudegiangday', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group18', get_string('chudegiangday', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'danhsach_cdr', get_string('danhsach_cdr', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group18', get_string('danhsach_cdr', 'block_educationpgrs'), array(' '),  false);


        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'hoatdong_giangday', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group21', get_string('hoatdong_giangday', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'hoatdong_danhgia', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group21', get_string('hoatdong_danhgia', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_kehoachgiangday_TH_submit', 'Cập nhật kế hoạch giảng dạy');
    }
    function validation($data, $files)
    {
        return array();
    }
}
class update_giangday_LT_decuongmonhoc_form extends moodleform
{

    public function definition()
    {
        global $CFG;
        //Group ke hoach giang day
        $mform = $this->_form;
        $mform->addElement('header', 'update_kehoachgiangday_lt_monhoc', get_string('update_kehoachgiangday_lt_monhoc', 'block_educationpgrs'));
        // $mform->setExpanded('group_giangday_LT', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'chudegiangday', get_string('chudegiangday', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group18', get_string('chudegiangday', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'danhsach_cdr', get_string('danhsach_cdr', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group18', get_string('danhsach_cdr', 'block_educationpgrs'), array(' '),  false);


        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'hoatdong_giangday', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group21', get_string('hoatdong_giangday', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'hoatdong_danhgia', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group21', get_string('hoatdong_danhgia', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_kehoachgiangday_LT_submit', 'Cập nhật kế hoạch giảng dạy lý thuyết');
    }
    function validation($data, $files)
    {
        return array();
    }
}
class update_danhgia_decuongmonhoc_form extends moodleform
{

    public function definition()
    {
        global $CFG;
        //Group danh gia
        $mform = $this->_form;
        $mform->addElement('header', 'update_danhgiamonhoc', get_string('update_danhgiamonhoc', 'block_educationpgrs'));
        //  $mform->setExpanded('group_danhgia', false);

        
        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'madanhgia', get_string('madanhgia', 'block_educationpgrs'), array('G1.1', 'G2.2'));
        $mform->addGroup($eGroup, 'thongtinchung_group23', get_string('madanhgia', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tendanhgia', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group24', get_string('tendanhgia', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'motadanhgia', get_string('motadanhgia', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group25', get_string('motadanhgia', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'cacchuandaura_danhgia', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group26', get_string('cacchuandaura_danhgia', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'tile_danhgia', '', 'size=5');
        $mform->addGroup($eGroup, 'thongtinchung_group27', get_string('tile_danhgia', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'them_danhgiamonhoc_submit', 'Cập nhật đánh giá môn học');
        $mform->addGroup($eGroup, 'thongtinchung_group28', '', array(' '),  false);
    }
    function validation($data, $files)
    {
        return array();
    }
}
class update_tainguyenmonhoc_decuongmonhoc_form extends moodleform
{

    public function definition()
    {
        global $CFG;
        //Group tai nguyen mon hoc
        $mform = $this->_form;
        $mform->addElement('header', 'update_tainguyenmonhoc', get_string('update_tainguyenmonhoc', 'block_educationpgrs'));
        // $mform->setExpanded('group_tainguyen', false);

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');

        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'loaitainguyen', get_string('loaitainguyen', 'block_educationpgrs'), array('Sách', 'Internet', 'Khác'));
        $mform->addGroup($eGroup, 'thongtinchung_group28', get_string('loaitainguyen', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'mota_tainguyen', get_string('mota_tainguyen', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group29', get_string('mota_tainguyen', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'link_tainguyen', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group31', get_string('link_tainguyen', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_tainguyenmonhoc_submit', 'Cập nhật tài nguyên môn học');
    }
    function validation($data, $files)
    {
        return array();
    }
}
class update_quydinhchung_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        // Mo ta quy dinh chung
        $mform = $this->_form;
        $mform->addElement('header', 'update_quydinhchung_monhoc', get_string('update_quydinhchung_monhoc', 'block_educationpgrs'));
        
        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'ma_decuong', '');
        $mform->addElement('hidden', 'ma_ctdt', '');
        
        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'mota_quydinhchung', get_string('mota_quydinhchung', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group32', get_string('mota_quydinhchung', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_quydinhchung_submit', 'Cập nhật quy định chung');
    }
    function validation($data, $files)
    {
        return array();
    }
}
// Form search
class decuong_seach extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $decuong_seach = array();
        
        $decuong_seach[] = &$mform->createElement('text', 'decuong_content_seach', 'none',  array('size'=>'40'));
        $decuong_seach[] = &$mform->createElement('submit', 'decuong_btn_seach', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($decuong_seach, 'seach_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
// Form search
class monhoc_seach extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $monhoc_seach = array();
        
        $monhoc_seach[] = &$mform->createElement('text', 'monhoc_content_seach', 'none',  array('size'=>'40'));
        $monhoc_seach[] = &$mform->createElement('submit', 'monhoc_btn_seach', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($monhoc_seach, 'seach_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
