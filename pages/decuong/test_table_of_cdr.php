<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/decuong_model.php');


global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$ma_ctdt = trim(optional_param('ma_ctdt', '', PARAM_NOTAGS));
if(!$ma_ctdt){
    $ma_ctdt=0;
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
$PAGE->set_heading('Môn học By Chuẩn đầu ra CTDT');
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

global $DB; $arr = array();

////////////////////////NEW RECORDs HERE///////////////////////////

// $arr = $DB->get_records('block_edu_chuandaura_ctdt', ['ma_ctdt'=> 'CTDT2020'], '', 'ma_cdr');

// foreach($arr as $iarr){
//     echo $iarr->ma_cdr;
//     echo "<br>";
// }

////////////////////////NEW RECORDs HERE///////////////////////////

////////////////////////FORM///////////////////////////

class mform1 extends moodleform{
    public function definition(){
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;

        $mform->addElement('header', 'general_thong_tin_monhoc', 'Chọn chương trình đào tạo');
        $arr_ctdt = array();
        $arr_ctdt += ["0" => "Chọn chương trình đào tạo"];

        $all_ctdt = $DB->get_records('block_edu_ctdt', array(), '');
        foreach ($all_ctdt as $ictdt) {
            $arr_ctdt += ['ma_ctdt' => $ictdt->ma_ctdt];
            // , 'ma_bac'=> $ictdt->ma_bac, 'ma_he'=> $ictdt->ma_he , 'ma_nienkhoa'=> $ictdt->ma_nienkhoa, 'ma_nganh'=> $ictdt->ma_nganh , 'ma_chuyennganh'=> $ictdt->ma_chuyennganh];
        }
    

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'sort_ctdt', 'Chọn chương trình đào tạo', $arr_ctdt );
        $eGroup[] = &$mform->createElement('submit', 'fetch_ctdt_1', 'Show Data',['style'=>"border-radius: 3px; width: 100px; height:40px; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'thongtinchung_group133',  'Chương trình đào tạo', array(' '),  false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'ma_bac', '', 'size=50');
        $mform->addGroup($eGroup, 'ma_bac', 'Thuộc bậc đào tạo', array(' '), false);
        $mform->disabledIf('ma_bac', '');
        

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'ma_he', '', 'size=50');
        $mform->addGroup($eGroup, 'ma_he', 'Thuộc hệ đào tạo', '', false);
        $mform->disabledIf('ma_he', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'ma_nienkhoa', '', 'size=50');
        $mform->addGroup($eGroup, 'ma_nienkhoa', 'Thuộc niên khóa', [], false);
        $mform->disabledIf('ma_nienkhoa', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'ma_nganh', '', 'size=50');
        $mform->addGroup($eGroup, 'ma_nganh', 'Thuộc ngành đào tạo', [], false);
        $mform->disabledIf('ma_nganh', '');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'ma_chuyennganh', '', 'size=50');
        $mform->addGroup($eGroup, 'ma_chuyennganh', 'Thuộc chuyên ngành đào tạo', [], false);
        $mform->disabledIf('ma_chuyennganh', '');
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

$mform = new mform1();


if ($mform->is_cancelled()) {
    
} else if ($mform->no_submit_button_pressed()) {
    
} else if ($fromform = $mform->get_data()) {
    
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/decuong/test_table_of_cdr.php?ma_ctdt='.$mform->get_submit_value('sort_ctdt'));

} else if ($mform->is_submitted()) {
    
    $mform->display();
} else {
    
    $toform;
    

    $all_ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt'=>$ma_ctdt]);
    

    $toform->ma_bac = $all_ctdt->ma_bac;
    $toform->ma_he = $all_ctdt->ma_he;
    $toform->ma_nienkhoa = $all_ctdt->ma_nienkhoa;
    $toform->ma_nganh = $all_ctdt->ma_nganh;
    $toform->ma_chuyennganh = $all_ctdt->ma_chuyennganh;

    $toform->sort_ctdt = $all_ctdt->ma_ctdt;

    $mform->set_data($toform);
    
    $mform->display();
}

////////////////////////FORM///////////////////////////

$arr = $DB->get_records('block_edu_chuandaura_ctdt', ['ma_ctdt'=> $ma_ctdt], '', 'ma_cdr');


usort($arr, function($a,$b){
    return $a<$b?-1:1;
});

$table = new html_table();
$table->head[] = ' ';


$list_monhoc = get_list_monhoc($ma_ctdt);


//header
foreach($arr as $iarr){
    $table->head[] = $iarr->ma_cdr;
}

//data row
$len = count($table->head)-1;



foreach($list_monhoc as $iarr_1){
    $row = array();
    $row[] = "<a href='#'>$iarr_1</a>";

    for($i=0;$i<$len;$i++){ //contructor
    
        $row[] = ' ';
       
    }

    $cdr_monhoc_arr =  get_cdr($iarr_1);

    $len_1 = count($cdr_monhoc_arr);
    
    for($i=0;$i<$len_1;$i++){
            
        for($j=1;$j<$len; $j++){
            if($cdr_monhoc_arr[$i] == $table->head[$j]){
                
                $row[$j] = 'x';
            }
        }
        
    }
    $table->data[] = $row;
}



//print table

echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Biểu đồ</h2>";
echo html_writer::table($table);    





function get_cdr($mamonhoc){
    global $DB, $USER, $CFG, $COURSE;
    
    
    //find de cuong cua tung mon
    // find chuan dau ra cdtd cua de cuong do
    
    $list_ma_decuong =  $DB->get_records('block_edu_decuong', ['mamonhoc'=>$mamonhoc], '', 'ma_decuong');
    $arr = array();

    foreach($list_ma_decuong as $i){
        
        $danhsach_cdr = $DB->get_records('block_edu_muctieumonhoc', ['ma_decuong'=>$i->ma_decuong, 'mamonhoc'=>$mamonhoc], '', 'danhsach_cdr');
        
        foreach($danhsach_cdr as $i){

            $arr[] = $i->danhsach_cdr;
            

        }
        
    }

    $arr_3 = array();
    foreach($arr as $iarr){

        $arr_2 = explode(', ', $iarr);
        
        foreach($arr_2 as $iarr_2){
            
            $arr_3[] = $iarr_2;
        }
    }
    
    usort($arr_3, function($a, $b){
        return  preg_replace("/[^0-9.]/", "", $a)<preg_replace("/[^0-9.]/", "", $b) ? -1:1;
    });
  

    return $arr_3;

    
    
}
function get_list_monhoc($ma_ctdt){
    global $DB, $USER, $CFG, $COURSE; $arr= array();
    

    $ctdt = $DB->get_record('block_edu_ctdt', ['ma_ctdt'=>$ma_ctdt]);
    
    $cay_khoikienthuc = $DB->get_record('block_edu_cay_khoikienthuc', ['ma_cay_khoikienthuc'=>$ctdt->ma_cay_khoikienthuc]);
    

    $list_khoikienthuc = $DB->get_records('block_edu_cay_khoikienthuc', ['ma_khoi'=>$cay_khoikienthuc->ma_khoi]);

    foreach($list_khoikienthuc as $ikhoikienthuc){
        $list_monhoc = $DB->get_records('block_edu_monthuockhoi', ['ma_khoi'=>$ikhoikienthuc->ma_khoi]);

        foreach($list_monhoc as $imonhoc){
            
            $arr[] = $imonhoc->mamonhoc;
        }
    }

    
    return $arr;
}
// Footer
echo $OUTPUT->footer();