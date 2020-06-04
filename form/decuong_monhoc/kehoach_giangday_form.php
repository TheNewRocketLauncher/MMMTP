<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class kehoach_giangday_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->addElement('select', 'tuan_giangday', get_string('tuan_giangday', 'block_educationpgrs'), array('1', '2', '3'));
            $mform->addElement('text', 'ngay_giangday', get_string('ngay_giangday', 'block_educationpgrs') );
            $mform->addElement('text', 'chude_giangday', get_string('chude_giangday', 'block_educationpgrs') );
            $mform->addElement('text', 'tailieu_thamkhao_giangday', get_string('tailieu_thamkhao_giangday', 'block_educationpgrs') );
            $mform->addElement('text', 'baitap_giangday', get_string('baitap_giangday', 'block_educationpgrs') );
            $mform->addElement('button', 'add_kehoach_giangday', get_string('add', 'block_educationpgrs'));


        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>