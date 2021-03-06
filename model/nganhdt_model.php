<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');
 

function insert_nganhdt($param)
{
   global $DB;
   if(!$DB->count_records('eb_nganhdt', ['ma_nganh' => $param->ma_nganh])) {
      $DB->insert_record('eb_nganhdt', $param);
    }
}

function update_nganhdt($param)
{
   global $DB;
   $DB->update_record('eb_nganhdt', $param, $bulk = false);
}

function get_nganhdt()
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Mã ngành', 'Ngành đào tạo', 'Mô tả');
   $allnganhdts = $DB->get_records('eb_nganhdt', []);
   $stt = 1;
   foreach ($allnganhdts as $inganhdt) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/update_nganhdt.php', ['courseid' => $courseid, 'id' => $inganh->id]);
      $ten_url = \html_writer::link($url, $inganhdt->ten);
      $table->data[] = [(string) $stt, (string) $inganhdt->ma_nganh, $ten_url, (string) $inganhdt->mota];
      $stt = $stt + 1;
   }
   return $table;
}

function get_table_nganhdt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Mã ngành', 'Ngành đào tạo', 'Mô tả');
   $nganhdt = $DB->get_record('eb_nganhdt', ['id' => $id]);
   $table->data[] = [(string) $id, (string) $nganhdt->ma_nganh, (string) $nganhdt->ten, (string) $nganhdt->mota];
   return $table;
}

function get_nganhdt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $nganhdt = $DB->get_record('eb_nganhdt', ['id' => $id]);
   return $nganhdt;
}


