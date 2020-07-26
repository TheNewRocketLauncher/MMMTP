<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class mo_nienkhoa_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        // Header
        // $mform->addElement('header', 'general', 'Quản lý thông tin');

        $mform->addElement('hidden', 'idnienkhoa', '');

        


        //Mã khóa tuyển
        $mform->addElement('text', 'ma_nienkhoa', 'Mã khóa tuyển', 'size=50');
        $mform->addRule('ma_nienkhoa', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        //Tên khóa tuyển
        $mform->addElement('text', 'ten_nienkhoa', 'Tên khóa tuyển', 'size="100"');
        $mform->addRule('ten_nienkhoa', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        // Mô tả
        $mota = array();
        $mota[] = &$mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
        $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Thực hiện');
        $buttonarray[] = $mform->createElement('cancel', null, 'Hủy');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
    function get_editor_options()
    {
        $editoroptions = [];
        return $editoroptions;
    }
}

class nienkhoa_search extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $nienkhoa_search = array();
        $nienkhoa_search[] = &$mform->createElement('text', 'nienkhoa_search', 'none',  array('size'=>'40'));
        $nienkhoa_search[] = &$mform->createElement('submit', 'btn_nienkhoa_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($nienkhoa_search, 'nienkhoa_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}

class them_nganh_vao_nienkhoa_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Select ngành
        $nganh_select = array();
        $allnganhs = $DB->get_records('eb_nganhdt', []);
        $arr_manganh = array();
        $arr_manganh += ['' => 'Chọn Ngành đào tạo...'];

        foreach ($allnganhs as $inganh) {
            $arr_manganh += [$inganh->ma_nganh => $inganh->ma_nganh . ' ('.$inganh->ma_nganh_goc. ' - '.$inganh->ten.')'];
        }
        $nganh_select[] = &$mform->createElement('select', 'manganh', 'select:', $arr_manganh, array());
        $nganh_select[] = &$mform->createElement('submit', 'btn_ctdt_select', 'Thêm vào khóa tuyển', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($nganh_select, 'nganh_select_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }

    function get_value() {
        $mform = & $this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }
}