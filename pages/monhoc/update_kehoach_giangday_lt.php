<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
require_once('../../js.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_decuong', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
$id = optional_param('id', 0, PARAM_INT);
$ma_decuong = optional_param('ma_decuong', '', PARAM_ALPHANUMEXT);
$ma_ctdt = optional_param('ma_ctdt', '', PARAM_ALPHANUMEXT);
$mamonhoc = optional_param('mamonhoc', '', PARAM_ALPHANUMEXT);

require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');
$chitietmh = get_kehoachgiangday_LT_by_mamonhoc_1($id);
$mform = new update_giangday_LT_decuongmonhoc_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();
    $param1->id = $fromform->id;
    $param1->mamonhoc = $fromform->mamonhoc;
    $param1->ten_chude = $fromform->chudegiangday;
    //$param1->danhsach_cdr = $fromform->danhsach_cdr;
    $param1->hoatdong_gopy = $fromform->hoatdong_giangday;
    $param1->hoatdong_danhgia = $fromform->hoatdong_danhgia;
    $tem = $fromform->danhsach_cdr;
    //echo($tem);
    $tem1;

    if(count($tem) == 1){
        $param1->danhsach_cdr = $tem[0];
    }elseif (count($tem)==0) {
        $param1->danhsach_cdr = null;
    }
    else{
        
        foreach($tem as $item){
            
            $tem1 .= $item . ', ';
            
        }
        $param1->danhsach_cdr = substr($tem1, 0, -2);
    }

    //echo($param1->danhsach_cdr);
    update_kehoachgiangday_lt_table($param1);
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php', ['ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc, 'ma_decuong'=>$ma_decuong]);
    echo \html_writer::link($url, 'Trở về trang trước');
} else if ($mform->is_submitted()) {
    // Button sumbit
} else {

    $list_cdr=get_list_cdr($id);

    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;

    $toform->chudegiangday = $chitietmh->ten_chude;
    $toform->danhsach_cdr = $chitietmh->danhsach_cdr;
    $toform->hoatdong_giangday = $chitietmh->hoatdong_gopy;
    $toform->hoatdong_danhgia = $chitietmh->hoatdong_danhgia;
    $toform->danhsach_cdr  = $list_cdr;
    //echo json_encode($toform->danhsach_cdr);
    $mform->set_data($toform);
    $mform->display();
}

// Print footer
echo $OUTPUT->footer();
function get_list_cdr($id) {
    global $DB, $USER, $CFG, $COURSE;
    $list_cdr = $DB->get_records('eb_kh_giangday_lt', ['id'=>$id]);

    $list_cdr1 = array();
    foreach ($list_cdr as $item) {
        $arr = explode(', ', $item->danhsach_cdr);
        if(!empty($arr)){
            if(count($arr) == 1){
                $list_cdr1[] = $item->danhsach_cdr;
            } else{
                foreach ($arr as $i) {
                    $list_cdr1[] = $i;
                }
            }
        }
    }
    //echo json_encode($list_cdr1); echo "<br>";
    return $list_cdr1;
}


function get_kehoachgiangday_LT_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Chủ đề', 'Chuẩn đầu ra', 'Hoạt động giảng dạy/Hoạt động học (gợi ý)', 'Hoạt động đánh giá');
   $alldatas = $DB->get_records('eb_kh_giangday_lt', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_kehoachgiangday_lt.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link($url, $idata->ten_chude);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'kehoachgiangday_LT_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'kehoachgiangday_LT' . $idata->id, 'value' => '0', 'onclick' => "changecheck_kehoachgiangday_LT($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->danhsach_cdr, (string) $idata->hoatdong_gopy, (string) $idata->hoatdong_danhgia];
      $stt = $stt + 1;
   }
   return $table;
}