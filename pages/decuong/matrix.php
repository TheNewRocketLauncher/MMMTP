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
$PAGE->set_heading('Sơ đồ MATRIX');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

global $DB; $arr = array();

////////////////////////NEW RECORDs HERE///////////////////////////

////////////////////////NEW RECORDs HERE///////////////////////////

////////////////////////FORM///////////////////////////

class mform1 extends moodleform{
    public function definition(){
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;

        $mform->addElement('header', 'general_thong_tin_monhoc', 'Chọn chương trình đào tạo');
        $arr_ctdt = array();
        $arr_ctdt += ["0" => "Chọn chương trình đào tạo"];

        $all_ctdt = $DB->get_records('eb_ctdt', array(), '');
        foreach ($all_ctdt as $ictdt) {
            $arr_ctdt += [$ictdt->ma_ctdt => $ictdt->ma_ctdt];
            // , 'ma_bac'=> $ictdt->ma_bac, 'ma_he'=> $ictdt->ma_he , 'ma_nienkhoa'=> $ictdt->ma_nienkhoa, 'ma_nganh'=> $ictdt->ma_nganh , 'ma_chuyennganh'=> $ictdt->ma_chuyennganh];
        }
    

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'sort_ctdt', 'Chọn chương trình đào tạo', $arr_ctdt );
        $eGroup[] = &$mform->createElement('submit', 'fetch_ctdt_1', 'Show Data',['style'=>"border-radius: 3px; width: 130px; height:40px; padding: 0; background-color: #1177d1; color: #fff"]);
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

        $eGroup = array();
        $eGroup[] = &$mform->createElement('text', 'ten_chuandaura', '', 'size=50');
        $mform->addGroup($eGroup, 'ten_chuandaura', 'Chuẩn đầu ra', [], false);
        $mform->disabledIf('ten_chuandaura', '');
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
    $ma_ctdt = $mform->get_submit_value('sort_ctdt');
    if($ma_ctdt != 0 && $ma_ctdt != '0'){

        redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/decuong/matrix.php?ma_ctdt='.$ma_ctdt);
    }
    

} else if ($mform->is_submitted()) {
    
    $mform->display();
} else {
    
    $toform;
    

    $all_ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt'=>$ma_ctdt]);
    

    $toform->ma_bac = $all_ctdt->ma_bac;
    $toform->ma_he = $all_ctdt->ma_he;
    $toform->ma_nienkhoa = $all_ctdt->ma_nienkhoa;
    $toform->ma_nganh = $all_ctdt->ma_nganh;
    $toform->ma_chuyennganh = $all_ctdt->ma_chuyennganh;

    $toform->sort_ctdt = $all_ctdt->ma_ctdt;
    
    // $toform->ten_chuandaura = $DB->get_record('eb_chuandaura_ctdt',['ma_cdr' => $all_ctdt->chuandaura])->ten;

    $mform->set_data($toform);
    
    // $mform->display();
}

////////////////////////FORM///////////////////////////

$arr = $DB->get_records('eb_chuandaura_ctdt', [], '');


usort($arr, function($a,$b){
    return $a<$b?-1:1;
});

$table = new html_table();
$table->head[] = ' ';


$list_monhoc = get_list_monhoc($ma_ctdt);



//header

$link_cdr = $CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/index.php';
$arr_head = array();
$arr_head[] = ' ';
foreach($arr as $iarr){
    if($iarr->level_cdr != '1' && $iarr->level_cdr != 1){
        $table->head[] = "<a href='$link_cdr'>".$iarr->ma_cdr. "</a>";
        $arr_head[] = ['ma_cdr'=>$iarr->ma_cdr, 'level_cdr'=>$iarr->level_cdr];
    }
    
    
}

//data row
$len = count($table->head)-1;

