<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');

global $COURSE;
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT)) {
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;
$chitietmh = get_monhoc_by_id_monhoc($id);
$mamonhoc=$chitietmh->mamonhoc;

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("monhoc", "edit");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$navbar_name = 'Môn học';
$title_heading = '';
if ($founded_id == true) {
    $navbar_name = $chitietmh->tenmonhoc_vi;
    $title_heading = $chitietmh->tenmonhoc_vi;
} else {
    // Something here
}
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật môn học');
$PAGE->set_heading('Cập nhật môn học ' . $title_heading);
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/decuongmonhoc/update_monhoc_form.php');
$mform = new update_monhoc_form();
$url = new \moodle_url('them_decuongmonhoc.php', ['id' => $id]);



echo '<br>';
// Action
//check môn học có đề cương chưa
$check = check_exist_decuong($mamonhoc);
if($check==0){
    $action_form =
        html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))  
        . '<br>'
            . html_writer::tag(
                'button',
                'Tạo đề cương môn học',          
                array('id' => 'btn_add_decuong', 'onClick' => "window.location.href='them_decuong_head.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 140px; height:35px; padding: 0; background-color: #1177d1; color: white;')
                
            )
        . html_writer::end_tag('div');
    echo $action_form;
}

//cần phải get ma_ctdt và
if($check==1)
{
    $action_form =
        html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))  
        . '<br>'
            . html_writer::tag(
                'button',
                'Sửa đề cương môn học',          
                array('id' => 'btn_update_decuong', 'onClick' => "window.location.href='them_decuongmonhoc.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 150px; height:50px; padding: 0; background-color: #1177d1; color: white;')
                
            )
        . html_writer::end_tag('div');
    echo $action_form;
}

// Process form
if ($mform->is_cancelled()) {
    
    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php?courseid='.$courseid);
} else if($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();
    //$param1->id = $mform->get_data()->id;
    $param1->id = $fromform->idmonhoc;
    $param1->mamonhoc = $mform->get_data()->mamonhoc;
    $param1->tenmonhoc_vi = $mform->get_data()->tenmonhoc_vi;
    $param1->tenmonhoc_en = $mform->get_data()->tenmonhoc_en;
    $param1->sotinchi = $mform->get_data()->sotinchi;
    $param1->sotietlythuyet = $mform->get_data()->sotiet_LT;
    $param1->sotietthuchanh = $mform->get_data()->sotiet_TH;
    $param1->sotiet_baitap = $mform->get_data()->sotiet_BT;
    $param1->loaihocphan = $mform->get_data()->loaihocphan;
    $param1->ghichu = $mform->get_data()->ghichu;
    $param1->mota = $mform->get_data()->mota;
    update_monhoc_table($param1);
    echo '<h2>Cập nhật môn học thành công!</h2>';
    echo '<br>';
    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php', []);
    $linktext = get_string('label_monhoc', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    $mform->display();
} else {
    //Set default data from DB
    $toform;
    $toform->idmonhoc = $chitietmh->id;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $toform->tenmonhoc_vi = $chitietmh->tenmonhoc_vi;
    $toform->tenmonhoc_en = $chitietmh->tenmonhoc_en;
    $toform->sotinchi = $chitietmh->sotinchi;
    $toform->sotiet_LT = $chitietmh->sotietlythuyet;
    $toform->sotiet_TH = $chitietmh->sotietthuchanh;
    $toform->sotiet_BT = $chitietmh->sotiet_baitap;
    $toform->loaihocphan = $chitietmh->loaihocphan;
    $toform->ghichu = $chitietmh->ghichu;
    $toform->mota = $chitietmh->mota;
    
    
    $mform->set_data($toform);
    $mform->display();
}



// Print footer
echo $OUTPUT->footer();