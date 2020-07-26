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

$action_form0 =
    html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center;'))
    .
    html_writer::tag(
    'tag',
    "<a href='../pages/lopmo/view.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Danh mục lớp mở</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/lopmo/view.php'",
    'style' => 'margin:20px;'))
    

. html_writer::end_tag('div');

$action_form1 =
    html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center;'))
    .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/ctdt/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Chương trình đào tạo</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/ctdt/index.php'",
    'style' => 'margin:20px;'))
    .
    html_writer::tag(
        'tag',
        "<a href='../pages/ctdt/pdf_ctdt.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
        line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
        '>Xem PDF chương trình đào tạo</a>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_ctdt.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/decuong/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Đề cương môn học</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/decuong/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))

    .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/chuandauractdt/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Chuẩn đầu ra CTDT</a>",
    
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/chuandauractdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/monhoc/danhsach_monhoc.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Môn học</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/monhoc/danhsach_monhoc.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/lopmo/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Lớp mở</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/lopmo/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        
        

. html_writer::end_tag('div');

$action_form2 =
    html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    
    
    
    html_writer::tag(
    'tag',
    "
    <a href='../pages/bacdt/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Bậc</a>",
    
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/bacdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/hedt/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Hệ</a>",
    
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/hedt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/nienkhoa/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Niên khóa</a>",

    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/nienkhoa/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))

    .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/nganhdt/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Ngành</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/nganhdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'tag',
    "
    <a href='../pages/chuyennganhdt/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Chuyên ngành</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/chuyennganhdt/index.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        

. html_writer::end_tag('div');

$action_form3 =
    html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    
    
    html_writer::tag(
        'tag',
        "<a href='../pages/khoikienthuc/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Khối kiến thức</a>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/khoikienthuc/index.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        .      
        html_writer::tag(
        'tag',
        "<a href='../pages/caykkt/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Cây khối kiến thức</a>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/caykkt/index.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
        
. html_writer::end_tag('div');


$action_form4 =
html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))

    .
    html_writer::tag(
    'tag',
    "<a href='../pages/import/import_tonghop.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Bậc, Hệ, Niên khóa, Ngành, Chuyên ngành</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_tonghop.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    html_writer::tag(
    'tag',
    "<a href='../pages/import/import_ctdt.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Chương trình đào tạo</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_ctdt.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .
    
    html_writer::tag(
    'tag',
    "<a href='../pages/import/import_decuong.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Đề cương môn học</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_decuong.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .      
    html_writer::tag(
    'tag',
    "<a href='../pages/import/import_chuandauractdt.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Chuẩn đầu ra CTDT</a>",
    array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_chuandauractdt.php'",
    'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
. html_writer::end_tag('div');

$action_form5 =
html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    html_writer::tag(
        'tag',
        "<a href='../pages/import/import_lopmo.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Lớp mở</a>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_lopmo.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;')) 

    .

    html_writer::tag(
        'tag',
        "<a href='../pages/import/import_monhoc.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Môn học</a>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/import/import_monhoc.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    .

    html_writer::tag(
        'tag',
        "<a href='../pages/import/import_kkt.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Khối kiến thức</a>",
        array('id' => 'btn_to_import_kkt', 'onClick' => "window.location.href='../pages/import/import_kkt.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'))
    
. html_writer::end_tag('div');

$action_form6 =
html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    html_writer::tag(
        'tag',
        "<a href='../pages/decuong/matrix.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Ma trận chuẩn đầu ra</a>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/decuong/matrix.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;')) 

. html_writer::end_tag('div');

$action_form7 =
html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
    .
    html_writer::tag(
        'tag',
        "<a href='../pages/quyen/index.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
    '>Quản lý quyền điều khiển</a>",
        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/decuong/matrix.php'",
        'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;')) 

. html_writer::end_tag('div');

echo "<br><p style='color:#1177d1; margin-left: 0; font-size: 1.5rem;'>❖ Danh mục lớp mở</p>";

echo $action_form0;
echo "<div class='card' style='margin-top: 50px;'></div>";


echo "<br><p style='color:#1177d1; margin-left: 0; font-size: 1.5rem;'>❖ Quản lý</p>";
echo $action_form2;

echo $action_form1;



echo $action_form3;
echo "<div class='card' style='    margin: 100px 0px 0 0;'></div>";

echo "<br><p style='color:#1177d1; margin-left: 0; font-size: 1.5rem;'>❖ Import</p>";
echo $action_form4;

echo $action_form5;

echo "<div class='card' style='    margin: 150px 0px 0 0;'></div>";
echo "<br><p style='color:#1177d1; margin-left: 0; font-size: 1.5rem;'>❖ Ma trận</p>";

echo $action_form6  ;

echo "<div class='card' style='    margin: 150px 0px 0 0;'></div>";
echo "<br><p style='color:#1177d1; margin-left: 0; font-size: 1.5rem;'>❖ Quản lý quyền</p>";

echo $action_form7  ;

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

