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
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/decuong/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_quanly_decuong', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/decuong/index.php'));

// Title.
$PAGE->set_title(get_string('label_quanly_decuong', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import chương trình đào tạo');
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

    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/import/import_ctdt.php?linkto='.$rex);

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

    $arr_thongtin_ctdt = array(); $arr_muctieuchung = array(); $arr_muctieucuthe = array(); $arr_chuandaura_ctdt = array();
        $arr_cohoinghenghiep = array(); $thoigian_daotao; $khoiluongkienthuc; $doituongtuyensinh; $quytrinhdaotao; $dieukientotnghiep;
        $arr_khoikienthuc = array(); $arr_caykhoikienthuc = array();$arr_monhoc = array();

    if (($handle = fopen( $fromform->link, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {


                if($data[0] == 0 || $data[0] == '0'){
                    $arr_thongtin_ctdt[] = ['ma_bac'=> $data[1], 'ten_bac'=> $data[2], 'ma_he'=> $data[3], 'ten_he'=> $data[4],
                'ma_nienkhoa'=> $data[5], 'ten_nienkhoa'=> $data[6], 'ma_nganh'=> $data[7], 'ten_nganh'=> $data[8],
                 'ma_chuyennganh'=> $data[9], 'ten_chuyennganh'=> $data[10],'ten_chuongtrinh'=> $data[11], 'ma_ctdt'=> $data[12], 'mota'=>$data[13]];
                }else
                if($data[0] == 1 || $data[0]== '1'){
                    $arr_muctieuchung[] = ['title_muctieuchung' => $data[1]];
                }else
                if($data[0]== 1.1 || $data[0]== '1.1'){
                    $arr_muctieuchung[] = ['noidung_muctieuchung' => $data[1]];
                }else
                if($data[0]== 1.2 || $data[0]== '1.2'){
                    $arr_muctieucuthe[] = ['noidung_muctieucuthe' => $data[1]];
                }else
                if($data[0] == 1.3 || $data[0] == '1.3'){
                    $arr_chuandaura_ctdt[] = ['level'=> $data[1], 'ma_cdr' => $data[2], 'ten' => $data[3], 'mota' => $data[4], 'have_ctdt'=> $data[5]];
                }else
                if($data[0] == 4 || $data[0]== '4'){
                    $arr_cohoinghenghiep[] = ['title_cohoi' => $data[1]];
                }else
                if($data[0]== 1.4 || $data[0]== '1.4'){
                    $arr_cohoinghenghiep[] = ['noidung_cohoi' => $data[1]];
                }else
                if($data[0] == 1.5 || $data[0] == '1.5'){
                    $thoigian_daotao = $data[1];
                }else
                if($data[0] == 1.6 || $data[0] == '1.6'){
                    $khoiluongkienthuc = $data[1];
                }else
                if($data[0] == 1.7 || $data[0] == '1.7'){
                    $doituongtuyensinh = $data[1];
                }else
                if($data[0] == 1.8 || $data[0] == '1.8'){
                    $quytrinhdaotao = $data[1];
                }else
                if($data[0] == 1.9 || $data[0] == '1.9'){
                    $dieukientotnghiep = $data[1];
                }else
                if($data[0] == 2.3 || $data[0] == '2.3'){
                    

                    if($data[1] == 'info'){
                        $arr_khoikienthuc[] = ['ma_khoi'=>$data[2], 'ten_khoi'=>$data[6], 'mota' => $data[7], 'mon_BB' => array()];
                        $i ++ ;
                    }else
                    if($data[1] == 'mon_BB'){
                        $mon_bb = array();
                        foreach($data as $idata){
                            if($idata != '2.3' && $idata != 'mon_BB' && $idata != '' && $idata != null){
                                $mon_bb[] = $idata;
                            }
                        }
                        
                        $arr_khoikienthuc[$i-1]['mon_BB'] =  $mon_bb;

                        
                    }

                }else
                if($data[0] == 2.4 || $data[0] == '2.4'){
                    $arr_caykhoikienthuc[] =  ['ma_caykhoikienthuc' => $data[2], 'ma_tt'=> $data[3], 'ma_khoi'=> $data[4], 'ma_khoicha'=> $data[5], 'ten_cay'=>$data[6], 'mota'=> $data[7],
                    'danhdau'=> $data[8]];
                }else
                if($data[0] == 2.5 || $data[0] == '2.5'){
                    $arr_monhoc[] =  ['thuoc_khoi' => $data[1], 'mamonhoc'=> $data[2], 'tenmonhoc'=> $data[3], 'sotc'=> $data[4], 'sotiet_lt'=> $data[5], 'sotiet_th'=> $data[6], 'sotiet_bt'=> $data[7], 'loaihocphan'=> $data[8], 'ghichu'=> $data[9]];
                }



        }

        fclose($handle);
    }
    
    /////////////////////////CHECK/////////////////////////

    $is_check_ctdt_hople = check_ctdt_hople($arr_thongtin_ctdt);

    if(!$is_check_ctdt_hople){ // hople
        echo 'Chương trình đào tạo <strong>'.$arr_thongtin_ctdt[1]['ma_ctdt'] . ' - ' . $arr_thongtin_ctdt[1]['ten_chuongtrinh']. '</strong> không hợp lệ hoặc đã tồn tại'; 
        echo "<br>";
    }

    if($is_check_ctdt_hople){

        $arr_tem = array();
        foreach($arr_khoikienthuc as $iarr_khoikienthuc){ // tim va gan list mon bb vao moi khoi
            $iarr_khoikienthuc['list_monhoc'] = array();

            if(count($iarr_khoikienthuc['mon_BB'] > 0)){
                
                $arr_mon_BB = $iarr_khoikienthuc['mon_BB'];
                

                $monhoc = find_monhoc_BB($arr_monhoc, $arr_mon_BB);

                
                $arr_tem[] = ['list_monhoc'=>$monhoc, 'ma_khoi'=>$iarr_khoikienthuc['ma_khoi'], 'ten_khoi'=>$iarr_khoikienthuc['ten_khoi'],
                'mota'=>$iarr_khoikienthuc['mota'], 'mon_BB'=>$iarr_khoikienthuc['mon_BB']];
                

            }

            
            
        } // tra ve ban copy cua arr_khoikienthuc co chua list_monhoc

        
        $arr_tem1 = array(); // cay sau khi tong hop du lieu

        foreach($arr_tem as $iarr_tem){
            foreach($arr_caykhoikienthuc as $iarr_caykhoikienthuc){

                if($iarr_tem['ma_khoi'] == $iarr_caykhoikienthuc['ma_khoi']){
                    
                   $arr_tem1[] = ['ma_caykhoikienthuc'=>$iarr_caykhoikienthuc['ma_caykhoikienthuc'] , 'ma_tt'=>$iarr_caykhoikienthuc['ma_tt'], 'ma_khoi'=>$iarr_caykhoikienthuc['ma_khoi'],
                    'ma_khoicha'=>$iarr_caykhoikienthuc['ma_khoicha'], 'ten_cay'=>$iarr_caykhoikienthuc['ten_cay'], 'mota'=>$iarr_caykhoikienthuc['mota'], 'danhdau'=>$iarr_caykhoikienthuc['danhdau'],
                   'list_monhoc'=>$iarr_tem['list_monhoc'], 'mon_BB'=>$iarr_tem['mon_BB'], 'ten_khoi'=>$iarr_tem['ten_khoi']];
                }else 
                if(($iarr_caykhoikienthuc['ma_tt'] == null || $iarr_caykhoikienthuc['ma_tt'] == '') && 
                ($iarr_caykhoikienthuc['ma_khoicha'] == null || $iarr_caykhoikienthuc['ma_khoicha'] == '')){
                    // node root
                    $arr_tem1[] = ['ma_caykhoikienthuc'=>$iarr_caykhoikienthuc['ma_caykhoikienthuc'] , 'ma_tt'=>$iarr_caykhoikienthuc['ma_tt'], 'ma_khoi'=>$iarr_caykhoikienthuc['ma_khoi'],
                    'ma_khoicha'=>$iarr_caykhoikienthuc['ma_khoicha'], 'ten_cay'=>$iarr_caykhoikienthuc['ten_cay'], 'mota'=>$iarr_caykhoikienthuc['mota'], 'danhdau'=>$iarr_caykhoikienthuc['danhdau']];
                }
            }
        }

        //monhoc
        foreach($arr_monhoc as $iarr_monhoc){
                
    
            $param_monhoc = new stdClass();

            $param_monhoc->mamonhoc = $iarr_monhoc['mamonhoc'];
            $param_monhoc->tenmonhoc_vi= $iarr_monhoc['tenmonhoc'];
            $param_monhoc->tenmonhoc_en= '';
            $param_monhoc->lopmo= '';
            $param_monhoc->loaihocphan= $iarr_monhoc['loaihocphan'];
            $param_monhoc->sotinchi= $iarr_monhoc['sotc'];
            $param_monhoc->sotietlythuyet= $iarr_monhoc['sotiet_lt'];
            $param_monhoc->sotietthuchanh= $iarr_monhoc['sotiet_th'];
            $param_monhoc->sotiet_baitap= $iarr_monhoc['sotiet_bt'];
            $param_monhoc->ghichu= $iarr_monhoc['ghichu'];
            $param_monhoc->mota= '';

            $is_check_monhoc = requiredRules('eb_monhoc', 'mamonhoc', $param_monhoc->mamonhoc);
            
            if(!$is_check_monhoc){
                echo 'Môn học <strong>'.$param_monhoc->mamonhoc . ' - ' . $param_monhoc->tenmonhoc_vi . '</strong> không hợp lệ hoặc đã tồn tại'; 
                echo "<br>";
            }else{
                insert('eb_monhoc', $param_monhoc);

                echo 'Môn học <strong>'.$param_monhoc->mamonhoc . ' - ' . $param_monhoc->tenmonhoc_vi . '</strong> được thêm thành công'; 
                echo "<br>";
            }


        }

        echo json_encode($arr_tem1); 
        //khoikienthuc, monthuockhoi, caykhoikienthuc
        foreach($arr_tem1 as $iarr_tem1){ // cay khoi kien thuc            

            $is_check_khoikienthuc = requiredRules('eb_khoikienthuc', 'ma_khoi', $param_khoikienthuc->ma_khoi);
            $is_check_monthuockhoi = check_monthuockhoi('eb_monthuockhoi', $param_khoikienthuc->ma_khoi,  $iarr_tem1['list_monhoc']);
            $is_check_caykhoikienthuc = requiredRules('eb_cay_khoikienthuc', 'ma_cay_khoikienthuc', $param_khoikienthuc->ma_khoi);

            if(!$is_check_khoikienthuc){
                echo 'Khối kiến thức <strong>'.$param_khoikienthuc->ma_khoi. ' - ' .$param_khoikienthuc->ten_khoi  . '</strong> không hợp lệ hoặc đã tồn tại'; 
                echo "<br>";
            }else{
                $param_khoikienthuc = new stdClass();

                $param_khoikienthuc->ma_khoi = $iarr_tem1['ma_khoi'];
                $param_khoikienthuc->id_loai_kkt;
                $param_khoikienthuc->co_dieukien;
                $param_khoikienthuc->ma_dieukien;
                $param_khoikienthuc->ten_khoi = $iarr_tem1['ten_khoi'];
                $param_khoikienthuc->mota = $iarr_tem1['mota'];

                //insert khoi kien thuc
                
            }
            if(!$is_check_monthuockhoi){
                echo 'Môn thuộc khối <strong>'.$param_khoikienthuc->ma_khoi. ' - ' .$param_khoikienthuc->ten_khoi  . '</strong> không hợp lệ hoặc đã tồn tại';
                echo "<br>";
            }else{

                foreach($iarr_tem1['list_monhoc'] as $imonhoc){

                    $param_monthuockhoi = new stdClass();

                    
                    $param_monthuockhoi->ma_khoi = $iarr_tem1['ma_khoi'];
                    $param_monthuockhoi->mamonhoc = $imonhoc['mamonhoc'];

                    
                    //insert monthuockhoi
                }
                
                
                
            }
            if(!$is_check_caykhoikienthuc){
                echo 'Cây khối kiến thức <strong>'.$iarr_tem1['ma_caykhoikienthuc']. ' - ' .$iarr_tem1['ten_cay']  . '</strong> không hợp lệ hoặc đã tồn tại';                 
                echo "<br>";
            }else{
                
                $param_caykhoikienthuc = new stdClass();

                $param_caykhoikienthuc->ma_cay_khoikienthuc = $iarr_tem1['ma_caykhoikienthuc'];
                $param_caykhoikienthuc->ma_tt = $iarr_tem1['ma_tt'];
                $param_caykhoikienthuc->ma_khoi = $iarr_tem1['ma_khoi'];
                $param_caykhoikienthuc->ma_khoicha = $iarr_tem1['ma_khoicha'];
                $param_caykhoikienthuc->ten_cay = $iarr_tem1['ten_cay'];
                $param_caykhoikienthuc->mota = $iarr_tem1['mota'];
                

                // echo json_encode($param_caykhoikienthuc); echo "<br>";

                //insert cay khoi kien thuc
            }
            
            
        }


        //ctdt
        $param_ctdt = new stdClass();

        $param_ctdt->ma_ctdt = $arr_thongtin_ctdt[1]['ma_ctdt'];
        $param_ctdt->ma_bac = $arr_thongtin_ctdt[1]['ma_bac'];
        $param_ctdt->ma_he = $arr_thongtin_ctdt[1]['ma_he'];
        $param_ctdt->ma_nienkhoa = $arr_thongtin_ctdt[1]['ma_nienkhoa'];
        $param_ctdt->ma_nganh = $arr_thongtin_ctdt[1]['ma_nganh'];
        $param_ctdt->ma_chuyennganh = $arr_thongtin_ctdt[1]['ma_chuyennganh'];

        
        $muctieu_daotao = array();
        $muctieu_daotao[] .= $arr_muctieuchung[1]['title_muctieuchung'];
        foreach($arr_muctieuchung as $iarr_muctieuchung){
            if($iarr_muctieuchung['noidung_muctieuchung']){
                $muctieu_daotao[] .= $iarr_muctieuchung['noidung_muctieuchung'];
            }
        }
        $param_ctdt->muctieu_daotao = $muctieu_daotao;


        
        $muctieu_cuthe = array();
        foreach($arr_muctieucuthe as $iarr_muctieucuthe){
            if($iarr_muctieucuthe['noidung_muctieucuthe']){
                $muctieu_cuthe[] .= $iarr_muctieucuthe['noidung_muctieucuthe'];
            }
        }
        $param_ctdt->muctieu_cuthe = $muctieu_cuthe;


        $param_ctdt->chuandaura = $arr_thongtin_ctdt[1]['ma_ctdt']; //chua biet insert sao

        
        $cohoi_nghenghiep = array();
        $cohoi_nghenghiep[] .= $arr_cohoinghenghiep[1]['title_cohoi'];
        foreach($arr_cohoinghenghiep as $iarr_cohoinghenghiep){
            if($iarr_cohoinghenghiep['noidung_cohoi']){
                $cohoi_nghenghiep[] .= $iarr_cohoinghenghiep['noidung_cohoi'];
            }
        }
        $param_ctdt->cohoi_nghenghiep = $cohoi_nghenghiep;

        $param_ctdt->thoigian_daotao = $thoigian_daotao;
        
        $param_ctdt->khoiluong_kienthuc = $khoiluongkienthuc;

        $param_ctdt->doituong_tuyensinh = $doituongtuyensinh;

        $param_ctdt->quytrinh_daotao = $quytrinhdaotao;

        $param_ctdt->dieukien_totnghiep = $dieukientotnghiep;

        $param_ctdt->ma_cay_khoikienthuc = $arr_tem1[1]['ma_caykhoikienthuc'];

        $param_ctdt->mota = $arr_thongtin_ctdt[1]['mota'];
        

        // echo json_encode($param_ctdt);
    }





} else if ($mform2->is_submitted()) {
} else {


    $toform;
    $toform->link = $link;
    $mform2->set_data($toform);

    $ma_decuong = null;

    if($link != null){
        $index = 1;

        $arr_thongtin_ctdt = array(); $arr_muctieuchung = array(); $arr_muctieucuthe = array(); $arr_chuandaura_ctdt = array();
        $arr_cohoinghenghiep = array(); $thoigian_daotao; $khoiluongkienthuc; $doituongtuyensinh; $quytrinhdaotao; $dieukientotnghiep;
        $arr_khoikienthuc = array(); $arr_caykhoikienthuc = array();$arr_monhoc = array();

        if (($handle = fopen( $link, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if($data[0] == 0 || $data[0] == '0'){
                    $arr_thongtin_ctdt[] = ['ma_bac'=> $data[1], 'ten_bac'=> $data[2], 'ma_he'=> $data[3], 'ten_he'=> $data[4],
                'ma_nienkhoa'=> $data[5], 'ten_nienkhoa'=> $data[6], 'ma_nganh'=> $data[7], 'ten_nganh'=> $data[8],
                 'ma_chuyennganh'=> $data[9], 'ten_chuyennganh'=> $data[10],'ten_chuongtrinh'=> $data[11], 'ma_ctdt'=> $data[12], 'mota'=>$data[13]];
                }else
                if($data[0] == 1 || $data[0]== '1'){
                    $arr_muctieuchung[] = ['title_muctieuchung' => $data[1]];
                }else
                if($data[0]== 1.1 || $data[0]== '1.1'){
                    $arr_muctieuchung[] = ['noidung_muctieuchung' => $data[1]];
                }else
                if($data[0]== 1.2 || $data[0]== '1.2'){
                    $arr_muctieucuthe[] = ['noidung_muctieucuthe' => $data[1]];
                }else
                if($data[0] == 1.3 || $data[0] == '1.3'){
                    $arr_chuandaura_ctdt[] = ['level'=> $data[1], 'ma_cdr' => $data[2], 'ten' => $data[3], 'mota' => $data[4], 'have_ctdt'=> $data[5]];
                }else
                if($data[0] == 4 || $data[0]== '4'){
                    $arr_cohoinghenghiep[] = ['title_cohoi' => $data[1]];
                }else
                if($data[0]== 1.4 || $data[0]== '1.4'){
                    $arr_cohoinghenghiep[] = ['noidung_cohoi' => $data[1]];
                }else
                if($data[0] == 1.5 || $data[0] == '1.5'){
                    $thoigian_daotao = $data[1];
                }else
                if($data[0] == 1.6 || $data[0] == '1.6'){
                    $khoiluongkienthuc = $data[1];
                }else
                if($data[0] == 1.7 || $data[0] == '1.7'){
                    $doituongtuyensinh = $data[1];
                }else
                if($data[0] == 1.8 || $data[0] == '1.8'){
                    $quytrinhdaotao = $data[1];
                }else
                if($data[0] == 1.9 || $data[0] == '1.9'){
                    $dieukientotnghiep = $data[1];
                }else
                if($data[0] == 2.3 || $data[0] == '2.3'){
                    

                    if($data[1] == 'info'){
                        $arr_khoikienthuc[] = ['ma_khoi'=>$data[2], 'ten_khoi'=>$data[6], 'mota' => $data[7], 'mon_BB' => array()];
                        $i ++ ;
                    }else
                    if($data[1] == 'mon_BB'){
                        $mon_bb = array();
                        foreach($data as $idata){
                            if($idata != '2.3' && $idata != 'mon_BB' && $idata != '' && $idata != null){
                                $mon_bb[] = $idata;
                            }
                        }
                        
                        $arr_khoikienthuc[$i-1]['mon_BB'] =  $mon_bb;

                        
                    }

                }else
                if($data[0] == 2.4 || $data[0] == '2.4'){
                    $arr_caykhoikienthuc[] =  ['ma_caykhoikienthuc' => $data[2], 'ma_tt'=> $data[3], 'ma_khoi'=> $data[4], 'ma_khoicha'=> $data[5], 'ten_cay'=>$data[6], 'mota'=> $data[7],
                    'danhdau'=> $data[8]];
                }else
                if($data[0] == 2.5 || $data[0] == '2.5'){
                    $arr_monhoc[] =  ['thuoc_khoi' => $data[1], 'mamonhoc'=> $data[2], 'tenmonhoc'=> $data[3], 'sotc'=> $data[4], 'sotiet_lt'=> $data[5], 'sotiet_th'=> $data[6], 'sotiet_bt'=> $data[7], 'loaihocphan'=> $data[8], 'ghichu'=> $data[9]];
                }



            }


            fclose($handle);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        class mfrom_thongtinchung extends moodleform{
            public function definition(){
                global $CFG;
                $mform = $this->_form;

                $mform->addElement('text', 'tenchuongtrinh', 'Tên chương trình', 'size=50');
                $mform->disabledIf('tenchuongtrinh','');
                $mform->addElement('text', 'trinhdodaotao', 'Trình độ đào tạo', 'size=50');
                $mform->disabledIf('trinhdodaotao','');
                $mform->addElement('text', 'nganhdaotao', 'Ngành đào tạo', 'size=50');
                $mform->disabledIf('nganhdaotao','');
                $mform->addElement('text', 'manganh', 'Mã ngành', 'size=50');
                $mform->disabledIf('manganh','');
                $mform->addElement('text', 'loaihinhdaotao', 'Loại hình đào tạo', 'size=50');
                $mform->disabledIf('loaihinhdaotao','');
                $mform->addElement('text', 'khoatuyen', 'Khóa tuyển', 'size=50');
                $mform->disabledIf('khoatuyen','');
            }

            function validation($data, $files)
            {
                return array();
            }
        }


        echo "<br>"; echo "<br>"; echo "<br>"; echo "<br>";

        $mform_thongtinchung = new mfrom_thongtinchung();


        $toform;
        $toform->tenchuongtrinh = $arr_thongtin_ctdt[1]['ten_chuongtrinh'];
        $toform->trinhdodaotao = $arr_thongtin_ctdt[1]['ten_bac'];
        $toform->nganhdaotao = $arr_thongtin_ctdt[1]['ten_nganh'];
        $toform->manganh = $arr_thongtin_ctdt[1]['ma_nganh'];
        $toform->loaihinhdaotao = $arr_thongtin_ctdt[1]['ten_he'];
        $toform->khoatuyen = $arr_thongtin_ctdt[1]['ten_nienkhoa'];

        $mform_thongtinchung->set_data($toform);
        $mform_thongtinchung->display();

        ////////////////////////////////////////MỤC TIÊU CHUNG////////////////////////////////////////////////////
        echo "<br>";echo "<br>";
        echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>1. <span style='text-decoration:underline'>Mục tiêu đào tạo</span></strong>
            </h3>"; echo "<br>";
        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>1.1. Mục tiêu chung</strong></h3>";

        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $arr_muctieuchung[1]['title_muctieuchung'] . "</p>";
        
        foreach($arr_muctieuchung as $iarr_muctieuchung){
            if($iarr_muctieuchung['noidung_muctieuchung']){
                echo "<p style='font-size: 20px; font-family: auto; margin-left:70px'> • ". $iarr_muctieuchung['noidung_muctieuchung'] . "</p>";
            }

        }


        echo "<h3 style='text-transform: uppercase '>
            <strong style='font-weight: 600; font-family: auto;'>1.2. Mục tiêu cụ thể - Chuẩn đầu ra của chương trình đào tạo</strong>
            </h3>"; echo "<br>";
        echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>1.2.1. Mục tiêu cụ thể</strong></h4>"; 

        foreach($arr_muctieucuthe as $iarr_muctieucuthe){
            if($iarr_muctieucuthe['noidung_muctieucuthe']){
                echo "<p style='font-size: 20px; font-family: auto; margin-left:70px'> • ". $iarr_muctieucuthe['noidung_muctieucuthe'] . "</p>";
            }

        }

        ////////////////////////////////////////CHUẨN ĐẦU RA////////////////////////////////////////////////////
        echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>1.2.2. Chuẩn đầu ra của chương trình giáo dục</strong></h4>"; echo "<br>";

        foreach($arr_chuandaura_ctdt as $iarr_chuandaura_ctdt){
            $arr_level2 = array();

            if($iarr_chuandaura_ctdt['level'] == 1 || $iarr_chuandaura_ctdt['level'] == '1'){

                echo "<h4 ><strong style='margin-left: 70px;font-weight: 600; font-family: auto;'> ❖ " . $iarr_chuandaura_ctdt['mota'] ."</strong></h4>" ; 

                $arr_level2 =  find_chuandaura_con($arr_chuandaura_ctdt,  $iarr_chuandaura_ctdt['ma_cdr'], 2);

                $arr_level3 = array();
                foreach($arr_level2 as $iarr_level2){

                    echo"<h4 style='margin-left: 7% ; margin-bottom: 0; font-family: auto;'> - ". $iarr_level2['mota'] . "</h4>"; echo "<br>";

                    $arr_level3 = find_chuandaura_con($arr_chuandaura_ctdt,  $iarr_level2['ma_cdr'], 3);

                    foreach($arr_level3 as $iarr_level3){

                        echo "<h4 style='margin-left: 10%; margin-bottom: 0; font-family: auto;'> • " . $iarr_level3['mota'] . "</h4>"; echo "<br>";
                    }

                }
            }

        }

        ////////////////////////////////////////CƠ HỘI NGHỀ NGHIỆP////////////////////////////////////////////////////

        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>1.3. Cơ hội nghề nghiệp</strong></h3>"; echo "<br>";


        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $arr_cohoinghenghiep[1]['title_cohoi'] . "</p>";

        foreach($arr_cohoinghenghiep as $iarr_cohoinghenghiep){

            if($iarr_cohoinghenghiep['noidung_cohoi']){
                echo "<p style='font-size: 20px; font-family: auto; margin-left:70px'> • ". $iarr_cohoinghenghiep['noidung_cohoi'] . "</p>";
            }

        }

        ////////////////////////////////////////THỜI GIAN ĐÀO TẠO////////////////////////////////////////////////////

        
        echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>2. <span style='text-decoration:underline'>Thời gian đào tạo: 
                </span><span style='text-transform: lowercase'>" .$thoigian_daotao. "</span></strong>
            </h3>"; echo "<br>";

        ////////////////////////////////////////KHỐI LƯỢNG KIẾN THỨC TOÀN KHÓA////////////////////////////////////////////////////


        echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>3. <span style='text-decoration:underline'>Khối lượng kiến thức toàn khóa: 
                </span><span style='text-transform: lowercase'>" .$khoiluongkienthuc. "</span></strong>
            </h3>"; echo "<br>";


        ////////////////////////////////////////ĐỐI TƯỢNG TUYỂN SINH////////////////////////////////////////////////////

        // echo "<h3 style='text-transform: uppercase '><strong>4. đối tượng tuyển sinh</strong></h3>" . "<h4>". $doituongtuyensinh ."</h3>";

        echo "
        <h3 style='text-transform: uppercase '>
            <strong style='font-weight: 600; font-family: auto;'>4. <span style='text-decoration:underline'>đối tượng tuyển sinh: 
            </span></strong>
        </h3>"; 
        

        echo "<h4 style='text-transform: lowercase; font-weight: 500; font-size: 20px; font-family: auto; margin-left:30px'>" .$doituongtuyensinh. "</h4>";


        ////////////////////////////////////////QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP////////////////////////////////////////////////////

        echo "
        <h3 style='text-transform: uppercase '>
            <strong style='font-weight: 600; font-family: auto;'>4. <span style='text-decoration:underline'>QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP
            </span></strong>
        </h3>"; 
        

        
        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>5.1. quy trình đào tạo</strong></h3>"; echo "<br>";
        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $quytrinhdaotao . "</p>";
        
        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>5.2. điều kiện tốt nghiệp</strong></h3>"; echo "<br>";
        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $dieukientotnghiep . "</p>";


        ////////////////////////////////////////CẤU TRÚC CHƯƠNG TRÌNH////////////////////////////////////////////////////
        
        echo "
        <h3 style='text-transform: uppercase '>
            <strong style='font-weight: 600; font-family: auto;'>6. <span style='text-decoration:underline'>CẤU TRÚC CHƯƠNG TRÌNH
            </span></strong>
        </h3>"; 



        ////////////////////////////////////////NỘI DUNG CHƯƠNG TRÌNH////////////////////////////////////////////////////
        echo "
        <h3 style='text-transform: uppercase '>
            <strong style='font-weight: 600; font-family: auto;'>7. <span style='text-decoration:underline'>nội dung CHƯƠNG TRÌNH
            </span></strong>
        </h3>"; echo "<br>";


        
        $arr_tem = array();
        foreach($arr_khoikienthuc as $iarr_khoikienthuc){ // tim va gan list mon bb vao moi khoi
            $iarr_khoikienthuc['list_monhoc'] = array();

            if(count($iarr_khoikienthuc['mon_BB'] > 0)){
                
                $arr_mon_BB = $iarr_khoikienthuc['mon_BB'];
                

                $monhoc = find_monhoc_BB($arr_monhoc, $arr_mon_BB);

                
                $arr_tem[] = ['list_monhoc'=>$monhoc, 'ma_khoi'=>$iarr_khoikienthuc['ma_khoi'], 'ten_khoi'=>$iarr_khoikienthuc['ten_khoi'],
                'mota'=>$iarr_khoikienthuc['mota'], 'mon_BB'=>$iarr_khoikienthuc['mon_BB']];
                

            }

            
            
        } // tra ve ban copy cua arr_khoikienthuc co chua list_monhoc

        
        $arr_tem1 = array(); // cay sau khi tong hop du lieu

        foreach($arr_tem as $iarr_tem){
            foreach($arr_caykhoikienthuc as $iarr_caykhoikienthuc){

                if($iarr_tem['ma_khoi'] == $iarr_caykhoikienthuc['ma_khoi']){
                    
                   $arr_tem1[] = ['ma_caykhoikienthuc'=>$iarr_caykhoikienthuc['ma_caykhoikienthuc'] , 'ma_tt'=>$iarr_caykhoikienthuc['ma_tt'], 'ma_khoi'=>$iarr_caykhoikienthuc['ma_khoi'],
                    'ma_khoicha'=>$iarr_caykhoikienthuc['ma_khoicha'], 'ten_cay'=>$iarr_caykhoikienthuc['ten_cay'], 'mota'=>$iarr_caykhoikienthuc['mota'], 'danhdau'=>$iarr_caykhoikienthuc['danhdau'],
                   'list_monhoc'=>$iarr_tem['list_monhoc'], 'mon_BB'=>$iarr_tem['mon_BB'], 'ten_khoi'=>$iarr_tem['ten_khoi']];
                }else 
                if(($iarr_caykhoikienthuc['ma_tt'] == null || $iarr_caykhoikienthuc['ma_tt'] == '') && 
                ($iarr_caykhoikienthuc['ma_khoicha'] == null || $iarr_caykhoikienthuc['ma_khoicha'] == '')){
                    // node root
                    $arr_tem1[] = ['ma_caykhoikienthuc'=>$iarr_caykhoikienthuc['ma_caykhoikienthuc'] , 'ma_tt'=>$iarr_caykhoikienthuc['ma_tt'], 'ma_khoi'=>$iarr_caykhoikienthuc['ma_khoi'],
                    'ma_khoicha'=>$iarr_caykhoikienthuc['ma_khoicha'], 'ten_cay'=>$iarr_caykhoikienthuc['ten_cay'], 'mota'=>$iarr_caykhoikienthuc['mota'], 'danhdau'=>$iarr_caykhoikienthuc['danhdau']];
                }
            }
        }
        
        
        
        
        // tim node lon nhat
        $node_root = get_root_node($arr_tem1);

        

        // tim tat ca cac khoi nho hon, co chung ma_cay_khoikienthuc
        $node_conlai = get_all_thanhphan_cay($arr_tem1, $node_root['ma_caykhoikienthuc']);

        
        ////////////////////////PRINT////////////////////////

        
        //in cac node con ra
        print_any($node_conlai, $node_root);


        $is_check_ctdt_hople = check_ctdt_hople($arr_thongtin_ctdt);

        if(!$is_check_ctdt_hople){ // hople
            echo 'Chương trình đào tạo <strong>'.$arr_thongtin_ctdt[1]['ma_ctdt'] . ' - ' . $arr_thongtin_ctdt[1]['ten_chuongtrinh']. '</strong> không hợp lệ hoặc đã tồn tại'; 
            echo "<br>";
        }
        if($is_check_ctdt_hople){
            echo "<strong style='text-decoration: underline;'>LOG</strong>"; echo "<br>";
    
            /////////////////////////////////CREATE MONHOC/////////////////////////////////
    
            foreach($arr_monhoc as $iarr_monhoc){
                
    
                $param_monhoc = new stdClass();
    
                $param_monhoc->mamonhoc = $iarr_monhoc['mamonhoc'];
                $param_monhoc->tenmonhoc_vi= $iarr_monhoc['tenmonhoc'];
                $param_monhoc->tenmonhoc_en= '';
                $param_monhoc->lopmo= '';
                $param_monhoc->loaihocphan= $iarr_monhoc['loaihocphan'];
                $param_monhoc->sotinchi= $iarr_monhoc['sotc'];
                $param_monhoc->sotietlythuyet= $iarr_monhoc['sotiet_lt'];
                $param_monhoc->sotietthuchanh= $iarr_monhoc['sotiet_th'];
                $param_monhoc->sotiet_baitap= $iarr_monhoc['sotiet_bt'];
                $param_monhoc->ghichu= $iarr_monhoc['ghichu'];
                $param_monhoc->mota= '';
    
                $is_check_monhoc = requiredRules('eb_monhoc', 'mamonhoc', $param_monhoc->mamonhoc);
                
                if(!$is_check_monhoc){
                    echo 'Môn học <strong>'.$param_monhoc->mamonhoc . ' - ' . $param_monhoc->tenmonhoc_vi . '</strong> không hợp lệ hoặc đã tồn tại'; 
                    echo "<br>";
                }
    
    
            }
    
    
            /////////////////////////////////CREATE KHOI KIEN THUC////////////////////////////////
            
    
            foreach($arr_tem1 as $iarr_tem1){ // vcay khoi kien thuc
    
                $param_khoikienthuc = new stdClass();
    
                $param_khoikienthuc->ma_khoi = $iarr_tem1['ma_khoi'];
                $param_khoikienthuc->id_loai_kkt;
                $param_khoikienthuc->co_dieukien;
                $param_khoikienthuc->ma_dieukien;
                $param_khoikienthuc->ten_khoi = $iarr_tem1['ten_khoi'];
                $param_khoikienthuc->mota = $iarr_tem1['mota'];
                
    
    
                $is_check_khoikienthuc = requiredRules('eb_khoikienthuc', 'ma_khoi', $param_khoikienthuc->ma_khoi);
                $is_check_monthuockhoi = check_monthuockhoi('eb_monthuockhoi', $param_khoikienthuc->ma_khoi,  $iarr_tem1['list_monhoc']);
                $is_check_caykhoikienthuc = requiredRules('eb_cay_khoikienthuc', 'ma_cay_khoikienthuc', $param_khoikienthuc->ma_khoi);
    
                if(!$is_check_khoikienthuc){
                    echo 'Khối kiến thức <strong>'.$param_khoikienthuc->ma_khoi. ' - ' .$param_khoikienthuc->ten_khoi  . '</strong> không hợp lệ hoặc đã tồn tại'; 
                    echo "<br>";
                }
                if(!$is_check_monthuockhoi){
                    echo 'Môn thuộc khối <strong>'.$param_khoikienthuc->ma_khoi. ' - ' .$param_khoikienthuc->ten_khoi  . '</strong> không hợp lệ hoặc đã tồn tại';
                    echo "<br>";
                }
                if(!$is_check_caykhoikienthuc){
                    echo 'Cây khối kiến thức <strong>'.$iarr_tem1['ma_caykhoikienthuc']. ' - ' .$iarr_tem1['ten_cay']  . '</strong> không hợp lệ hoặc đã tồn tại';                 
                    echo "<br>";
                }
                
                
            }
            
        }
        if(count($arr_thongtin_ctdt)>0 && count($arr_muctieuchung)>0 && count($arr_muctieucuthe)>0 &&
        count($arr_chuandaura_ctdt)>0 && count($arr_cohoinghenghiep)>0 && count($arr_khoikienthuc)>0
        && count($arr_caykhoikienthuc)>0 && count($arr_monhoc)>0){
            $mform2->display();
        }else{
            echo "<h2 style='color: #960202;font-weight: 350; text-decoration: underline;'>Dữ liệu trống hoặc không đủ để mở đề cương</h2>";
        }
    }

}

function insert($table_name, $param){
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record($table_name, $param);
}

function requiredRules($db_name, $sen, $des){
    global $DB, $USER, $CFG, $COURSE;
    $item = $DB->get_record($db_name, [$sen=>$des]);
    
    if($item){
        return false;
    }
    return true;

}
function check_monthuockhoi($table_name, $ma_khoi, $arr_monhoc){

    global $DB, $USER, $CFG, $COURSE;

    

    foreach($arr_monhoc as $iarr_monhoc){

        $item = $DB->get_record($table_name, ['ma_khoi'=>$ma_khoi, 'mamonhoc'=>$iarr_monhoc['mamonhoc']]);    

        if($item){
            return false;
        }

    }
    return true;
}

function get_khoikienthuccon($arr_khoikienthuc, $arr_khoicon){
    $arr_result = array();
    $arr_mon = array('monhoc'=>[]);
    

    foreach($arr_khoicon as $iarr_khoicon){
        foreach($arr_khoikienthuc as $iarr_khoikienthuc){
        
            if($iarr_khoikienthuc['ma_khoi'] == $iarr_khoicon){ // tim thay khoi con
                
                // $monhoc = find_monhoc_BB($arr_monhoc, $iarr_khoikienthuc['mon_BB']);
                // $arr_mon[] = $monhoc;
                
                $arr_result[] = $iarr_khoikienthuc;
                
            }

        }

        
    }
    

    return $arr_result;
}
function find_monhoc_BB($arr_monhoc ,$arr_khoicon){
        $arr =  array();
        foreach($arr_khoicon as $iarr_khoicon){

            
            foreach($arr_monhoc as $iarr_monhoc){
                
                if($iarr_monhoc['mamonhoc'] == $iarr_khoicon){
                    $arr[] = $iarr_monhoc;
                    
                }
            }
        }
    return $arr;
    
}
function find_chuandaura_con($arr, $ma_cdr, $level){

    $arr_result = array();

    foreach($arr as $iarr){
        if($iarr['level'] == $level){

            if(startsWith($iarr['ma_cdr'], $ma_cdr)){
                $arr_result[] = $iarr;
            }

        }
    }
    return $arr_result;
}

function get_root_node($arr_caykhoikienthuc){

    return current(array_filter($arr_caykhoikienthuc, function($e) { return $e['ma_tt']==null || $e['ma_tt']== ''  || $e['ma_khoicha']==null   || $e['ma_khoicha']==''; }));
    
}
function get_khoi_cha($arr_caykhoikienthuc, $ma_khoi_cha){

    return current(array_filter($arr_caykhoikienthuc, function($e) use($ma_khoi_cha) { return $e['ma_khoi']==$ma_khoi_cha; }));
}
function get_all_thanhphan_cay($arr_caykhoikienthuc, $ma_cay_khoikienthuc_cha){

    $arr = array();

    foreach($arr_caykhoikienthuc as $iarr_caykhoikienthuc){ 

        if( ($iarr_caykhoikienthuc['ma_tt'] != null || $iarr_caykhoikienthuc['ma_tt'] != '') && 
            ($iarr_caykhoikienthuc['ma_khoicha'] != null || $iarr_caykhoikienthuc['ma_khoicha'] != '') ){
            
            if($iarr_caykhoikienthuc['ma_caykhoikienthuc'] == $ma_cay_khoikienthuc_cha){
                $arr[] =  $iarr_caykhoikienthuc;
            }
        }
    }

    return $arr;
}
function add_contentkhoi_to_khoi($arr_caykhoikienthuc, $arr_khoikienthuc){
    
    

    foreach($arr_khoikienthuc as $iarr_khoikienthuc){
        

        // $khoi = array_filter($arr_caykhoikienthuc, function($e) { return $e['ma_khoi']== $iarr_khoikienthuc['ma_khoi'] ; });
        $arr = array();
        
        foreach($arr_caykhoikienthuc as $iarr_caykhoikienthuc){
            
            $iarr_caykhoikienthuc['list_monhoc'] = array();

            if($iarr_caykhoikienthuc['ma_khoi'] == $iarr_khoikienthuc['ma_khoi']){
                

                $iarr_caykhoikienthuc['list_monhoc'] = $iarr_khoikienthuc['list_monhoc'];
                
            }
        }

        
    }
}

function find_mininode($arr_tem1, $node_root){
    $arr = array();

    foreach($arr_tem1 as $iarr_tem1){
        if($iarr_tem1['ma_khoicha'] == $node_root['ma_khoi'] &&  !$iarr_tem1['danhdau'] &&  !$iarr_tem1['ten_cay']){
            $arr[]  = $iarr_tem1;    
        }
    }
    return $arr;
    // return array_filter($arr_tem1, function($e) { return  $node_root['ma_khoi'] == $e['ma_khoicha']; });
}
function find_nodecon($arr_tem1, $node_root){
    $arr = array();

    foreach($arr_tem1 as $iarr_tem1){
        if($iarr_tem1['ma_khoicha'] == $node_root['ma_khoi']){
            $arr[]  = $iarr_tem1;    
        }
    }
    return $arr;
    // return array_filter($arr_tem1, function($e) { return  $node_root['ma_khoi'] == $e['ma_khoicha']; });
}
function print_any($node_conlai, $node_root){

    $arr_bandau = $node_conlai; // mang ban dau;
    $noderoot = $node_root; // nut root 

    $arr_tam = find_nodecon($arr_bandau, $noderoot);

    if($node_root['danhdau'] && count($node_root['list_monhoc']) == 0){
        

        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>"
        . $node_root['danhdau'].'. '. $node_root['ten_cay'].
        "</strong></h3>"; echo "<br>";

        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $node_root['mota'] . "</p>";
    }
    
    
    

    foreach($arr_tam as $iarr_tam){

        

        if(count($iarr_tam['list_monhoc']) > 0){
            
                
            
            $table =  new html_table();
            if($iarr_tam['danhdau']){ //cac khoi chinh

                $arr_mini_node = find_mininode($arr_bandau, $iarr_tam);

                $table->head = ['STT', 'MÃ HỌC PHẦN', 'TÊN HỌC PHẦN', 'SỐ TC', 'LÝ THUYẾT', 'THỰC HÀNH', 'BÀI TẬP', 'LOẠI HỌC PHẦN', 'GHI CHÚ'];

                $idx=1;
                foreach($iarr_tam['list_monhoc'] as $imonhoc){
                                    
                    $table->data[] = [$idx,$imonhoc['mamonhoc'], $imonhoc['tenmonhoc'], $imonhoc['sotc'], $imonhoc['sotiet_lt'],
                    $imonhoc['sotiet_th'], $imonhoc['sotiet_bt'], $imonhoc['loaihocphan'], $imonhoc['ghichu']];
                    $idx ++ ;
                }

                if(count($arr_mini_node)==0){

                }else{
                    foreach($arr_mini_node as $iarr_mini_node){
                        $table->data[] = [$idx, $iarr_mini_node['mota'], '','', '','','', '',''];

                        foreach($iarr_mini_node['list_monhoc'] as $i_mini_node_monhoc){
                            $table->data[] = ['',$i_mini_node_monhoc['mamonhoc'], $i_mini_node_monhoc['tenmonhoc'], $i_mini_node_monhoc['sotc'], $i_mini_node_monhoc['sotiet_lt'],
                            $i_mini_node_monhoc['sotiet_th'], $i_mini_node_monhoc['sotiet_bt'], $i_mini_node_monhoc['loaihocphan'], $i_mini_node_monhoc['ghichu']];
                        }
                    }
                    
                }

                echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>"
                . $iarr_tam['danhdau'].'. '. $iarr_tam['ten_cay'].
                "</strong></h4>"; echo "<br>";

                echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $iarr_tam['mota'] . "</p>";
                

            }

           
            echo html_writer::table($table);
        }

        
        if(count($arr_tam) > 0){
            print_any($arr_bandau, $iarr_tam);
        }
        
    }

    
}
function check_ctdt_hople($arr_thongtin_ctdt){
    global $DB, $USER, $CFG, $COURSE;
    

    $ctdt = $DB->get_records('eb_ctdt', ['ma_ctdt'=>$arr_thongtin_ctdt[1]['ma_ctdt'],'ma_bac'=>$arr_thongtin_ctdt[1]['ma_bac'], 'ma_he'=>$arr_thongtin_ctdt[1]['ma_he'],
     'ma_nienkhoa'=>$arr_thongtin_ctdt[1]['ma_nienkhoa'], 'ma_nganh'=>$arr_thongtin_ctdt[1]['ma_nganh'], 'ma_chuyennganh'=>$arr_thongtin_ctdt[1]['ma_chuyennganh']]);

    if(count($ctdt) == 0){
        return true; 
    }
    return false;
}
// function check_table_db_thanhphan($db_name, $sen, $des, $arr_thongtin_ctdt){
//     global $DB, $USER, $CFG, $COURSE;
//     return $DB->get_record($db_name, [$sen => $arr_thongtin_ctdt[1][$des]]);
// }
function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
// Footer
echo $OUTPUT->footer();