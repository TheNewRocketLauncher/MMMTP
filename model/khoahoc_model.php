<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../js.php');

function insert_khoahoc($param)
{   
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('block_edu_khoahoc', $param);
}

function get_khoahoc_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $khoahoc = $DB->get_record('block_edu_khoahoc', ['id' => $id]);
   return $khoahoc;
}

function get_khoahoc_checkbox($courseid)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('', 'STT', 'Id môn học', 'Tên khóa học', 'Giáo viên phụ trách', 'Mô tả');
   $allkhoahocs = $DB->get_records('block_edu_khoahoc', []);
   $stt = 1;
   foreach ($allkhoahocs as $ikhoahoc) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'khoahoccheckbox', 'type' => "checkbox", 'name' => $ikhoahoc->id, 'id' => 'bdt' . $ikhoahoc->id, 'value' => '0', 'onclick' => "changecheck($ikhoahoc->id)"));
      $url = new \moodle_url('/blocks/educationpgrs/pages/khoahoc/update_khoahoc.php', ['courseid' => $courseid, 'id' => $ikhoahoc->id]);
      $ten_url = \html_writer::link($url, $ikhoahoc->ten_khoahoc);
      $table->data[] = [$checkbox, (string) $stt, (string) $ikhoahoc->id_monhoc, $ten_url, (string) $ikhoahoc->giaovien_phutrach, (string) $ikhoahoc->mota];
      $stt = $stt + 1;
   }
   return $table;
}

function update_khoahoc($param)
{   
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('block_edu_khoahoc', $param, $bulk = false);
}

function get_khoahoc_table()
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Id môn học', 'Tên khóa học', 'Giáo viên phụ trách', 'Mô tả');
   $allkhoahocs = $DB->get_records('block_edu_khoahoc', []);
   $stt = 1;
   foreach ($allkhoahocs as $ikhoahoc) {
      $table->data[] = [(string) $stt, (string) $ikhoahoc->id_monhoc, (string) $ikhoahoc->ten_khoahoc, (string) $ikhoahoc->giaovien_phutrach, (string) $ikhoahoc->mota];
      $stt = $stt + 1;
   }
   return $table;
}