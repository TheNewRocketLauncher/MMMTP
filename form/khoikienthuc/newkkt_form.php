<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');

    class newkkt_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;

            ///----------------------------------------------------------------------------------------------------------------------///        
            $mform->addElement('header', 'general0', get_string('themctdt_thongtintongquat', 'block_educationpgrs'));
            $mform->setExpanded('general0', true);
            ///----------------------------------------------------------------------------------------------------------------------///         
            //$mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' . get_string('themctdt_thongtintongquat', 'block_educationpgrs') . '</h1>');

            
            $listKhoa = array(
                0 => 'G1',
                1 => 'G2',
                2 => 'G3'
            );

            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'txt_bac', 'hello', $listKhoa);
            $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_bac', 'block_educationpgrs'), array(' '), false);   
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'txt_he', 'hello', $listKhoa);
            $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_he', 'block_educationpgrs'), array(' '), false);   

            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'txt_khoa', 'hello', $listKhoa);
            $mform->addGroup($eGroup, 'gtxt_khoa', get_string('themkkt_lbl_khoa', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_nganh', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_nganh', get_string('themkkt_lbl_nganh', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_chuyennganh', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_chuyenganh', get_string('themkkt_lbl_chuyenganh', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_tenkkt', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_tenkkt', get_string('themkkt_lbl_makhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_makhoi', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_makhoi', get_string('themkkt_lbl_loaikhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_loaikhoi', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_loaikhoi', get_string('themkkt_lbl_thuockhoi', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'txt_mota', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtxt_mota', get_string('themkkt_lbl_mota', 'block_educationpgrs'), array(' '), false);

            $mform->registerNoSubmitButton('btn_newkkt');
            $mform->registerNoSubmitButton('btn_newkktcon');
            $eGroup=array();
            $eGroup[] =& $mform->createElement('submit', 'btn_newkkt', get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
            $eGroup[] =& $mform->createElement('submit', 'btn_newkktcon', get_string('themkkt_btn_themkhoicon', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'gbtn', '', array(' '), false);  
            
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
