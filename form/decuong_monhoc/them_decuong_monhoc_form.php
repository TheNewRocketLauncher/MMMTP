<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
    
    class them_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->closeHeaderBefore('them_decuong_monhoc_submit');
            $eGroup = $mform->addElement('submit', 'them_decuong_monhoc_submit', 'Xem trước');
            // $eGroup = $mform->addElement('submit', 'them_decuong_monhoc_review', 'Xem trước');
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    // class them_decuong_monhoc_form extends moodleform{
        
    //     public function definition()
    //     {
    //         global $CFG;
    //     }
    //     function validation($data, $files)
    //     {
    //         return array();
    //     }
    // }
    class thong_tin_chung_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
            //Group thong tin chung
            $mform = $this->_form;
            $mform->addElement('header','general_thong_tin_chung', get_string('group_thong_tin_chung', 'block_educationpgrs'));
            
            $eGroup1=array();
            $eGroup1[] =& $mform->createElement('text', 'ten_monhoc1_thongtin_chung', '', 'size=50');
            $mform->addGroup($eGroup1, 'ten_monhoc1_thongtin_chung', get_string('ten_monhoc1_thongtin_chung', 'block_educationpgrs'), array(' '), false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'ten_monhoc2_thongtin_chung', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group1', get_string('ten_monhoc2_thongtin_chung', 'block_educationpgrs'), array(' '), false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'maso_monhoc_thongtin_chung', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group2', get_string('maso_monhoc_thongtin_chung', 'block_educationpgrs'), array(' '),  false);


            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'thuoc_khoi_kienthuc_thongtin_chung', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group3', get_string('thuoc_khoi_kienthuc_thongtin_chung', 'block_educationpgrs'), array(' '),  false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'so_tinchi_thongtin_chung', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group4', get_string('so_tinchi_thongtin_chung', 'block_educationpgrs'), array(' '),  false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'tiet_lythuyet_thongtin_chung', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group5', get_string('tiet_lythuyet_thongtin_chung', 'block_educationpgrs'), array(' '),  false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'tiet_thuchanh_thongtin_chung', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group6', get_string('tiet_thuchanh_thongtin_chung', 'block_educationpgrs'), array(' '),  false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'monhoc_tienquyet_thongtin_chung', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group7', get_string('monhoc_tienquyet_thongtin_chung', 'block_educationpgrs'), array(' '),  false);

        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class muctieu_monhoc_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
            $a = array('G1', 'G2');
            //Group muc tieu mon hoc
            $mform = $this->_form;
            $mform->addElement('header','group_muctieu_monhoc8', get_string('group_muctieu_monhoc', 'block_educationpgrs'));
            $mform->setExpanded('group_muctieu_monhoc8', false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'muctieu_muctieu_monhoc', get_string('muctieu_muctieu_monhoc', 'block_educationpgrs'), $a);
            $mform->addGroup($eGroup, 'thong_tin_chung_group9', get_string('muctieu_muctieu_monhoc', 'block_educationpgrs'), array(' '),  false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'mota_muctieu_muctieu_monhoc', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group11', get_string('mota_muctieu_muctieu_monhoc', 'block_educationpgrs'), array(' '),  false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'chuan_daura_cdio_muctieu_monhoc', get_string('muctieu_muctieu_monhoc', 'block_educationpgrs'), array('Không có'));
            $mform->addGroup($eGroup, 'thong_tin_chung_group12', get_string('chuan_daura_cdio_muctieu_monhoc', 'block_educationpgrs'), array(' '),  false);

            // $eGroup = $mform->addElement('submit', 'them_muctiru_monhoc_submit', 'Thêm mục tiêu môn học');
            
            $eGroup=array();
            // $mform->registerNoSubmitButton('btn_submit_muctieu_monhoc');
            $eGroup[] =& $mform->createElement('submit', 'btn_submit_muctieu_monhoc', 'Thêm mục tiêu môn học mới');
            $mform->addGroup($eGroup, 'thong_tin_chung_group13', '', array(' '),  false);
        }
        function validation($data, $files)
        {
            return array();
        }
        public function get_submit_value($elementname){
            $mform = & $this->_form;
            return $mform->getSubmitValue($elementname);
        }
        
    }
    class chuan_daura_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
             //Group chuan daura monhoc
             $mform = $this->_form;
             $mform->addElement('header','group_chuan_daura', get_string('group_chuan_daura', 'block_educationpgrs'));
             $mform->setExpanded('group_chuan_daura', false);

             $eGroup=array();
             $eGroup[] =& $mform->createElement('select', 'chuan_daura', get_string('chuan_daura', 'block_educationpgrs'), array('G1.1','G2.2'));
             $mform->addGroup($eGroup, 'thong_tin_chung_group13', get_string('chuan_daura', 'block_educationpgrs'), array(' '),  false);
             
             $eGroup=array();
             $eGroup[] =& $mform->createElement('textarea', 'mota_chuan_daura',get_string('mota_chuan_daura', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
             $mform->addGroup($eGroup, 'thong_tin_chung_group14', get_string('mota_chuan_daura', 'block_educationpgrs'), array(' '),  false);
 
             $eGroup=array();
             $eGroup[] =& $mform->createElement('text', 'Mucdo_ITU_chuan_daura', get_string('Mucdo_ITU_chuan_daura', 'block_educationpgrs'), array('Không có'));
             $mform->addGroup($eGroup, 'thong_tin_chung_group15', get_string('Mucdo_ITU_chuan_daura', 'block_educationpgrs'), array(' '),  false);
            
             $eGroup = $mform->addElement('submit', 'them_chuan_daura_monhoc_submit', 'Thêm chuẩn đầu ra môn học');
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class giangday_TH_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
            //Group ke hoach giang day
            $mform = $this->_form;
            $mform->addElement('header','group_giangday_TH', get_string('group_giangday_TH', 'block_educationpgrs'));
            $mform->setExpanded('group_giangday_TH', false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'tuan_giangday', get_string('tuan_giangday', 'block_educationpgrs'), array('1','2'));
            $mform->addGroup($eGroup, 'thong_tin_chung_group16', get_string('tuan_giangday', 'block_educationpgrs'), array(' '),  false);            

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'chude_giangday',get_string('chude_giangday', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform->addGroup($eGroup, 'thong_tin_chung_group18', get_string('chude_giangday', 'block_educationpgrs'), array(' '),  false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'danhsach_cdr',get_string('danhsach_cdr', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform->addGroup($eGroup, 'thong_tin_chung_group18', get_string('danhsach_cdr', 'block_educationpgrs'), array(' '),  false);


            $eGroup=array();
            $eGroup[] =& $mform->createElement('textarea', 'hoatdong_giangday', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group21', get_string('hoatdong_giangday', 'block_educationpgrs'), array(' '),  false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'hoatdong_danhgia', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group21', get_string('hoatdong_danhgia', 'block_educationpgrs'), array(' '),  false);

            $eGroup = $mform->addElement('submit', 'them_kehoach_giangday_TH_submit', 'Thêm kế hoạch giảng dạy');
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class giangday_LT_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
            //Group ke hoach giang day
            $mform = $this->_form;
            $mform->addElement('header','group_giangday_LT', get_string('group_giangday_LT', 'block_educationpgrs'));
            $mform->setExpanded('group_giangday_LT', false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'chude_giangday',get_string('chude_giangday', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform->addGroup($eGroup, 'thong_tin_chung_group18', get_string('chude_giangday', 'block_educationpgrs'), array(' '),  false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'danhsach_cdr',get_string('danhsach_cdr', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform->addGroup($eGroup, 'thong_tin_chung_group18', get_string('danhsach_cdr', 'block_educationpgrs'), array(' '),  false);
            

            $eGroup=array();
            $eGroup[] =& $mform->createElement('textarea', 'hoatdong_giangday', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group21', get_string('hoatdong_giangday', 'block_educationpgrs'), array(' '),  false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'hoatdong_danhgia', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group21', get_string('hoatdong_danhgia', 'block_educationpgrs'), array(' '),  false);

            $eGroup = $mform->addElement('submit', 'them_kehoach_giangday_LT_submit', 'Thêm kế hoạch giảng dạy');
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class danhgia_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
             //Group danh gia
             $mform = $this->_form;
             $mform->addElement('header','group_danhgia', get_string('group_danhgia', 'block_educationpgrs'));
             $mform->setExpanded('group_danhgia', false);

             $eGroup=array();
             $eGroup[] =& $mform->createElement('text', 'ma_danhgia', get_string('ma_danhgia', 'block_educationpgrs'), array('G1.1','G2.2'));
             $mform->addGroup($eGroup, 'thong_tin_chung_group23', get_string('ma_danhgia', 'block_educationpgrs'), array(' '),  false);
             
             $eGroup=array();
             $eGroup[] =& $mform->createElement('text', 'ten_danhgia', '', 'size=50');
             $mform->addGroup($eGroup, 'thong_tin_chung_group24', get_string('ten_danhgia', 'block_educationpgrs'), array(' '),  false);
 
             $eGroup=array();
             $eGroup[] =& $mform->createElement('textarea', 'mota_danhgia',get_string('mota_danhgia', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
             $mform->addGroup($eGroup, 'thong_tin_chung_group25', get_string('mota_danhgia', 'block_educationpgrs'), array(' '),  false);
 
             $eGroup=array();
             $eGroup[] =& $mform->createElement('text', 'cac_chuan_daura_danhgia', '', 'size=50');
             $mform->addGroup($eGroup, 'thong_tin_chung_group26', get_string('cac_chuan_daura_danhgia', 'block_educationpgrs'), array(' '),  false);
 
             $eGroup=array();
             $eGroup[] =& $mform->createElement('text', 'tile_danhgia', '', 'size=5');
             $mform->addGroup($eGroup, 'thong_tin_chung_group27', get_string('tile_danhgia', 'block_educationpgrs'), array(' '),  false);

             $eGroup=array();
             $eGroup[] =& $mform->createElement('submit', 'them_danhgia_monhoc_submit', 'Thêm đánh giá môn học');
             $mform->addGroup($eGroup, 'thong_tin_chung_group28', '', array(' '),  false);
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class tainguyen_monhoc_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
            //Group tai nguyen mon hoc
            $mform = $this->_form;
            $mform->addElement('header','group_tainguyen', get_string('group_tainguyen', 'block_educationpgrs'));
            $mform->setExpanded('group_tainguyen', false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('select', 'loai_tainguyen', get_string('loai_tainguyen', 'block_educationpgrs'), array('Sách','Internet', 'Khác'));
            $mform->addGroup($eGroup, 'thong_tin_chung_group28', get_string('loai_tainguyen', 'block_educationpgrs'), array(' '),  false);
            
            $eGroup=array();
            $eGroup[] =& $mform->createElement('textarea', 'mota_tainguyen',get_string('mota_tainguyen', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform->addGroup($eGroup, 'thong_tin_chung_group29', get_string('mota_tainguyen', 'block_educationpgrs'), array(' '),  false);

            $eGroup=array();
            $eGroup[] =& $mform->createElement('text', 'link_tainguyen', '', 'size=50');
            $mform->addGroup($eGroup, 'thong_tin_chung_group31', get_string('link_tainguyen', 'block_educationpgrs'), array(' '),  false);

            $eGroup = $mform->addElement('submit', 'them_tainguyen_monhoc_submit', 'Thêm tài nguyên môn học');
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class quydinh_chung_decuong_monhoc_form extends moodleform{
        
        public function definition()
        {
            global $CFG;
             // mo ta quy dinh chung
             $mform = $this->_form;
             $mform->addElement('header','group_mota_quydinh_chung', get_string('group_mota_quydinh_chung', 'block_educationpgrs'));
             $mform->setExpanded('group_mota_quydinh_chung', false);

             $eGroup=array();
             $eGroup[] =& $mform->createElement('textarea', 'mota_quydinh_chung',get_string('mota_quydinh_chung', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
             $mform->addGroup($eGroup, 'thong_tin_chung_group32', get_string('mota_quydinh_chung', 'block_educationpgrs'), array(' '),  false);
             
             $eGroup = $mform->addElement('submit', 'them_quydinh_chung_submit', 'Thêm quy định chung');
        }
        function validation($data, $files)
        {
            return array();
        }
    }



    class muctieu_monhoc_table extends moodleform{
        
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
        function validation($data, $files)
        {
            return array();
        }
    }
    class chuan_daura_decuong_monhoc_table extends moodleform{
        
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
                $table->head = array('STT', 'Chuẩn đầu ra', 'Mô tả', 'Mức độ');
                // $table->data[] = $tmp1;
                // $table->data[] = $tmp2;
                // $table->data[] = $tmp3;
                // $table->data[] = $tmp4;
                // $table->data[] = $tmp5;
                // Print table
                echo html_writer::table($table);
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class giangday_decuong_monhoc_table extends moodleform{
        
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
                $table->head = array('STT', 'Tuần', 'Ngày', 'Chủ đề', 'Tài liệu tham khảo', 'Bài tập');
                // $table->data[] = $tmp1;
                // $table->data[] = $tmp2;
                // $table->data[] = $tmp3;
                // $table->data[] = $tmp4;
                // $table->data[] = $tmp5;
                // Print table
                echo html_writer::table($table);
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class danhgia_decuong_monhoc_table extends moodleform{
        
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
                $table->head = array('STT', 'Mã', 'Tên', 'Mô tả', 'Các chuẩn đầu ra', 'Tỉ lệ (%)');
                // $table->data[] = $tmp1;
                // $table->data[] = $tmp2;
                // $table->data[] = $tmp3;
                // $table->data[] = $tmp4;
                // $table->data[] = $tmp5;
                // Print table
                echo html_writer::table($table);
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class tainguyen_monhoc_decuong_monhoc_table extends moodleform{
        
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
                $table->head = array('STT', 'Loại tài nguyên', 'Mô tả', 'Link đính kèm');
                // $table->data[] = $tmp1;
                // $table->data[] = $tmp2;
                // $table->data[] = $tmp3;
                // $table->data[] = $tmp4;
                // $table->data[] = $tmp5;
                // Print table
                echo html_writer::table($table);
        }
        function validation($data, $files)
        {
            return array();
        }
    }
    class quydinh_chung_decuong_monhoc_table extends moodleform{
        
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
                $table->head = array('STT', 'Mô tả');
                // $table->data[] = $tmp1;
                // $table->data[] = $tmp2;
                // $table->data[] = $tmp3;
                // $table->data[] = $tmp4;
                // $table->data[] = $tmp5;
                // Print table
                echo html_writer::table($table);
        }
        function validation($data, $files)
        {
            return array();
        }
    }
?>