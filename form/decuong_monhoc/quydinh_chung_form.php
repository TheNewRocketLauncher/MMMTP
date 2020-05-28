<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class quydinh_chung_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->addElement('text', 'mota_quydinh_chung', get_string('mota_quydinh_chung', 'block_educationpgrs'));
            $mform->addElement('button', 'add_quydinh_chung', get_string('add', 'block_educationpgrs'));
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>