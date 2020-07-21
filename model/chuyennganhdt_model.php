<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');
 
function insert_chuyennganhdt($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_chuyennganhdt', $param);
}

function update_chuyennganhdt($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_chuyennganhdt', $param, $bulk = false);
}

function get_chuyennganhdt()
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Chuyên ngành đào tạo', 'Mô tả');
   $allchuyennganhdts = $DB->get_records('eb_chuyennganhdt', []);
   $stt = 1;
   foreach ($allchuyennganhdts as $ichuyennganhdt) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/update_chuyennganhdt.php', [ 'id' => $ichuyennganhdt->id]);
      $ten_url = \html_writer::link($url, $ichuyennganhdt->ten);
      $table->data[] = [(string) $stt, $ten_url, (string) $ichuyennganhdt->mota];
      $stt = $stt + 1;
   }
   return $table;
}

function get_table_chuyennganhdt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Chuyên ngành đào tạo', 'Mô tả');
   $chuyennganhdt = $DB->get_record('eb_chuyennganhdt', ['id' => $id]);
   $table->data[] = [(string) $id, (string) $chuyennganhdt->ten, (string) $chuyennganhdt->mota];
   return $table;
}

function get_chuyennganhdt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $chuyennganhdt = $DB->get_record('eb_chuyennganhdt', ['id' => $id]);
   return $chuyennganhdt;
}

