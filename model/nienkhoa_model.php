<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');

function get_nienkhoa_byID($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $nienkhoa = $DB->get_record('block_edu_nienkhoa', ['id' => $id]);
    return $nienkhoa;
}
 

function get_nienkhoa_checkbox($courseid) {
 global $DB, $USER, $CFG, $COURSE;
 $table = new html_table();
 $table->head = array('','STT', 'Id niên khóa','Mã bậc','Mã hệ','Mã niên khóa','Tên niên khóa','Mô tả');
 $allnienkhoas = $DB->get_records('block_edu_nienkhoa', []);
 $stt = 1;    
 setcookie("arr", [0,1], time() + (86400 * 30), "/");

 foreach ($allnienkhoas as $inienkhoa) {
    // Create checkbox
    // $check_id = 'bdt' . $inienkhoa->id;

    $checkbox = html_writer::tag('input', ' ', array('class' => 'nienkhoacheckbox','type' => "checkbox", 'name' => $inienkhoa->id, 'id' => 'bdt' . $inienkhoa->id, 'value' => '0', 'onclick' => "changecheck($inienkhoa->id)")); 
    

    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_nienkhoa.php', ['courseid' => $courseid, 'id' => $inienkhoa->id]);
    $ten_url = \html_writer::link($url, $inienkhoa->ten_nienkhoa);

    $table->data[] = [$checkbox, (string)$stt,(string)$inienkhoa->id_nienkhoa,(string)$inienkhoa->ma_bac,(string)$inienkhoa->ma_he,(string)$inienkhoa->ma_nienkhoa, $ten_url,(string)$inienkhoa->mota];
    $stt = $stt+1;
 }
 return $table;
}
function update_nienkhoa($param) {
 /*
  $param = new stdClass();
  $param->ma_bac = 'DH';
  $param->ten = 'Đại học';
  $param->mota = 'Bậc Đại học HCMUS'
 */
global $DB, $USER, $CFG, $COURSE;
$DB->update_record('block_edu_nienkhoa', $param, $bulk = false);
}






 function insert_nienkhoa($param) {
     
    //  $param = new stdClass();
    //  $param->id_he = '3';
    //  $param->ma_nienkhoa='AB';
    //  $param->ten='phong dep trai3';
    //  $param->mota = 'hello';
     
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('block_edu_nienkhoa', $param);
 }
 function get_nienkhoa() {
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('STT', 'Niên khóa', 'Mô tả');
    $allbacdts = $DB->get_records('block_edu_nienkhoa', []);
    $stt = 1;
    foreach ($allbacdts as $inienkhoa) {
        $table->data[] = [(string)$stt,(string)$inienkhoa->ten_nienkhoa,(string)$inienkhoa->mota];
        $stt = $stt+1;
    }
    return $table;
 }