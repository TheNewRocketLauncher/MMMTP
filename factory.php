<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../config.php');

// Create button with method post
function button_method_post($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "post"))
    .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
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

// insert into bacdt table
function insert_bacdt() {
    global $DB, $USER, $CFG, $COURSE, $bacDTinserted;

    $dataObj1 = new stdClass();
    $dataObj1->ma_bac = 'DH';
    $dataObj1->ten = 'Đại học';
    $dataObj1->mota = 'Bậc Đại học HCMUS';

    $dataObj2 = new stdClass();
    $dataObj2->ma_bac = 'CD';
    $dataObj2->ten = 'Đại học';
    $dataObj2->mota = 'Bậc Đại học HCMUS';

    $dataObj3 = new stdClass();
    $dataObj3->ma_bac = 'DTTX';
    $dataObj3->ten = 'Đại học';
    $dataObj3->mota = 'Bậc Đại học HCMUS';
    
    $DB->insert_record('block_edu_bacdt', $dataObj1);
    $DB->insert_record('block_edu_bacdt', $dataObj2);
    $DB->insert_record('block_edu_bacdt', $dataObj3);
 }
 function get_bacdt() {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('ID', 'Mã bậc', 'Tên bậc', 'Mô tả');
    $allbacdts = $DB->get_records('block_edu_bacdt', ['mota' => 'Bậc Đại học HCMUS']);
    foreach ($allbacdts as $ibacdt) {
        $table->data[] = [(string)$ibacdt->id, $ibacdt->ma_bac,(string)$ibacdt->ten,(string)$ibacdt->mota];
    }
    return $table;
 }


// Viết lại hàm nhận tham số function insertSubject($param);
function insertSubject() {
    global $DB, $USER, $CFG, $COURSE;

    $dataObj1 = new stdClass();
    $dataObj1->mssv = 1612572;
    $dataObj1->coursecode = 'CSC10004';
    $dataObj1->subject = 'Cấu trúc dữ liệu và giải thuật';
    $dataObj1->credit = 4;
    $dataObj1->grade = 7.0;

    $dataObj2 = new stdClass();
    $dataObj2->mssv = 1612572;
    $dataObj2->coursecode = 'CSC13003';
    $dataObj2->subject = 'Kiểm chứng phần mềm';
    $dataObj2->credit = 4;
    $dataObj2->grade = 7.5;

    $dataObj3 = new stdClass();
    $dataObj3->mssv = 1612572;
    $dataObj3->coursecode = 'MTH00050';
    $dataObj3->subject = 'Toán học tổ hợp';
    $dataObj3->credit = 10;
    $dataObj3->grade = 8.0;
    
    $DB->insert_record('block_educationpgrs', $dataObj1);
    $DB->insert_record('block_educationpgrs', $dataObj2);
    $DB->insert_record('block_educationpgrs', $dataObj3);
 }

 function getAllSubject() {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('Course Code', 'Subject', 'Credit', 'Grade');
    $allsubjects = $DB->get_records('block_educationpgrs', ['mssv' => '1612572']);
    foreach ($allsubjects as $subject) {
        $table->data[] = [(string)$subject->coursecode, $subject->subject,(string)$subject->credit,(string)$subject->grade];
    }
    return $table;
 }

 function getAllCourse() {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('ID', 'Course Name', 'Format', 'Start', 'End');
    $allcourses = $DB->get_records('course', ['category' => '1']);
    foreach ($allcourses as $allcourse) {
        $table->data[] = [(string)$allcourse->id, $allcourse->fullname,(string)$allcourse->format,(string)$allcourse->startdate,(string)$allcourse->enddate];
    }
    return $table;
 }

