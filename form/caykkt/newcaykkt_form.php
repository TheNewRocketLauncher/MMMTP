<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/caykkt_model.php');
require_once('../../model/khoikienthuc_model.php');

class newcaykkt_form_final extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        $mform->addElement('header', 'general7', 'Thông tin chung của cây');
        $mform->addElement('text', 'txt_tencay', 'Tên cây', 'size="200"');
        $mform->addElement('text', 'txt_mota', 'Mô tả', 'size="200"');
        $mform->addElement('submit', 'btn_Edit', 'Sửa');
        
        $mform->addElement('hidden', 'is_save', 0);
        $mform->disabledIf('txt_tencay', 'is_save', 'eq', 0);
        $mform->disabledIf('txt_mota', 'is_save', 'eq', 0);

        $mform->addElement('select', 'select_ma_khoi', 'Khối thuộc cây', $this->get_listkkt(), $options);

        $eGroup = array();
        $eGroup[] = $mform->createElement('button', 'btn_addcaykkt_add_khoi', 'Thêm thành khối cùng cấp', ['style'=>"border-radius: 3px; width: auto; height:40px; background-color: #32d96f; color: #fff"]);
        $eGroup[] = $mform->createElement('button', 'btn_addcaykkt_addkhoi_asChild', 'Thêm thành khối con', ['style'=>"border-radius: 3px; width: auto; height:40px; background-color: #32d96f; color: #fff"]);
        $mform->addGroup($eGroup, 'gbtn', '', array(' '), false);
        $mform->disable_form_change_checker();
    }

    function validation($data, $files)
    {
        return array();
    }
    
    function get_submit_value($elementname) {
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }

    function get_listkkt(){
        $listkkts = get_list_kkt();

        $arrMaKhois = array();
        $arrMaKhois += [0 => 'Chọn khối... '];
        foreach($listkkts as $item){
            $arrMaKhois += [$item->ma_khoi => $item->ma_khoi];
        }
        return $arrMaKhois;
    }
}

class newcaykkt_form_editable extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        $mform->addElement('header', 'general7', 'Thông tin chung của cây');
        $mform->addElement('text', 'txt_tencay', 'Tên cây', 'size="200"');
        $mform->addRule('txt_tencay', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        // $mform->setType('txt_tencay', PARAM_TEXT);

        $mform->addElement('text', 'txt_mota', 'Mô tả', 'size="200"');
        $mform->addRule('txt_mota', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_mota', PARAM_RAW);

        $mform->addElement('submit', 'btn_Submit', 'Lưu');
    }

    function validation($data, $files)
    {
        return array();
    }
    
    function get_submit_value($elementname) {
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}

class newcaykkt_form1_b extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        $eGroup = array();
        $eGroup[] = $mform->createElement('submit', 'btn_review', 'Xem thử dạng PDF');
        $eGroup[] = $mform->createElement('submit', 'btn_complete', 'Tạo cây này');
        $eGroup[] = $mform->createElement('submit', 'btn_cancle', 'Huỷ bỏ');        
        $mform->addGroup($eGroup, 'ndctbtn', '', '', false);

        $mform->registerNoSubmitButton('btn_cancle');
        $mform->registerNoSubmitButton('btn_review');
        
        $mform->disable_form_change_checker();
    }

    function validation($data, $files)
    {
        return array();
    }

    function get_submit_value($elementname) {
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}

class newcaykkt_form_Export extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        $mform->addElement('submit', 'btn_reveiw', 'Xem trước cây');
        $mform->disable_form_change_checker();
    }

    function validation($data, $files)
    {
        return array();
    }

    function get_submit_value($elementname) {
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}


///
class newcaykkt_form3 extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        $mform->addElement('header', 'general7', 'Thông tin chung của cây');
        $mform->addElement('text', 'txt_tencay', 'Tên cây', 'size="200"');
        $mform->addRule('txt_tencay', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        // $mform->setType('txt_tencay', PARAM_TEXT);

        $mform->addElement('editor', 'txt_mota', 'Mô tả', 'size="200"');
        $mform->addRule('txt_mota', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_mota', PARAM_RAW);

        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        $mform->addElement('autocomplete', 'area_mamonhoc', 'Khối thuộc cây', $this->get_listkkt(), $options);
        $mform->addRule('area_mamonhoc', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->addElement('submit', 'btn_complete', 'Tạo cây này');
        $mform->addElement('submit', 'btn_cancle', 'Huỷ');
        $mform->registerNoSubmitButton('btn_cancle');

    }

    function validation($data, $files)
    {
        return array();
    }

    function get_submit_value($elementname) {
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }

    function get_listkkt(){
        $listkkts = get_list_kkt();
        $arrMaKhois = array();
        $arrMaKhois[] = [0 => 'Chọn khối... '];
        foreach($listkkts as $item){
            $arrMaKhois += [$item->ma_khoi => $item->ma_khoi];
        }
        return $arrMaKhois;
    }
}

class newcaykkt_form2 extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        $mform->addElement('static', 'confirmQuestion', '', 'Bạn đang tạo mới một cây khối kiến thức rồi, bạn có muốn tiếp tục tạo cây này không?');

        $eGroup = array();
        $eGroup[] =& $mform->createElement('submit', 'btn_caykkt_continue', 'Tiếp tục tạo mới');
        $eGroup[] =& $mform->createElement('submit', 'btn_caykkt_createnew', 'Tạo một cây khác');
        $eGroup[] =& $mform->createElement('submit', 'btn_caykkt_cancle', 'Trở về');
        $mform->addGroup($eGroup, 'gbtn', '', array(' '), false);
        $mform->registerNoSubmitButton('btn_caykkt_createnew');
        $mform->registerNoSubmitButton('btn_caykkt_cancle');

        $mform->addElement('static', 'confirmQuestion', '', 'Lưu ý, bạn không thể tạo 2 cây cùng lúc, tạo một cây khác sẽ xoá sạch dữ liệu của cây hiện tại!');
    }

    function validation($data, $files)
    {
        return array();
    }
    
    function get_submit_value($elementname) {
        $mform = & $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}