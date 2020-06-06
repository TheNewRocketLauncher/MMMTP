<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/bacdt_model.php');
require_once('../../model/hedt_model.php');
require_once('../../model/global_model.php');
// require_once('../../model/global_model.php');
// require_once('../../factory.php');

// Create button with method post
function button_method_post($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "post"))
    .html_writer::tag('input', ' ', array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}

// Create button with method get
function button_method_get($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "get"))
    .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}



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
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/block_edu.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));
$PAGE->navbar->add(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/newkkt.php'));
// Title.
$PAGE->set_title(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
echo $OUTPUT->header();


///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

$mform = new newkkt_form();

// $table = get_monhoc_table();
// echo html_writer::table($table);

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($mform->no_submit_button_pressed()) {
    if ($mform->get_submit_value('btn_newkkt')) {
            if(validatedata()){
                $param = new stdClass();
                $param->ma_khoi = $mform->get_submit_value('txt_khoa');;
                $param->id_loai_kkt = $mform->get_submit_value('txt_khoa');
                $param->co_dieukien = $mform->get_submit_value('txt_khoa');
                $param->ma_dieukien = $mform->get_submit_value('txt_khoa');
                $param->ten_khoi = $mform->get_submit_value('txt_khoa');
                $param->mota = $mform->get_submit_value('txt_khoa');

                $param_monhoc = get_global($USER->id);

                insert_kkt($param);

            }


        
        $index = $mform->get_submit_value('txt_bac');
        echo $index;

    } else if($mform->get_submit_value('btn_cancle')){
        
        $json = '{"list_mon": ["Mon1", "Mon2", "Mon3","Mon4"],"caykkt": "ADV"}';

        $str = json_decode($json, true);
        echo $str["list_mon"][0];

        $list_mon = $str["list_mon"];
        



        // echo $str;

        // echo '111111111111111';
        // $list_mon = $str->list_mon;
        // echo $list_mon[0];

        // foreach($list_mon as $i){
        //     //echo '111111111111111';
        //     echo $i[0];
        // }


        // $json = '{"a":14444,"b":2,"c":3,"d":4,"e":5}';
        // $test = json_decode($json);
        // echo $test->a;
        // var_dump(json_decode($json, true));
        
        //redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/index.php");
    }

    $mform->display();
    // if ($mform->get_submit_value('btn_newkkt')) {
    //     redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/newctdt.php");
    // }

} else if ($fromform = $mform->get_data()) {

    if(validatedata()){
        $param_khoi = new stdClass();
        $param_khoi->ma_khoi = $mform->get_submit_value('');
        $param_khoi->id_loai_kkt = $mform->get_submit_value('txt_makhoi');
        $param_khoi->co_dieukien = $mform->get_submit_value('txt_loaikhoi');
        $param_khoi->ma_dieukien = $mform->get_submit_value('txt_loaikhoi');
        $param_khoi->ten_khoi = $mform->get_submit_value('txt_tenkkt');
        $param_khoi->mota = $mform->get_submit_value('txt_mota');

        // $arr_mon = {'ma_monhocA', 'ma_monhocC', 'ma_monhocB'}
        $arr_mon = convertToArrayMon(get_global($USER->id));

        insert_kkt($param_khoi, $arr_mon);
    }

} else {
    // $datatest = array(
    //     txt_khoa => array(
    //         'lewd', 'mlem'
    //     ),
    //     txt_nganh => 'yes'
    // );

    $mform->set_data($datatest);

    // displays the form
    $mform->display();
}

function validatedata(){
    
    // $str = get_global($USER->id);
    // if(empty($str)){}
    return true;
}


 // Footere
echo $OUTPUT->footer();


?>
