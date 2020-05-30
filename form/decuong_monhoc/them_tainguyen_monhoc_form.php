<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


    class them_tainguyen_monhoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;

            $table = new html_table();
            $tmp1 = ['1','Book', 'software angerneer solution', 'http://w3chool.com'];
            $table->head = array('STT', 'Loại tài nguyên', 'Mô tả', 'Link đính kèm', 'Thao tác');
            $table->data[] = $tmp1;
            echo html_writer::table($table);
            $mform->addElement('button', 'back_tainguyen', get_string('back', 'block_educationpgrs'));
            $mform->addElement('button', 'next_tainguyen', get_string('next', 'block_educationpgrs'));
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>