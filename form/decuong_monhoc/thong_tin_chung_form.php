<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../../../style.css');

    class thong_tin_chung_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            $mform->addElement('text', 'ten_monhoc1_thongtin_chung', get_string('ten_monhoc1_thongtin_chung', 'block_educationpgrs'), ['class'=>'myclass']);
            $mform->addElement('text', 'ten_monhoc2_thongtin_chung', get_string('ten_monhoc2_thongtin_chung', 'block_educationpgrs') );
            $mform->addElement('text', 'maso_monhoc_thongtin_chung', get_string('maso_monhoc_thongtin_chung', 'block_educationpgrs') );
            $mform->addElement('text', 'thuoc_khoi_kienthuc_thongtin_chung', get_string('thuoc_khoi_kienthuc_thongtin_chung', 'block_educationpgrs') );
            $mform->addElement('text', 'so_tinchi_thongtin_chung', get_string('so_tinchi_thongtin_chung', 'block_educationpgrs') );
            $mform->addElement('text', 'tiet_lythuyet_thongtin_chung', get_string('tiet_lythuyet_thongtin_chung', 'block_educationpgrs') );
            $mform->addElement('text', 'tiet_thuchanh_thongtin_chung', get_string('tiet_thuchanh_thongtin_chung', 'block_educationpgrs') );
            $mform->addElement('text', 'tiet_tuhoc_thongtin_chung', get_string('tiet_tuhoc_thongtin_chung', 'block_educationpgrs') );
            $mform->addElement('text', 'monhoc_tienquyet_thongtin_chung', get_string('monhoc_tienquyet_thongtin_chung', 'block_educationpgrs') );
            $mform->addElement('button', 'next_thongtinchung', get_string('next', 'block_educationpgrs'));
        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>