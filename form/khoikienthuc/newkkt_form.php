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

            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'txt_bac', 'hello', $arr_mabac);
            $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_bac', 'block_educationpgrs'), array(' '), false);   
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'txt_he', 'hello', $arr_mahe);
            $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_he', 'block_educationpgrs'), array(' '), false);   

            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'txt_khoa', 'hello', $arr_manienkhoa);
            $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_khoa', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'txt_nganh', 'hello', $arr_nganh);
            $mform->addGroup($eGroup, 'gtxt_nganh', get_string('themkkt_lbl_nganh', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'txt_chuyennganh', 'hello', $arr_chuyenganh);
            $mform->addGroup($eGroup, 'gtxt_chuyenganh', get_string('themkkt_lbl_chuyenganh', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_tenkkt', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_tenkkt', get_string('themkkt_lbl_makhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_makhoi', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_makhoi', get_string('themkkt_lbl_loaikhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_loaikhoi', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_loaikhoi', get_string('themkkt_lbl_loaikhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_mota', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_mota', get_string('themkkt_lbl_mota', 'block_educationpgrs'), array(' '), false);

            // $mform->registerNoSubmitButton('btn_newkkt');
            $mform->registerNoSubmitButton('btn_cancle');
            // $mform->registerNoSubmitButton('btn_newkktcon');
            $eGroup=array();
            $eGroup[] =& $mform->createElement('submit', 'btn_newkkt', get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
            $eGroup[] =& $mform->createElement('submit', 'btn_cancle', get_string('themkkt_btn_cancel', 'block_educationpgrs'));
            // $eGroup[] =& $mform->createElement('submit', 'btn_newkktcon', get_string('themkkt_btn_themkhoicon', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'gbtn', '', array(' '), false);  
            
            // $mform->addElement('header', 'general', 'Header');
            // $mform->addElement('advcheckbox', 'config_checkbox', $repository->name);
            // $mform->setType('config_checkbox', PARAM_BOOL);

            // $mform->addElement('text', 'config_text', 'Some text input');

            
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
            parent::definition_after_data();

            // $mform =& $this->_form;
            // $config_text =& $mform->getElement('config_text');
            // $config_checkbox =& $mform->getElement('config_checkbox');

            // if (isset($config_checkbox->_attributes['checked'])) {
            //     $config_text->attributes['value'] = "The checkbox is checked";
            // } // if





            // $mform =& $this->_form;
            // $select_bac =& $mform->getElement('txt_bac');
            // $select_he =& $mform->getElement('txt_he');
            // $txt_cn =& $mform->getElement('txt_chuyennganh');

            // // if (isset($config_checkbox->_attributes[‘checked’])) {
            // //     $config_text->attributes[‘value’] = "The checkbox is checked";
            // // } // if

            // if($select_bac->attributes['value'] == 0){
            //     $txt_cn->attributes['value'] = "0";
            // }
            // if(get_submit_value('txt_bac') == 1){
            //     $txt_cn->attributes['value'] = "1";
            // }
            // if(get_submit_value('txt_bac') == 2){
            //     $txt_cn->attributes['value'] = "2";
            // }
        }

        // function init_tree($listKkt, $dataCurrent){
        //     foreach($listKkt as $i){
        //         if(count($i)> 1){
        //             init_tree($listKkt, null);
        //         } else{
        //             $eGroup=array();
        //             $eGroup[] =& $mform->createElement('text', 'txt_chuyennganh', '', 'size="100"');
        //             $mform->addGroup($eGroup, 'gtxt_chuyenganh', get_string('themkkt_lbl_chuyenganh', 'block_educationpgrs'), array(' '), false);
        //         }
        //     }
        // }

    }
?>
