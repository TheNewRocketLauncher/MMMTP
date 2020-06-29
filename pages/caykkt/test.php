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
    
    $id = 0;
    $type = 1;
    $paramfirst = '16CNTT-CN.1.1';

    $current_list = array();
    $current_list[] = ['name' => $paramfirst,
        'index' => '1',
        'level' => 1,
    ];
    $current_list[] = ['name' => $paramfirst,
        'index' => '1.1',
        'level' => 2,
    ];
    $current_list[] = ['name' => $paramfirst,
        'index' => '1.2',
        'level' => 2,
    ];
    $current_list[] = ['name' => $paramfirst,
        'index' => '2',
        'level' => 2,
    ];
    $current_list[] = ['name' => $paramfirst,
        'index' => '2.1',
        'level' => 2,
    ];

    
    $current_list = get_current_list();
    $index = explode('.', end($current_list)['index'])[0];

    echo count($current_list);
    $index++;
    echo $index;

    // $result = sort_list($current_list);
    // echo json_encode($result);

    //add_khoi($paramfirst);

    // switch ($type){
    //     case 1:
    //         add_khoiCungCap($id, $paramfirst);
    //     break;
    //     case 2:
    //         add_khoiCon($id, $paramfirst);
    //     break;
    //     case 3:
    //         removeLeafChild($id);
    //     break;
    //     case 4:
    //         moveUp($paramfirst);
    //     break;
    //     case 5:
    //         moveDown($paramfirst);
    //     break;
    //     default:
    // }
} else if ($fromform = $confirmFrom->get_data()) {
    
} else{

}
$confirmFrom->display();
 // Footere
echo $OUTPUT->footer();


///-------------------------------------------------------------------------------------------------------///
//FUNCTION

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
        return $current_global['newcaykkt'];
    } else {
        $current_global[] = array(
            'newcaykkt' => array(),
        );
        set_global($USER->id, $current_global);
    }

    var_dump($current_global);
    echo '<br>';
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

function add_khoi($paramfirst){
    $current_list = get_current_list();
    if(count($current_list) == 0){
        $index = '1';
    } else{
        $index = explode('.', end($current_list)['index'])[0] + 1;
    }

    $current_list[] = ['name' => $paramfirst,
        'index' => (string) $index,
        'level' => 1,
    ];
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

    // $current_list = sort_list($current_list);
    // update_global($current_list);
    sort_list($current_list);
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

function sort_list($current_list){
    $result = array();
    $sortList = array();
    foreach($current_list as $item){
        $sortList[] = $item['index'];
    }    

    asort($sortList);

    $result = array();
    foreach($sortList as $key => $item){
        $result[] =['name' => $current_list[$key]['name'],
                    'index' => $current_list[$key]['index'],
                    'level' => $current_list[$key]['level'],
        ];
    }

    return $result;
}