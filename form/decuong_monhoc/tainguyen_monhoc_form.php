<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class tainguyen_monhoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->addElement('select', 'loai_tainguyen', get_string('loai_tainguyen', 'block_educationpgrs'), array('URL', 'File'));
            $mform->addElement('text', 'mota_tainguyen', get_string('mota_tainguyen', 'block_educationpgrs') );
            $mform->addElement('select', 'link_tainguyen', get_string('link_tainguyen', 'block_educationpgrs'), array('Không có'));
            $mform->addElement('button', 'add_tainguyen', get_string('add', 'block_educationpgrs'));
            

        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>