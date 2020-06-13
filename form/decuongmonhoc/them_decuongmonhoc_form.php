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

class thongtinchung_decuongmonhoc_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        //Group thong tin chung
        $mform = $this->_form;
        $mform->addElement('header', 'general_thongtinchung', get_string('group_thongtinchung', 'block_educationpgrs'));

        $mform->addElement('hidden', 'mamonhoc', '');
        $mform->addElement('hidden', 'id', '');

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
        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'muctieu_muctieumonhoc', get_string('muctieu_muctieumonhoc', 'block_educationpgrs'), $a);
        $mform->addGroup($eGroup, 'thongtinchung_group9', get_string('muctieu_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'mota_muctieu_muctieumonhoc', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group11', get_string('mota_muctieu_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'chuandaura_cdio_muctieumonhoc', get_string('muctieu_muctieumonhoc', 'block_educationpgrs'), array('Không có'));
        $mform->addGroup($eGroup, 'thongtinchung_group12', get_string('chuandaura_cdio_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

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
        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'chuandaura', get_string('chuandaura', 'block_educationpgrs'), array('G1.1', 'G2.2'));
        $mform->addGroup($eGroup, 'thongtinchung_group133', get_string('chuandaura', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'mota_chuandaura', get_string('mota_chuandaura', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group14', get_string('mota_chuandaura', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'mucdo_itu_chuandaura', get_string('mucdo_itu_chuandaura', 'block_educationpgrs'));
        $mform->addGroup($eGroup, 'thongtinchung_group15', get_string('mucdo_itu_chuandaura', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_chuandaura_monhoc_submit', 'Thêm chuẩn đầu ra môn học');
    }
    function validation($data, $files)
    {
        return array();
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

        $eGroup = $mform->addElement('submit', 'them_kehoachgiangday_LT_submit', 'Thêm kế hoạch giảng dạy');
    }
    function validation($data, $files)
    {
        return array();
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
        $eGroup[] = &$mform->createElement('submit', 'them_danhgiamonhoc_submit', 'Thêm đánh giá môn học');
        $mform->addGroup($eGroup, 'thongtinchung_group28', '', array(' '),  false);
    }
    function validation($data, $files)
    {
        return array();
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

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'loaitainguyen', get_string('loaitainguyen', 'block_educationpgrs'), array('Sách', 'Internet', 'Khác'));
        $mform->addGroup($eGroup, 'thongtinchung_group28', get_string('loaitainguyen', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'mota_tainguyen', get_string('mota_tainguyen', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group29', get_string('mota_tainguyen', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'link_tainguyen', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group31', get_string('link_tainguyen', 'block_educationpgrs'), array(' '),  false);

        $eGroup = $mform->addElement('submit', 'them_tainguyenmonhoc_submit', 'Thêm tài nguyên môn học');
    }
    function validation($data, $files)
    {
        return array();
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

        $eGroup = array();
        $eGroup[] = &$mform->createElement('textarea', 'mota_quydinhchung', get_string('mota_quydinhchung', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
        $mform->addGroup($eGroup, 'thongtinchung_group32', get_string('mota_quydinhchung', 'block_educationpgrs'), array(' '),  false);

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
        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'muctieu_muctieumonhoc', get_string('muctieu_muctieumonhoc', 'block_educationpgrs'), $a);
        $mform->addGroup($eGroup, 'thongtinchung_group9', get_string('muctieu_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'mota_muctieu_muctieumonhoc', '', 'size=50');
        $mform->addGroup($eGroup, 'thongtinchung_group11', get_string('mota_muctieu_muctieumonhoc', 'block_educationpgrs'), array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'chuandaura_cdio_muctieumonhoc', get_string('muctieu_muctieumonhoc', 'block_educationpgrs'), array('Không có'));
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
        $mform->addElement('hidden', 'id', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'chuandaura', get_string('chuandaura', 'block_educationpgrs'), array('G1.1', 'G2.2'));
        $mform->addGroup($eGroup, 'thongtinchung_group13', get_string('chuandaura', 'block_educationpgrs'), array(' '),  false);

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
