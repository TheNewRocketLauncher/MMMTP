<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once("../../../style.css")

    class mo_nienkhoa_form extends moodleform {
        
        public function definition()
        {
            global $CFG,$DB;
            $mform = $this->_form;
           
    
            $mform = $this->_form;
            $mform->addElement('header','general_thong_tin_chung', get_string('group_thong_tin_chung', 'block_educationpgrs'));
            
  
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'id', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group', 'Id', array(' '), false);
               // Mã bậc            
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
            $mahe[] =& $mform->createElement('select', 'mahe', 'Testmmh Select:', $arr_mahe, array());
            $mform->addGroup($mahe, 'mahe', 'Mã hệ đào tạo', array(' '), false);





            $manienkhoaGroup =array();
            $manienkhoaGroup[]=& $mform->createElement('text','ma_nienkhoa','','size="100"');
            $mform->addGroup($manienkhoaGroup,'',get_string('themnienkhoa_manienkhoa','block_educationpgrs'),array(' '),false);

            $tenGroup =array();
            $tenGroup[]=& $mform->createElement('text','ten_nienkhoa','','size="100"');
            $mform->addGroup($tenGroup,'',get_string('themnienkhoa_tennienkhoa','block_educationpgrs'),array(' '),false);

      
            $eGroup=array();
            $eGroup[] =& $mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
            $mform->addGroup($eGroup, 'thong_tin_chung_group', get_string('themnienkhoa_mota', 'block_educationpgrs'), array(' '), false);



           
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
        function get_editor_options() {
            $editoroptions = [
            ];
            return $editoroptions;
        }
    }
?>