<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


    class them_quydinh_chung_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;

            $table = new html_table();
            $tmp1 = ['1','Sinh viên chỉ được sử dụng tài liệu do nhà xuất bản HCM sản xuất và phân phối'];
            $table->head = array('STT', 'Mô tả', 'Thao tác');
            $table->data[] = $tmp1;
            echo html_writer::table($table);
            $mform->addElement('button', 'back_quydinh_chung', get_string('back', 'block_educationpgrs'));
            $mform->addElement('button', 'next_quydinh_chung', get_string('next', 'block_educationpgrs'));
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>