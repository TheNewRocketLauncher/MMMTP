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
require_permission("monhoc", "edit");


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
$chitietmh = get_muctieu_monmhoc_by_mamonhoc_1($id);
$mform = new update_muctieumonhoc_decuongmonhoc_form();

$muctieu=$chitietmh->muctieu;
//echo($muctieu);

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    
    $param1 = new stdClass();
    $param1->id = $mform->get_data()->id;
    $param1->mamonhoc = $mform->get_data()->mamonhoc;
    $param1->muctieu = $chitietmh->muctieu;
    $param1->mota = $mform->get_data()->mota_muctieu_muctieumonhoc;
    $tem = $mform->get_data()->chuandaura_cdio_muctieumonhoc;
    $tem1;

    if(count($tem) == 1){
        $param1->danhsach_cdr = $tem[0];
    }elseif (count($tem)==0) {
        $param1->danhsach_cdr = null;
    }
    else{
        foreach($tem as $item){
            if($item!= null && $item != ''){
                $tem1 .= $item . ', ';    
            }
            
            
        }
        $param1->danhsach_cdr = substr($tem1, 0, -2);
    }
    
    
    update_muctieumonhoc_table($param1);
    echo '<br>';

    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php', ['ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc, 'ma_decuong'=>$ma_decuong]);
    echo \html_writer::link($url, 'Trở về trang trước');
    
} else if ($mform->is_submitted()) {
    // Button submit
} else {
    
    $list_cdr=get_list_cdr($muctieu);
    
    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;
    $toform->mamonhoc = $mamonhoc;

    $toform->muctieu_muctieumonhoc = $chitietmh->muctieu;
    $toform->mota_muctieu_muctieumonhoc = $chitietmh->mota;

    $toform->chuandaura_cdio_muctieumonhoc  = $list_cdr;
    
 
    $mform->set_data($toform);
    $mform->display();
}
 
// Print footer
echo $OUTPUT->footer();

function get_list_cdr($muctieu) {
    global $DB, $USER, $CFG, $COURSE;
    $list_cdr = $DB->get_records('eb_muctieumonhoc', ['muctieu'=>$muctieu]);

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
    return $list_cdr1;
}


function get_muctieu_monmhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Mục tiêu', 'Mô tả', 'Chuẩn đầu ra');
   $alldatas = $DB->get_records('eb_muctieumonhoc', array('mamonhoc' => $mamonhoc));
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_muctieumonhoc.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link($url, $idata->muctieu);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'muctieumonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'muctieumonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_muctieumonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $idata->mota, (string) $idata->danhsach_cdr];
      $stt = $stt + 1;
   }
   return $table;
}