foreach($list_monhoc as $iarr_1){
    $link = $CFG->wwwroot.'/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php?ma_ctdt='.$iarr_1['ma_ctdt'] . '&ma_decuong='. $iarr_1['ma_decuong'] . '&mamonhoc='. $iarr_1['mamonhoc'];
    $row = array();
    $row[] = "<a href='$link'>"
        .$iarr_1['mamonhoc'].
    "</a>";

    for($i=0;$i<$len;$i++){ //contructor
    
        $row[] = ' ';
       
    }

    $cdr_monhoc_arr =  get_cdr($iarr_1['mamonhoc']);

    $len_1 = count($cdr_monhoc_arr);
    
    for($i=0;$i<$len_1;$i++){
            
        for($j=1;$j<=$len; $j++){
            
            if($cdr_monhoc_arr[$i] == $arr_head[$j]['ma_cdr']){
                
                $row[$j] = 'x';
                for($k = $j + 1; $k <= $len; $k++){
                    
                    if($arr_head[$k]['level_cdr'] > $arr_head[$j]['level_cdr']){
                        $row[$k] = 'x';
                    }
                    
                }

            }
        }
        
    }
    $table->data[] = $row;
}

$rsx_ctdt = $mform->get_submit_value('sort_ctdt');
if($ma_ctdt){
    $toform;
    

    $all_ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt'=>$ma_ctdt]);
    

    $toform->ma_bac = $all_ctdt->ma_bac;
    $toform->ma_he = $all_ctdt->ma_he;
    $toform->ma_nienkhoa = $all_ctdt->ma_nienkhoa;
    $toform->ma_nganh = $all_ctdt->ma_nganh;
    $toform->ma_chuyennganh = $all_ctdt->ma_chuyennganh;

    $toform->sort_ctdt = $all_ctdt->ma_ctdt;
      
    $toform->ten_chuandaura = $DB->get_record('eb_chuandaura_ctdt',['ma_cdr' => $all_ctdt->chuandaura])->ten;

    $mform->set_data($toform);

    $mform->display();
    echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Biểu đồ</h2>";
    echo html_writer::table($table);    
}else{
    $mform->display();
    echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>KHÔNG TÌM THẤY CHƯƠNG TRÌNH ĐÀO TẠO</h2>";
}







function get_cdr($mamonhoc){
    global $DB, $USER, $CFG, $COURSE;
    
    
    //find de cuong cua tung mon
    // find chuan dau ra cdtd cua de cuong do
    
    $list_ma_decuong =  $DB->get_records('eb_decuong', ['mamonhoc'=>$mamonhoc], '', 'ma_decuong');
    $arr = array();

    foreach($list_ma_decuong as $i){
        
        $danhsach_cdr = $DB->get_records('eb_muctieumonhoc', ['ma_decuong'=>$i->ma_decuong, 'mamonhoc'=>$mamonhoc], '', 'danhsach_cdr');
        
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
    

    $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt'=>$ma_ctdt]);

    
    
    $cay_khoikienthuc = $DB->get_record('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc'=>$ctdt->ma_cay_khoikienthuc]);
    
    

    $list_khoikienthuc = $DB->get_records('eb_khoikienthuc', ['ma_khoi'=>$cay_khoikienthuc->ma_khoi]);

    

    foreach($list_khoikienthuc as $ikhoikienthuc){
        $list_monhoc = $DB->get_records('eb_monthuockhoi', ['ma_khoi'=>$ikhoikienthuc->ma_khoi]);
        

        foreach($list_monhoc as $imonhoc){
            $item = $DB->get_record('eb_decuong', ['mamonhoc'=>$imonhoc->mamonhoc]);
            // if($item){
                $arr[] = ['mamonhoc' => $imonhoc->mamonhoc, 'ma_ctdt' => $ma_ctdt, 'ma_decuong'=> $item->ma_decuong];
            // }else{
                // echo "<h4>Môn học <strong> $imonhoc->mamonhoc </strong>chưa có đề cương môn học </h4>";
            // }
        }
    }

    
    return $arr;
}
// Footer
echo $OUTPUT->footer();