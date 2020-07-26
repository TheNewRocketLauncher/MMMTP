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

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("import", "");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/decuong/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Import đề cương môn học', new moodle_url('/blocks/educationpgrs/pages/import/import_decuong.php'));

// Title.
$PAGE->set_title(get_string('label_quanly_decuong', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import đề cương');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


class form1 extends moodleform{
    public function definition(){
        global $CFG;
        $mform = $this->_form;
        
        $mform->addElement('filepicker', 'userfile', 'File .CSV nhập vào đề cương môn học', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.csv'));
        $mform->addRule('userfile', 'Khong phai file csv', 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'HIỂN THỊ DỮ LIỆU');
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

    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/import/import_decuong.php?linkto='.$rex);

    // echo 'rex '. $rex;echo "<br>";
    echo "<br>";echo "<br>";echo "<br>";

    
    
} else if ($form->is_submitted()) {
    
    $form->display();
    echo "<h2 >Dữ liệu trống</h2>";
    
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
                
            if($data[0] == '1' || $data[0] == 1){ // thong tin de cuong
                $arr_thongtin[] = ['ma_decuong'=>$data[1], 'ma_ctdt'=>$data[2], 'mamonhoc'=>$data[3], 'mota'=>$data[5]];
            }else 
            if($data[0] == '2' || $data[0] == 2){ // muc tieu mon hoc
                $arr_muctieu_monhoc[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'muctieu'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'danhsach_cdr'=>$data[4], 'mota'=> $data[5]];
            }else 
            if($data[0] == '3' || $data[0] == 3){ // chuan dau ra mon hoc
                $arr_chuandaura_monhoc[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'mucdo'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'ma_cdr'=>$data[4], 'mota'=> $data[5]];
            }else 
            if($data[0] == '4' || $data[0] == 4){ //ke hoach giang day ly thuyet
                $arr_kh_giangday_lt[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'ten_chude'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'danhsach_cdr'=>$data[4], 'hoatdong_gopy'=> $data[5], 'hoatdong_danhgia'=> $data[6]];
            }else
            if($data[0] == '6' || $data[0] == 6){ //danh gia mon hoc
                $arr_danhgiamonhoc[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'ma_danhgia'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'chuandaura_danhgia'=>$data[4], 'mota_danhgia'=> $data[5], 'tendanhgia'=> $data[6], 'tile_danhgia'=>$data[7]];
            }else
            if($data[0] == '7' || $data[0] == 7){ // tai nguyen mon hoc
                $arr_tainguyenmonhoc[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'loaitainguyen'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'link_Tainguyen'=>$data[4], 'mota_tainguyen'=> $data[5], 'tentainguyen'=> $data[6]];
            }else
            if($data[0] == '8' || $data[0] == 8){ // quy dinh chung mon hoc
                $arr_quydinhchung[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'ma_quydinhchung'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'],  'mota_quydinhchung'=> $data[5]];
            }

            



            
        }

        fclose($handle);
    }

    

    $ma_decuong; $mamonhoc; $ma_ctdt;$mota_decuong;$ma_khoi_decuong;
    foreach($arr_thongtin as $iarr_thongtin){
        $ma_decuong = $iarr_thongtin['ma_decuong'];
        $ma_ctdt =  $iarr_thongtin['ma_ctdt'];
        $mamonhoc =  $iarr_thongtin['mamonhoc'];
        $ma_khoi_decuong = $iarr_thongtin['ma_khoi'];
        $mota_decuong =  $iarr_thongtin['mota'];
    }


    $is_check_decuong_hople = check_decuong_hople($ma_decuong, $ma_ctdt, $mamonhoc);

    if($arr_thongtin[0]['ma_ctdt'] && $arr_thongtin[0]['mamonhoc']){
        $arr_a = get_list_monhoc($arr_thongtin[0]['ma_ctdt']);
    }else
    if(!$arr_thongtin[0]['ma_ctdt'] && $arr_thongtin[0]['mamonhoc']){
        $arr_a = get_all_monhoc();
    }

    $is_check_monhoc_hople = null;
    foreach($arr_a as $iarr_a){
        
        if($iarr_a->mamonhoc == $arr_thongtin[0]['mamonhoc']){
            $is_check_monhoc_hople = 1;
        }
    }

    echo "<strong style='text-decoration: underline;'>LOG</strong>"; echo "<br>";
    if(!$is_check_decuong_hople){
        echo 'Mã đề cương <strong>'.$ma_decuong. '</strong> không hợp lệ hoặc đã tồn tại'; 
        
    }echo "<br>";
    if(!$is_check_monhoc_hople){
        echo "Mã môn học <strong style='color: red'>".$arr_thongtin[0]['mamonhoc'].  "</strong> chưa tồn tại hoặc không thuộc chương trình đào tạo <strong style='color: red'>".$arr_thongtin[0]['ma_ctdt']."</strong></strong>";            
    }echo "<br>";
    
    if($is_check_decuong_hople && $is_check_monhoc_hople){
        

        /////////////////////////////////CREATE DE CUONG/////////////////////////////////

        $param_decuong = new stdClass();

        $param_decuong->ma_decuong = $ma_decuong;
        $param_decuong->ma_ctdt = $ma_ctdt;
        $param_decuong->mamonhoc = $mamonhoc;
        $param_decuong->ma_khoi = $ma_khoi_decuong;
        $param_decuong->mota = $mota_decuong;

        insert('eb_decuong', $param_decuong);

        echo "<strong style='color:#1177d1'>Tạo đề cương thành công</strong>";echo "<br>";
        /////////////////////////////////CREATE MUC TIEU MONHOC/////////////////////////////////

        foreach($arr_muctieu_monhoc as $iarr_muctieu_monhoc){
            
            if(!requiredRules($arr_muctieu_monhoc, 'eb_muctieumonhoc', $iarr_muctieu_monhoc['ma_decuong'], 'muctieu', $iarr_muctieu_monhoc['muctieu'])){
                

                $table_muctieu->data[] = [$iarr_muctieu_monhoc['ma_decuong'], $iarr_muctieu_monhoc['mamonhoc'], $iarr_muctieu_monhoc['muctieu'], $iarr_muctieu_monhoc['danhsach_cdr'], $iarr_muctieu_monhoc['mota']];

                $param_muctieu = new stdClass();

                $param_muctieu->ma_decuong = $ma_decuong;
                $param_muctieu->mamonhoc = $mamonhoc;
                $param_muctieu->muctieu = $iarr_muctieu_monhoc['muctieu'];
                if(!$is_check_ctdt_hople){
                    $param_muctieu->danhsach_cdr = $iarr_muctieu_monhoc['danhsach_cdr'];
                }else{
                    $param_muctieu->danhsach_cdr = $iarr_muctieu_monhoc['danhsach_cdr'];
                }

                
                $param_muctieu->mota = $iarr_muctieu_monhoc['mota'];
                
                
                insert('eb_muctieumonhoc', $param_muctieu);

            }else{
                echo "Mục tiêu ". "<strong>" .$iarr_muctieu_monhoc['muctieu'] . '-' .$iarr_muctieu_monhoc['mota'] ."</strong> đã tồn tại trước đó";
                echo "<br>";
            }

            
        }
        echo "<strong style='color:#1177d1'>Tạo mục tiêu thành công</strong>";echo "<br>";

        /////////////////////////////////CREATE CHUAN DAU RA/////////////////////////////////

        foreach($arr_chuandaura_monhoc as $iarr_chuandaura_monhoc){
            
            if(requiredRules($arr_chuandaura_monhoc, 'eb_chuandaura', $iarr_chuandaura_monhoc['ma_decuong'], 'ma_cdr', $iarr_chuandaura_monhoc['ma_cdr']) == false){
                
                $table_chuandaura->data[] = [$iarr_chuandaura_monhoc['ma_decuong'], $iarr_chuandaura_monhoc['mamonhoc'], $iarr_chuandaura_monhoc['ma_cdr'], $iarr_chuandaura_monhoc['mota'], $iarr_chuandaura_monhoc['mucdo']];

                $param_chuandaura = new stdClass();

                $param_chuandaura->ma_decuong = $ma_decuong;
                $param_chuandaura->mamonhoc = $mamonhoc;
                $param_chuandaura->ma_cdr = $iarr_chuandaura_monhoc['ma_cdr'];
                $param_chuandaura->mota = $iarr_chuandaura_monhoc['mota'];
                $param_chuandaura->mucdo_utilize = $iarr_chuandaura_monhoc['mucdo'];


                insert('eb_chuandaura', $param_chuandaura);

            }else{
                echo "Chuẩn đầu ra môn học ". "<strong>" .$iarr_chuandaura_monhoc['ma_cdr'] . '-' .$iarr_chuandaura_monhoc['mota'] ."</strong> đã tồn tại trước đó";
                echo "<br>";
            }

            
        }
        echo "<strong style='color:#1177d1'>Tạo chuẩn đầu ra môn học thành công</strong>";echo "<br>";


        /////////////////////////////////CREATE KE HOACH GIANG DAY LY THUYET/////////////////////////////////

        foreach($arr_kh_giangday_lt as $iarr_kh_giangday_lt){
            
                
                $table_kh_giangday_lt->data[] = [$iarr_kh_giangday_lt['ma_decuong'], $iarr_kh_giangday_lt['mamonhoc'], $iarr_kh_giangday_lt['ten_chude'], $iarr_kh_giangday_lt['danhsach_cdr'], $iarr_kh_giangday_lt['hoatdong_gopy'], $iarr_kh_giangday_lt['hoatdong_danhgia']];


                $param_kh_giangday_lt = new stdClass();

                $param_kh_giangday_lt->ma_decuong = $ma_decuong;
                $param_kh_giangday_lt->mamonhoc = $mamonhoc;
                $param_kh_giangday_lt->ten_chude = $iarr_kh_giangday_lt['ten_chude'];
                $param_kh_giangday_lt->danhsach_cdr = $iarr_kh_giangday_lt['danhsach_cdr'];
                $param_kh_giangday_lt->hoatdong_gopy = $iarr_kh_giangday_lt['hoatdong_gopy'];
                $param_kh_giangday_lt->hoatdong_danhgia = $iarr_kh_giangday_lt['hoatdong_danhgia'];

                $check_result =  check_chuandaura_hople($param_kh_giangday_lt->danhsach_cdr, $arr_chuandaura_monhoc);

                if($check_result){

                    insert('eb_kh_giangday_lt', $param_kh_giangday_lt);
                }else{
                    echo "Kế hoạch giảng dạy lý thuyết ". "<strong>" .$iarr_kh_giangday_lt['ten_chude'] ."</strong> có chuẩn đầu ra môn học không hợp lệ";
                    echo "<br>";
                }

            
        }
        echo "<strong style='color:#1177d1'>Tạo kế hoạch giảng dạy lý thuyết thành công</strong>";echo "<br>";


        /////////////////////////////////CREATE DANH GIA/////////////////////////////////

        foreach($arr_danhgiamonhoc as $iarr_danhgiamonhoc){
            
            
                
                $table_danhgia->data[] = [$iarr_danhgiamonhoc['ma_decuong'], $iarr_danhgiamonhoc['mamonhoc'], $iarr_danhgiamonhoc['tendanhgia'], $iarr_danhgiamonhoc['mota_danhgia'], $iarr_danhgiamonhoc['chuandaura_danhgia'], $iarr_danhgiamonhoc['tile_danhgia']];


                $param_danhgia = new stdClass();

                $param_danhgia->ma_decuong = $ma_decuong;
                $param_danhgia->mamonhoc = $mamonhoc;
                $param_danhgia->tendanhgia = $iarr_danhgiamonhoc['tendanhgia'];
                $param_danhgia->motadanhgia =  $iarr_danhgiamonhoc['mota_danhgia'];
                $param_danhgia->chuandaura_danhgia = $iarr_danhgiamonhoc['chuandaura_danhgia'];
                $param_danhgia->tile_danhgia = $iarr_danhgiamonhoc['tile_danhgia'];
                $param_danhgia->madanhgia = $iarr_danhgiamonhoc['ma_danhgia'];
                


                $check_result =  check_chuandaura_hople($param_danhgia->chuandaura_danhgia, $arr_chuandaura_monhoc);

                if($check_result){
                    insert('eb_danhgiamonhoc', $param_danhgia);
                }else{
                    echo "Đánh giá ". "<strong>" .$iarr_danhgiamonhoc['ma_danhgia'] ."</strong> có chuẩn đầu ra môn học không hợp lệ";
                    echo "<br>";
                }

            
        }
        echo "<strong style='color:#1177d1'>Tạo đánh giá môn học thành công</strong>";echo "<br>";

        /////////////////////////////////CREATE TAI NGUYEN/////////////////////////////////


        foreach($arr_tainguyenmonhoc as $iarr_tainguyenmonhoc){
            
            // if(requiredRules($arr_tainguyenmonhoc, 'eb_tainguyenmonhoc', $iarr_tainguyenmonhoc['ma_decuong'], '', '') == false){
                
                $table_tainguyen->data[] = [$iarr_tainguyenmonhoc['ma_decuong'], $iarr_tainguyenmonhoc['mamonhoc'], $iarr_tainguyenmonhoc['loaitainguyen'], $iarr_tainguyenmonhoc['tentainguyen'], $iarr_tainguyenmonhoc['mota_tainguyen'], $iarr_tainguyenmonhoc['link_Tainguyen']];


                $param_tainguyen = new stdClass();

                $param_tainguyen->ma_decuong = $ma_decuong;
                $param_tainguyen->mamonhoc = $mamonhoc;
                $param_tainguyen->loaitainguyen = $iarr_tainguyenmonhoc['loaitainguyen'];
                $param_tainguyen->ten_tainguyen =  $iarr_tainguyenmonhoc['tentainguyen'];
                $param_tainguyen->mota_tainguyen = $iarr_tainguyenmonhoc['mota_tainguyen'];
                $param_tainguyen->link_tainguyen = $iarr_tainguyenmonhoc['link_Tainguyen'];



                insert('eb_tainguyenmonhoc', $param_tainguyen);
                
            // }else{
                
            // }

            
        }
        echo "<strong style='color:#1177d1'>Tạo tài nguyên môn học thành công</strong>";echo "<br>";


        /////////////////////////////////CREATE QUY DINH CHUNG/////////////////////////////////

        foreach($arr_quydinhchung as $iarr_quydinhchung){
            
                
                $table_quydinhchung->data[] = [$iarr_quydinhchung['ma_decuong'], $iarr_quydinhchung['mamonhoc'], $iarr_quydinhchung['mota_quydinhchung']];

                $param_quydinhchung = new stdClass();

                $param_quydinhchung->ma_decuong = $ma_decuong;
                $param_quydinhchung->mamonhoc = $mamonhoc;
                $param_quydinhchung->mota_quydinhchung = $iarr_quydinhchung['mota_quydinhchung'];
                

                insert('eb_quydinhchung', $param_quydinhchung);
            
        }
        echo "<strong style='color:#1177d1'>Tạo quy định chung thành công</strong>";echo "<br>";

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
                    $arr_thongtin[] = ['ma_decuong'=>$data[1], 'ma_ctdt'=>$data[2], 'mamonhoc'=>$data[3],'ma_khoi'=>$data[4], 'mota'=>$data[5]];
                }else
                if($data[0] == '2' || $data[0] == 2){ // muc tieu mon hoc
                    $arr_muctieu_monhoc[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'muctieu'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'danhsach_cdr'=>$data[4], 'mota'=> $data[5]];
                }else 
                if($data[0] == '3' || $data[0] == 3){ // chuan dau ra mon hoc
                    $arr_chuandaura_monhoc[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'mucdo'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'ma_cdr'=>$data[4], 'mota'=> $data[5]];
                }else 
                if($data[0] == '4' || $data[0] == 4){ //ke hoach giang day ly thuyet
                    $arr_kh_giangday_lt[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'ten_chude'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'danhsach_cdr'=>$data[4], 'hoatdong_gopy'=> $data[5], 'hoatdong_danhgia'=> $data[6]];
                }else
                if($data[0] == '6' || $data[0] == 6){ //danh gia mon hoc
                    $arr_danhgiamonhoc[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'ma_danhgia'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'chuandaura_danhgia'=>$data[4], 'mota_danhgia'=> $data[5], 'tendanhgia'=> $data[6], 'tile_danhgia'=>$data[7]];
                }else
                if($data[0] == '7' || $data[0] == 7){ // tai nguyen mon hoc
                    $arr_tainguyenmonhoc[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'loaitainguyen'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'], 'link_Tainguyen'=>$data[4], 'mota_tainguyen'=> $data[5], 'tentainguyen'=> $data[6]];
                }else
                if($data[0] == '8' || $data[0] == 8){ // quy dinh chung mon hoc
                    $arr_quydinhchung[] = ['ma_decuong'=>$arr_thongtin[0]['ma_decuong'], 'ma_quydinhchung'=>$data[2], 'mamonhoc'=>$arr_thongtin[0]['mamonhoc'],  'mota_quydinhchung'=> $data[5]];
                }
                
            }


            fclose($handle);
        }

        
        $is_check_decuong_hople = check_decuong_hople($arr_thongtin[0]['ma_decuong'], $arr_thongtin[0]['ma_ctdt'], $arr_thongtin[0]['mamonhoc']);

        if($arr_thongtin[0]['ma_ctdt'] && $arr_thongtin[0]['mamonhoc']){
            $arr_a = get_list_monhoc($arr_thongtin[0]['ma_ctdt']);
        }else
        if(!$arr_thongtin[0]['ma_ctdt'] && $arr_thongtin[0]['mamonhoc']){
            $arr_a = get_all_monhoc();
        }

        $is_check_monhoc_hople = null;
        foreach($arr_a as $iarr_a){
            
            if($iarr_a->mamonhoc == $arr_thongtin[0]['mamonhoc']){
                $is_check_monhoc_hople = 1;
            }
        }

        echo "<strong style='text-decoration: underline;'>LOG</strong>"; 
        if(!$is_check_decuong_hople){
            echo "<br>Mã đề cương <strong style='color: red'>".$arr_thongtin[0]['ma_decuong']. "</strong> không hợp lệ hoặc đã tồn tại";
            
            
        }echo "<br>";
        if(!$is_check_monhoc_hople){
            echo "Mã môn học <strong style='color: red'>".$arr_thongtin[0]['mamonhoc'].  "</strong> chưa tồn tại hoặc không thuộc chương trình đào tạo <strong style='color: red'>".$arr_thongtin[0]['ma_ctdt']."</strong></strong>";            
        }echo "<br>";

        $log = array();

        if($is_check_decuong_hople && $is_check_monhoc_hople){
            /////////////////////////////////TABLE MUCTIEU/////////////////////////////////
            $table_muctieu = new html_table();
            $table_muctieu->head = ['Mã đề cương', 'Mã môn học', 'Tên mục tiêu', 'Danh sách chuẩn đầu ra CTDT', 'Mô tả'];
            foreach($arr_muctieu_monhoc as $iarr_muctieu_monhoc){
                
                if(requiredRules($arr_muctieu_monhoc, 'eb_muctieumonhoc', $iarr_muctieu_monhoc['ma_decuong'], 'muctieu', $iarr_muctieu_monhoc['muctieu']) == false){
                    
                    if(!$is_check_ctdt_hople){
                        $table_muctieu->data[] = [$iarr_muctieu_monhoc['ma_decuong'], $iarr_muctieu_monhoc['mamonhoc'], $iarr_muctieu_monhoc['muctieu'],'', $iarr_muctieu_monhoc['mota']];
                    }else{
                        $table_muctieu->data[] = [$iarr_muctieu_monhoc['ma_decuong'], $iarr_muctieu_monhoc['mamonhoc'], $iarr_muctieu_monhoc['muctieu'], $iarr_muctieu_monhoc['danhsach_cdr'], $iarr_muctieu_monhoc['mota']];
                    }
                    
                }else{
                    $log[] = "Mục tiêu ". "<strong>" .$iarr_muctieu_monhoc['muctieu'] . '-' .$iarr_muctieu_monhoc['mota'] ."</strong> đã tồn tại trước đó";
                }

                
            }
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Mục tiêu môn học</h2>";echo "<br>";
            echo html_writer::table($table_muctieu);echo "<br>";

            /////////////////////////////////TABLE CHUAN DAU RA/////////////////////////////////
            $table_chuandaura = new html_table();
            $table_chuandaura->head = ['Mã đề cương', 'Mã môn học', 'Chuẩn đầu ra', 'Mô tả (mức chi tiết-hành động)', 'Mức độ'];
            foreach($arr_chuandaura_monhoc as $iarr_chuandaura_monhoc){
                
                if(requiredRules($arr_chuandaura_monhoc, 'eb_chuandaura', $iarr_chuandaura_monhoc['ma_decuong'], 'ma_cdr', $iarr_chuandaura_monhoc['ma_cdr']) == false){
                    
                    $table_chuandaura->data[] = [$iarr_chuandaura_monhoc['ma_decuong'], $iarr_chuandaura_monhoc['mamonhoc'], $iarr_chuandaura_monhoc['ma_cdr'], $iarr_chuandaura_monhoc['mota'], $iarr_chuandaura_monhoc['mucdo']];
                }else{
                    $log[] = "Chuẩn đầu ra môn học ". "<strong>" .$iarr_chuandaura_monhoc['ma_cdr'] . '-' .$iarr_chuandaura_monhoc['mota'] ."</strong> đã tồn tại trước đó";
                }

                
            }
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Chuẩn đầu ra môn học</h2>";echo "<br>";
            echo html_writer::table($table_chuandaura);

            /////////////////////////////////TABLE KE HOACH GIANG DAY/////////////////////////////////
            $table_kh_giangday_lt = new html_table();
            $table_kh_giangday_lt->head = ['Mã đề cương', 'Mã môn học', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá'];
            
            
            
            foreach($arr_kh_giangday_lt as $iarr_kh_giangday_lt){
                
                // if(requiredRules($arr_kh_giangday_lt, 'eb_kh_giangday_lt', $iarr_kh_giangday_lt['ma_decuong'], '', '') == false){
                $check_result =  check_chuandaura_hople($iarr_kh_giangday_lt['danhsach_cdr'], $arr_chuandaura_monhoc);

                if(!$check_result){

                    $table_kh_giangday_lt->data[] = [$iarr_kh_giangday_lt['ma_decuong'], $iarr_kh_giangday_lt['mamonhoc'], $iarr_kh_giangday_lt['ten_chude'], $iarr_kh_giangday_lt['danhsach_cdr'], $iarr_kh_giangday_lt['hoatdong_gopy'], $iarr_kh_giangday_lt['hoatdong_danhgia']];

                }else{
                    $log[] = "Kế hoạch giảng dạy lý thuyết ". "<strong>" .$iarr_kh_giangday_lt['ten_chude'] ."</strong> có chuẩn đầu ra môn học không hợp lệ";
                }

                
            }
            
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Kế hoạch giảng dạy lý thuyết</h2>";echo "<br>";
            echo html_writer::table($table_kh_giangday_lt);



            /////////////////////////////////TABLE DANH GIA/////////////////////////////////

            $table_danhgia = new html_table();
            $table_danhgia->head = ['Mã đề cương', 'Mã môn học', 'Mã đánh giá', 'Tên',  'Mô tả (gợi ý)', 'Các chuẩn', 'Tỉ lệ'];
            foreach($arr_danhgiamonhoc as $iarr_danhgiamonhoc){
                
                // if(requiredRules($arr_danhgiamonhoc, 'eb_danhgiamonhoc', $iarr_danhgiamonhoc['ma_decuong'], '', '') == false){
                    
                $check_result =  check_chuandaura_hople($iarr_danhgiamonhoc['chuandaura_danhgia'], $arr_chuandaura_monhoc);
                
                if(!$check_result){
                
                    $table_danhgia->data[] = [$iarr_danhgiamonhoc['ma_decuong'], $iarr_danhgiamonhoc['mamonhoc'],$iarr_danhgiamonhoc['ma_danhgia'], $iarr_danhgiamonhoc['tendanhgia'], $iarr_danhgiamonhoc['mota_danhgia'], $iarr_danhgiamonhoc['chuandaura_danhgia'], $iarr_danhgiamonhoc['tile_danhgia']];
                
                }else{
                    $log[] = "Đánh giá ". "<strong>" .$iarr_danhgiamonhoc['ma_danhgia'] ."</strong> có chuẩn đầu ra môn học không hợp lệ";
                }

                
            }
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Đánh giá môn học</h2>";echo "<br>";
            echo html_writer::table($table_danhgia);



            /////////////////////////////////TABLE TAI NGUYEN/////////////////////////////////

            $table_tainguyen = new html_table();
            $table_tainguyen->head = ['Mã đề cương', 'Mã môn học', 'Loại tài nguyên', 'Tên tài nguyên' , 'Mô tả (gợi ý)', 'Link đính kèm'];
            foreach($arr_tainguyenmonhoc as $iarr_tainguyenmonhoc){
                
                if(requiredRules($arr_tainguyenmonhoc, 'eb_tainguyenmonhoc', $iarr_tainguyenmonhoc['ma_decuong'], '', '') == false){
                    
                    $table_tainguyen->data[] = [$iarr_tainguyenmonhoc['ma_decuong'], $iarr_tainguyenmonhoc['mamonhoc'], $iarr_tainguyenmonhoc['loaitainguyen'], $iarr_tainguyenmonhoc['tentainguyen'], $iarr_tainguyenmonhoc['mota_tainguyen'], $iarr_tainguyenmonhoc['link_Tainguyen']];
                }else{
                    
                }

                
            }
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Tài nguyên môn học</h2>";echo "<br>";
            echo html_writer::table($table_tainguyen);
        


            /////////////////////////////////TABLE QUY DINH CHUNG/////////////////////////////////

            $table_quydinhchung = new html_table();
            $table_quydinhchung->head = ['Mã đề cương', 'Mã môn học', 'Nội dung'];
            foreach($arr_quydinhchung as $iarr_quydinhchung){
                
                if(requiredRules($arr_quydinhchung, 'eb_quydinhchung', $iarr_quydinhchung['ma_decuong'], '', '') == false){
                    
                    $table_quydinhchung->data[] = [$iarr_quydinhchung['ma_decuong'], $iarr_quydinhchung['mamonhoc'], $iarr_quydinhchung['mota_quydinhchung']];
                }else{
                    
                }

                
            }
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Quy định chung</h2>";echo "<br>";
            echo html_writer::table($table_quydinhchung);
            
            if(count($table_muctieu->data)>0 && count($table_chuandaura->data)>0 && count($table_kh_giangday_lt->data)>0 &&
            count($table_danhgia->data)>0 && count($table_tainguyen->data)>0 && count($table_quydinhchung->data)>0){
                $mform2->display();
            }else{
                echo "<h2 style='color: #960202;font-weight: 350; text-decoration: underline;'>Dữ liệu trống hoặc không đủ để mở đề cương</h2>";
            }
        }
        
        foreach($log as $ilog){
            echo $ilog; echo '<br>';
        }
        
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


function insert($table_name, $param){
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record($table_name, $param);
}

function get(){
    global $DB, $USER, $CFG, $COURSE;
    $arr = array();
    $arr = $DB->get_records('eb_monhoc', []);
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

function get_list_monhoc($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
    $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);

    // Lưu danh sách mã môn học
    $list_mamonhoc = array();

    // Lấy ra cây khối kiến thức của CTDT 
    $caykkt = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);


    $decuong = $DB->get_record('eb_decuong', ['ma_ctdt' => $ma_ctdt]);

    // Với mỗi khối kiến thức, lấy ra các khối con có thể có
    foreach ($caykkt as $item) {
        // Thêm các mã môn học thuộc khối vào $list_mamonhoc
        $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $item->ma_khoi]);

        foreach ($data_records as $data) {
            $tmp = array();
            $tmp['mamonhoc'] = $data->mamonhoc;
            $tmp['ma_decuong'] = $decuong->ma_decuong;
            $tmp['ma_ctdt'] = $ctdt->ma_ctdt;

            if (in_array($tmp, $list_mamonhoc)) {
            } else {
                $list_mamonhoc[] = $tmp;
            }
        }

        // Kiểm tra xem khối có khối con hay không? Điều kiện: có 1 khối cùng tên và có ma_tt = 0
        if ($DB->count_records('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0])) {
            $khoicha = $DB->get_record('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0]);

            // Lấy ra các khối con: có cùng mã cây khối kiến thức và có mã khối cha = mã khối của item
            $listkhoicon = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoicha'  => $khoicha->ma_khoi, 'ma_cay_khoikienthuc' => $khoicha->ma_cay_khoikienthuc]);

            // Lấy ra các mã môn học thuộc các khối con
            foreach ($listkhoicon as $khoicon) {
                $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $khoicon->ma_khoi]);
                foreach ($data_records as $data) {
                    $tmp = array();
                    $tmp['mamonhoc'] = $data->mamonhoc;
                    $tmp['ma_decuong'] = $decuong->ma_decuong;
                    $tmp['ma_ctdt'] = $ctdt->ma_ctdt;
                    $list_mamonhoc[] = $tmp;
                }
            }
        }
    }

    // Trả về danh sách mã môn học
    return $list_mamonhoc;
}
function get_all_monhoc(){
    global $DB, $USER, $CFG, $COURSE;
    return $DB->get_records('eb_monhoc');
}

function check_decuong_hople($ma_decuong){
    global $DB, $USER, $CFG, $COURSE;

    $arr_decuong = $DB->get_records('eb_decuong', []);

    foreach($arr_decuong as $iarr_decuong){
        if($iarr_decuong->ma_decuong == $ma_decuong){
            return false;
        }
    }

    return true;
}

function check_monhoc_hople($mamonhoc, $ma_ctdt){
    global $DB, $USER, $CFG, $COURSE;

    $arr_monhoc = $DB->get_records('eb_monhoc', []);
    foreach($arr_monhoc as $iarr_monhoc){
        
        if($iarr_monhoc->mamonhoc == $mamonhoc){
            return true;
        }
    }

    return false;
}

function check_ctdt_hople($mamonhoc, $ma_ctdt){
    global $DB, $USER, $CFG, $COURSE;

    $arr_khoi = $DB->get_records('eb_monthuockhoi', ['mamonhoc'=>$mamonhoc]);
    
    foreach($arr_khoi as $iarr_khoi){
        if($iarr_khoi->mamonhoc == $mamonhoc){
            

            $arr_cay_khoikienthuc = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoi'=>$iarr_khoi->ma_khoi]);

            foreach($arr_cay_khoikienthuc as $iarr_cay_khoikienthuc){

                $ctdt = $DB->get_record('eb_ctdt', ['ma_cay_khoikienthuc'=>$iarr_cay_khoikienthuc->ma_cay_khoikienthuc]);

                if($ctdt->ma_ctdt == $ma_ctdt){
                    return true;
                }
            }
        }
    }
    return false;
}

function check_chuandaura_hople($item_chuandaura, $arr_chuandaura_monhoc1){
    
    global $DB, $USER, $CFG, $COURSE;

    $arr_chuandaura_monhoc = $DB->get_records('eb_chuandaura', []);
    

    $arr = explode(', ', $item_chuandaura);
    
    
    foreach($arr as $iarr){
        // echo $iarr; echo "<br>"; //G1.1, G2.1 ,...
        $check = '0';
        foreach($arr_chuandaura_monhoc as $iarr_chuandaura_monhoc){
            
            if($iarr_chuandaura_monhoc->ma_cdr == $iarr){
                $check = '1';
            }
        }
        
       

        foreach($arr_chuandaura_monhoc1 as $iarr_chuandaura_monhoc1){
            
            if($iarr_chuandaura_monhoc1->ma_cdr == $iarr){
                $check = '1';
            }
        }

        if($check == '0'){
            
            return false;
        }
    }


return true;
}



// Footer
echo $OUTPUT->footer();