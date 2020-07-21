<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');

global $COURSE,$DB;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/lopmo/create.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add("Danh sách lớp mở", new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php'));
$PAGE->navbar->add('Mở lớp học');
// Title.
$PAGE->set_title("Mở lớp học" );
$PAGE->set_heading(get_string('head_molopmo', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();




//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/lopmo/mo_lopmo_form.php');
$mform = new mo_lopmo_form();



if ($mform->is_cancelled()) {
    // echo '<h2>Thêm không thành công</h2>';
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/lopmo/index.php');
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    // Thực hiện insert
    $param1 = new stdClass();



    $param1->id = $fromform->idlopmo;
    $param1->ma_ctdt = $fromform->ma_ctdt;
    $param1->mamonhoc = $fromform->mamonhoc1;
    $param1->nam_hoc = $fromform->start_year;
    $param1->hoc_ky = $fromform->start_semester;
    $param1->assign_to = $fromform->assign_to;
    $param1->mota = $fromform->mota;
    $param1->start_date = $fromform->start_year;
    $param1->end_date = $fromform->start_year;
 
    $amount = intval($fromform->amount);
    if ($amount <=1 ){  
        $param1->full_name = $fromform->fullname;
        $param1->short_name = $fromform->shortname; 
        insert_lopmo($param1);

    }else{
        $mamonhoc= $fromform->mamonhoc1;
        $ma_ctdt= $fromform->ma_ctdt;
        for($x = 0 ; $x < $amount ; $x++){
            $result = get_lopmo_from_mamonhoc($mamonhoc,$ma_ctdt);
            $monhoc = $DB->get_record('eb_monhoc',array('mamonhoc' => $mamonhoc));
            $param1->full_name = $monhoc->tenmonhoc_vi . $result;
            $param1->short_name = $monhoc->mamonhoc . $result;
            insert_lopmo($param1);
          }

    }
    

    // Hiển thị thêm thành công
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';
    //link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    $linktext = get_string('label_lopmo', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    


} else if ($mform->is_submitted()) {
    // echo '<h2>Nhập sai thông tin</h2>';
    // $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []);
    // $linktext = get_string('label_lopmo', 'block_educationpgrs');
    // echo \html_writer::link($url, $linktext);
    $mform->display();
} else {
    
    $mform->set_data($toform);
    $mform->display();
}

 // Footere


 function get_lopmo_from_mamonhoc($mamonhoc , $ma_ctdt) {

    global $DB, $USER, $CFG, $COURSE;
    $ctdt = $DB->get_record('eb_ctdt',array('ma_ctdt' => $ma_ctdt));

    $lopmo = $DB->get_records('eb_lop_mo', array('mamonhoc' => $mamonhoc , 'ma_nienkhoa' => $ctdt->ma_nienkhoa, 'ma_nganh'=> $ctdt->ma_nganh, 'ma_ctdt' => $ctdt->ma_ctdt ));

    usort($lopmo, function($a, $b)
    {
       return strcmp($a->full_name, $b->full_name);
    });


    $len2 = 1 ; 
    if (count($lopmo)  >= 1){
      $maxOld = 0 ;
      $maxResult = 0 ;
      $maxNew = 0 ;
      foreach ($lopmo as $item ){
        $fullname_split = explode("_",$item->full_name);
        $stt = intval($fullname_split[1][1]) ;
        $maxOld = $maxNew;
        if($stt > $maxNew){
          $maxNew = $stt ; 
        }
        if (($maxNew-$maxOld)>1 && $maxResult == 0 ){
          $maxResult = $maxOld  + 1 ; 
        }
      }
      $maxNew = $maxNew + 1;
      $len2 = ($maxResult == 0 ? $maxNew : $maxResult) ;
    }
    
    $chuyennganhdts = $DB->get_records('eb_chuyennganhdt' ,['ma_nganh' => $ctdt->ma_nganh]);
    $temparray = array();

    foreach($chuyennganhdts as $item){
      $temparray [] =& $item->ma_chuyennganh;
    }
    $currentchuyennganhdt = $DB->get_record('eb_chuyennganhdt',array('ma_chuyennganh' => $ctdt->ma_chuyennganh));
    $index = array_search($currentchuyennganhdt->ma_chuyennganh,$temparray);
    $index = $index + 1 ;

    $rsx =  ' ' . $ctdt->ma_nienkhoa . '_' . $index . $len2;
    // echo "Rsx" . $rsx;
    return $rsx;
    
}
echo $OUTPUT->footer();

 ?>
