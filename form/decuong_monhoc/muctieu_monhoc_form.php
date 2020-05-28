<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class muctieu_monhoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->addElement('select', 'colors', get_string('muctieu_muctieu_monhoc', 'block_educationpgrs'), array('G1', 'G2', 'G3'));
            $mform->addElement('text', 'mota_muctieu_muctieu_monhoc', get_string('mota_muctieu_muctieu_monhoc', 'block_educationpgrs') );
            $mform->addElement('select', 'chuan_daura_cdio_muctieu_monhoc', get_string('chuan_daura_cdio_muctieu_monhoc', 'block_educationpgrs'), array('Không có'));
            $mform->addElement('button', 'add_muctieu_monhoc', get_string('add', 'block_educationpgrs'));


        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>