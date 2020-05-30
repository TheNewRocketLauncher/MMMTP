<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


    class them_danhgia_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;

            $table = new html_table();
            $tmp1 = ['1','CSC3004', 'Bai tap 01', 'Deadline về nhà tuần 1', 'Hiểu cách vận hành Kernel', '10%'];
            $table->head = array('STT', 'Mã', 'Tên', 'Mô tả', 'Các chuẩn đầu ra', 'Tỉ lệ', 'Thao tác');
            $table->data[] = $tmp1;
            echo html_writer::table($table);
            $mform->addElement('button', 'back_danhgia', get_string('back', 'block_educationpgrs'));
            $mform->addElement('button', 'next_danhgia', get_string('next', 'block_educationpgrs'));
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>