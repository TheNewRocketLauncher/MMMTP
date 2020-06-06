<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');

function userIsAdmin(){
    return true;

}
// Return Json object
function get_global($iduser){
    $datatemp = $DB->ger_record('block_edu_global', ['iduser' => $iduser]);
    
    if(empty($datatemp)){
        return NULL;
    }
    return json_decode($datatemp->string);
}

function set_global($iduser, $arr){
    $datatemp = $DB->ger_record('block_edu_global', ['iduser' => $iduser]);
    
    if(empty($datatemp)){
        $dataobject = new stdClass();
        $dataobject->id_user = $iduser;
        $dataobject->timestamp = time();
        $dataobject->string = json_encode($arr);
        $DB->insert_record($block_edu_global, $dataobject);
    } else{
        $param = new stdClass();
        $param->id = $datatemp->id;
        $param->id_user = $iduser;
        $param->timestamp = time();
        $dataobject->string = json_encode($arr);
        $DB->update_record('block_edu_ctdt', $param, $bulk=false);
    }
    
    return json_decode($datatemp->string);
}

function test_get_global(){
    // $datatemp = $DB->ger_record('block_edu_global', ['iduser' => $iduser]);
    
    // if(empty($datatemp)){
    //     return NULL;
    // }
    $str = '{
        "list_mon": {
            0: "Mon1"
            1: "Mon2"
            2: "Mon3"
            3: "Mon4"
        },
        "caykkt": "ADV"
    }';

    return json_decode($str);
}

    
?>