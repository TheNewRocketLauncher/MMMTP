<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

    class them_decuong_monhoc_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            
            
            //Group thong tin chung
            $mform1 = $this->_form;
            $mform1->addElement('header','general_thong_tin_chung', get_string('group_thong_tin_chung', 'block_educationpgrs'));
            
            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'ten_monhoc1_thongtin_chung', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('ten_monhoc1_thongtin_chung', 'block_educationpgrs'), array(' '), true);
            
            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'ten_monhoc2_thongtin_chung', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('ten_monhoc2_thongtin_chung', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'maso_monhoc_thongtin_chung', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('maso_monhoc_thongtin_chung', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'thuoc_khoi_kienthuc_thongtin_chung', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('thuoc_khoi_kienthuc_thongtin_chung', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'so_tinchi_thongtin_chung', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('so_tinchi_thongtin_chung', 'block_educationpgrs'), array(' '), true);
            
            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'tiet_lythuyet_thongtin_chung', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('tiet_lythuyet_thongtin_chung', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'tiet_thuchanh_thongtin_chung', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('tiet_thuchanh_thongtin_chung', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform1->createElement('text', 'tiet_tuhoc_thongtin_chung', '', 'size=50');
            $mform1->addGroup($eGroup, 'thong_tin_chung_group', get_string('monhoc_tienquyet_thongtin_chung', 'block_educationpgrs'), array(' '), true);


            //Group muc tieu mon hoc
            $mform2 = $this->_form;
            $mform2->addElement('header','group_muctieu_monhoc', get_string('group_muctieu_monhoc', 'block_educationpgrs'));
            
            $table = new html_table();
            $table->head = array('STT', 'Mục tiêu môn học', 'Mô tả', 'Chuẩn đẩu ra');
            echo html_writer::table($table);


            $eGroup=array();
            $eGroup[] =& $mform2->createElement('select', 'muctieu_muctieu_monhoc', get_string('muctieu_muctieu_monhoc', 'block_educationpgrs'), array('G1','G2'));
            $mform2->addGroup($eGroup, 'thong_tin_chung_group', get_string('muctieu_muctieu_monhoc', 'block_educationpgrs'), array(' '), true);
            
            $eGroup=array();
            $eGroup[] =& $mform2->createElement('text', 'mota_muctieu_muctieu_monhoc', '', 'size=50');
            $mform2->addGroup($eGroup, 'thong_tin_chung_group', get_string('mota_muctieu_muctieu_monhoc', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform2->createElement('select', 'chuan_daura_cdio_muctieu_monhoc', get_string('muctieu_muctieu_monhoc', 'block_educationpgrs'), array('Không có'));
            $mform2->addGroup($eGroup, 'thong_tin_chung_group', get_string('chuan_daura_cdio_muctieu_monhoc', 'block_educationpgrs'), array(' '), true);
            

            //Group chuan daura monhoc
            $mform3 = $this->_form;
            $mform3->addElement('header','group_chuan_daura', get_string('group_chuan_daura', 'block_educationpgrs'));
            
            $eGroup=array();
            $eGroup[] =& $mform3->createElement('select', 'chuan_daura', get_string('chuan_daura', 'block_educationpgrs'), array('G1.1','G2.2'));
            $mform3->addGroup($eGroup, 'thong_tin_chung_group', get_string('chuan_daura', 'block_educationpgrs'), array(' '), true);
            
            $eGroup=array();
            $eGroup[] =& $mform3->createElement('textarea', 'mota_chuan_daura',get_string('mota_chuan_daura', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform3->addGroup($eGroup, 'thong_tin_chung_group', get_string('mota_chuan_daura', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform3->createElement('select', 'Mucdo_ITU_chuan_daura', get_string('Mucdo_ITU_chuan_daura', 'block_educationpgrs'), array('Không có'));
            $mform3->addGroup($eGroup, 'thong_tin_chung_group', get_string('Mucdo_ITU_chuan_daura', 'block_educationpgrs'), array(' '), true);
            

            //Group chuan daura monhoc
            $mform4 = $this->_form;
            $mform4->addElement('header','group_giangday', get_string('group_giangday', 'block_educationpgrs'));
            
            $eGroup=array();
            $eGroup[] =& $mform4->createElement('select', 'tuan_giangday', get_string('tuan_giangday', 'block_educationpgrs'), array('1','2'));
            $mform4->addGroup($eGroup, 'thong_tin_chung_group', get_string('tuan_giangday', 'block_educationpgrs'), array(' '), true);
            
            $eGroup=array();
            $eGroup[] =& $mform4->createElement('text', 'ngay_giangday', '', 'size=50');
            $mform4->addGroup($eGroup, 'thong_tin_chung_group', get_string('ngay_giangday', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform4->createElement('textarea', 'chude_giangday',get_string('chude_giangday', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform4->addGroup($eGroup, 'thong_tin_chung_group', get_string('chude_giangday', 'block_educationpgrs'), array(' '), true);
            
            $eGroup=array();
            $eGroup[] =& $mform4->createElement('text', 'ngay_giangday', '', 'size=50');
            $mform4->addGroup($eGroup, 'thong_tin_chung_group', get_string('ngay_giangday', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform4->createElement('text', 'baitap_giangday', '', 'size=50');
            $mform4->addGroup($eGroup, 'thong_tin_chung_group', get_string('baitap_giangday', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform4->createElement('select', 'Mucdo_ITU_chuan_daura', get_string('Mucdo_ITU_chuan_daura', 'block_educationpgrs'), array('Không có'));
            $mform4->addGroup($eGroup, 'thong_tin_chung_group', get_string('Mucdo_ITU_chuan_daura', 'block_educationpgrs'), array(' '), true);

            //Group chuan daura monhoc
            $mform5 = $this->_form;
            $mform5->addElement('header','group_danhgia', get_string('group_danhgia', 'block_educationpgrs'));
            
            $eGroup=array();
            $eGroup[] =& $mform5->createElement('select', 'ma_danhgia', get_string('ma_danhgia', 'block_educationpgrs'), array('G1.1','G2.2'));
            $mform5->addGroup($eGroup, 'thong_tin_chung_group', get_string('ma_danhgia', 'block_educationpgrs'), array(' '), true);
            
            $eGroup=array();
            $eGroup[] =& $mform5->createElement('text', 'ten_danhgia', '', 'size=50');
            $mform5->addGroup($eGroup, 'thong_tin_chung_group', get_string('ten_danhgia', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform5->createElement('textarea', 'mota_danhgia',get_string('mota_danhgia', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform5->addGroup($eGroup, 'thong_tin_chung_group', get_string('mota_danhgia', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform5->createElement('text', 'cac_chuan_daura_danhgia', '', 'size=50');
            $mform5->addGroup($eGroup, 'thong_tin_chung_group', get_string('cac_chuan_daura_danhgia', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform5->createElement('text', 'tile_danhgia', '', 'size=5');
            $mform5->addGroup($eGroup, 'thong_tin_chung_group', get_string('tile_danhgia', 'block_educationpgrs'), array(' '), true);

            
            //Group tai nguyen mon hoc
            $mform6 = $this->_form;
            $mform6->addElement('header','group_tainguyen', get_string('group_tainguyen', 'block_educationpgrs'));
            
            $eGroup=array();
            $eGroup[] =& $mform6->createElement('select', 'loai_tainguyen', get_string('loai_tainguyen', 'block_educationpgrs'), array('G1.1','G2.2'));
            $mform6->addGroup($eGroup, 'thong_tin_chung_group', get_string('loai_tainguyen', 'block_educationpgrs'), array(' '), true);
            
            $eGroup=array();
            $eGroup[] =& $mform6->createElement('textarea', 'mota_tainguyen',get_string('mota_tainguyen', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform6->addGroup($eGroup, 'thong_tin_chung_group', get_string('mota_tainguyen', 'block_educationpgrs'), array(' '), true);

            $eGroup=array();
            $eGroup[] =& $mform6->createElement('text', 'link_tainguyen', '', 'size=50');
            $mform6->addGroup($eGroup, 'thong_tin_chung_group', get_string('link_tainguyen', 'block_educationpgrs'), array(' '), true);

            //Group quy dinh chung
            $mform7 = $this->_form;
            $mform7->addElement('header','group_mota_quydinh_chung', get_string('group_mota_quydinh_chung', 'block_educationpgrs'));
        
            $eGroup=array();
            $eGroup[] =& $mform6->createElement('textarea', 'mota_quydinh_chung',get_string('mota_quydinh_chung', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            $mform7->addGroup($eGroup, 'thong_tin_chung_group', get_string('mota_quydinh_chung', 'block_educationpgrs'), array(' '), true);
        
            //group button export
            $mform = $this->_form;
            $eGroup=array();
            $eGroup[] =& $mform->createElement('button', 'review',get_string('review', 'block_educationpgrs'));
            $eGroup[] =& $mform->createElement('button', 'export',get_string('export', 'block_educationpgrs'));
            $mform7->addGroup($eGroup, 'thong_tin_chung_group','', array(' '), true);
            
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>