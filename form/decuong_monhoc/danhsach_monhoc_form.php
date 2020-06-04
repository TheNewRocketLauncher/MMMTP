<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once("../../../style.css")

    class danhsach_monhoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            // Header
            // $mform->addElement('header', 'general', 'Danh sách môn học');

                 
        }

        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>

