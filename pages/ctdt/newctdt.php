<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once('../factory.php');

// Create button with method post
function button_method_post($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "post"))
    .html_writer::tag('input', ' ', array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}

// Create button with method get
function button_method_get($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "get"))
    .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}


///-------------------------------------------------------------------------------------------------------///
global $COURSE;
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/index.php'));
$PAGE->navbar->add(get_string('themctdt_lable', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php'));
// Title.
$PAGE->set_title(get_string('themctdt_title', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('themctdt_head', 'block_educationpgrs'));
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
// Tạo form
require_once('../../form/ctdt/newctdt_form.php');
$mform = new newctdt_form();

// Lưu ý sự kiện button click đều gây load lại trang và lưu lại toàn bộ thông tin trong form
// Tiến trình xử lý của form ở dưới đây
if ($mform->is_cancelled()) {
    // Gọi khi Cancel button được bấm 
    // VD: element cancel hoặc button cancel tạo ra từ add_action_buttons()
} else if ($mform->no_submit_button_pressed()) { 
    // Gọi khi button được khai báo là no submit được click
    // $mform->registerNoSubmitButton('btnchoosetree');
    // $mform->addElement('submit', 'btnchoosetree', get_string('themctdt_btn_choncaykkt', 'block_educationpgrs'));

    if ($mform->_form->get_submit_value('btnchoosetree')) {
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/newkkt_form.php");
        //get_submit_value này lấy được bất kì thông tin nào đang có trên form lmao :D 
        echo $mform->get_submit_value();
    }
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    // Gọi khi và chỉ khi ( !$this->is_cancelled() and $this->is_submitted() and $this->is_validated() )
    // Chi tiết xử lí hàm ở trong file formlib.php dòng 661
    // Sự kiện Submit button click load lại file php này và thêm dữ liệu là form đã được submit -> dẫn tới hàm này được chạy vì thoả điều kiện.
    // Lưu ý $mform->get_data() trả về stdClass và nó không thể ép kiểu sang string
    // if(get_submit_value('newctdt') != NULL && 
    //     get_submit_value('newctdt') != NULL && 
    //     get_submit_value('newctdt') != NULL && 
    //     get_submit_value('newctdt') != NULL && 
    //     get_submit_value('newctdt') != NULL && 
    //     get_submit_value('newctdt') != NULL && 
    //     get_submit_value('newctdt') != NULL
    // ){
    //     $param;
    //     insert_ctdt($param);
    // }

    $muctieu = $mform->get_value_editor('mtc_1_1');
    if(empty($muctieu)){
        echo 'yes';
    } else{
        echo 'no data';
    }
    echo $muctieu['context'];

    $muctieu = $mform->get_value_editor()->mtc_1_1;

    if(empty($muctieu)){
        echo 'yes';
    } else{
        echo 'no data';
    }
    echo $muctieu['context'];


    // Tuỳ xử lí tiếp theo mà có nên cho form hiện lại hay không
    $mform->display();
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form. 
    //Set default data (if any)
    $mform->set_data($toform);
    // displays the form
    $mform->display();
}



 // Footere
echo $OUTPUT->footer();
?>
