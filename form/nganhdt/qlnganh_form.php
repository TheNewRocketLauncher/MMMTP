<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once("../../js.php");

// require_once("../../../style.css")

    class qlnganh_form extends moodleform {
        
        public function definition()
        {
            global $CFG,$DB;
            $mform = $this->_form;
            // Header
            $mform->addElement('header', 'general', 'Quản lý thông tin');

            // id
            $idnganh=array();
            $idnganh[] =& $mform->createElement('text', 'idnganh', 'ÁDASD', 'size="10"');
            $mform->addGroup($idnganh, 'idnganh', 'ID ngành đào tạo', array(' '), false);

            $mabac=array();
            $allbacdts = $DB->get_records('block_edu_bacdt', []);
            $arr_mabac = array();
            foreach ($allbacdts as $ibacdt) {
                $arr_mabac += [$ibacdt->ma_bac => $ibacdt->ma_bac];
              }              
            $mabac[] =& $mform->createElement('select', 'mabac', 'Test Select:', $arr_mabac, array());
            $mform->addGroup($mabac, 'mabac', 'Mã bậc đào tạo', array(' '), false);

            // Mã hệ
            $mahe=array();
            $allhedts = $DB->get_records('block_edu_hedt', []);
            $arr_mahe = array();
            foreach ($allhedts as $ihedt) {
                $arr_mahe += [$ihedt->ma_he => $ihedt->ma_he];
              }              
            $mahe[] =& $mform->createElement('select', 'mahe', 'Test Select:', $arr_mahe, array());
            $mform->addGroup($mahe, 'mahe', 'Mã hệ đào tạo', array(' '), false);

            // Mã niên khóa
            $manienkhoa=array();
            $allnienkhoadts = $DB->get_records('block_edu_nienkhoa', []);
            $arr_manienkhoa = array();
            foreach ($allnienkhoadts as $inienkhoadt) {
                $arr_manienkhoa += [$inienkhoadt->ma_nienkhoa => $inienkhoadt->ma_nienkhoa];
              }              
            $manienkhoa[] =& $mform->createElement('select', 'manienkhoa', 'Test Select:', $arr_manienkhoa, array());
            $mform->addGroup($manienkhoa, 'manienkhoa', 'Mã niên khóa đào tạo', array(' '), false);


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
            $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);
            
            
            
            
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

