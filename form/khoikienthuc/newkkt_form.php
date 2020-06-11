<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');

    class newkkt_form extends moodleform {
        
        public function definition()
        {
            global $CFG,$DB;
            $mform = $this->_form;

            ///----------------------------------------------------------------------------------------------------------------------///        
            $mform->addElement('header', 'general0', get_string('themctdt_thongtintongquat', 'block_educationpgrs'));
            $mform->setExpanded('general0', true);
            ///----------------------------------------------------------------------------------------------------------------------///         
            //$mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' . get_string('themctdt_thongtintongquat', 'block_educationpgrs') . '</h1>');

            
            // $listKhoa = array(
            //     0 => 'G1',
            //     1 => 'G2',
            //     2 => 'G3'
            // );

            $allbacdts = $DB->get_records('block_edu_bacdt', []);
            $arr_mabac = array();
            foreach ($allbacdts as $i) {
                $arr_mabac[] =& $i->ma_bac;
            }
            $allhedts = $DB->get_records('block_edu_hedt', []);
            $arr_mahe = array();
            foreach ($allhedts as $i) {
                $arr_mahe[] =& $i->ma_he;
            }
            $allnkdts = $DB->get_records('block_edu_nienkhoa', []);
            $arr_manienkhoa = array();
            foreach ($allnkdts as $i) {
                $arr_manienkhoa[] =& $i->ma_nienkhoa;
            }
            $allndts = $DB->get_records('block_edu_nganhdt', []);
            $arr_nganh = array();
            foreach ($allndts as $i) {
                $arr_nganh[] =& $i->ma_nganh;
            }
            $allcndts = $DB->get_records('block_edu_chuyennganhdt', []);
            $arr_chuyenganh = array();
            foreach ($allcndts as $i) {
                $arr_chuyenganh[] =& $i->ma_chuyenganh;
            }
            $arr_loaikhoi = array(
                0 => 'Bắt buộc',
                1 => 'Tự chọn'
            );
            $arr_xettren = array(
                0 => 'Tín chỉ',
                1 => 'Tiết lý thuyết',
                2 => 'Tiết thực hành',
                3 => 'Tiết bài tập'
            );
            $arr_loaikhoi = array(
                0 => 'Bắt buộc',
                1 => 'Tự chọn'
            );
            $arr_dieukien = array(
                0 => 'Có điều kiện',
                1 => 'Không điều kiện'
            );
            $arr_xettren_op = array(
                0 => 'Tối thiểu',
                1 => 'Tối đa'
            );

            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('select', 'select_bac', 'hello', $arr_mabac);
            // $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_bac', 'block_educationpgrs'), array(' '), false);   
            
            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('select', 'select_he', 'hello', $arr_mahe);
            // $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_he', 'block_educationpgrs'), array(' '), false);   

            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('select', 'select_khoa', 'hello', $arr_manienkhoa);
            // $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_khoa', 'block_educationpgrs'), array(' '), false);       
            
            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('select', 'select_nganh', 'hello', $arr_nganh);
            // $mform->addGroup($eGroup, 'gtxt_nganh', get_string('themkkt_lbl_nganh', 'block_educationpgrs'), array(' '), false);       
            
            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('select', 'select_chuyennganh', 'hello', $arr_chuyenganh);
            // $mform->addGroup($eGroup, 'gtxt_chuyenganh', get_string('themkkt_lbl_chuyenganh', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_tenkkt', '', 'size="50"');
            $mform->addGroup($eGroup, 'gtxt_tenkkt', get_string('themkkt_lbl_tenkhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_makhoi', '', 'size="50"');
            $mform->addGroup($eGroup, 'gtxt_makhoi', get_string('themkkt_lbl_makhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'select_loaikhoi', 'hello', $arr_loaikhoi);
            $mform->addGroup($eGroup, 'gtxt_loaikhoi', get_string('themkkt_lbl_loaikhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'select_operator', 'hello', $arr_xettren_op);
            $eGroup[] =& $mform->createElement('text', 'txt_xettren_value', '', 'size="5"');
            $eGroup[] =& $mform->createElement('select', 'select_xettren', 'hello', $arr_xettren);
            $mform->addGroup($eGroup, 'gtxt_loaidieukien', get_string('themkkt_lbl_xettren', 'block_educationpgrs'), array(' '), false);
            
            $mform->hideIf('gtxt_loaidieukien', 'select_loaikhoi', 'eq', 0);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_mota', '', 'size="50"');
            $mform->addGroup($eGroup, 'gtxt_mota', get_string('themkkt_lbl_mota', 'block_educationpgrs'), array(' '), false);

            // $mform->registerNoSubmitButton('btn_newkkt');
            $mform->registerNoSubmitButton('btn_cancle');
            // $mform->registerNoSubmitButton('btn_newkktcon');
            $eGroup=array();
            $eGroup[] =& $mform->createElement('submit', 'btn_newkkt', get_string('themkkt_btn_complete', 'block_educationpgrs'));
            $eGroup[] =& $mform->createElement('submit', 'btn_cancle', get_string('themkkt_btn_cancel', 'block_educationpgrs'));
            // $eGroup[] =& $mform->createElement('submit', 'btn_newkktcon', get_string('themkkt_btn_themkhoicon', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'gbtn', '', array(' '), false);



            $mform->registerNoSubmitButton('btn_addmonhoc');
            $mform->registerNoSubmitButton('btn_addkhoicon');
            
            $mform->addElement('checkbox', 'checkbox_cokhoicon', 'Có khối con');
            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'select_ktt', 'Chọn Khối con', $this->get_listkkt());
            $eGroup[] =& $mform->createElement('submit', 'btn_addkhoicon', get_string('themkkt_btn_themkhoicon', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'gadd_khoicon', 'Chọn môn học', array(' '), false);
            $mform->hideIf('gadd_khoicon', 'checkbox_cokhoicon', 'notchecked');

            
            $mform->addElement('checkbox', 'checkbox_comonhoc', 'Có môn học');
            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'select_ma_monhoc', 'hello', $this->get_listmonhoc());
            $eGroup[] =& $mform->createElement('submit', 'btn_addmonhoc', get_string('themkkt_btn_addsubject', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'gadd_monhoc', 'Chọn môn học', array(' '), false);
            $mform->hideIf('gadd_monhoc', 'checkbox_comonhoc', 'notchecked');
            
            // $mform->disable_form_change_checker();
        }

        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }

        function get_submit_value($elementname) {
            $mform = & $this->_form;
            return $mform->getSubmitValue($elementname);
        }

        function definition_after_data(){
            //parent::definition_after_data();
            $mform = $this->_form;
            $defaulttext = 'dmawndwa';
            $mform->setDefaults('txt_tenkkt', array('text'=>$defaulttext));

        }
        function get_listmonhoc(){
            global $CFG,$DB;
            $allmonhoc = $DB->get_records('block_edu_monhoc');
            if($allmonhoc == null){
                return null;
            } else{
                $arr_mamonhoc = array();
                foreach ($allmonhoc as $imonhoc) {
                    $arr_mamonhoc += array($imonhoc->ma_monhoc => $imonhoc->ma_monhoc);
                }
            }
            return $arr_mamonhoc;
        }
        function get_listkkt(){
            global $CFG,$DB;
            $arr_kkt = array();
            if($allmonhoc == null){
                return null;
            } else{
                $allkkt = $DB->get_records('block_edu_khoikienthuc', []);
                foreach ($allkkt as $imonhoc) {
                    $arr_kkt += array($imonhoc->ma_khoi => $imonhoc->ma_khoi);
                }
            }
            return $arr_kkt;
        }
    }
?>
