<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');
 

function insert_hedt($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_hedt', $param);
}

function update_hedt($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_hedt', $param, $bulk = false);
}

function get_hedt($courseid)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Bậc đào tạo', 'Hệ đào tạo', 'Mô tả');
   $allhedts = $DB->get_records('eb_hedt', []);
   $stt = 1;
   foreach ($allhedts as $ihedt) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/qlhe.php', ['courseid' => $courseid, 'id' => $ihedt->id]);
      $ten_url = \html_writer::link($url, $ihedt->ten);
      $table->data[] = [(string) $stt, 'Đại học', $ten_url, (string) $ihedt->mota];
      $stt = $stt + 1;
   }
   return $table;
}

function get_table_hedt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Bậc đào tạo', 'Hệ đào tạo', 'Mô tả');
   $hedt = $DB->get_record('eb_hedt', ['id' => $id]);
   $table->data[] = [(string) $id, 'Đại học', (string) $hedt->ten, (string) $hedt->mota];
   return $table;
}

function get_hedt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $hedt = $DB->get_record('eb_hedt', ['id' => $id]);
   return $hedt;
}
