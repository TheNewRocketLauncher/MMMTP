<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

    class index_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;

            $mform->registerNoSubmitButton('newctdt');
            $mform->addElement('submit', 'newctdt', get_string('themctdt_head', 'block_educationpgrs'));
            

            // $tenbac=array();
            // $mform->addGroup($tenbac, 'serach_ctdt', 'Tìm kiếm', array(' '), false);


            // $mahe=array();
            // $allhedts ;
            // $arr_mahe = array();
            // foreach ($allhedts as $ihedt) {
            //     $arr_mahe[] =& $ihedt->ma_he;
            //   }
            // $mahe[] =& $mform->createElement('select', 'ma_he', 'Test Select:', $arr_mahe, array(''));
            // $mform->addGroup($mahe, 'ma_he', 'Mã hệ đào tạo', array(' '), false);
            // $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Thực hiện');
            // $buttonarray[] = $mform->createElement('cancel', null , 'Hủy');

            $manienkhoaGroup =array();
            $manienkhoaGroup[]= $mform->createElement('text','ma_nienkhoa','','size="100"');
                        $manienkhoaGroup[] =  $mform->createElement('submit', 'newctdt', 'Tìm kiếm');

            $mform->addGroup($manienkhoaGroup,'',get_string('themnienkhoa_manienkhoa','block_educationpgrs'),' ',false);






            // $mform->registerNoSubmitButton('hellomoodle');
            // $mform->addElement('submit', 'hellomoodle', get_string('themctdt_head', 'block_educationpgrs'));

            // $mform->addElement('submit', 'hello', get_string('themctdt_head', 'block_educationpgrs'));
            // $this->add_action_buttons();

            // //$mform->addElement('hidden', 'hiddenID', $this->_customdata['hiddenID']);
            // //$mform->setType('hiddenID', PARAM_INT);            
        }

        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
        
        function get_submit_value($elementname) {
            $mform = $this->_form;
            return $mform->getSubmitValue($elementname);
        }

        
        function hello() {
            $mform = & $this->_form;
            $mform->addElement('submit', 'newct', get_string('themctdt_btn_updatefromup', 'block_educationpgrs'));
        }

       
        
    }
?>