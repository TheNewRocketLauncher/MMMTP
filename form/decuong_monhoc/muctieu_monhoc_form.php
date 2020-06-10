<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class muctieu_monhoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            // Set table.
            
            $table = new html_table();
            // $tmp1 = [1, 'Cấu trúc dữ liệu và giải thuật', '4', '7.0'];
            // $tmp2 = ['CSC13003', 'Kiểm chứng phần mềm', '4', '7.5'];
            // $tmp3 = ['MTH00050', 'Toán học tổ hợp', '4', '8.0'];
            // $tmp4 = ['CSC10007', 'Hệ điều hành', '4', '7.0'];
            // $tmp5 = ['CSC13112', 'Thiết kế giao diện', '4', '8.0'];
            $table->head = array('STT', 'Mục tiêu', 'Mô tả', 'Chuẩn đầu ra');
            // $table->data[] = $tmp1;
            // $table->data[] = $tmp2;
            // $table->data[] = $tmp3;
            // $table->data[] = $tmp4;
            // $table->data[] = $tmp5;
            // Print table
            echo html_writer::table($table);
            
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>