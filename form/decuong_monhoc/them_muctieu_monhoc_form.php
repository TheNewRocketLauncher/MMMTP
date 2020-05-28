<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


    class them_muctieu_monhoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;

            $table = new html_table();
            $tmp1 = ['1','G2', 'Thông thạo design by zeplin.io', 'Không có'];
            $table->head = array('STT', 'Mục tiêu', 'Mô tả', 'Chuẩn đầu ra', 'Thao tác');
            $table->data[] = $tmp1;
            echo html_writer::table($table);
            $mform->addElement('button', 'back_muctieu_monhoc', get_string('back', 'block_educationpgrs'));
            $mform->addElement('button', 'next_muctieu_monhoc', get_string('next', 'block_educationpgrs'));
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>