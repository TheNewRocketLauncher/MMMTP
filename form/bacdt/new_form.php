<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once("../../../style.css")

    class new_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
            // Header
            $btn = html_writer::start_tag('form', array('method' => "post"))
            .html_writer::tag('input', ' ', array('type' => "submit", 'name' => "MyBTN", 'id' => "MyBTN", 'value' => "Mục lớn 1"))
            .html_writer::end_tag('form');
            // $mform->addElement('header', 'general', $btn);


            // // BẬC c
            // $a1_b1_c1 = array();
            // $a1_b1_c2 = array();
            // $a1_b2_c1 = array();
            // $a1_b2_c2 = array();
            // $a1_b3_c1 = array();
            // $a1_b3_c2 = array();
            // $a1_b3_c3 = array();
            // $a1_b1_c1[] =& $mform->createElement('header', 'general111', '111');
            // $a1_b1_c2[] =& $mform->createElement('header', 'general112', '112');
            // $a1_b2_c1[] =& $mform->createElement('header', 'general121', '121');
            // $a1_b2_c2[] =& $mform->createElement('header', 'general122', '122'); 
            // $a1_b3_c1[] =& $mform->createElement('header', 'general131', '131');
            // $a1_b3_c2[] =& $mform->createElement('header', 'general132', '132');
            // $a1_b3_c3[] =& $mform->createElement('header', 'general133', '133');
            // // BẬC b
            // $a1_b1 = array();
            // $a1_b2 = array();
            // $a1_b3 = array();
            // $a1_b1[] =& $a1_b1_c1;
            // $a1_b1[] =& $a1_b1_c2;
            // $a1_b2[] =& $a1_b2_c1;
            // $a1_b2[] =& $a1_b2_c2;
            // $a1_b3[] =& $a1_b3_c1;
            // $a1_b3[] =& $a1_b3_c2;
            // $a1_b3[] =& $a1_b3_c3;
            // // BẬC a
            // $a1 == array();
            // $a1[] =& $a1_b1;
            // $a1[] =& $a1_b2;
            // $a1[] =& $a1_b3;
            // $mform->addGroup($a1, 'baca', 'Tên bậc đào tạo', array(' '), false);
            $mform->addElement('choosecoursefile', 'mediafile', 'My Media File', array('courseid' =>null,  //if it is null (default then use global $COURSE
            'height'   =>500,   // height of the popup window
            'width'    =>750,   // width of the popup window
            'options'  =>'none'));
            $mform->addElement('header', 'generaln', 'First');
            $myBtn = $mform->createElement('submit', 'submitbutton1', 'Node');
            $a1_b1 = $myBtn;
            $a1_b2 = $myBtn;
            $a1_b3 = $myBtn;

            $a1 = array();
            $a1[] = $a1_b1;
            // $a1[] = '<br>';
            $a1[] = $a1_b2;
            // $a1[] =& $a1_b3;
            $mform->addGroup($a1, 'baca', $btn, array(' '), true);



            $mform->addElement('header', 'general', 'Đai học');
            $tenbac=array();
            $tenbac[] =& $mform->createElement('text', 'tenbac', 'ÁDASD', 'size="70"');
            
            $mform->addGroup($tenbac, 'tenbac', 'Tên bậc đào tạo', array(' '), false);


            $mform->addElement('header', 'ge', 'Quản lý thông tin');

            // Mô tả
            $mota = array();
            $mota[] =& $mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
            $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), true);
            
            
            
            
            // $mform->addElement('html', '<p class="nganhdt">' . get_string('themctdt_nganhdt', 'block_educationpgrs') . '</p>');
            // $mform->addElement('text');
            // $mform->addElement('html', '<p class="manganh">' . get_string('themctdt_manganh', 'block_educationpgrs') . '</p>');
            // $mform->addElement('text');
            // $mform->addElement('html', '<p class="hedt">' . get_string('themctdt_hedt', 'block_educationpgrs') . '</p>');
            // $mform->addElement('text');
            // $mform->addElement('html', '<p class="khoatuyen">' . get_string('themctdt_khoatuyen', 'block_educationpgrs') . '</p>');
            // $mform->addElement('text');
            // $mform->addHelpButton('shuffleanswers', 'shuffleanswers', 'qtype_multichoice');
            //Button
            $buttonarray=array();
            $buttonarray[] = $mform->createElement('submit', 'submitbutton', '1 Cập nhật');
            $buttonarray[] = $mform->createElement('cancel', null , 'Hủy');
            $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
        }

        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>

