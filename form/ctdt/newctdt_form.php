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
        
        
        $mform->addElement('text', 'txt_tct', 'Tên đầy đủ', 'size="200"');
        $mform->addRule('txt_tct', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_tct', PARAM_TEXT);
        
        //SELECT BAC DT
        $allbacdts = $DB->get_records('eb_bacdt', []);
        $arr_mabac = array();
        $arr_mabac += ['0' => 'Chọn Bậc đào tạo...'];
        foreach ($allbacdts as $i) {
            $arr_mabac += [$i->ma_bac => $i->ma_bac];
        }
        $mform->addElement('select', 'mabac', get_string('themctdt_bacdt', 'block_educationpgrs'), $arr_mabac);
        $mform->addElement('text', 'bacdt', '', 'size="100"');
        
        //SELECT HE DT
        $arr_mahe = array();
        $arr_mahe += [0 => 'Chọn Hệ đào tạo...'];
        $allhedts = $DB->get_records('eb_hedt', []);
        foreach ($allhedts as $i) {
            $arr_mahe += [$i->ma_he => $i->ma_he];
        }
        $mform->addElement('select', 'mahe', get_string('themctdt_hedt', 'block_educationpgrs'), $arr_mahe);
        $mform->addElement('text', 'hedt', '', 'size="100"');

        //SELECT NIENKHOA DT
        $allnienkhoas = $DB->get_records('eb_nienkhoa', []);
        $arr_manienkhoa = array();
        $arr_manienkhoa += [0 => 'Chọn Niên khoá...'];
        foreach ($allnienkhoas as $i) {
            $arr_manienkhoa += [$i->ma_nienkhoa => $i->ma_nienkhoa];
        }
        $mform->addElement('select', 'manienkhoa', get_string('themctdt_khoatuyen', 'block_educationpgrs'), $arr_manienkhoa);
        $mform->addElement('text', 'nienkhoa', '', 'size="100"');
        
        //SELECT NGANH DT
        $allnganhs = $DB->get_records('eb_nganhdt', []);
        $arr_nganh = array();
        $arr_nganh += [0 => 'Chọn Ngành đào tạo...'];
        foreach ($allnganhs as $i) {
            $arr_nganh += [$i->ma_nganh => $i->ma_nganh];
        }
        $mform->addElement('select', 'manganh', get_string('themctdt_nganhdt', 'block_educationpgrs'), $arr_nganh);
        $mform->addElement('text', 'nganhdt', '', 'size="100"');

        //SELECT CHUYEN NGANH DT
        $allchuyennganhs = $DB->get_records('eb_chuyennganhdt', []);
        $arr_chuyenganh = array();
        $arr_chuyenganh += [0 => 'Chọn Chuyên ngành...'];
        foreach ($allchuyennganhs as $i) {
            $arr_chuyenganh += [$i->ma_chuyennganh => $i->ma_chuyennganh];
        }
        $mform->addElement('select', 'machuyennganh', get_string('themctdt_chuyennganh', 'block_educationpgrs'), $arr_chuyenganh);
        $mform->addElement('text', 'chuyenganhdt', '', 'size="100"');

        $mform->disabledIf('bacdt', '');
        $mform->disabledIf('hedt', '');
        $mform->disabledIf('nienkhoa', '');
        $mform->disabledIf('nganhdt', '');
        $mform->disabledIf('chuyenganhdt', '');
        

        /////////////////// 1.1 MỤC TIÊU ĐÀO TẠO
        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general1', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('editor', 'editor_muctieudt_chung', '1.1 Mục tiêu chung');
        $mform->addRule('editor_muctieudt_chung', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('editor', 'editor_muctieudt_cuthe', '1.2.1 Mục tiêu cụ thể');
        $mform->addRule('editor_muctieudt_cuthe', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $arr_cdr = array();
        $listcdr = $DB->get_records('eb_chuandaura_ctdt', ['level_cdr' => 0]);
        $arr_cdr += [0 => 'Chọn Chuẩn đầu ra...'];
        foreach($listcdr as $item){
            $arr_cdr += [$item->ma_cay_cdr => $item->ten];
        }
        $mform->addElement('select', 'select_cdr', 'Chuẩn đầu ra', $arr_cdr);

        // $mform->addElement('filepicker', 'file_cdr', 'Chuẩn đầu ra', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.xls'));
        // $mform->addRule('file_cdr', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('editor', 'editor_muctieudt_chnn', '1.3 Cơ hội nghề nghiệp');
        $mform->addRule('editor_muctieudt_chnn', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        /////////////////// 1.2 CHUẨN ĐẦU RA

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


        /////////////////// 6 CẤU TRÚC CHƯƠNG TRÌNH
        ///----------------------------------------------------------------------------------------------------------------------///
        // $mform->addElement('header', 'general6', get_string('themctdt_lbl_ctct', 'block_educationpgrs'));
        // ///----------------------------------------------------------------------------------------------------------------------///            
        
        
        // // Button
        // $mform->registerNoSubmitButton('btnupdatetodown');
        // $mform->registerNoSubmitButton('btnupdatefromdown');
        // $eGroup=array();
        // $eGroup[] = $mform->createElement('submit', 'btnupdatetodown', get_string('themctdt_btn_updatetodown', 'block_educationpgrs'));
        // $eGroup[] = $mform->createElement('html', '<h1 class="ten_mh" style="text-align: center; padding-left: 200px;"></h1>');
        // $eGroup[] = $mform->createElement('submit', 'btnupdatefromdown' , get_string('themctdt_btn_updatefromdown', 'block_educationpgrs'));
        // $mform->addGroup($eGroup, 'ctctbtn', '', ' ', false);


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
            $listMaCay += [$item->ma_cay_khoikienthuc => $item->ma_cay_khoikienthuc];
        }

        $url = new moodle_url('/blocks/educationpgrs/pages/caykkt/add_caykkt_ttc.php');
        $eGroup=array();
        $eGroup[] =& $mform->createElement('select','select_caykkt', '', $listMaCay);
        $eGroup[] =& $mform->createElement('button', 'btn_create_tree', 'Tạo cây mới', [ 'onClick' => "window.open('".$url."')", 'style'=>"border: 1px; border-color: #1177d1; width: auto; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'ndctbtn', '', '', false);

        /////////////////// IMPORT FILE
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general8', get_string('themctdt_lbl_importfile', 'block_educationpgrs'));
        $mform->setExpanded('general8', true);
        ///----------------------------------------------------------------------------------------------------------------------///            
        
        $mform->addElement('filepicker', 'file_cdtt_full', 'File CTĐT đầy đủ', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.xls'));

        $mform->registerNoSubmitButton('btn_review');
        $eGroup=array();
        $eGroup[] = $mform->createElement('submit', 'btn_review', 'Xem trước PDF');
        $eGroup[] = $mform->createElement('submit', 'btn_complete', get_string('themkkt_btn_complete', 'block_educationpgrs'));
        $mform->addGroup($eGroup, 'ndctbtn', '', '', false);
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

    function get_value() {
        $mform = & $this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }
}

class editctdt_form extends moodleform {
    
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        /////////////////// THÔNG TIN CHUNG
        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general0', get_string('themctdt_thongtintongquat', 'block_educationpgrs'));
        $mform->setExpanded('general0', false);
        ///----------------------------------------------------------------------------------------------------------------------///         
        
        
        $mform->addElement('text', 'txt_tct', 'Tên đầy đủ', 'size="200"');
        $mform->addRule('txt_tct', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        $mform->setType('txt_tct', PARAM_TEXT);
        
        //SELECT BAC DT
        $allbacdts = $DB->get_records('eb_bacdt', []);
        $arr_mabac = array();
        $arr_mabac += ['0' => 'Chọn Bậc đào tạo...'];
        foreach ($allbacdts as $i) {
            $arr_mabac += [$i->ma_bac => $i->ma_bac];
        }
        $mform->addElement('select', 'mabac', get_string('themctdt_bacdt', 'block_educationpgrs'), $arr_mabac);
        $mform->addElement('text', 'bacdt', '', 'size="100"');
        
        //SELECT HE DT
        $arr_mahe = array();
        $arr_mahe += [0 => 'Chọn Hệ đào tạo...'];
        $allhedts = $DB->get_records('eb_hedt', []);
        foreach ($allhedts as $i) {
            $arr_mahe += [$i->ma_he => $i->ma_he];
        }
        $mform->addElement('select', 'mahe', get_string('themctdt_hedt', 'block_educationpgrs'), $arr_mahe);
        $mform->addElement('text', 'hedt', '', 'size="100"');

        //SELECT NIENKHOA DT
        $allnienkhoas = $DB->get_records('eb_nienkhoa', []);
        $arr_manienkhoa = array();
        $arr_manienkhoa += [0 => 'Chọn Niên khoá...'];
        foreach ($allnienkhoas as $i) {
            $arr_manienkhoa += [$i->ma_nienkhoa => $i->ma_nienkhoa];
        }
        $mform->addElement('select', 'manienkhoa', get_string('themctdt_khoatuyen', 'block_educationpgrs'), $arr_manienkhoa);
        $mform->addElement('text', 'nienkhoa', '', 'size="100"');
        
        //SELECT NGANH DT
        $allnganhs = $DB->get_records('eb_nganhdt', []);
        $arr_nganh = array();
        $arr_nganh += [0 => 'Chọn Ngành đào tạo...'];
        foreach ($allnganhs as $i) {
            $arr_nganh += [$i->ma_nganh => $i->ma_nganh];
        }
        $mform->addElement('select', 'manganh', get_string('themctdt_nganhdt', 'block_educationpgrs'), $arr_nganh);
        $mform->addElement('text', 'nganhdt', '', 'size="100"');

        //SELECT CHUYEN NGANH DT
        $allchuyennganhs = $DB->get_records('eb_chuyennganhdt', []);
        $arr_chuyenganh = array();
        $arr_chuyenganh += [0 => 'Chọn Chuyên ngành...'];
        foreach ($allchuyennganhs as $i) {
            $arr_chuyenganh += [$i->ma_chuyennganh => $i->ma_chuyennganh];
        }
        $mform->addElement('select', 'machuyennganh', get_string('themctdt_chuyennganh', 'block_educationpgrs'), $arr_chuyenganh);
        $mform->addElement('text', 'chuyenganhdt', '', 'size="100"');

        $mform->disabledIf('bacdt', '');
        $mform->disabledIf('hedt', '');
        $mform->disabledIf('nienkhoa', '');
        $mform->disabledIf('nganhdt', '');
        $mform->disabledIf('chuyenganhdt', '');
        

        /////////////////// 1.1 MỤC TIÊU ĐÀO TẠO
        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general1', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'));
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('editor', 'editor_muctieudt_chung', '1.1 Mục tiêu chung');
        $mform->addRule('editor_muctieudt_chung', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('editor', 'editor_muctieudt_cuthe', '1.2.1 Mục tiêu cụ thể');
        $mform->addRule('editor_muctieudt_cuthe', get_string('error'), 'required', 'extraruledata', 'server', false, false);

        $arr_cdr = array();
        $listcdr = $DB->get_records('eb_chuandaura_ctdt', ['level_cdr' => 1]);
        $arr_cdr += [0 => 'Chọn Bậc đào tạo...'];
        $stt = 1;
        foreach($listcdr as $item){
            $arr_cdr += [$stt => $item->ma_cdr];
            $stt ++;
        }
        $mform->addElement('select', 'select_cdr', 'Chuẩn đầu ra', $arr_cdr);

        // $mform->addElement('filepicker', 'file_cdr', 'Chuẩn đầu ra', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.xls'));
        // $mform->addRule('file_cdr', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        
        $mform->addElement('editor', 'editor_muctieudt_chnn', '1.3 Cơ hội nghề nghiệp');
        $mform->addRule('editor_muctieudt_chnn', get_string('error'), 'required', 'extraruledata', 'server', false, false);
        /////////////////// 1.2 CHUẨN ĐẦU RA

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


        /////////////////// 6 CẤU TRÚC CHƯƠNG TRÌNH
        ///----------------------------------------------------------------------------------------------------------------------///
        // $mform->addElement('header', 'general6', get_string('themctdt_lbl_ctct', 'block_educationpgrs'));
        // ///----------------------------------------------------------------------------------------------------------------------///            
        
        
        // // Button
        // $mform->registerNoSubmitButton('btnupdatetodown');
        // $mform->registerNoSubmitButton('btnupdatefromdown');
        // $eGroup=array();
        // $eGroup[] = $mform->createElement('submit', 'btnupdatetodown', get_string('themctdt_btn_updatetodown', 'block_educationpgrs'));
        // $eGroup[] = $mform->createElement('html', '<h1 class="ten_mh" style="text-align: center; padding-left: 200px;"></h1>');
        // $eGroup[] = $mform->createElement('submit', 'btnupdatefromdown' , get_string('themctdt_btn_updatefromdown', 'block_educationpgrs'));
        // $mform->addGroup($eGroup, 'ctctbtn', '', ' ', false);


        /////////////////// 7 NỘI DUNG CHƯƠNG TRÌNH
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general7', get_string('themctdt_lbl_ndct', 'block_educationpgrs'));
        $mform->setExpanded('general7', true);
        ///----------------------------------------------------------------------------------------------------------------------///            
        
        ///////////////// Sẽ có hàm để cập nhật data trong form này
        $mform->registerNoSubmitButton('btn_create_tree');

        $allCayKKT = (array) get_list_caykkt();
        $listMaCay = array();
        foreach($allCayKKT as $item){
            $listMaCay += [$item->ma_cay_khoikienthuc => $item->ma_cay_khoikienthuc];
        }

        $eGroup=array();
        $eGroup[] =& $mform->createElement('select','select_caykkt', '', $listMaCay);
        $eGroup[] =& $mform->createElement('submit', 'btn_create_tree', 'Tạo cây mới');
        $mform->addGroup($eGroup, 'ndctbtn', '', '', false);

        /////////////////// IMPORT FILE
        ///----------------------------------------------------------------------------------------------------------------------///
        $mform->addElement('header', 'general8', get_string('themctdt_lbl_importfile', 'block_educationpgrs'));
        $mform->setExpanded('general8', true);
        ///----------------------------------------------------------------------------------------------------------------------///            
        
        $mform->addElement('filepicker', 'file_cdtt_full', 'File CTĐT đầy đủ', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.xls'));

        $mform->registerNoSubmitButton('btn_review');
        $mform->registerNoSubmitButton('btn_cancle');
        $eGroup=array();
        $eGroup[] = $mform->createElement('submit', 'btn_review', 'Xem trước PDF');
        $eGroup[] = $mform->createElement('submit', 'btn_complete', get_string('themkkt_btn_complete', 'block_educationpgrs'));
        $eGroup[] = $mform->createElement('submit', 'btn_cancle', 'Huỷ bỏ');
        $mform->addGroup($eGroup, 'ndctbtn', '', '', false);
        $mform->registerNoSubmitButton('btn_review');

        $mform->addElement('hidden', 'edit_mode', '0');
        $mform->addElement('hidden', 'ma_ctdt', '');

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