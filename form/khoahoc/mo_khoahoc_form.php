<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

    class mo_khoahoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            
            
            //Group thong tin chung
            $mform1 = $this->_form;
            $mform1->addElement('header','general_thong_tin_chung', get_string('group_thong_tin_chung', 'block_educationpgrs'));
            
  
            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'id', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', 'Id', array(' '), false);




            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'id_monhoc', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', 'Id môn học', array(' '), false);


            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'ten_khoahoc', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('ten_khoahoc', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'giaovien_phutrach', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('giaovien_phutrach', 'block_educationpgrs'), array(' '), false);

            $eGroup=array();
            $eGroup[] =& $mform1->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('mota_khoahoc', 'block_educationpgrs'), array(' '), false);


            $buttonarray=array();
            $buttonarray[] = $mform1->createElement('submit', 'submitbutton', 'Thực hiện');
            $buttonarray[] = $mform1->createElement('cancel', null , 'Hủy');
            $mform1->addGroup($buttonarray, 'buttonar', '', ' ', false);
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>