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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php', ['courseid' => $courseid]));
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
$mform = new newcaykkt_form_final();
if ($mform->is_cancelled()) {
} else if ($mform->no_submit_button_pressed()) {

} else if ($fromform = $mform->get_data()) {
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/add_caykkt_ttc.php");
} else{
    $toform = new stdClass();
    $data = get_newcaykkt_info();
    $toform->txt_tencay = $data->tencay;
    $toform->txt_mota = $data->mota;
    $mform->set_data($toform);
}
$mform->display();
if(print_table()){
    $action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:left;'))
    . html_writer::tag(
        'button',
        'Xoá khối',
        array('id' => 'btn_addcaykkt_remove_khoi', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #fa4b1b; color:#fff;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Di chuyển lên',
        array('id' => 'btn_addcaykkt_moveup', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #32d96f; color:#fff;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Di chuyển xuống',
        array('id' => 'btn_addcaykkt_movedown', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #32d96f; color:#fff;')
    )
    . '<br>'
    . '<br>'
    . html_writer::end_tag('div');
    echo $action_form;
}

$updateTableForm = new newcaykkt_form1_b();
if ($updateTableForm->is_cancelled()) {
} else if ($updateTableForm->no_submit_button_pressed()) {
    if($updateTableForm->get_submit_value('btn_review')){
        
    } else if($updateTableForm->get_submit_value('btn_cancle')){
        reset_global();
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/index.php");
    }
} else if ($fromform = $updateTableForm->get_data()) {
    insert_cay_kkt();
    reset_global();
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/caykkt/index.php");
}
$updateTableForm->display();


 // Footere
echo $OUTPUT->footer();


///-------------------------------------------------------------------------------------------------------///
//FUNCTION

function get_newcaykkt_info(){
    global $USER;
    get_adding_list();
    $current_data = get_global($USER->id)['newcaykkt'];
    $result = new stdClass();
    $result->tencay = $current_data['tencay'];
    $result->mota = $current_data['mota'];
    return $result;
}

function get_newcaykkt_global(){
    global $USER;
    get_adding_list();
    return $current_data = get_global($USER->id)['newcaykkt'];
}

function update_newcaykkt_global($newdata){
    global $USER;
    $current_global = get_global($USER->id);
    $current_global['newcaykkt']['tencay'] = $newdata['tencay'];
    $current_global['newcaykkt']['mota'] = $newdata['mota'];
    set_global($USER->id, $current_global);
}

function print_table(){
    global $DB, $USER, $CFG, $COURSE;
    $list = get_adding_list();

    if(empty($list)){
        echo 'Không có khối nào để hiển thị';
        return false;
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
        $checkbox = html_writer::tag('input', ' ', array('class' => 'add_caykkt_checkbox', 'type' => "checkbox", 'name' => $stt-1,   'id' => 'addcaykkt' . $stt, 'value' => '0', 'onclick' => "changecheck_checkbox_addcaykkt($stt)"));
        // $checkbox = html_writer::tag('input', ' ', array('class' => 'add_caykkt_checkbox', 'type' => "checkbox", 'name' => $item['ma_khoi'],   'id' => 'addcaykkt' . $stt, 'value' => '0', 'onclick' => "changecheck_checkbox_addcaykkt($stt)"));
        $table->data[] = [$checkbox, (string) $item['index'], (string) $item['ten_khoi'], (string) $item['loaikhoi'], (string) $item['mota']];
        $stt = $stt + 1;
    }
    echo html_writer::table($table);
    return true;
}

function reset_global(){
    global $USER;
    $arr = get_global($USER->id);
    unset($arr['newcaykkt']);
    set_global($USER->id, $arr);
}