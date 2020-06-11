<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class update_monhoc_form extends moodleform {
        public $id = 0;
        public function definition()
        {
            global $CFG;
            //Group thong tin chung
            $mform = $this->_form;
            $mform->addElement('header','general_thong_tin_monhoc', 'Thông tin cập nhật');
            
            $mform->addElement('hidden', 'id', '');
            

            $eGroup1=array();
            $eGroup1[] =& $mform->createElement('text', 'ma_monhoc', '', 'size=50');
            $mform->addGroup($eGroup1, 'ma_monhoc', get_string('ma_monhoc_chitiet', 'block_educationpgrs'), array(' '), false);
            
            $eGroup1=array();
            $eGroup1[] =& $mform->createElement('text', 'ten_monhoc_vi', '', 'size=50');
            $mform->addGroup($eGroup1, 'ten_monhoc', get_string('ten_monhoc1_thongtin_chung', 'block_educationpgrs'), array(' '), false);
            
            
            $eGroup1=array();
            $eGroup1[] =& $mform->createElement('text', 'ten_monhoc_en', '', 'size=50');
            $mform->addGroup($eGroup1, 'ten_monhoc', get_string('ten_monhoc2_thongtin_chung', 'block_educationpgrs'), array(' '), false);
            

            $eGroup1=array();
            $eGroup1[] =& $mform->createElement('text', 'so_tinchi', '', 'size=10');
            $mform->addGroup($eGroup1, 'ten_monhoc', get_string('so_tinchi', 'block_educationpgrs'), array(' '), false);

            $eGroup1=array();
            $eGroup1[] =& $mform->createElement('text', 'so_tiet_LT', '', 'size=10');
            $mform->addGroup($eGroup1, 'ten_monhoc', get_string('so_tiet_LT', 'block_educationpgrs'), array(' '), false);

            $eGroup1=array();
            $eGroup1[] =& $mform->createElement('text', 'so_tiet_TH', '', 'size=10');
            $mform->addGroup($eGroup1, 'ten_monhoc', get_string('so_tiet_TH', 'block_educationpgrs'), array(' '), false);

            $eGroup1=array();
            $eGroup1[] =& $mform->createElement('text', 'so_tiet_BT', '', 'size=10');
            $mform->addGroup($eGroup1, 'ten_monhoc', get_string('so_tiet_BT', 'block_educationpgrs'), array(' '), false);         

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'loai_hocphan', '', 'size=50');
            $mform->addGroup($eGroup, 'loai_hocphan', get_string('loai_hocphan', 'block_educationpgrs'), array(' '),  false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'ghichu', '', 'size=50');
            $mform->addGroup($eGroup, 'ghi_chu', get_string('ghichu', 'block_educationpgrs'), array(' '),  false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('submit', 'btn_submit_update_monhoc', 'Cập nhật');
            $mform->addGroup($eGroup, 'thong_tin_chung_group16', '', array(' '),  false);
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
        public function getID()
        {
            return $id;
        }
        public function setID($x)
        {
            $id = $x;
        }

    }
?>