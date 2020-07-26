<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');

class create_cdr_form extends moodleform
{
    public function definition()
    {
        global $CFG,$DB;
        //Group thong tin chung
        $mform = $this->_form;
        $mform->addElement('header', 'general_thongtinchung', get_string('group_thongtinchung', 'block_educationpgrs'));
        
        $mform->addElement('text', 'ten', 'Tên đầy đủ', 'size=200');
        $mform->addRule('ten', 'Tên chuẩn đầu ra không được để trống', 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('select', 'ma_loai', 'Loại chuẩn đầu ra', get_loai_cdr());
        $mform->addRule('ma_loai', 'Bắt buộc chọn một loại', 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('textarea', 'mota', 'Mô tả', 'wrap="virtual" rows="7" cols="200"');

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'btn_create', 'Tạo mới');
        $buttonarray[] = $mform->createElement('submit', 'btn_cancel', 'Hủy');
        $mform->createElement('submit', 'btn_submit', 'Hủy');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
        $mform->registerNoSubmitButton('btn_cancel');

        $mform->addElement('hidden', 'id', 0);
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
