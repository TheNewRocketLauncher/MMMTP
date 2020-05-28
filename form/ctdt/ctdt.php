<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

    class ctdt extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            //text-align: center;

            // $mform->registerNoSubmitButton('newctdt');
            // $mform->addElement('submit', 'newctdt', get_string('themctdt_head', 'block_educationpgrs'));
            

            
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