<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once("../../../style.css")

    class qlbac_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            // Header
            $mform->addElement('header', 'general', 'Quản lý thông tin');

            // id
            $idbac=array();
            $idbac[] =& $mform->createElement('text', 'idbac', 'ÁDASD', 'size="70"');
            $mform->addGroup($idbac, 'idbac', 'ID', array(' '), false);

            // Mã bậc
            $mabac=array();
            $mabac[] =& $mform->createElement('text', 'mabac', 'ÁDASD', 'size="70"');
            $mform->addGroup($mabac, 'mabac', 'Mã bậc đào tạo', array(' '), false);

            // Tên bậc
            $tenbac=array();
            $tenbac[] =& $mform->createElement('text', 'tenbac', 'ÁDASD', 'size="70"');
            $mform->addGroup($tenbac, 'tenbac', 'Tên bậc đào tạo', array(' '), false);

            // Mô tả
            $mota = array();
            $mota[] =& $mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
            $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);
            
            
            
            
            // $mform->addElement('html', '<p class="nganhdt">' . get_string('themctdt_nganhdt', 'block_educationpgrs') . '</p>');
            // $mform->addElement('text');
            // $mform->addElement('html', '<p class="manganh">' . get_string('themctdt_manganh', 'block_educationpgrs') . '</p>');
            // $mform->addElement('text');
            // $mform->addElement('html', '<p class="hedt">' . get_string('themctdt_hedt', 'block_educationpgrs') . '</p>');
            // $mform->addElement('text');
            // $mform->addElement('html', '<p class="khoatuyen">' . get_string('themctdt_khoatuyen', 'block_educationpgrs') . '</p>');
            // $mform->addElement('text');
            // $mform->addHelpButton('shuffleanswers', 'shuffleanswers', 'qtype_multichoice');
            //Button
            $buttonarray=array();
            $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Thực hiện');
            $buttonarray[] = $mform->createElement('cancel', null , 'Hủy');
            $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
        }

        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>

