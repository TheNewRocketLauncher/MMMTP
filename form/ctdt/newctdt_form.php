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
            
            $allbacdts = $DB->get_records('block_edu_bacdt', []);
            $arr_mabac = array();
            $arr_mabac += ['0' => 'Chọn Bậc đào tạo...'];
            foreach ($allbacdts as $i) {
                $arr_mabac += [$i->ma_bac => $i->ma_bac];
            }
            $mform->addElement('select', 'select_bacdt', get_string('themctdt_bacdt', 'block_educationpgrs'), $arr_mabac);
            
            $allhedts = $DB->get_records('block_edu_hedt', []);
            $arr_mahe = array();
            $arr_mahe += [0 => 'Chọn Hệ đào tạo...'];
            foreach ($allhedts as $i) {
                $arr_mahe += [$i->ma_he => $i->ma_he];
            }
            $mform->addElement('select', 'select_hedt', get_string('themctdt_hedt', 'block_educationpgrs'), $arr_mahe);
            
            $allnkdts = $DB->get_records('block_edu_nienkhoa', []);
            $arr_manienkhoa = array();
            $arr_manienkhoa += [0 => 'Chọn Bậc đào tạo....'];
            foreach ($allnkdts as $i) {
                $arr_manienkhoa += [$i->ma_nienkhoa => $i->ma_nienkhoa];
            }
            $mform->addElement('select', 'select_nienkhoa', get_string('themctdt_khoatuyen', 'block_educationpgrs'), $arr_manienkhoa);

            $allndts = $DB->get_records('block_edu_nganhdt', []);
            $arr_nganh = array();
            $arr_nganh += [0 => 'Chọn Bậc đào tạo...'];
            foreach ($allndts as $i) {
                $arr_nganh += [$i->ma_nganh => $i->ma_nganh];
            }
            $mform->addElement('select', 'select_nganhdt', get_string('themctdt_nganhdt', 'block_educationpgrs'), $arr_nganh);
            
            $allcndts = $DB->get_records('block_edu_chuyennganhdt', []);
            $arr_chuyenganh = array();
            $arr_chuyenganh += [0 => 'Chọn Bậc đào tạo...'];
            foreach ($allcndts as $i) {
                $arr_chuyenganh += [$i->ma_chuyenganh => $i->ma_chuyenganh];
            }
            $mform->addElement('select', 'select_chuyenganh', get_string('themctdt_chuyennganh', 'block_educationpgrs'), $arr_chuyenganh);
            

            /////////////////// 1.1 MỤC TIÊU ĐÀO TẠO
            ///----------------------------------------------------------------------------------------------------------------------///        
            $mform->addElement('header', 'general1', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('editor', 'editor_muctieudt_chung', '1.1 Mục tiêu chung');
            $mform->addRule('editor_muctieudt_chung', get_string('error'), 'required', 'extraruledata', 'server', false, false);

            $mform->addElement('editor', 'editor_muctieudt_cuthe', '1.2.1 Mục tiêu cụ thể');
            $mform->addRule('editor_muctieudt_cuthe', get_string('error'), 'required', 'extraruledata', 'server', false, false);

            $mform->addElement('filepicker', 'file_cdr', 'Chuẩn đầu ra', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.xls'));
            $mform->addRule('file_cdr', get_string('error'), 'required', 'extraruledata', 'server', false, false);
            
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
            $mform->addElement('editor', 'editor_qtdt', '', array('context' => $context, 'width' => '10200px') );
            $mform->addRule('editor_qtdt', get_string('error'), 'required', 'extraruledata', 'server', false, false);
            $mform->setType('editor_qtdt', PARAM_RAW);


            /////////////////// 6 CẤU TRÚC CHƯƠNG TRÌNH
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general6', get_string('themctdt_lbl_ctct', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            
            // Button
            $mform->registerNoSubmitButton('btnupdatetodown');
            $mform->registerNoSubmitButton('btnupdatefromdown');
            $eGroup=array();
            $eGroup[] = $mform->createElement('submit', 'btnupdatetodown', get_string('themctdt_btn_updatetodown', 'block_educationpgrs'));
            $eGroup[] = $mform->createElement('html', '<h1 class="ten_mh" style="text-align: center; padding-left: 200px;"></h1>');
            $eGroup[] = $mform->createElement('submit', 'btnupdatefromdown' , get_string('themctdt_btn_updatefromdown', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'ctctbtn', '', ' ', false);


            /////////////////// 7 NỘI DUNG CHƯƠNG TRÌNH
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general7', get_string('themctdt_lbl_ndct', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            ///////////////// Sẽ có hàm để cập nhật data trong form này
            $mform->registerNoSubmitButton('btnchoosetree');

            $allCayKKT = (array) get_list_caykkt();
            $listMaCay = array();
            foreach($allCayKKT as $item){
                $listMaCay += [$item->ma_cay_khoikienthuc => $item->ma_cay_khoikienthuc];
            }

            $eGroup=array();
            $eGroup[] =& $mform->createElement('select','select_caykkt', '', $listMaCay);
            $eGroup[] =& $mform->createElement('submit', 'btnchoosetree', 'Chọn cây');
            $mform->addGroup($eGroup, 'ndctbtn', '', '', false);
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

    class newctdt_form_import extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;

            /////////////////// IMPORT FILE
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general8', get_string('themctdt_lbl_importfile', 'block_educationpgrs'));
            $mform->setExpanded('general8', true);
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $mform->addElement('filepicker', 'file_cdtt_full', 'File CTĐT đầy đủ', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.xls'));

            $mform->registerNoSubmitButton('btn_review');
            $eGroup=array();
            $eGroup[] = $mform->createElement('submit', 'btn_review', get_string('themctdt_review', 'block_educationpgrs'));
            $eGroup[] = $mform->createElement('submit', 'btn_complete', get_string('themkkt_btn_complete', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'ndctbtn', '', '', false);

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
