<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);

function delete_chuandaura_ctdt($id) {
    
    global $DB, $USER, $CFG, $COURSE;
    $current_cdr = $DB->get_record('block_edu_chuandaura_ctdt', ['id' => $id]);    
    $ma_cdr = $current_cdr->ma_cdr;
    $All_ctdt = $DB->get_records('block_edu_chuandaura_ctdt', []);

    foreach($All_ctdt as $item){
        if(startsWith( $item->ma_cdr, $ma_cdr)){
                $DB->delete_records('block_edu_chuandaura_ctdt', ['ma_cdr' => $item->ma_cdr]);        
        };
    }
}
delete_chuandaura_ctdt($id);

function startsWith($haystack, $needle) // kiem tra trong chuỗi hastack có đưuọc bắt đầu bằng chuỗi needle ko
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
    exit;



