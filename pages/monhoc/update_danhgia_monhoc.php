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
$chitietmh = get_danhgiamonhoc_by_mamonhoc_1($id);
$mform = new update_danhgia_decuongmonhoc_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();    
    $param1->id = $fromform->id;
    $param1->mamonhoc = $fromform->mamonhoc;
    $param1->madanhgia = $fromform->madanhgia;
    $param1->tendanhgia = $fromform->tendanhgia;
    $param1->motadanhgia = $fromform->motadanhgia;
    // $param1->chuandaura_danhgia = $fromform->cacchuandaura_danhgia;
    $param1->tile_danhgia = $fromform->tile_danhgia;
    $tem = $fromform->cacchuandaura_danhgia;
    $tem1;
    if(count($tem) == 1){
        $param1->chuandaura_danhgia = $tem[0];
    }elseif (count($tem)==0) {
        $param1->chuandaura_danhgia = null;
    }
    else{
        
        foreach($tem as $item){
            
            $tem1 .= $item . ', ';
            
        }
        $param1->chuandaura_danhgia = substr($tem1, 0, -2);
    }


    update_danhgiamonhoc_table($param1);
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';

    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php', ['ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc, 'ma_decuong'=>$ma_decuong]);
    echo \html_writer::link($url, 'Trở về trang trước');
} else if ($mform->is_submitted()) {
    // Button submit
} else {
    $list_cdr=get_list_cdr($id);

    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;

    $toform->madanhgia = $chitietmh->madanhgia;
    $toform->tendanhgia = $chitietmh->tendanhgia;
    $toform->motadanhgia = $chitietmh->motadanhgia;
    $toform->cacchuandaura_danhgia = $list_cdr;
    //echo json_encode($toform->cacchuandaura_danhgia);
    $toform->tile_danhgia = $chitietmh->tile_danhgia;
    $mform->set_data($toform);
    $mform->display();
}

// Print footer
echo $OUTPUT->footer();
function get_list_cdr($id) {
    global $DB, $USER, $CFG, $COURSE;
    $list_cdr = $DB->get_records('eb_danhgiamonhoc', ['id'=>$id]);

    $list_cdr1 = array();
    foreach ($list_cdr as $item) {
        $arr = explode(', ', $item->chuandaura_danhgia);
        if(!empty($arr)){
            if(count($arr) == 1){
                $list_cdr1[] = $item->chuandaura_danhgia;
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


function get_danhgiamonhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Mã', 'Tên', 'Mô tả (gợi ý)', 'Các chuẩn', 'Tỷ lệ (%)');
   $alldatas = $DB->get_records('eb_danhgiamonhoc', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_danhgiamonhoc.php', ['id' => $idata->id]);
      $ten_url = \html_writer::link($url, $idata->tendanhgia);
      $checkbox = html_writer::tag('input', ' ', array('class' => 'danhgiamonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'danhgiamonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_danhgiamonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, (string) $idata->madanhgia, $ten_url, (string) $idata->motadanhgia, (string) $idata->chuandaura_danhgia, (string) $idata->tile_danhgia];
      $stt = $stt + 1;
   }
   return $table;
}