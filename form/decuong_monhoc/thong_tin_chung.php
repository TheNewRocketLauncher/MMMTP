<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once("../../../style.css")

    class thong_tin_chung_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->addElement('html', '<p class="ten_mh">' . get_string('ten_monhoc1', 'block_educationpgrs') . '</p>');
            $mform->addElement('text');
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>