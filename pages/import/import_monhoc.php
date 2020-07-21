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
$PAGE->navbar->add(get_string('label_monhoc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php'));

// Title.
$PAGE->set_title(get_string('label_quanly_decuong', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import môn học');
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


$form = new form1();$mform2 = new form2();$array_toDB = array(); $table = new html_table(); // new table



//////////////////////////////////FORM 1 //////////////////////////////////

if ($form->is_cancelled()) {
    
} else if ($form->no_submit_button_pressed()) {
    
} else if ($fromform = $form->get_data()) {

    $name = $form->get_new_filename('userfile');


    $rex = $form->save_temp_file('userfile');

    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/import/import_monhoc.php?linkto='.$rex);

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
            
            
            if($data[0] == 1 || $data[0] == '1'){

                $arr[] = ['mamonhoc'=> $data[1], 'tenmonhoc_vi'=>$data[2], 'tenmonhoc_en'=>$data[3], 'lopmo'=>$data[4],
                'loaihocphan'=> $data[5], 'sotinchi'=>$data[6], 'sotietlythuyet'=>$data[7], 'sotietthuchanh'=>$data[8],
                'sotiet_baitap'=> $data[9], 'ghichu'=>$data[10], 'mota'=>$data[11]
                ];

                

                foreach($arr as $iarr){
                    
                    $param = new stdClass();

                    $param->mamonhoc = $iarr['mamonhoc'];
                    $param->tenmonhoc_vi = $iarr['tenmonhoc_vi'];
                    $param->tenmonhoc_en = $iarr['tenmonhoc_en'];
                    $param->lopmo = $iarr['lopmo'];
                    $param->loaihocphan = $iarr['loaihocphan'];
                    $param->sotinchi = $iarr['sotinchi'];
                    $param->sotietlythuyet = $iarr['sotietlythuyet'];
                    $param->sotietthuchanh = $iarr['sotietthuchanh'];
                    $param->sotiet_baitap = $iarr['sotiet_baitap'];
                    $param->ghichu = $iarr['ghichu'];
                    $param->mota = $iarr['mota'];
                    
                    $arr_2 = get();

                    $check = is_check($param->mamonhoc, $arr_2);
                    
                    if($check){
                        
                        insert_cdr($param);
                        
                        
                    }

                    
                }
            }
        }
        fclose($handle);
    }
    
    
} else if ($mform2->is_submitted()) {
} else {


    $toform;
    $toform->link = $link;
    $mform2->set_data($toform);

    if($link != null){

        $arr_monhoc = array();

        if (($handle = fopen( $link, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                

                
                
                if($data[0] == 1 || $data[0] == '1'){

                    $arr_monhoc[] = ['mamonhoc'=> $data[1], 'tenmonhoc_vi'=>$data[2], 'tenmonhoc_en'=>$data[3], 'lopmo'=>$data[4],
                    'loaihocphan'=> $data[5], 'sotinchi'=>$data[6], 'sotietlythuyet'=>$data[7], 'sotietthuchanh'=>$data[8],
                    'sotiet_baitap'=> $data[9], 'ghichu'=>$data[10], 'mota'=>$data[11]
                    ];

                }
                
            }
            fclose($handle);
        }
        

        
        $table->head = ['Mã môn học','Tên môn học (Tiếng Việt)', 'Tên môn học (Tiếng Anh)', 'Lớp mở', 'Loại học phần',
        'Số TC', 'Số tiết lý thuyết', 'Số tiết thực hành', 'Số tiết bài tập', 'Ghi chú', 'Mô tả'];

        foreach($arr_monhoc as $iarr_monhoc){
            
            $arr_2 = get();
            $check = is_check($iarr_monhoc['mamonhoc'], $arr_2);
                    
            if($check){
                $table->data[] = [ $iarr_monhoc['mamonhoc'], $iarr_monhoc['tenmonhoc_vi'],$iarr_monhoc['tenmonhoc_en'],$iarr_monhoc['lopmo'],
                $iarr_monhoc['loaihocphan'], $iarr_monhoc['sotinchi'], $iarr_monhoc['sotietlythuyet'],$iarr_monhoc['sotietthuchanh'],
                $iarr_monhoc['sotiet_baitap'], $iarr_monhoc['ghichu'],$iarr_monhoc['mota']];
            }
        }

       

        if(count($table->data)>0){
            echo html_writer::table($table);
            $mform2->display();
            
        }else{
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Không tìm thấy môn học mới</h2>";
        }
        
    }

}

function insert_cdr($param){
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('eb_monhoc', $param);
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
            return false;
        }
    }
    return true;
}


// Footer
echo $OUTPUT->footer();