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
$PAGE->navbar->add('Xác nhận hoàn tất cây mới');
// Title.
$PAGE->set_title('Thêm cây mới');
$PAGE->set_heading('Thêm cây mới');
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///

// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . html_writer::tag(
        'button',
        'Helloworld',
        array('id' => 'btn_newcaykkt_toChild', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #z; color:#fff;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone BDT',
        array('id' => 'btn_newcaykkt_toFather', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #1177d1; color:#fff;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

print_caykkt();

 // Footere
echo $OUTPUT->footer();




///-------------------------------------------------------------------------------------------------------///
function print_caykkt(){
    $current_list = get_lastList();
    if(count($currenList) != 0){
        $table = init_caykkt_table();
 
        echo html_writer::table($table);
    
        echo '<br>';
        echo '    ';
        echo \html_writer::tag(
            'button',
            'Xóa caykkt',
            array('id' => 'btn_caykkt_'));
    }

    $table = init_caykkt_table();
 
    echo html_writer::table($table);

    echo '  ';
    echo \html_writer::tag(
        'button',
        'Xóa caykkt',
        array('id' => 'btn_delete_caykkt'));
}

function init_caykkt_table(){

}

function get_lastList(){
    global $USER;
    define_global();
    $arr = get_global($USER->id);

    return $arr['newcaykkt'];
}

function define_global(){
    global $USER;
    $arr = get_global($USER->id);
    if($arr == NULL){
        $arr = array('newcaykkt' => array());
        set_global($USER->id, $arr);
    } else if(!array_key_exists('newcaykkt', $arr)){
        $arr[] = ['newcaykkt' => array()];
        set_global($USER->id, $arr);
    }
}

function on_btn_updateList($newList){
    checkingChange($newList);
}

function checkingChange($newList){
    $currenList = get_last_list_khoi($firstList);
    if(count($currenList) != count($newList)){
        init_newcaykkt($newList);
        return;
    }
    foreach($newList as $item){
        if(array_search($item, $currenList) !== false){
            init_newcaykkt($newList);
            return;
        }
    }
}

function init_newcaykkt($arr){
    $result = array();
    foreach($arr as $item){
        $result[] = array(
            'name' => $item,
            'index' => 0,
            'value' => array(),
        );
    }
    update_caykkt_toGlobal($result);
}

function update_caykkt_toGlobal($arrcay){
    global $USER;
    define_global();
    $current_global = get_global($USER->id);
    $current_global['newcaykkt'] = $arrcay;
    set_global($USER->id, $current_global);
}

function get_last_list_khoi($arr){
    $arrListKhoi = array();
    if(count($arr) != 0){
        foreach($arr as $item){
            $arrListKhoi[] = $item['name'];
            if($item['index'] != 0){
                foreach(get_last_list_khoi($item['value']) as $item_){
                    $arrListKhoi[] = $item_;
                }
            }
        }
        return $arrListKhoi;
    }
    return $arrListKhoi;
}

function moveIn($childName){
    $arr = get_lastList();

    $arr = changePosIn($childName, $arr);
}

function printListkkt($newListkkt){
    $arrTree = array(
        0 => array(
            'value' => array(),
            'name' => '',
            'index' => 0,
    ));
}

function changePosIn($childName, $arr){
    $result = $arr;
    foreach($arr['value'] as $key => $item){
        if ($item['name'] == $childName){
            if($item['index'] == 0){
                return $arr;
            } else{ 
                $arr[$key - 1]['value'] += [$arr[$key - 1]['index'] => $item];
                $arr[$key - 1]['index']++;
                unset($arr[$key]);
                $arr['index']--;
            }
            return $result;
        }
        $looparr = changePosIn($childName, $item);
        if($looparr['index'] != $item['index']){
            $result[$key] = $looparr;
            return $result;
        }
    }

    return $result;
}
?>
