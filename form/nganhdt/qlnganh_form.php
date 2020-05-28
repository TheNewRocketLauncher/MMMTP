<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once("../../../style.css")

    class qlnganh_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            // Header
            $mform->addElement('header', 'general', 'Quản lý thông tin');

            // Mã ngành
            $manganh=array();
            $manganh[] =& $mform->createElement('text', 'manganh', 'ÁDASD', 'size="10"');
            $mform->addGroup($manganh, 'manganh', 'Mã ngành đào tạo', array(' '), false);

            // Tên ngành
            $tennganh=array();
            $tennganh[] =& $mform->createElement('text', 'tennganh', 'ÁDASD', 'size="70"');
            $mform->addGroup($tennganh, 'tennganh', 'Tên ngành đào tạo', array(' '), false);

            // Mô tả
            $mota = array();
            $mota[] =& $mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="100"');
            $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), true);
            
            
            
            
            //Button
            $buttonarray=array();
            $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Cập nhật');
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

