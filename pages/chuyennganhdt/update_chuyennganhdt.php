<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuyennganhdt_model.php');
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
class simplehtml_form extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;
        $mform->addElement('html', '        


        ');
    }
    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}
global $COURSE;

// Định dang courseid, item_id
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT))
{
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;


// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/update_chuyennganhdt.php', ['courseid' => $courseid, 'id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$chuyennganhdt = get_chuyennganhdt_byID($id);
$navbar_name = 'Chuyên ngành ĐT';
$title_heading = 'ĐT';
if($founded_id == true)
{
    $navbar_name = $chuyennganhdt->ten;
    $title_heading = $chuyennganhdt->ten;
}
else
{
    //
}
$PAGE->navbar->add($navbar_name);
// Title.
$PAGE->set_title('Cập nhật chuyên ngành ' . $title_heading);
$PAGE->set_heading('Cập nhật chuyên ngành ' . $title_heading);
echo $OUTPUT->header();

 // Form
 require_once('../../form/chuyennganhdt/qlchuyennganh_form.php');
 $mform = new qlchuyennganh_form();
 //Form processing and displaying is done here
 if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if($mform->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    // Thực hiện insert
    $param1 = new stdClass();
    // $param
    $param1->id = $mform->get_data()->idchuyennganh; // The data object must have the property "id" set.
    $param1->ma_chuyennganh = $mform->get_data()->machuyennganh;
    $param1->ten = $mform->get_data()->tenchuyennganh;
    $param1->mota = $mform->get_data()->mota;
    update_chuyennganhdt($param1);
    // Hiển thị thêm thành côngz
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    //edit file index.php tương ứng trong thư mục page. trỏ đến đường dẫn chứa file đó
    $url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_chuyennganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    // $mform->display();


} else if ($mform->is_submitted()) {
    //
} else {
    //Set default data from DB
    $toform;
    $toform->idchuyennganh = $chuyennganhdt->id;
    $toform->machuyennganh = $chuyennganhdt->ma_chuyennganh;
    $toform->tenchuyennganh = $chuyennganhdt->ten;
    $toform->mota = $chuyennganhdt->mota;
    $mform->set_data($toform);

    // displays the form
    $mform->display();
}

 // Footere
echo $OUTPUT->footer();

// Set table.
// $table = new html_table();
// $tmp1 = ['CSC10004', 'Cấu trúc dữ liệu và giải thuật', '4', '7.0'];
// $tmp2 = ['CSC13003', 'Kiểm chứng phần mềm', '4', '7.5'];
// $tmp3 = ['MTH00050', 'Toán học tổ hợp', '4', '8.0'];
// $tmp4 = ['CSC10007', 'Hệ điều hành', '4', '7.0'];
// $tmp5 = ['CSC13112', 'Thiết kế giao diện', '4', '8.0'];
// $table->head = array('Course Code', 'Subject', 'Credit', 'Grade');
// $table->data[] = $tmp1;
// $table->data[] = $tmp2;
// $table->data[] = $tmp3;
// $table->data[] = $tmp4;
// $table->data[] = $tmp5;
// // Print table
// echo html_writer::table($table);




    // <?php
    //     require_once(`../model/bacdt_model.php`);
    //     require_once(__DIR__ . `/../../../config.php`);

    //     function click(){

    //         $param1 = new stdClass()
    //         $param1->ma_bac = `DH`;
    //         $param1->ten = `Đại học`;
    //         $param1->mota = `Bậc Đại học HCMUS`;
            
    //         insert_bacdt(param1);
                    
    //     }

    // ?>
