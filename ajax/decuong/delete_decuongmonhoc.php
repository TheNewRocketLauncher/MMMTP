<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
$courseid = required_param('course', PARAM_INT);




function delete_decuongmonhoc($id) {
    global $DB, $USER, $CFG, $COURSE;
    $ma_dc= $DB->get_record('eb_decuong',['id'=>$id])->ma_decuong;
    // echo "phongle";
    // echo $ma_dc;
    $DB->delete_records('eb_decuong', array('id' => $id));

    $DB->delete_records('eb_muctieumonhoc', array('ma_decuong' => $ma_dc));
    $DB->delete_records('eb_chuandaura', array('ma_decuong' => $ma_dc));
    $DB->delete_records('eb_kh_giangday_lt', array('ma_decuong' => $ma_dc));
    $DB->delete_records('eb_danhgiamonhoc', array('ma_decuong' => $ma_dc));
    $DB->delete_records('eb_tainguyenmonhoc', array('ma_decuong' => $ma_dc));
    $DB->delete_records('eb_quydinhchung', array('ma_decuong' => $ma_dc));
}
delete_decuongmonhoc($id);


    exit;
 
