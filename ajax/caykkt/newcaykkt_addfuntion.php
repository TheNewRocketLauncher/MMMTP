<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/global_model.php');
require_once('../../model/khoikienthuc_model.php');
require_once('../../controller/auth.php');
require_permission("caykkt", "edit");
$id = required_param('id', PARAM_ALPHANUMEXT);
$type = required_param('type', PARAM_ALPHANUMEXT);
$paramfirst = required_param('paramfirst', PARAM_ALPHANUMEXT);
// $paramsecond = required_param('paramsecond', PARAM_ALPHANUMEXT);


// id: index Mã khối cha
// type: nocheck: thêm khối ở level 1 (khối đầu tiên)
// type:        1: thêm khối cùng cấp
// type:        2: thêm khối ở level 1 
// type:        3: Xoá bỏ khối và toàn bộ khối con của nó
// type:        4: Dời khối con lên trên
// type:        5: Dời khối con xuống dưới

if($id === 'nocheck'){
    add_khoi($paramfirst);
} else{
    // $id = get_khoi_id_inList($name);
    if($id != null){
        mainDo($id, $type, $paramfirst);
    } else{
        // $arr = array(
        //     'error' => 1,
        //     'mess' => 'id null'
        // );
        // echo json_encode($arr);
    }
}

function mainDo($id, $type, $paramfirst){
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


function get_current_list(){
    global $USER;
    $current_global = get_global($USER->id);
    return $current_global['newcaykkt']['value'];
}

function get_khoi_id_inList($name){
    $current_list = get_current_list();
    $index = 0;
    foreach($current_list as $item){
        if($item['name'] == $name){
            return $index;
        }
        $index++;
    }
    return null;
}

function update_global_listkkt($newcaykkt){
    global $USER;
    $current_global = get_global($USER->id);
    $current_global['newcaykkt']['value'] = $newcaykkt;
    set_global($USER->id, $current_global);
}

function moveUp($id, $paramfirst){

}

function moveDown($index){

}

function add_khoi($paramfirst){
    $current_list = get_current_list();
    if(count($current_list) == 0){
        $index = '1';
    } else{
        $index = explode('.', end($current_list)['index'])[0];
        $index++;
    }
    
    $current_list[] = ['name' => $paramfirst,
        'index' => (string) $index,
        'level' => 1,
        'fatherName' => '',
    ];
    update_global_listkkt($current_list);
}

function add_khoiCungCap($id, $paramfirst){
    $current_list = get_current_list();
    $level = $current_list[$id]['level'];
    if($level == 1){
        add_khoi($paramfirst);
    } else{
        $fatherName = '';
        foreach($current_list as $item){
            if($level-1 == $item['level'] && strpos($lastIndex, $item['index']) === 0){
                $fatherName = $item['name'];
            }
        }

        $lastIndex = $current_list[$id]['index'];
        foreach($current_list as $item){
            if($level == $item['level'] && $item['fatherName'] == $fatherName){
                $lastIndex = $item['index'];
            }
        }

        $arr = explode('.', $lastIndex);
        $arr[$level-1]++;

        $index = 'DM';
        foreach($arr as $item){
            $index = $index . '.' . $item;
        }
        $index = substr($index, 3, 999);

        $current_list[] = array('name' => $paramfirst,
            'index' => $index,
            'level' => $level,
            'fatherName' => $fatherName,
        );

        $current_list = sort_list($current_list);
        update_global_listkkt($current_list);
    }
}

function add_khoiCon($id, $paramfirst){
    $current_list = get_current_list();
    $level = $current_list[$id]['level'];
    $level++;

    $fatherIndex = $current_list[$id]['index'];
    $lastIndex = $current_list[$id]['index'] . '.0';

    foreach($current_list as $item){
        if($level == $item['level'] && strpos($item['index'], $fatherIndex) === 0){
            $lastIndex = $item['index'];
        }
    }

    //Thêm prefix vào trước khi ++ để php không hiểu lằm thành interger
    $index = 'DM' . $lastIndex;
    $index++;
    $index = substr($index, 2, 999);

    $current_list[] = array('name' => $paramfirst,
        'index' => (string) $index,
        'level' => $level,
        'fatherName' => $current_list[$id]['name'],
    );

    $current_list = sort_list($current_list);
    update_global_listkkt($current_list);
}

function removeLeafChild($id){
    $current_list = get_current_list();
    $delLevel = $current_list[$id]['level'];
    $delIndex = $current_list[$id]['index'];

    $fatherIndex = '';
    if($delLevel > 1){
        foreach($current_list as $item){
            if(strpos($delIndex, $item['index']) === 0 && $item['index'] !== $delIndex){
                $fatherIndex = $item['index'];
                break;
            }
        }
    }

    $i = 0;
    foreach($current_list as $item) {
        if($delLevel < ($item['level']) && strpos($item['index'], $delIndex) === 0){
            //Xoá con của item bị xoá
            unset($current_list[$i]); 
        } else if($delLevel !== 1){ 
            //Sửa index của các node cùng cấp với item bị xoá (nếu node bị xoá có level > 1)
            if($delLevel == ($item['level']) && strpos($item['index'], $fatherIndex) === 0){
                if($id < $i){
                    $arrIndex = explode('.', $item['index']);
                    $arrIndex[$delLevel-1]--;
                    $newIndex = '';
                    foreach($arrIndex as $item){
                        $newIndex = $newIndex . '.' . $item;
                    }
                    $newIndex = substr($newIndex, 1, 999);
                    $current_list[$i]['index'] = (string) $newIndex;
                }
            }
        } else if($delLevel === 1){
            //Sửa index của các node cùng cấp với item bị xoá (nếu node bị xoá có level = 1)
            if($item['index'] > $delIndex){
                $current_list[$i]['index']--;
            }
        }
        $i++;
    }

    unset($current_list[$id]);
    $current_list = sort_list($current_list);
    update_global_listkkt($current_list);
}

function sort_list($current_list){
    $result = array();
    $sortList = array();
    $keyList = array();
    echo '<br>KEY<br>';
    foreach($current_list as $item){
        $sortList[] = $item['index'];
        $key = array_search($item, $current_list);
        $keyList += [$key => $item['index']];
    }

    asort($sortList);

    $result = array();
    foreach($sortList as $k => $item){
        $key = array_search($item, $keyList);
        $result[] = ['name' => $current_list[$key]['name'],
                    'index' => (string) $current_list[$key]['index'],
                    'level' => $current_list[$key]['level'],
                    'fatherName' => $current_list[$key]['fatherName'],
        ];
    }

    return $result;
}

// echo json_encode($result);
exit;