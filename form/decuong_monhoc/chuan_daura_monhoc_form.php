<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class chuan_daura_monhoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->addElement('select', 'colors', get_string('chuan_daura', 'block_educationpgrs'), array('G1.1', 'G2.1', 'G3.1'));
            $mform->addElement('text', 'mota_chuan_daura', get_string('mota_chuan_daura', 'block_educationpgrs') );
            $mform->addElement('select', 'Mucdo_ITU_chuan_daura', get_string('Mucdo_ITU_chuan_daura', 'block_educationpgrs'), array('Không có'));
            $mform->addElement('button', 'add_chuan_daura', get_string('add', 'block_educationpgrs'));
            

        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>