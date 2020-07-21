<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');
 

function get_nienkhoa_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $nienkhoa = $DB->get_record('eb_nienkhoa', ['id' => $id]);
   return $nienkhoa;
}

function update_nienkhoa($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->update_record('eb_nienkhoa', $param, $bulk = false);
}

function insert_nienkhoa($param)
{
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_nienkhoa', $param);
}