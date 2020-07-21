<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');

 

function insert_bacdt($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_bacdt', $param);
}

function update_bacdt($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_bacdt', $param, $bulk = false);
}

function get_bacdt()
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Bậc đào tạo', 'Mô tả');
   $allbacdts = $DB->get_records('eb_bacdt', []);
   $stt = 1;
   foreach ($allbacdts as $ibacdt) {
      $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/update_bdt.php', ['id' => $ibacdt->id]);
      $ten_url = \html_writer::link($url, $ibacdt->ten);
      $table->data[] = [(string) $stt, $ten_url, (string) $ibacdt->mota];
      $table->data[$stt]->attributes['style'] = "width: 100%; text-align: center; border: 1px solid black";
      $stt = $stt + 1;
   }
   $table->attributes['style'] = "width: 100%; border: 1px solid red";

   return $table;
}

function get_table_bacdt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('STT', 'Bậc đào tạo old', 'Mô tả');
   $bacdt = $DB->get_record('eb_bacdt', ['id' => $id]);
   $table->data[] = [(string) $id, (string) $bacdt->ten, (string) $bacdt->mota];
   return $table;
}

function get_bacdt_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $bacdt = $DB->get_record('eb_bacdt', ['id' => $id]);
   return $bacdt;
}
