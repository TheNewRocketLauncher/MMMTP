<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');


class chitiet_cdr_form extends moodleform
{
    public function definition()
    {
        global $CFG,$DB;
        //Group thong tin chung
        $mform = $this->_form;
        $mform->addElement('header', 'general_thongtinchung', get_string('group_thongtinchung', 'block_educationpgrs'));

        $mform->addElement('select', 'select_cdr', 'Chuẩn đầu ra', []);
        $mform->disabledIf('select_cdr', '');

        $eGroup = array();
        $eGroup[] = $mform->createElement('text', 'txt_ten_cdr', 'Chọn chuẩn đầu ra', 'size="50"');
        $eGroup[] = $mform->createElement('button', 'btn_edit_cdr', 'Chỉnh sửa', ['style'=>"border: 1px; border-color: #1177d1; width: auto; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'group_', 'Tên chuẩn đầu ra', ' ', false);
        $mform->disabledIf('txt_ten_cdr', '');

        $eGroup = array();
        $eGroup[] = $mform->createElement('select', 'select_cdr_node', '', []);
        $eGroup[] = $mform->createElement('button', 'btn_refresh_chitiet_cdr', 'Làm mới', ['style'=>"border: 1px; border-color: #1177d1; width: auto; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'group_selectnode', 'Chọn node', ' ', false);

        $mform->addElement('text', 'txt_ten', 'Tên node con', 'size="200"');
        $mform->addRule('txt_ten', 'Tên chuẩn đầu ra không được trống', 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_ten', PARAM_TEXT);

        $mform->addElement('textarea', 'mota', 'Mô tả', 'wrap="virtual" rows="7" cols="75"');
      
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'btn_add_node_cdr', 'Thực hiện', ['style'=>"border: 1px; border-color: #1177d1; width: auto; height:40px; background-color: #1177d1; color: #fff"]);
        $buttonarray[] = $mform->createElement('cancel', 'btn_cancel', 'Trở về');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);

        $mform->addElement('hidden', 'ma_cay_cdr', '');

        $mform->registerNoSubmitButton('btn_add_node_cdr');
        $mform->registerNoSubmitButton('btn_cancel');

        $mform->addElement('hidden', 'is_used', 0);
        
        $mform->disabledIf('group_', 'is_used', 'eq', 1);
        $mform->disabledIf('btn_edit_cdr', 'is_used', 'eq', 1);
        $mform->disabledIf('txt_ten', 'is_used', 'eq', 1);
        $mform->disabledIf('mota', 'is_used', 'eq', 1);
        $mform->disabledIf('btn_add_node_cdr', 'is_used', 'eq', 1);
        $mform->disabledIf('group_selectnode', 'is_used', 'eq', 1);
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

    function get_all_list_cdr(){
        global $DB;
        $allchuandaura = $DB->get_records('eb_chuandaura_ctdt', ['level_cdr' => 0]);

        $arr_cdr = array();
        foreach($allchuandaura as $item){
            $arr_cdr += [$item->ma_cay_cdr => $item->ma_cay_cdr];
        }

        return $arr_cdr;
    }

    function get_list_ma_cdr(){
        global $DB;
        $allchuandaura = $DB->get_records('eb_chuandaura_ctdt', []);

        $arr_cdr = array();
        $arr_cdr += [0 => 'Vui lòng làm mới trước trước khi chọn'];
        foreach($allchuandaura as $item){
            if($item->ma_cdr != NULL){
                $arr_cdr += [$item->ma_cdr => $item->ten];
            }
        }

        return $arr_cdr;
    }

    function get_value() {
        $mform = & $this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }
}

class add_cdr_form extends moodleform
{
    public function definition()
    {
        global $CFG,$DB;
        //Group thong tin chung
        $mform = $this->_form;
        $mform->addElement('header', 'general_thongtinchung', get_string('group_thongtinchung', 'block_educationpgrs'));
        
        $mform->addElement('select', 'loai_cdr', 'Loại chuẩn đầu ra', get_loai_cdr());
        $mform->disabledIf('loai_cdr', '');
        $eGroup = array();
        $eGroup[] = $mform->createElement('select', 'cdr', 'Chuẩn đầu ra', $this->get_all_cdr());
        $eGroup[] = $mform->createElement('button', 'btn_edit_cdr', 'Chỉnh sửa', ['style'=>"border: 1px; border-color: #1177d1; width: auto; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'group_', 'Tên', ' ', false);
        $mform->disabledIf('cdr', '');

        $mform->addElement('text', 'txt_ten', 'Tên chuẩn đầu ra mới', 'size="200"');
        $mform->addRule('txt_ten', 'Tên chuẩn đầu ra không được trống', 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_ten', PARAM_TEXT);
        $mform->disabledIf('txt_ten', 'select_cdr', 'neq', 0);

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('button', 'btn_add_node_cdr', 'Thêm', ['style'=>"border: 1px; border-color: #1177d1; width: auto; height:40px; background-color: #1177d1; color: #fff"]);
        $buttonarray[] = $mform->createElement('submit', null, 'Trở về');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
        $mform->addElement('hidden', 'id', 0);
        $mform->disable_form_change_checker();
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

    function get_value() {
        $mform = & $this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }

    function get_all_cdr(){
        global $DB;
        $allchuandaura = $DB->get_records('eb_chuandaura_ctdt', ['level' => 1]);

        $arr_cdr = array();
        foreach($allchuandaura as $item){
            $arr_cdr += [$item->id => $item->ten];
        }

        return $arr_cdr;
    }

    function get_all_cdr_lv2(){
        global $DB;
        $allchuandaura = $DB->get_records('eb_chuandaura_ctdt', ['level' => 2]);

        $arr_cdr = array();
        $arr_cdr += [0 => 'Chọn chuẩn đầu ra'];
        foreach($allchuandaura as $item){
            if($item->ma_cdr != NULL){
                $arr_cdr += [$item->ma_cdr => $item->ten];
            }
        }

        return $arr_cdr;
    }
}