<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class danhgia_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->addElement('select', 'ma_danhgia', get_string('ma_danhgia', 'block_educationpgrs'), array('1', '2', '3'));
            $mform->addElement('text', 'ten_danhgia', get_string('ten_danhgia', 'block_educationpgrs') );
            $mform->addElement('text', 'mota_danhgia', get_string('mota_danhgia', 'block_educationpgrs') );
            $mform->addElement('text', 'cac_chuan_daura_danhgia', get_string('cac_chuan_daura_danhgia', 'block_educationpgrs') );
            $mform->addElement('text', 'tile_danhgia', get_string('tile_danhgia', 'block_educationpgrs') );
            $mform->addElement('button', 'add_danhgia', get_string('add', 'block_educationpgrs'));
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>