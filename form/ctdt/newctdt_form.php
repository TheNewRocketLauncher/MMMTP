<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

    class newctdt_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            //text-align: center;

            /////////////////// THÔNG TIN CHUNG
            ///----------------------------------------------------------------------------------------------------------------------///        
            $mform->addElement('header', 'general0', get_string('themctdt_thongtintongquat', 'block_educationpgrs'));
            $mform->setExpanded('general0', false);
            ///----------------------------------------------------------------------------------------------------------------------///         
            //$mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' . get_string('themctdt_thongtintongquat', 'block_educationpgrs') . '</h1>');

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'tct', '', 'size="100"');
            $mform->addGroup($eGroup, 'tctg', get_string('themctdt_tenchuogntrinh', 'block_educationpgrs'), array(' '), false);       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'bacdt', '', 'size="100"');
            $mform->addGroup($eGroup, 'tddtg', get_string('themctdt_bacdt', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'hedt', '', 'size="100"');
            $mform->addGroup($eGroup, 'hedtg', get_string('themctdt_hedt', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'khoatuyen', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_khoatuyen', 'block_educationpgrs'), array(' '), false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'nganhdt', '', 'size="100"');
            $mform->addGroup($eGroup, 'nganhdtg', get_string('themctdt_nganhdt', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'chuyenganh', '', 'size="100"');
            $mform->addGroup($eGroup, 'manganhg', get_string('themctdt_chuyennganh', 'block_educationpgrs'), array(' '), false);
            

            /////////////////// 1 MỤC TIÊU ĐÀO TẠO
            ///----------------------------------------------------------------------------------------------------------------------///        
            $mform->addElement('header', 'general1', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('editor', 'mtc', 'dd', array('context' => $context, 'width' => '1050px') );
            $mform->setType('mtc', PARAM_RAW);
            $mform->addGroup($eGroup, 'mtdt1', '', array(' '), false);

            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('textarea', 'mtc_1_1', '', 'wrap="virtual" rows="10" cols="105"');
            // $mform->addGroup($eGroup, 'mtdt1', get_string('themctdt_mtc', 'block_educationpgrs'), array(' '), false);


            // $mform->addElement('html', '<p class="mtdt2" style="text-align: left; padding-left: 0px;">' . 
            //                     get_string('themctdt_mtctcdr', 'block_educationpgrs') . '</p>');
            
            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('textarea', 'mtc_1_2_1', '', 'wrap="virtual" rows="10" cols="105"');
            // $mform->addGroup($eGroup, 'mtdt21', get_string('themctdt_mtct', 'block_educationpgrs'), array(' '), false);
            
            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('textarea', 'mtc_1_2_2', '', 'wrap="virtual" rows="10" cols="105"');
            // $mform->addGroup($eGroup, 'mtdt22', get_string('themctdt_cdr', 'block_educationpgrs'), array(' '), false);
            
            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('textarea', 'mtc_1_3', '', 'wrap="virtual" rows="10" cols="105"');
            // $mform->addGroup($eGroup, 'mtdt3', get_string('themctdt_chnn', 'block_educationpgrs'), array(' '), false);
            

            /////////////////// 2 THỜI GIÁN ĐÀO TẠO
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general2', get_string('themctdt_lbl_tgdt', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'tgdt', '', 'size="100"');
            $mform->addGroup($eGroup, 'gtgdt', get_string('themctdt_lbl_tgdt', 'block_educationpgrs'), array(' '), false);


            /////////////////// 3 KHỐI LƯỢNG KIẾN THỨC TOÀN KHOÁ
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general3', get_string('themctdt_lbl_klkt', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'klkt', '', 'size="100"');
            $mform->addGroup($eGroup, 'g', get_string('themctdt_lbl_klkt', 'block_educationpgrs'), array(' '), false);


            /////////////////// 4 ĐỐI TƯỢNG TUYỂN SINH
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general4', get_string('themctdt_lbl_dtts', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'dtts', '', 'size="100"');
            $mform->addGroup($eGroup, 'gdtts', get_string('themctdt_lbl_dtts', 'block_educationpgrs'), array(' '), false);


            /////////////////// 5 QUY TRÌNH ĐÀO TẠO
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general5', get_string('themctdt_lbl_qtdt', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('textarea', '1.2', '', 'wrap="virtual" rows="10" cols="105"');
            // $mform->addGroup($eGroup, 'qtdt1', get_string('themctdt_qtdt', 'block_educationpgrs'), array(' '), false);
            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('textarea', '1.2', '', 'wrap="virtual" rows="10" cols="105"');
            // $mform->addGroup($eGroup, 'qtdt2', get_string('themctdt_dktn', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('editor', 'qtdt', 'dd', array('context' => $context, 'width' => '1050px') );
            $mform->setType('qtdt', PARAM_RAW);
            $mform->addGroup($eGroup, 'gqtdt', '', array(' '), false);


            /////////////////// 6 CẤU TRÚC CHƯƠNG TRÌNH
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general6', get_string('themctdt_lbl_ctct', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            
            //Button
            $mform->registerNoSubmitButton('btnupdatetodown');
            $mform->registerNoSubmitButton('btnupdatefromdown');
            $eGroup=array();
            $eGroup[] = $mform->createElement('submit', 'btnupdatetodown', get_string('themctdt_btn_updatetodown', 'block_educationpgrs'));
            $eGroup[] = $mform->createElement('html', '<h1 class="ten_mh" style="text-align: center; padding-left: 50px;"></h1>');
            $eGroup[] = $mform->createElement('submit', 'btnupdatefromdown' , get_string('themctdt_btn_updatefromdown', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'ctctbtn', '', ' ', false);


            /////////////////// 7 NỘI DUNG CHƯƠNG TRÌNH
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general7', get_string('themctdt_lbl_ndct', 'block_educationpgrs'));
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            ///////////////// Sẽ có hàm để cập nhật data trong form này
            $mform->registerNoSubmitButton('btnchoosetree');
            $mform->registerNoSubmitButton('btnupdatefromup');
            $eGroup=array();
            $mform->addElement('submit', 'btnchoosetree', get_string('themctdt_btn_choncaykkt', 'block_educationpgrs'));

            $eGroup[] = $mform->createElement('submit', 'btnupdatefromup', get_string('themctdt_btn_updatefromup', 'block_educationpgrs'));
            $mform->addGroup($eGroup, 'ndctbtn', '', ' ', false);
            
            


            /////////////////// IMPORT FILE
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('header', 'general8', get_string('themctdt_lbl_importfile', 'block_educationpgrs'));
            $mform->setExpanded('general8', true);
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $mform->addElement('filepicker', 'userfile', get_string('file'), null, array('maxbytes' => $maxbytes, 'accepted_types' => '*'));


            $eGroup[] = $mform->addElement('submit', 'btnreview', get_string('themctdt_review', 'block_educationpgrs'));














            
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

        // function get_value_editor($elementname) {
        //     $mform = & $this->_form;
        //     return $mform->getValues($elementname);
        // }

    }
?>