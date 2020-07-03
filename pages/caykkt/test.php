<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');

global $DB, $USER, $CFG, $COURSE;

$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}



///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/newkkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_caykhoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/caykkt/index.php'));
$PAGE->navbar->add('Thêm cây mới');
$PAGE->navbar->add('Chọn danh sách khối');
// Title.
$PAGE->set_title('Thêm cây mới');
$PAGE->set_heading('Thêm cây mới');
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/caykkt/newcaykkt_form.php');

$confirmFrom = new newcaykkt_form2();

//FORM Xác nhận
if ($confirmFrom->is_cancelled()) {
} else if ($confirmFrom->no_submit_button_pressed()) {
    
    $id = 7;
    $type = 1;
    $paramfirst = '16CNTT-CN.1.1';

    removeLeafChild($id);



} else if ($fromform = $confirmFrom->get_data()) {
    
} else{

}
$confirmFrom->display();
print_table();
 // Footere
echo $OUTPUT->footer();

function print_table(){
    global $DB, $USER, $CFG, $COURSE;
    $list = get_adding_list();

    if(empty($list)){
        echo 'Không có khối nào để hiển thị';
        return false;
    }

    $rows = [];
    foreach($list as $item){
        $khoi = get_kkt_byMaKhoi($item['name']);
        $mota = $khoi->name;
        $loaiktt = "Tự chọn";
        if ($i->id_loai_ktt === 0 ){
            $loaiktt = "Bắt buộc";
        }
        $rows[] = array(
            'index' => $item['index'],
            'ten_khoi' => $khoi->ten_khoi,
            'loaikhoi'=> $loaiktt,
            'mota' => $khoi->mota,
            'ma_khoi' => $item['name'],
        );
    }
    $table = new html_table();
    $table->head = array('', 'ID', 'Tên khối', 'Loại khối', 'Mô tả');
    $stt = 1;
    foreach ($rows as $item) {
        $checkbox = html_writer::tag('input', ' ', array('class' => 'add_caykkt_checkbox', 'type' => "checkbox", 'name' => $stt-1,   'id' => 'addcaykkt' . $stt, 'value' => '0', 'onclick' => "changecheck_checkbox_addcaykkt($stt)"));
        // $checkbox = html_writer::tag('input', ' ', array('class' => 'add_caykkt_checkbox', 'type' => "checkbox", 'name' => $item['ma_khoi'],   'id' => 'addcaykkt' . $stt, 'value' => '0', 'onclick' => "changecheck_checkbox_addcaykkt($stt)"));
        $table->data[] = [$checkbox, (string) $item['index'], (string) $item['ten_khoi'], (string) $item['loaikhoi'], (string) $item['mota']];
        $stt = $stt + 1;
    }
    echo html_writer::table($table);
    return true;
}
///-------------------------------------------------------------------------------------------------------///
//FUNCTION

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
    if($current_global == null){
        $current_global[] = array(
            'newcaykkt' => array(
                'value' => array(),
                'tencay' => '',
                'mota' => '',
            ),
        );
        set_global($USER->id, $current_global);
    } else if(empty($current_global)){
        $current_global[] = array(
            'newcaykkt' => array(
                'value' => array(),
                'tencay' => '',
                'mota' => '',
            ),
        );
        set_global($USER->id, $current_global);
    } else if(array_key_exists('newcaykkt', $current_global)){
        return $current_global['newcaykkt']['value'];
    } else {
        $current_global[] = array(
            'newcaykkt' => array(
                'value' => array(),
                'tencay' => '',
                'mota' => '',
            ),
        );
        set_global($USER->id, $current_global);
    }
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
    ];
    update_global_listkkt($current_list);
}

function add_khoiCungCap($id, $paramfirst){
    $current_list = get_current_list();
    $level = $current_list[$id]['level'];
    $lastIndex = $current_list[$id]['index'];
    foreach($current_list as $key => $item){
        if($level == $item['level'] && strpos($item['index'], $lastIndex) === 0 && $id != $key){
            $lastIndex = $item['index'];
        }
    }

    $arr = explode('.', $lastIndex);
    $arr[$level-1]++;
    foreach($arr as $item){
        $index .= $item;
    }
    $current_list[] = array('name' => $paramfirst,
        'index' => $index,
        'level' => $level,
    );

    $current_list = sort_list($current_list);
    update_global_listkkt($current_list);
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
                    'index' => $current_list[$key]['index'],
                    'level' => $current_list[$key]['level'],
        ];
    }

    return $result;
}

// echo json_encode($result);
exit;


