<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once("../../../style.css")

    class ctdt_addnew_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            //text-align: center;

            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' . get_string('themctdt_tenchuogntrinh', 'block_educationpgrs') . '</h1>');

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'tct', '', 'size="100"');
            $mform->addGroup($eGroup, 'tctg', get_string('themctdt_tenchuogntrinh', 'block_educationpgrs'), array(' '), true)     ;       
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'tddt', '', 'size="100"');
            $mform->addGroup($eGroup, 'tddtg', get_string('themctdt_trinhdodt', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'nganhdt', '', 'size="100"');
            $mform->addGroup($eGroup, 'nganhdtg', get_string('themctdt_nganhdt', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'manganh', '', 'size="100"');
            $mform->addGroup($eGroup, 'manganhg', get_string('themctdt_manganh', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'hedt', '', 'size="100"');
            $mform->addGroup($eGroup, 'hedtg', get_string('themctdt_hedt', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'khoatuyen', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_khoatuyen', 'block_educationpgrs'), array(' '), false);


            /////////////////// 1 MỤC TIÊU ĐÀO TẠO
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;"></h1>');
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' 
            . get_string('themctdt_lbl_mtdt', 'block_educationpgrs') . '</h1>');
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('textarea', '1.1', '', 'wrap="virtual" rows="10" cols="105"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'), array(' '), false);
            $eGroup=array();
            $eGroup[] =& $mform->createElement('textarea', '1.2', '', 'wrap="virtual" rows="10" cols="105"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'), array(' '), false);


            /////////////////// 2 THỜI GIÁN ĐÀO TẠO
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;"></h1>');
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' 
            . get_string('themctdt_lbl_tgdt', 'block_educationpgrs') . '</h1>');
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', '2', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_lbl_tgdt', 'block_educationpgrs'), array(' '), false);


            /////////////////// 3 KHỐI LƯỢNG KIẾN THỨC TOÀN KHOÁ
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;"></h1>');
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' 
            . get_string('themctdt_lbl_klkt', 'block_educationpgrs') . '</h1>');
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', '3', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_lbl_klkt', 'block_educationpgrs'), array(' '), false);


            /////////////////// 4 ĐỐI TƯỢNG TUYỂN SINH
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;"></h1>');
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' 
            . get_string('themctdt_lbl_dtts', 'block_educationpgrs') . '</h1>');
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', '4', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_lbl_dtts', 'block_educationpgrs'), array(' '), false);


            /////////////////// 5 QUY TRÌNH ĐÀO TẠO
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;"></h1>');
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' 
            . get_string('themctdt_lbl_qtdt', 'block_educationpgrs') . '</h1>');
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', '5.1', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_qtdt', 'block_educationpgrs'), array(' '), false);
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', '5.2', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_dktn', 'block_educationpgrs'), array(' '), false);


            /////////////////// 6 CẤU TRÚC CHƯƠNG TRÌNH
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;"></h1>');
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' 
            . get_string('themctdt_lbl_ctct', 'block_educationpgrs') . '</h1>');
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'khoatuyen', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'), array(' '), false);


            /////////////////// 7 NỘI DUNG CHƯƠNG TRÌNH
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;"></h1>');
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' 
            . get_string('themctdt_lbl_ndct', 'block_educationpgrs') . '</h1>');
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'khoatuyen', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'), array(' '), false);


            /////////////////// IMPORT FILE
            ///----------------------------------------------------------------------------------------------------------------------///
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;"></h1>');
            $mform->addElement('html', '<h1 class="ten_mh" style="text-align: center; padding-bottom: 50px;">' 
            . get_string('themctdt_lbl_qtdt', 'block_educationpgrs') . '</h1>');
            ///----------------------------------------------------------------------------------------------------------------------///            
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'khoatuyen', '', 'size="100"');
            $mform->addGroup($eGroup, 'khoatuyeng', get_string('themctdt_lbl_mtdt', 'block_educationpgrs'), array(' '), false);

















            
        }

        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }

        
    }
?>