<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
$id = required_param('id', PARAM_INT);
function clone_chuandaura_ctdt($id) {
    global $DB, $USER, $CFG, $COURSE;    
    $param = $DB->get_record('block_edu_chuandaura_ctdt', array('id' => $id));
    $param->id = null;
    $param->ten = $param->ten . '_copy';

    $rsx ="rsx";
    $ma_cdr_cha = "" ;
    $level_con = intval($param->level_cdr);
    
    if ($level_con == 1){
        $rsx = handle("0");
    
    }
    else{
        $level_cha = intval($level_con) - 1 ;
        
        $rows = $DB->get_records('block_edu_chuandaura_ctdt', ['level_cdr' => $level_cha] );
        foreach($rows as $item){
            if (startsWith($param->ma_cdr, $item->ma_cdr)){
                $ma_cdr_cha = $item->ma_cdr;
            }
        }
        $rsx = handle($ma_cdr_cha); 
    
       
    }
    $param->ma_cdr = $rsx;
    $DB->insert_record('block_edu_chuandaura_ctdt',$param);
}
clone_chuandaura_ctdt($id);

function handle( $ma_cdr_cha){
    global $DB, $USER, $CFG, $COURSE;
    if($ma_cdr_cha == "0"){
        $max = 0 ;
        $maxNew = 0 ;
        $maxOld = 0;
        $maxResult = 0 ;
        $rows_cdr = $DB->get_records('block_edu_chuandaura_ctdt', []);
        usort($rows_cdr, function($a, $b)
        {
           return strcmp($a->ma_cdr, $b->ma_cdr);
        });
        foreach ($rows_cdr as $item) {
            if($item->level_cdr == "1" ){     
                $maxOld = $maxNew; 
                if( $maxNew < getLastValue($item->ma_cdr)){
                    $maxNew = getLastValue($item->ma_cdr);
                }
                if (($maxNew-$maxOld)>1 && $maxResult == 0  ){
                    $maxResult = $maxOld  +1;
                }
            }        
        }  
        $max = $maxResult == 0 ? ($maxNew+1) : $maxResult;

        return $max;
    }
    
    else if (intval($ma_cdr_cha) >= 1) {
        $rows = $DB->get_record('block_edu_chuandaura_ctdt', ['ma_cdr' => $ma_cdr_cha]);
        $level_cha = $rows->level_cdr;
        $level_con = intval($level_cha) + 1;
        $rows_cdr = $DB->get_records('block_edu_chuandaura_ctdt', []);
        usort($rows_cdr, function($a, $b)
        {
           return strcmp($a->ma_cdr, $b->ma_cdr);
        });


        $maxNew = 0 ;
        $maxOld = 0;
        $maxResult = 0 ;
        foreach ($rows_cdr as $item) {
            if($item->level_cdr == $level_con && startsWith($item->ma_cdr ,$ma_cdr_cha)){ 
                $maxOld = $maxNew; 
                if( $maxNew < getLastValue($item->ma_cdr)){
                    $maxNew = getLastValue($item->ma_cdr);
                }
                if (($maxNew-$maxOld)>1 && $maxResult == 0  ){
                    $maxResult = $maxOld  +1;
                }
            }        
        }        
        $max = $maxResult == 0 ? ($maxNew+1) : $maxResult;
        $result = $ma_cdr_cha . '.' . ($max);
        return $result; 
    }

}

function startsWith($haystack, $needle) // kiem tra trong chuỗi hastack có đưuọc bắt đầu bằng chuỗi needle ko
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
function cmp($a, $b) {
    return strcmp($a->datatemp, $b->datatemp);
}
function getLastValue($item){
    $temp = explode(".",$item);
    $count = count($temp)-1;
    
    return $temp[$count];
}
    exit;