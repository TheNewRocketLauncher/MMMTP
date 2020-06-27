<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;

$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}



///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/newkkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_caykhoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/caykkt/index.php'));
$PAGE->navbar->add('Thêm cây mới');
$PAGE->navbar->add('Chọn danh sách khối');
// Title.
$PAGE->set_title('Thêm cây mới');
$PAGE->set_heading('Thêm cây mới');
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/caykkt/newcaykkt_form.php');

//FORM tạo mới khối kiến thức
$mform = new newcaykkt_form1();
if ($mform->is_cancelled()) {
} else if ($fromform = $mform->get_data()) {
    
}


//FORM cho button xem trước cây
$updateTableForm = new newcaykkt_form1_b();
if ($updateTableForm->is_cancelled()) {
} else if ($fromform = $updateTableForm->get_data()) {
    
}

$mform->display();
// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:center;'))
    . html_writer::tag(
        'button',
        'Thêm thành khối cha',
        array('id' => 'btn_addcaykkt_delete_khoi', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #z; color:#fff;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm thành khối cùng cấp',
        array('id' => 'btn_addcaykkt_add_khoi', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #1177d1; color:#fff;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm thành khối con',
        array('id' => 'btn_addcaykkt_addkhoi_asChild', 'onClick' => "window.location.href='newcaykkt.php'", 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #1177d1; color:#fff;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
print_table();

$updateTableForm = new newcaykkt_form1_b();
if ($updateTableForm->is_cancelled()) {
} else if ($updateTableForm->no_submit_button_pressed()) {
    if($updateTableForm->get_submit_value('btn_review')){
        
    } else if($updateTableForm->get_submit_value('btn_cancle')){
        reset_global();
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/index.php");
    }
} else if ($fromform = $updateTableForm->get_data()) {
    
}

$updateTableForm->display();

 // Footere
echo $OUTPUT->footer();


///-------------------------------------------------------------------------------------------------------///
//FUNCTION



function get_list(){
    global $USER;
    $current_global = get_global($USER->id);
    if($current_global == null){
        $current_global = array(
            'newcaykkt' => array(),
        );
        set_global($USER->id, $current_global);
    } else if(empty($current_global)){
        $current_global[] = array(
            'newcaykkt' => array(),
        );
        set_global($USER->id, $current_global);
    } else if(array_key_exists('newcaykkt', $current_global)){
        return $current_global['newcaykkt'];
    } else {
        $current_global[] = array(
            'newcaykkt' => array(),
        );
        set_global($USER->id, $current_global);
    }
    return $current_global['newcaykkt'];


}

function print_table(){
    global $DB, $USER, $CFG, $COURSE;
    $list = get_list();

    if(empty($list)){
        echo 'Không có khối nào để hiển thị';
        return;
    }

    $rows = [];
    foreach($list as $item){
        $khoi = get_kkt_byMaKhoi($item['name']);
        $mota = $khoi->name;
        $loaiktt = "Tự chọn";
        if ($i->id_loai_ktt === 0 ){
            $loaiktt = "Bắt buộc";
        }
        $rows[] = array(
            'index' => $item['index'],
            'ten_khoi' => $khoi->ten_khoi,
            'loaikhoi'=> $loaiktt,
            'mota' => $khoi->mota,
            'ma_khoi' => $item['name'],
        );
    }
    $table = new html_table();
    $table->head = array('', 'ID', 'Tên khối', 'Loại khối', 'Mô tả');
    $stt = 1;
    foreach ($rows as $item) {
        $checkbox = html_writer::tag('input', ' ', array('class' => 'add_caykkt_checkbox', 'type' => "checkbox", 'name' => $item['ma_khoi'],   'id' => 'addcaykkt' . $stt, 'value' => '0', 'onclick' => "changecheck_checkbox_addcaykkt($stt)"));
        $table->data[] = [$checkbox, (string) $item['index'], (string) $item['ten_khoi'], (string) $item['loaikhoi'], (string) $item['mota']];
        $stt = $stt + 1;
    }
    echo html_writer::table($table);

    // global $DB, $USER, $CFG, $COURSE;
    // $table = new html_table();
    // $table->head = array('', 'STT', 'ID', 'Mã cây khối kiến thức', 'Mã khối', 'Tên cây', 'Mô tả');
    // $rows = $DB->get_records('block_edu_cay_khoikienthuc', []);
    // $stt = 1;
    // foreach ($rows as $item) {
    //     if((string)$item->ma_khoicha == ""){
    //         $checkbox = html_writer::tag('input', ' ', array('class' => 'ckktcheckbox', 'type' => "checkbox", 'name' => $item->id,   'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
    //         $table->data[] = [$checkbox, (string) $stt, (string) $item->id, (string) $item->ma_cay_khoikienthuc, (string) $item->ma_khoi, (string) $item->ten_cay, (string) $item->mota];
    //         $stt = $stt + 1;
    //     }
    // }
    // return $table;
}

function reset_global(){
    global $USER;
    $arr = get_global($USER->id);
    unset($arr['newcatkkt']);
    set_global($USER->id, $arr);
}