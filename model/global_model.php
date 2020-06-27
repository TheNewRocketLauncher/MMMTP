<?php
require_once(__DIR__ . '/../../../config.php');

function userIsAdmin()
{
    return true;
}

function get_global($id_user)
{
    global $CFG, $DB;
    $datatemp = $DB->get_record('block_edu_global', ['id_user' => $id_user]);
    if (empty($datatemp)) {
        return array();
    }
    return json_decode($datatemp->string, true);
}

function set_global($id_user, $arr)
{
    global $CFG, $DB;
    $datatemp = $DB->get_record('block_edu_global', ['id_user' => $id_user]);
    if (empty($datatemp)) {
        $dataobject = new stdClass();
        $dataobject->id_user = $id_user;
        $dataobject->timestamp = time();
        $dataobject->string = json_encode($arr);
        $DB->insert_record('block_edu_global', $dataobject);
    } else {
        $param = new stdClass();
        $param->id = $datatemp->id;
        $param->id_user = $id_user;
        $param->timestamp = time();
        $param->string = json_encode($arr);
        $DB->update_record('block_edu_global', $param, $bulk = false);
    }
}

function test_set_global($id_user, $arr)
{
    global $CFG, $DB;
    $dataobject = new stdClass();
    $dataobject->id_user = $id_user;
    $dataobject->timestamp = time();
    $dataobject->string = $arr;
    $DB->insert_record('block_edu_global', $dataobject);
}

function test_get_global($id_user)
{
    global $CFG, $DB;
    echo 'test_get_global';
    $datatemp = $DB->get_record('block_edu_global', array('id_user' => $id_user));
    return global_decode($datatemp->string);
}

function global_encode($text){
    $specChars = array(
        '\'' => "\\'",
        '"' => '"',
        '\\' => '\\\\',
    );
    return str_replace(array_keys($specChars), array_values($specChars), $text);
}

function global_decode($text){
    $specChars = array(
        '\'' => "\\'",
        '"' => '"',
        '\\' => '\\\\',
    );
    return str_replace(array_values($specChars), array_keys($specChars), $text);    
}