<?php
require_once(__DIR__ . '/../../../../config.php');
require_once(__DIR__ . '/../../model/caykkt_model.php');
require_once("$CFG->libdir/formslib.php");

class newctdt_form extends moodleform {
    
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        /////////////////// THÔNG TIN CHUNG
        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general0', get_string('themctdt_thongtintongquat', 'block_educationpgrs'));
        $mform->setExpanded('general0', false);
        ///----------------------------------------------------------------------------------------------------------------------///         
        
        
        $mform->addElement('text', 'txt_ma_ctdt', 'Mã chương trình đào tạo', 'size="200"');
        $mform->addRule('txt_ma_ctdt', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_ma_ctdt', PARAM_TEXT);
        
        $mform->addElement('text', 'txt_tct', 'Tên đầy đủ', 'size="200"');
        $mform->addRule('txt_tct', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_tct', PARAM_TEXT);
        

        /////////////////// 1.1 MỤC TIÊU ĐÀO TẠO
        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general1', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('editor', 'editor_muctieudt_chung', '1.1 Mục tiêu chung');
        $mform->addRule('editor_muctieudt_chung', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('editor', 'editor_muctieudt_cuthe', '1.2.1 Mục tiêu cụ thể');
        $mform->addRule('editor_muctieudt_cuthe', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        /////////////////// 1.2 CHUẨN ĐẦU RA
        
        $arr_cdr = array();
        $listcdr = $DB->get_records('eb_chuandaura_ctdt', ['level' => 1]);
        foreach($listcdr as $item){
            $arr_cdr += [$item->ma_cdr => $item->ten];
        }
        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        $mform->addElement('autocomplete', 'select_cdr', 'Chuẩn đầu ra', $arr_cdr, $options);
        $mform->addRule('select_cdr', 'Error', 'required', 'extraruledata', 'server', false, false);

        
        // $mform->addElement('filepicker', 'file_cdr', 'Chuẩn đầu ra', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.xls'));
        // $mform->addRule('file_cdr', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('editor', 'editor_muctieudt_chnn', '1.3 Cơ hội nghề nghiệp');
        $mform->addRule('editor_muctieudt_chnn', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        /////////////////// 2 THỜI GIAN ĐÀO TẠO
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general2', get_string('themctdt_lbl_tgdt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('text', 'txt_tgdt', '', 'size="200"');
        $mform->addRule('txt_tgdt', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_tgdt', PARAM_TEXT);

        /////////////////// 3 KHỐI LƯỢNG KIẾN THỨC TOÀN KHOÁ
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general3', get_string('themctdt_lbl_klkt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('text', 'txt_klkt', '', 'size="200"');
        $mform->addRule('txt_klkt', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_klkt', PARAM_TEXT);

        /////////////////// 4 ĐỐI TƯỢNG TUYỂN SINH
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general4', get_string('themctdt_lbl_dtts', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('text', 'txt_dtts', '', 'size="200"');
        $mform->addRule('txt_dtts', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_dtts', PARAM_TEXT);

        /////////////////// 5 QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general5', get_string('themctdt_lbl_qtdt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('editor', 'editor_qtdt', '5.1 Quy trình đào tạo', array('context' => $context, 'width' => '10200px') );
        $mform->addRule('editor_qtdt', 'Quy trình đào tạo không thể bỏ trống', 'required', 'extraruledata', 'server', false, false);
        $mform->setType('editor_qtdt', PARAM_RAW);

        // 5.2
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('editor', 'editor_dktn', '5.2 Điều kiện tốt nghiệp', array('context' => $context, 'width' => '10200px') );
        $mform->addRule('editor_dktn', 'Điều kiện tốt nghiệp không thể bỏ trống', 'required', 'extraruledata', 'server', false, false);
        $mform->setType('editor_dktn', PARAM_RAW);

        /////////////////// 7 NỘI DUNG CHƯƠNG TRÌNH
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general7', get_string('themctdt_lbl_ndct', 'block_educationpgrs'));
        $mform->setExpanded('general7', true);
        ///----------------------------------------------------------------------------------------------------------------------///            
        
        ///////////////// Sẽ có hàm để cập nhật data trong form này
        // $mform->registerNoSubmitButton('btn_create_tree');

        $allCayKKT = (array) get_list_caykkt();
        $listMaCay = array();
        foreach($allCayKKT as $item){
            $listMaCay += [$item->ma_cay_khoikienthuc => $item->ten_cay];
        }

        $url = new moodle_url('/blocks/educationpgrs/pages/caykkt/add_caykkt_ttc.php');
        $eGroup=array();
        $eGroup[] =& $mform->createElement('select','select_caykkt', '', $listMaCay);
        $eGroup[] =& $mform->createElement('button', 'btn_create_tree', 'Tạo cây mới', [ 'onClick' => "window.open('".$url."')", 'style'=>"border: 1px; border-color: #1177d1; width: auto; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'ndctbtn', '', '', false);

        $mform->addElement('submit', 'btn_complete', get_string('themkkt_btn_complete', 'block_educationpgrs'));

        $mform->addElement('hidden', 'id_ctdt', '');
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

    function get_value() {
        $mform = & $this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }
}


class edit_ctdt_form extends moodleform {
    
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        /////////////////// THÔNG TIN CHUNG
        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general0', get_string('themctdt_thongtintongquat', 'block_educationpgrs'));
        $mform->setExpanded('general0', false);
        ///----------------------------------------------------------------------------------------------------------------------///         
        
        
        $mform->addElement('text', 'txt_ma_ctdt', 'Mã chương trình đào tạo', 'size="200"');
        $mform->addRule('txt_ma_ctdt', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_ma_ctdt', PARAM_TEXT);
        
        $mform->addElement('text', 'txt_tct', 'Tên đầy đủ', 'size="200"');
        $mform->addRule('txt_tct', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_tct', PARAM_TEXT);
        

        /////////////////// 1.1 MỤC TIÊU ĐÀO TẠO
        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general1', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('editor', 'editor_muctieudt_chung', '1.1 Mục tiêu chung');
        $mform->addRule('editor_muctieudt_chung', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('editor', 'editor_muctieudt_cuthe', '1.2.1 Mục tiêu cụ thể');
        $mform->addRule('editor_muctieudt_cuthe', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        /////////////////// 1.2 CHUẨN ĐẦU RA
        
        $arr_cdr = array();
        $listcdr = $DB->get_records('eb_chuandaura_ctdt', ['level' => 1]);
        foreach($listcdr as $item){
            $arr_cdr += [$item->ma_cdr => $item->ten];
        }
        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        $mform->addElement('autocomplete', 'select_cdr', 'Chuẩn đầu ra', $arr_cdr, $options);
        $mform->addRule('select_cdr', 'Error', 'required', 'extraruledata', 'server', false, false);

        
        // $mform->addElement('filepicker', 'file_cdr', 'Chuẩn đầu ra', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.xls'));
        // $mform->addRule('file_cdr', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('editor', 'editor_muctieudt_chnn', '1.3 Cơ hội nghề nghiệp');
        $mform->addRule('editor_muctieudt_chnn', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        /////////////////// 2 THỜI GIAN ĐÀO TẠO
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general2', get_string('themctdt_lbl_tgdt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('text', 'txt_tgdt', '', 'size="200"');
        $mform->addRule('txt_tgdt', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_tgdt', PARAM_TEXT);

        /////////////////// 3 KHỐI LƯỢNG KIẾN THỨC TOÀN KHOÁ
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general3', get_string('themctdt_lbl_klkt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('text', 'txt_klkt', '', 'size="200"');
        $mform->addRule('txt_klkt', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_klkt', PARAM_TEXT);

        /////////////////// 4 ĐỐI TƯỢNG TUYỂN SINH
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general4', get_string('themctdt_lbl_dtts', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('text', 'txt_dtts', '', 'size="200"');
        $mform->addRule('txt_dtts', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_dtts', PARAM_TEXT);

        /////////////////// 5 QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general5', get_string('themctdt_lbl_qtdt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('editor', 'editor_qtdt', '5.1 Quy trình đào tạo', array('context' => $context, 'width' => '10200px') );
        $mform->addRule('editor_qtdt', 'Quy trình đào tạo không thể bỏ trống', 'required', 'extraruledata', 'server', false, false);
        $mform->setType('editor_qtdt', PARAM_RAW);

        // 5.2
        ///----------------------------------------------------------------------------------------------------------------------///            
        $mform->addElement('editor', 'editor_dktn', '5.2 Điều kiện tốt nghiệp', array('context' => $context, 'width' => '10200px') );
        $mform->addRule('editor_dktn', 'Điều kiện tốt nghiệp không thể bỏ trống', 'required', 'extraruledata', 'server', false, false);
        $mform->setType('editor_dktn', PARAM_RAW);

        /////////////////// 7 NỘI DUNG CHƯƠNG TRÌNH
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general7', get_string('themctdt_lbl_ndct', 'block_educationpgrs'));
        $mform->setExpanded('general7', true);
        ///----------------------------------------------------------------------------------------------------------------------///            
        
        ///////////////// Sẽ có hàm để cập nhật data trong form này
        // $mform->registerNoSubmitButton('btn_create_tree');

        $allCayKKT = (array) get_list_caykkt();
        $listMaCay = array();
        foreach($allCayKKT as $item){
            $listMaCay += [$item->ma_cay_khoikienthuc => $item->ten_cay];
        }

        $url = new moodle_url('/blocks/educationpgrs/pages/caykkt/add_caykkt_ttc.php');
        $eGroup=array();
        $eGroup[] =& $mform->createElement('select','select_caykkt', '', $listMaCay);
        $eGroup[] =& $mform->createElement('button', 'btn_create_tree', 'Tạo cây mới', [ 'onClick' => "window.open('".$url."')", 'style'=>"border: 1px; border-color: #1177d1; width: auto; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'ndctbtn', '', '', false);

        $mform->addElement('submit', 'btn_complete', get_string('themkkt_btn_complete', 'block_educationpgrs'));

        $mform->registerNoSubmitButton('btn_complete');
        $mform->addElement('hidden', 'key_ctdt', NULL);
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

    function get_value() {
        $mform = & $this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }
}
