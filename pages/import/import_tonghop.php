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
$PAGE->navbar->add(get_string('label_quanly_decuong', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/decuong/index.php'));

// Title.
$PAGE->set_title(get_string('label_quanly_decuong', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import bac_he_nienkhoa_nganh_chuyennganh');
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
        
        $mform->addElement('filepicker', 'userfile', 'CSV chuẩn đầu ra chương trình đào tạo', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.csv'));
        $mform->addRule('userfile', 'Khong phai file csv', 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'GET');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }
}
class form2 extends moodleform{
    public function definition(){
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('hidden', 'link');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'Insert');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }
}


$form = new form1();$mform2 = new form2();$array_toDB = array(); // new table


//////////////////////////////////FORM 1 //////////////////////////////////

if ($form->is_cancelled()) {
    
} else if ($form->no_submit_button_pressed()) {
    
} else if ($fromform = $form->get_data()) {

    $name = $form->get_new_filename('userfile');

    $rex = $form->save_temp_file('userfile');

    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/import/import_tonghop.php?linkto='.$rex);

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
        
    $arr_head_thongtin = array(); $arr_thongtin = array(); $arr_bacdt = array(); $arr_hedt = array();
    $arr_nienkhoa = array(); $arr_nganhdt = array(); $arr_chuyennganhdt = array();
    $arr_quydinhchung = array();




    if (($handle = fopen( $fromform->link, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    
            if($data[0] == '1' || $data[0] == 1){  // bac dt
                if(requiredRules('eb_bacdt',$data[1],'','','','')==true){
                    if (is_check($arr_bacdt,$data[1],'','','','')==true){
                    $arr_bacdt[] = ['ma_bac'=>$data[1], 'ten'=>$data[6],  'mota'=>$data[7]];
                    }
                }
            }else 

            if($data[0] == '2' || $data[0] == 2){ // he dt
                if(requiredRules('eb_hedt',$data[1],$data[2],'','','')==true){  
                    if (is_check($arr_hedt,$data[1],$data[2],'','','')==true){
                $arr_hedt[] = ['ma_bac'=>$data[1], 'ma_he'=>$data[2] , 'ten'=>$data[6],  'mota'=>$data[7]];
                    }
                }

            }else 
            if($data[0] == '3' || $data[0] == 3){ // nien khoa
                if(requiredRules('eb_nienkhoa', $data[1],$data[2],$data[3],'','')==true){        
                    if (is_check($arr_nienkhoa,$data[1],$data[2],$data[3],'','')==true){

                $arr_nienkhoa[] =  ['ma_bac'=>$data[1], 'ma_he'=>$data[2] , 'ma_nienkhoa' => $data[3], 'ten'=>$data[6],  'mota'=>$data[7]];
                }
            }

            }else 
            if($data[0] == '4' || $data[0] == 4){ // nganh dao tao
                if(requiredRules('eb_nganhdt',$data[1],$data[2],$data[3],$data[4],'')==true){        
                    if (is_check($arr_nganhdt,$data[1],$data[2],$data[3],$data[4],'')==true){

                $arr_nganhdt[] = ['ma_bac'=>$data[1], 'ma_he'=>$data[2] , 'ma_nienkhoa' => $data[3],'ma_nganh' => $data[4] ,  'ten'=>$data[6],  'mota'=>$data[7]];
                }
            }

            }else
            if($data[0] == '5' || $data[0] == 5){ // chuyen nganh dt
                if(requiredRules('eb_chuyennganhdt',$data[1],$data[2],$data[3],$data[4],$data[5])==true){        
                    if (is_check($arr_chuyennganhdt,$data[1],$data[2],$data[3],$data[4],$data[5])==true){

                $arr_chuyennganhdt[] = ['ma_bac'=>$data[1], 'ma_he'=>$data[2] , 'ma_nienkhoa' => $data[3],'ma_nganh' => $data[4] , 'ma_chuyennganh' => $data[5],  'ten'=>$data[6],  'mota'=>$data[7]];
                    }
                }

            }
        }

        fclose($handle);
        foreach($arr_bacdt as $iarr){
            $param = new stdClass();
            $param->ma_bac = $iarr['ma_bac'];
            $param->ten = $iarr['ten'];
            $param->mota = $iarr['mota'];
                       insert_table("eb_bacdt",$param);
        }
        foreach($arr_hedt as $iarr){
            $param = new stdClass();
     
            $param->ma_bac = $iarr['ma_bac'];
            $param->ma_he = $iarr['ma_he'];

            $param->ten = $iarr['ten'];
            $param->mota = $iarr['mota'];
            insert_table("eb_hedt",$param);
        }
         foreach($arr_nienkhoa as $iarr){
            $param = new stdClass();
     
            $param->ma_bac = $iarr['ma_bac'];
            $param->ma_he = $iarr['ma_he'];
            $param->ma_nienkhoa = $iarr['ma_nienkhoa'];

            $param->ten_nienkhoa = $iarr['ten'];
            $param->mota = $iarr['mota'];
            insert_table("eb_nienkhoa",$param);
        }
        foreach($arr_nganhdt as $iarr){
            $param = new stdClass();
     
            $param->ma_bac = $iarr['ma_bac'];
            $param->ma_he = $iarr['ma_he'];
            $param->ma_nienkhoa = $iarr['ma_nienkhoa'];
            $param->ma_nganh = $iarr['ma_nganh'];

            $param->ten = $iarr['ten'];
            $param->mota = $iarr['mota'];
            insert_table("eb_nganhdt",$param);
        }
        foreach($arr_chuyennganhdt as $iarr){
            $param = new stdClass();
     
            $param->ma_bac = $iarr['ma_bac'];
            $param->ma_he = $iarr['ma_he'];
            $param->ma_nienkhoa = $iarr['ma_nienkhoa'];
            $param->ma_nganh = $iarr['ma_nganh'];
            $param->ma_chuyennganh = $iarr['ma_chuyennganh'];
            $param->ten = $iarr['ten'];
            $param->mota = $iarr['mota'];
            insert_table("eb_chuyennganhdt",$param);
        }
    
       
      
       
    }
    
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/main.php');
    
    
} else if ($mform2->is_submitted()) {
} else {

    $arr_head_thongtin = array(); $arr_thongtin = array(); $arr_bacdt = array(); $arr_hedt = array();
    $arr_nienkhoa = array(); $arr_nganhdt = array(); $arr_chuyennganhdt = array();
    $arr_quydinhchung = array();


    $toform;
    $toform->link = $link; 
    $mform2->set_data($toform);
    if($link != null){

        

        if (($handle = fopen( $link, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                
                if($data[0] == '1' || $data[0] == 1){  // bac dt
                    if(is_check($arr_bacdt,$data[1],'','','','')==true){        
                    $arr_bacdt[] = ['ma_bac'=>$data[1], 'ten'=>$data[6],  'mota'=>$data[7]];
                    }
                }else 
                if($data[0] == '2' || $data[0] == 2){ // he dt
                    if(is_check($arr_hedt,$data[1],$data[2],'','','')==true){        
                    $arr_hedt[] = ['ma_bac'=>$data[1], 'ma_he'=>$data[2] , 'ten'=>$data[6],  'mota'=>$data[7]];
                    }
                }else 
                if($data[0] == '3' || $data[0] == 3){ // nien khoa
                    if(is_check($arr_nienkhoa,$data[1],$data[2],$data[3],'','')==true){        
                    $arr_nienkhoa[] =  ['ma_bac'=>$data[1], 'ma_he'=>$data[2] , 'ma_nienkhoa' => $data[3], 'ten'=>$data[6],  'mota'=>$data[7]];
                    }
                }else 
                if($data[0] == '4' || $data[0] == 4){ // nganh dao tao
                    if(is_check($arr_nganhdt,$data[1],$data[2],$data[3],$data[4],'')==true){        

                    $arr_nganhdt[] = ['ma_bac'=>$data[1], 'ma_he'=>$data[2] , 'ma_nienkhoa' => $data[3],'ma_nganh' => $data[4] ,  'ten'=>$data[6],  'mota'=>$data[7]];
                    }
                }else
                if($data[0] == '5' || $data[0] == 5){ // chuyen nganh dt
                    if(is_check($arr_chuyennganhdt,$data[1],$data[2],$data[3],$data[4],$data[5])==true){        

                    $arr_chuyennganhdt[] = ['ma_bac'=>$data[1], 'ma_he'=>$data[2] , 'ma_nienkhoa' => $data[3],'ma_nganh' => $data[4] , 'ma_chuyennganh' => $data[5],  'ten'=>$data[6],  'mota'=>$data[7]];
                    }
                }
                
            }


            fclose($handle);
        }

        /////////////////////////////////TABLE MUCTIEU/////////////////////////////////
        $table_bacdt = new html_table();
        $table_bacdt->head = ['Mã bậc', 'Tên bậc', 'Mô tả'];
        foreach($arr_bacdt as $item){
            
            if(requiredRules('eb_bacdt', $item['ma_bac'],'','','','') == true){
                $table_bacdt->data[] = [$item['ma_bac'], $item['ten'],$item['mota']];
            }else{
                
            }

            
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Bậc đt</h2>";echo "<br>";
        echo html_writer::table($table_bacdt);echo "<br>";
       
        /////////////////////////////////TABLE CHUAN DAU RA/////////////////////////////////
        $table_hedt = new html_table();
        $table_hedt->head = ['Mã bậc', 'Mã hệ','Tên hệ', 'Mô tả'];
        foreach($arr_hedt as $item){
            
            if(requiredRules('eb_hedt', $item['ma_bac'],$item['ma_he'],'','','') == true){

                $table_hedt->data[] = [$item['ma_bac'], $item['ma_he'],$item['ten'],$item['mota']];
            }else{
                
            }

            
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Hệ đt</h2>";echo "<br>";

        echo html_writer::table($table_hedt);echo "<br>";
      
        /////////////////////////////////TABLE KE HOACH GIANG DAY/////////////////////////////////
        $table_nienkhoa = new html_table();
        $table_nienkhoa->head = ['Mã bậc', 'Mã hệ ','Mã khóa tuyển','Tên khóa tuyển', 'Mô tả'];
        foreach($arr_nienkhoa as $item){
            
            if(requiredRules('eb_nienkhoa', $item['ma_bac'],$item['ma_he'],$item['ma_nienkhoa'],'','') == true){

                $table_nienkhoa->data[] = [$item['ma_bac'], $item['ma_he'],$item['ma_nienkhoa'],$item['ten'],$item['mota']];
                
                
            }
            
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>khóa tuyển</h2>";echo "<br>";
        echo html_writer::table($table_nienkhoa);echo "<br>";

        

        /////////////////////////////////TABLE DANH GIA/////////////////////////////////

        $table_nganhdt = new html_table();
        $table_nganhdt->head = ['Mã bậc', 'Mã hệ','Mã khóa tuyển','Mã ngành','Tên ngành', 'Mô tả'];
        foreach($arr_nganhdt as $item){
            
            if(requiredRules('eb_nganhdt', $item['ma_bac'], $item['ma_he'],$item['ma_nienkhoa'],$item['ma_nganh'],'') == true){

                $table_nganhdt->data[] = [$item['ma_bac'], $item['ma_he'],$item['ma_nienkhoa'],$item['ma_nganh'],$item['ten'],$item['mota']];
            }
   
            
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Ngành đào tạo</h2>";echo "<br>";
        echo html_writer::table($table_nganhdt);echo "<br>";
      
        /////////////////////////////////TABLE TAI NGUYEN/////////////////////////////////
        $table_chuyennganhdt = new html_table();
        $table_chuyennganhdt->head = ['Mã bậc', 'Mã hệ','Mã khóa tuyển','Mã ngành','Mã chuyên ngành' ,'Tên chuyên ngành', 'Mô tả'];
        foreach($arr_chuyennganhdt as $item){    
            
            if(requiredRules('eb_chuyennganhdt', $item['ma_bac'],$item['ma_he'],$item['ma_nienkhoa'],$item['ma_nganh'],$item['ma_chuyennganh']) == true){

                $table_chuyennganhdt->data[] = [$item['ma_bac'], $item['ma_he'],$item['ma_nienkhoa'],$item['ma_nganh'],$item['ma_chuyennganh'],$item['ten'],$item['mota']];
            }
        }
        echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Chuyên ngành đào tạo</h2>";echo "<br>";
        echo html_writer::table($table_chuyennganhdt);echo "<br>";
     


        /////////////////////////////////TABLE QUY DINH CHUNG/////////////////////////////////

            $mform2->display();    
     
        
    }
    

}


function requiredRules( $db_name, $ma_bac, $ma_he, $ma_nienkhoa, $ma_nganh, $ma_chuyennganh){
    global $DB ;
    $list = $DB->get_records($db_name, []);
    
    foreach($list as $item){
        if ($ma_bac != ''){
            if ($item->ma_bac == $ma_bac && $ma_he == ''){
                return false;
            }
            if($ma_he != ''){
                if ($item->ma_bac == $ma_bac && $item->ma_he == $ma_he && $ma_nienkhoa == ''){
                    return false;
                }
                if($ma_nienkhoa != ''){
                    if ($item->ma_bac == $ma_bac && $item->ma_he == $ma_he && $item->ma_nienkhoa == $ma_nienkhoa && $ma_nganh == ''){
                        return false;
                    }
                    if($ma_nganh != ''){
                        if ($item->ma_bac == $ma_bac && $item->ma_he == $ma_he && $item->ma_nienkhoa == $ma_nienkhoa && $item->ma_nganh == $ma_nganh && $ma_chuyennganh == ''){
                            return false;
                        }
                        if($ma_chuyennganh != ''){
                            if ($item->ma_bac == $ma_bac && $item->ma_he == $ma_he && $item->ma_nienkhoa == $ma_nienkhoa && $item->ma_nganh == $ma_nganh && $item->ma_chuyennganh == $ma_chuyennganh){
                                return false;
                            }
                        }
                     }
                }
            }
        }
    }
    return true;
}


function insert_table($db_name , $param){
    global $DB;
    
        $DB->insert_record($db_name, $param);
    
    
}

function get(){
    global $DB;
    $arr = array();
    $arr = $DB->get_records('eb_monhoc', []);
    return $arr;
}

function is_check($arr, $ma_bac, $ma_he , $ma_nienkhoa , $ma_nganh, $ma_chuyennganh){
    
    foreach($arr as $item){
        if ($ma_bac != ''){
            if ($item['ma_bac'] == $ma_bac && $ma_he == ''){
                return false;
            }
            if($ma_he != ''){
                if ($item['ma_bac'] == $ma_bac && $item['ma_he'] == $ma_he && $ma_nienkhoa == ''){
                    return false;
                }
                if($ma_nienkhoa != ''){
                    if ($item['ma_bac'] == $ma_bac && $item['ma_he'] == $ma_he && $item['ma_nienkhoa'] == $ma_nienkhoa && $ma_nganh == ''){
                        return false;
                    }
                    if($ma_nganh != ''){
                        if ($item['ma_bac'] == $ma_bac && $item['ma_he'] == $ma_he && $item['ma_nienkhoa'] == $ma_nienkhoa && $item['ma_nganh'] == $ma_nganh && $ma_chuyennganh == ''){
                            return false;
                        }
                        if($ma_chuyennganh != ''){
                            if ($item['ma_bac'] == $ma_bac && $item['ma_he'] == $ma_he && $item['ma_nienkhoa'] == $ma_nienkhoa && $item['ma_nganh'] == $ma_nganh && $item['ma_chuyennganh'] == $ma_chuyennganh){
                                return false;
                            }
                        }
                     }
                }
            }
        }
    }
    return true;
}


// Footer
echo $OUTPUT->footer();