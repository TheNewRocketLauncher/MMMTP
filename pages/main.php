<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->libdir/formslib.php");

///-------------------------------------------------------------------------------------------------------///
global $COURSE, $USER, $DB;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
// if ($courseid == SITEID) {
//     require_login();
//     $context = \context_system::instance();
// } else {
//     require_login($courseid);
//     $context = \context_course::instance($courseid); // Create instance base on $courseid
// }

require_login();

if (isguestuser()) {
    // Login as real user!
    
    $SESSION->wantsurl = (string)new moodle_url('/admin/index.php');
    redirect(get_login_url());
}

$str;
if (isguestuser()) {
    
} else {
    
}

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/main.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));

// Title.
$PAGE->set_title('Các danh mục chung' . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Các danh mục chung');





// Print header
echo $OUTPUT->header();
echo $str;

///-------------------------------------------------------------------------------------------------------///


echo "<h2 style='text-align: center;text-transform: uppercase;font-weight: 600;'>Trường đại học khoa học tự nhiên - ĐHQG HCM</h2>";
echo "<h3 style='text-align: center;text-transform: uppercase;font-weight: 600;'>Khoa công nghệ thông tin</h3>";
echo "<br>";
echo "<h1 style='text-align: center;text-transform: uppercase;font-weight: 600;'>Moodle Project</h1>";
echo "<br>";
echo "<h3 style='text-align: center;text-transform: uppercase;font-weight: 500;'>Ts. Lâm Quang Vũ</h3>";
echo "<h3 style='text-align: center;text-transform: uppercase;font-weight: 500;'>Nhóm moodle module</h3>";
echo "<br>";echo "<br>";

$action_form0 =
    html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/lopmo/view.php' style='color:#fff;font-size: 24px;'>Danh mục lớp mỏ</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/lopmo/view.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    

. html_writer::end_tag('div');

$action_form1 =
    html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/ctdt/index.php' style='color:#fff;font-size: 24px;'>Chương trình đào tạo</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/ctdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/decuong/index.php' style='color:#fff;font-size: 24px;'>Đề cương môn học</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/decuong/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))

    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/chuandauractdt/index.php' style='color:#fff;font-size: 24px;'>Chuẩn đầu ra CTDT</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/chuandauractdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/monhoc/danhsach_monhoc.php' style='color:#fff;font-size: 24px;'>Môn học</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/monhoc/danhsach_monhoc.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/lopmo/index.php' style='color:#fff;font-size: 24px;'>Lớp mở</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/lopmo/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        
        

. html_writer::end_tag('div');

$action_form2 =
    html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    
    
    
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/bacdt/index.php' style='color:#fff;font-size: 24px;'>Bậc</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/bacdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/hedt/index.php' style='color:#fff;font-size: 24px;'>Hệ</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/hedt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/nienkhoa/index.php' style='color:#fff;font-size: 24px;'>Niên khóa</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/nienkhoa/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))

    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/nganhdt/index.php' style='color:#fff;font-size: 24px;'>Ngành</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/nganhdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/chuyennganhdt/index.php' style='color:#fff;font-size: 24px;'>Chuyên ngành </a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/chuyennganhdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        

. html_writer::end_tag('div');

$action_form3 =
    html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    
    
    html_writer::tag(
        'button',
        "<p style='margin:0'><a href='../pages/khoikienthuc/index.php' style='color:#fff;font-size: 24px;'>Khối kiến thức</a></p>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/khoikienthuc/index.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        .      
        html_writer::tag(
        'button',
        "<p style='margin:0'><a href='../pages/caykkt/index.php' style='color:#fff;font-size: 24px;'>Cây khối kiến thức</a></p>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/caykkt/index.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        
. html_writer::end_tag('div');


$action_form4 =
html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))

    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/import/import_tonghop.php' style='color:#fff;font-size: 24px;'>Bậc, ... , chuyên ngành</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_tonghop.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/import/import_ctdt.php' style='color:#fff;font-size: 24px;'>Chương trình đào tạo</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_ctdt.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/import/import_decuong.php' style='color:#fff;font-size: 24px;'>Đề cương môn học</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_decuong.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .      
    html_writer::tag(
    'button',
    "<p style='margin:0'><a href='../pages/import/import_chuandauractdt.php' style='color:#fff;font-size: 24px;'>Chuẩn đầu ra CTDT</a></p>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_chuandauractdt.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
. html_writer::end_tag('div');

$action_form5 =
html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    html_writer::tag(
        'button',
        "<p style='margin:0'><a href='../pages/import/import_lopmo.php' style='color:#fff;font-size: 24px;'>Lớp mở</a></p>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_lopmo.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;')) 

    .

    html_writer::tag(
        'button',
        "<p style='margin:0'><a href='../pages/import/import_monhoc.php' style='color:#fff;font-size: 24px;'>Môn học </a></p>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_monhoc.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .

    html_writer::tag(
        'button',
        "<p style='margin:0'><a href='../pages/import/import_kkt.php' style='color:#fff;font-size: 24px;'>Khối kiến thức </a></p>",
        array('id' => 'btn_to_import_kkt', 'onClick' => "window.location.href='../pages/import/import_kkt.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    
. html_writer::end_tag('div');

$action_form6 =
html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    html_writer::tag(
        'button',
        "<p style='margin:0'><a href='../pages/decuong/matrix.php' style='color:#fff;font-size: 24px;'>MATRIX</a></p>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/decuong/matrix.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;')) 

. html_writer::end_tag('div');

echo "<h3 style='color: 1177d1;text-decoration: underline; '><strong>Danh mục lớp mở</strong></h3>";
echo $action_form0;

echo "<h3 style='color: 1177d1;text-decoration: underline; '><strong>Quản lý</strong></h3>";

echo $action_form2;

echo $action_form1;



echo $action_form3;
echo "<h3 style='color: 1177d1;text-decoration: underline; '><strong>Import</strong></h3>";
echo $action_form4;

echo $action_form5;

echo "<h3 style='color: 1177d1;text-decoration: underline; '><strong>MATRIX</strong></h3>";

echo $action_form6  ;

// $link = $CFG->dirroot.'/Gruntfile.js';

// if (($handle = fopen( $link, "r")) !== FALSE) {
//     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

//         echo json_encode($data); echo "<br>";
//     }
// }

/* Import auto DB */
require_once('../controller/import.php');
// insertDatabase();

// Footer
echo $OUTPUT->footer();

