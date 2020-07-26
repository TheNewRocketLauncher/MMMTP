<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
require_once('../../controller/auth.php');
require_permission("decuong", "edit");

function clone_decuongmonhoc($id)
{
    global $DB, $USER, $CFG, $COURSE;
    // $ma_dc= $DB->get_record('eb_decuong',['id'=>$id])->ma_decuong; 
    // //echo $ma_dc;

    // // Clone decuong
    // $param = $DB->get_record('eb_decuong', array('id' => $id));    
    // $param->id = null;
    // $param->ma_decuong = $param->ma_decuong . '_copy';
    // $DB->insert_record('eb_decuong', $param);

    // //clone muctieu
    // $param1= $DB->get_record('eb_muctieumonhoc',array('ma_decuong'=>$ma_dc));
    // $param1->id=null;
    // $param1->ma_decuong=$param1->ma_decuong.'_copy';
    // $DB->insert_record('eb_muctieumonhoc',$param1);

    // // //clone chuandaura
    // // $param2= $DB->get_record('eb_chuandaura',array('ma_decuong'=>$ma_dc));
    // // $param2->id=null;
    // // $param2->ma_decuong=$param2->ma_decuong.'_copy';
    // // $DB->insert_record('eb_chuandaura',$param2);

    // // //clone ke hoach giang day ly thuyet
    // // $param3= $DB->get_record('eb_kh_giangday_lt',array('ma_decuong'=>$ma_dc));
    // // $param3->id=null;
    // // $param3->ma_decuong=$param3->ma_decuong.'_copy';
    // // $DB->insert_record('eb_kh_giangday_lt',$param3);

    $rsx = $DB->get_record('eb_decuong', ['id'=>$id]);

    if($rsx){
        echo $rsx->ma_decuong;
    }
}
// Clone đề cương có id truyền vào
clone_decuongmonhoc($id);

exit;
