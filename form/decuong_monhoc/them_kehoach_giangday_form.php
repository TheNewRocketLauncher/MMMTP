<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


    class them_kehoach_giangday_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;

            $table = new html_table();
            $tmp1 = ['1','1/1/2011', 'Quy trình phần mềm', 'TL 1', 'Không có'];
            $table->head = array('STT', 'Tuần', 'Ngày', 'Chủ đề', 'Tài liệu tham khảo', 'Bài tập', 'Thao tác');
            $table->data[] = $tmp1;
            echo html_writer::table($table);
            $mform->addElement('button', 'back_kehoach_giangday', get_string('back', 'block_educationpgrs'));
            $mform->addElement('button', 'next_kehoach_giangday', get_string('next', 'block_educationpgrs'));
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>