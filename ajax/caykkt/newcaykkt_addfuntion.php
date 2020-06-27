<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/global_model.php');

$id = required_param('id', PARAM_ALPHANUMEXT);
$type = required_param('type', PARAM_ALPHANUMEXT);
$paramfirst = required_param('paramfirst', PARAM_ALPHANUMEXT);
// $paramsecond = required_param('paramsecond', PARAM_ALPHANUMEXT);

function get_current_list(){
    global $USER;
    $current_global = get_global($USER->id);
    if($current_global == null){
        $current_global = array(
            'newcaykkt' => array(),
        );
        set_global($USER->id, $current_global);
    } else if(empty($current_global)){
        $current_global = array(
            'newcaykkt' => array(),
        );
        set_global($USER->id, $current_global);
    } else if(array_key_exists('newcaykkt', $current_global)){
        return $current_global;
    } else {
        $current_global[] = array(
            'newcaykkt' => array(),
        );
        set_global($USER->id, $current_global);
    }
    return $current_global['newcaykkt'];


}

function update_global($newcaykkt){
    global $USER;
    $current_global = get_global($USER->id);
    $current_global['newcaykkt'] = $newcaykkt;
    set_global($USER->id, $current_global);
}

function moveUp($id, $paramfirst){

}

function moveDown($index){

}

function add_khoidautien($paramfirst){
    $current_list = get_current_list();
    $current_list[] = array('name' => $paramfirst,
        'index' => '1',
        'level' => 1,
    );
    $current_list = sort_list($current_list);
    update_global($current_list);
}

function add_khoiCungCap($id, $paramfirst){
    $current_list = get_current_list();
    $level = $current_list[$id]['level'];
    $lastIndex = $current_list['id']['index'];
    foreach($current_list as $key => $item){
        if($level == $item['level'] && strpos($item, $lastIndex) === 0 && $id != $key){
            $lastIndex = $item['index'];
        }
    }

    $arr = explode( '.', $lastIndex);
    $arr[$level-1]++;
    foreach($arr as $item){
        $index .= $item;
    }
    $current_list[] = array('name' => $paramfirst,
        'index' => $index,
        'level' => $level,
    );

    $current_list = sort_list($current_list);
    update_global($current_list);
}

function add_khoiCon($id, $paramfirst){
    $current_list = get_current_list();
    $level = $current_list[$id]['level']++;
    $lastIndex = $current_list['id']['index'] .= 0;
    foreach($current_list as $key => $item){
        if($level == $item['level'] && strpos($item, $lastIndex) === 0){
            $lastIndex = $item['index'];
        }
    }

    $arr = explode( '.', $lastIndex);
    $arr[$level-1]++;
    foreach($arr as $item){
        $index .= $item;
    }
    $current_list[] = array('name' => $paramfirst,
        'index' => $index,
        'level' => $level,
    );

    $current_list = sort_list($current_list);
    update_global($current_list);
}

function removeLeafChild($id){
    $current_list = get_current_list();
    $level = $current_list[$id]['level'];
    foreach($current_list as $key => $item){
        if($level == $item['level'] && strpos($item, $lastIndex) === 0){
            $index = $current_list[$key]['index'];
            $arr = explode( '.', $index);
            if($index > $current_list[$id]['index']){
                $current_list[$key]['index']--;
            }
        } else if($level > $item['level'] && strpos($item, $lastIndex) === 0){
            unset($current_list[$key]);
        }
    }
    unset($current_list[$id]);
    sort_list($current_list);
}

function sort_list($list){
    $result = array();

    $listPoint = array();
    foreach($list as $item){
        $listPoint[] = $item['index'];
    }

    // SORT Array
    asort($listPoint);
    // Replace old id
    foreach($listPoint as $key => $item){
        $result[] = array(
            'name' => $list[$key]['name'],
            'index' => $list[$key]['index'],
            'level' => $list['level'],
        );
    }
    
    return $result;
}
$result = array(
    'error' => 0,
    'mess' => '',
);
$current_list = get_current_list();

if(empty($current_list)){
    add_khoidautien($paramfirst);
} else{
    if($id == 'nocheck'){
        $result['error'] = 1;
        $result['mess'] = 'Không có khối nào được chọn';
    }
    switch ($type){
        case 1:
            add_khoiCungCap($id, $paramfirst);
        break;
        case 2:
            add_khoiCon($id, $paramfirst);
        break;
        case 3:
            removeLeafChild($id);
        break;
        case 4:
            moveUp($paramfirst);
        break;
        case 5:
            moveDown($paramfirst);
        break;
        default:
    }
}

echo json_encode($result);
exit;


