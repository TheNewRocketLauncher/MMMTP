<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/decuong_model.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$link = optional_param('linkto', '', PARAM_NOTAGS);
if(!$link){
    $link=null;
}

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/decuong/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_quanly_decuong', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/decuong/index.php'));

// Title.
$PAGE->set_title(get_string('label_quanly_decuong', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import đề cương');
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


class form1 extends moodleform{
    public function definition(){
        global $CFG;
        $mform = $this->_form;
        
        $mform->addElement('filepicker', 'userfile', 'CSV chuẩn đầu ra chương trình đào tạo', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.csv'));
        $mform->addRule('userfile', 'Khong phai file csv', 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'GET');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
class form2 extends moodleform{
    public function definition(){
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('hidden', 'link');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'insert to DB');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }
    function validation($data, $files)
    {
        return array();
    }
    public function get_submit_value($elementname)
    {
        $mform = &$this->_form;
        return $mform->getSubmitValue($elementname);
    }
}


$form = new form1();$mform2 = new form2();$array_toDB = array(); // new table


//////////////////////////////////FORM 1 //////////////////////////////////

if ($form->is_cancelled()) {
    
} else if ($form->no_submit_button_pressed()) {
    
} else if ($fromform = $form->get_data()) {

    $name = $form->get_new_filename('userfile');


    $rex = $form->save_temp_file('userfile');

    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/decuong/import_decuong.php?linkto='.$rex);

    // echo 'rex '. $rex;echo "<br>";
    echo "<br>";echo "<br>";echo "<br>";

    
    
} else if ($form->is_submitted()) {
    
    // $form->display();
    echo "<h2>Dữ liệu trống</h2>";
    
} else {
    
    $toform;
    
    $form->display();
    
}

//////////////////////////////////FORM 1 //////////////////////////////////

if ($mform2->is_cancelled()) {
    
} else if ($mform2->no_submit_button_pressed()) {
    
} else if ($fromform = $mform2->get_data()) {
        
    if (($handle = fopen( $fromform->link, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            

            $arr = array();
            
            
            if($data[0] != 'mamonhoc' &&  $data[1] != 'tenmonhoc_vi' && $data[2] != 'tenmonhoc_vi' && $data[3] != 'lopmo' &&
            $data[4] != 'loaihocphan' &&  $data[5] != 'sotinchi' && $data[6] != 'sotietlythuyet' && $data[7] != 'sotietthuchanh' &&
            $data[8] != 'sotiet_baitap' && $data[9] != 'ghichu' && $data[10] != 'mota'){

                $arr[] = ['mamonhoc'=> $data[0], 'tenmonhoc_vi'=>$data[1], 'tenmonhoc_en'=>$data[2], 'lopmo'=>$data[3],
                'loaihocphan'=> $data[4], 'sotinchi'=>$data[5], 'sotietlythuyet'=>$data[6], 'sotietthuchanh'=>$data[7],
                'sotiet_baitap'=> $data[8], 'ghichu'=>$data[9], 'mota'=>$data[10]
                ];

                

                foreach($arr as $iarr){
                    
                    $param = new stdClass();

                    $param->mamonhoc = $iarr['mamonhoc'];
                    $param->tenmonhoc_vi = $iarr['tenmonhoc_vi'];
                    $param->tenmonhoc_en = $iarr['tenmonhoc_en'];
                    
                    $param->loaihocphan = $iarr['loaihocphan'];
                    $param->sotinchi = $iarr['sotinchi'];
                    $param->sotietlythuyet = $iarr['sotietlythuyet'];
                    $param->sotietthuchanh = $iarr['sotietthuchanh'];
                    $param->sotiet_baitap = $iarr['sotiet_baitap'];
                    $param->ghichu = $iarr['ghichu'];
                    $param->mota = $iarr['mota'];
                    
                    $arr_2 = get();

                    $check = is_check($param->mamonhoc, $arr_2);
                    
                    if($check==false){
                        
                        insert_cdr($param);
                        
                        
                    }

                    
                }
            }
        }
        fclose($handle);
    }
    
    
} else if ($mform2->is_submitted()) {
} else {

    $arr_head_thongtin = array(); $arr_thongtin = array(); $arr_muctieu_monhoc = array(); $arr_chuandaura_monhoc = array();
    $arr_kh_giangday_lt = array(); $arr_danhgiamonhoc = array(); $arr_tainguyenmonhoc = array();
    $arr_quydinhchung = array();


    $toform;
    $toform->link = $link; 
    $mform2->set_data($toform);

    $ma_decuong = null;

    if($link != null){

        

        if (($handle = fopen( $link, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                
                if($data[0] == '1' || $data[0] == 1){ // thong tin de cuong
                    $arr_thongtin[] = ['ma_decuong'=>$data[1], 'ma_ctdt'=>$data[2], 'mamonhoc'=>$data[3], 'mota'=>$data[5]];
                }else 
                if($data[0] == '2' || $data[0] == 2){ // muc tieu mon hoc
                    $arr_muctieu_monhoc[] = ['ma_decuong'=>$data[1], 'muctieu'=>$data[2], 'mamonhoc'=>$data[3], 'danhsach_cdr'=>$data[4], 'mota'=> $data[5]];
                }else 
                if($data[0] == '3' || $data[0] == 3){ // chuan dau ra mon hoc
                    $arr_chuandaura_monhoc[] = ['ma_decuong'=>$data[1], 'mucdo'=>$data[2], 'mamonhoc'=>$data[3], 'ma_cdr'=>$data[4], 'mota'=> $data[5]];
                }else 
                if($data[0] == '4' || $data[0] == 4){ //ke hoach giang day ly thuyet
                    $arr_kh_giangday_lt[] = ['ma_decuong'=>$data[1], 'ten_chude'=>$data[2], 'mamonhoc'=>$data[3], 'danhsach_cdr'=>$data[4], 'hoatdong_gopy'=> $data[5], 'hoatdong_danhgia'=> $data[6]];
                }else
                if($data[0] == '6' || $data[0] == 6){ //danh gia mon hoc
                    $arr_danhgiamonhoc[] = ['ma_decuong'=>$data[1], 'ma_danhgia'=>$data[2], 'mamonhoc'=>$data[3], 'chuandaura_danhgia'=>$data[4], 'mota_danhgia'=> $data[5], 'tendanhgia'=> $data[6], 'tile_danhgia'=>$data[7]];
                }else
                if($data[0] == '7' || $data[0] == 7){ // tai nguyen mon hoc
                    $arr_tainguyenmonhoc[] = ['ma_decuong'=>$data[1], 'loaitainguyen'=>$data[2], 'mamonhoc'=>$data[3], 'link_Tainguyen'=>$data[4], 'mota_tainguyen'=> $data[5], 'tentainguyen'=> $data[6]];
                }else
                if($data[0] == '8' || $data[0] == 8){ // quy dinh chung mon hoc
                    $arr_quydinhchung[] = ['ma_decuong'=>$data[1], 'ma_quydinhchung'=>$data[2], 'mamonhoc'=>$data[3],  'mota_quydinhchung'=> $data[5]];
                }
                
            }


            fclose($handle);
        }

        /////////////////////////////////TABLE MUCTIEU/////////////////////////////////
        $table_muctieu = new html_table();
        $table_muctieu->head = ['Mã đề cương', 'Mã môn học', 'Tên mục tiêu', 'Danh sách chuẩn đầu ra CTDT', 'Mô tả'];
        foreach($arr_muctieu_monhoc as $iarr_muctieu_monhoc){
            
            if(requiredRules($arr_muctieu_monhoc, 'block_edu_muctieumonhoc', $iarr_muctieu_monhoc['ma_decuong'], 'muctieu', $iarr_muctieu_monhoc['muctieu']) == false){
                
                $table_muctieu->data[] = [$iarr_muctieu_monhoc['ma_decuong'], $iarr_muctieu_monhoc['mamonhoc'], $iarr_muctieu_monhoc['muctieu'], $iarr_muctieu_monhoc['danhsach_cdr'], $iarr_muctieu_monhoc['mota']];
            }else{
                
            }

            
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Mục tiêu môn học</h2>";echo "<br>";
        echo html_writer::table($table_muctieu);echo "<br>";

        /////////////////////////////////TABLE CHUAN DAU RA/////////////////////////////////
        $table_chuandaura = new html_table();
        $table_chuandaura->head = ['Mã đề cương', 'Mã môn học', 'Chuẩn đầu ra', 'Mô tả (mức chi tiết-hành động)', 'Mức độ'];
        foreach($arr_chuandaura_monhoc as $iarr_chuandaura_monhoc){
            
            if(requiredRules($arr_chuandaura_monhoc, 'block_edu_chuandaura', $iarr_chuandaura_monhoc['ma_decuong'], 'ma_cdr', $iarr_chuandaura_monhoc['ma_cdr']) == false){
                
                $table_chuandaura->data[] = [$iarr_chuandaura_monhoc['ma_decuong'], $iarr_chuandaura_monhoc['mamonhoc'], $iarr_chuandaura_monhoc['ma_cdr'], $iarr_chuandaura_monhoc['mota'], $iarr_chuandaura_monhoc['mucdo']];
            }else{
                
            }

            
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Chuẩn đầu ra môn học</h2>";echo "<br>";
        echo html_writer::table($table_chuandaura);

        /////////////////////////////////TABLE KE HOACH GIANG DAY/////////////////////////////////
        $table_kh_giangday_lt = new html_table();
        $table_kh_giangday_lt->head = ['Mã đề cương', 'Mã môn học', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá'];
        foreach($arr_kh_giangday_lt as $iarr_kh_giangday_lt){
            
            if(requiredRules($arr_kh_giangday_lt, 'block_edu_kh_giangday_lt', $iarr_kh_giangday_lt['ma_decuong'], '', '') == false){
                
                $table_kh_giangday_lt->data[] = [$iarr_kh_giangday_lt['ma_decuong'], $iarr_kh_giangday_lt['mamonhoc'], $iarr_kh_giangday_lt['ten_chude'], $iarr_kh_giangday_lt['danhsach_cdr'], $iarr_kh_giangday_lt['hoatdong_gopy'], $iarr_kh_giangday_lt['hoatdong_danhgia']];
            }else{
                
            }

            
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Kế hoạch giảng dạy lý thuyết</h2>";echo "<br>";
        echo html_writer::table($table_kh_giangday_lt);



        /////////////////////////////////TABLE DANH GIA/////////////////////////////////

        $table_danhgia = new html_table();
        $table_danhgia->head = ['Mã đề cương', 'Mã môn học', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá'];
        foreach($arr_danhgiamonhoc as $iarr_danhgiamonhoc){
            
            if(requiredRules($arr_danhgiamonhoc, 'block_edu_kh_giangday_lt', $iarr_danhgiamonhoc['ma_decuong'], '', '') == false){
                
                $table_danhgia->data[] = [$iarr_danhgiamonhoc['ma_decuong'], $iarr_danhgiamonhoc['mamonhoc'], $iarr_danhgiamonhoc['ten_chude'], $iarr_danhgiamonhoc['danhsach_cdr'], $iarr_danhgiamonhoc['hoatdong_gopy'], $iarr_danhgiamonhoc['hoatdong_danhgia']];
            }else{
                
            }

            
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Đánh giá môn học</h2>";echo "<br>";
        echo html_writer::table($table_danhgia);



        /////////////////////////////////TABLE TAI NGUYEN/////////////////////////////////





        /////////////////////////////////TABLE QUY DINH CHUNG/////////////////////////////////


        
    }

}


function requiredRules($arr, $db_name, $ma_decuong, $sen, $des){
    global $DB, $USER, $CFG, $COURSE;
    $list = $DB->get_records($db_name, ['ma_decuong'=>$ma_decuong]);
    
    foreach($list as $item){
    

        if($item->$sen == $des){
            return true;
        }
    }

    return false;

}


function insert_cdr($param){
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_monhoc', $param);
}

function get(){
    global $DB, $USER, $CFG, $COURSE;
    $arr = array();
    $arr = $DB->get_records('block_edu_monhoc', []);
    return $arr;
}
function is_check($mamonhoc, $arr){
    
    $arr_1 = array();
    foreach($arr as $iarr){
        if($iarr->mamonhoc == $mamonhoc){
            return true;
        }
    }
    return false;
}


// Footer
echo $OUTPUT->footer();