<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');
require_once('../../js.php');

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
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/block_edu.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));
$PAGE->navbar->add(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/newkkt.php'));
// Title.
$PAGE->set_title(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

$globla_string = get_global($USER->id);
$listmon = $globla_string['newkkt']['listmonhoc'];
$listkhoi = $globla_string['newkkt']['listkhoicon'];

defineListArray();
$mform = new newkkt_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($mform->no_submit_button_pressed()) {
    if($mform->get_submit_value('btn_cancle')){
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/index.php");
    } else if ($mform->get_submit_value('btn_addmonhoc')) {
        $newmonhoc = $mform->get_submit_value('select_mamonhoc');
        if(!alreadyAddMonhoc($newmonhoc)){
            $globla_string = get_global($USER->id);
            $globla_string['newkkt']['listmonhoc']['values'] += [$globla_string['newkkt']['listmonhoc']['index'] => $newmonhoc];
            $globla_string['newkkt']['listmonhoc']['index'] += 1;
            set_global($USER->id, $globla_string);
        } else{
            echo 'Môn học đã được thêm vào';
        }
        $listmon = $globla_string['newkkt']['listmonhoc'];
        // $mform->set_data(['btn_addmonhoc' => false]);
    } else if ($mform->get_submit_value('btn_addkhoicon')) {
        $newkhoicon = $mform->get_submit_value('select_makhoicon');
        if(!alreadyAddKhoiCon($newkhoicon)){

        }
        $listkhoi = $globla_string['newkkt']['listkhoicon'];
    }
    $mform->set_data($datatest);
    $mform->display();
} else if ($fromform = $mform->get_data()) {

    $param_khoi = new stdClass();
    $param_khoi->ma_khoi = $mform->get_submit_value('txt_makhoi');
    if($fromform->select_loaikhoi == 0){
        $param_khoi->id_loai_kkt = 0;
        $param_khoi->co_dieukien = 0;
        $param_khoi->ma_dieukien = NULL;
    } else if($fromform->select_loaikhoi == 1){
        $param_khoi->id_loai_kkt = 1;
        $param_khoi->co_dieukien = 1;

        // Kiểm tra mã điều kiện có tồn tại
        switch ($fromform->select_xettren) {
            case 0:
                $xet_tren = 'sotinchi';
                break;
            case 1:
                $xet_tren = 'sotietlythuyet';
                break;
            case 2:
                $xet_tren = 'sotietthuchanh';
                break;
            case 3:
                $xet_tren = 'sotiet_baitap';
                break;
            default:
            $xet_tren = NULL;
        }
        
        $giatri_dieukien = $fromform->txt_xettren_value;
        $list_dieukien = get_dieukien_kkt(NULL, NULL, NULL, $xet_tren, $giatri_dieukien, NULL);
        if($list_dieukien == NULL){
            $param_dieukien_kkt = new stdClass();
            $param_dieukien_kkt->ma_dieukien = 'AUTO_CREATE';
            $param_dieukien_kkt->ma_loaidieukien = 'AUTO_CREATE'.$xet_tren.$giatri_dieukien;
            $param_dieukien_kkt->xet_tren = $xet_tren;
            $param_dieukien_kkt->giatri_dieukien = $giatri_dieukien;
            $param_dieukien_kkt->ten_dieukien = NULL;
            $param_dieukien_kkt->mota = NULL;
            $id = insert_dieukien_kkt($param_dieukien_kkt);
            $param_khoi->ma_dieukien = get_dieukien_kkt($id)->ma_dieukien;
        } else{
            echo 'insert_dieukien_kkt NOT NULL';
            $param_khoi->ma_dieukien = $list_dieukien->ma_dieukien;
        }
    } else{ //default
        $param_khoi->co_dieukien = 0;
        $param_khoi->id_loai_kkt = 0;
        $param_khoi->ma_dieukien = NULL;
    }
    $param_khoi->ten_khoi = $fromform->txt_tenkkt;
    $param_khoi->mota = $fromform->txt_mota;
    
    //Lấy danh sách môn thuộc khối nếu có
    if($fromform->checkbox_comonhoc == true){
        if($listmon['index'] != 0){
            $arr_mon = $listmon['values'];
        } else{
            $arr_mon = NULL;
        }
    } else{
        $arr_mon = NULL;
    }

    insert_kkt($param_khoi, $arr_mon);
    echo 'Thêm mới thành công';

    $resetarr = array();
    $globla_string['newkkt'] = $resetarr;
    set_global($USER->id, $globla_string);
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/index.php");
} else {
    $mform->set_data($datatest);
    $mform->display();
}

//Table monhoc
printMonTable($listmon['values']);
 // Footere
echo $OUTPUT->footer();




function validatedata(){
    
    // $str = get_global($USER->id);
    // if(empty($str)){}
    return true;
}

function get_monthuockhoi_table(){
    global $USER;
    $arr = get_global($USER->id);
}

function printMonTable($arrmamon){
    global $DB, $USER;
    $table = new html_table();
    $table->head = array('', 'STT', 'Mã môn học', 'Tên môn học', 'Số TC', 'LT', 'TH', 'BT');

    $allmonhocs = array();
    foreach($arrmamon as $key => $item){
        $imonhoc = (array) $DB->get_record('block_edu_monhoc', ['mamonhoc' => $item]);
        $allmonhocs += [$key => $imonhoc];
    }
    $stt = 1;
    foreach ($allmonhocs as $imonhoc) {
        $checkbox = html_writer::tag('input', ' ', array('class' => 'kktlistmon', 
                            'type' => "checkbox", 'name' => $imonhoc['mamonhoc'], 
                            'id' => 'kktlistmon' . $imonhoc['id'], 'value' => '0', 
                            'onclick' => "changecheck_listmonthuockhoi($imonhoc[id])"));
        $table->data[] = [$checkbox, (string) $stt, (string) $imonhoc['mamonhoc'], (string) $imonhoc['tenmonhoc_vi'], (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'], (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']];
        $stt = $stt + 1;
    }

    echo html_writer::table($table);

    //Print Delete Button
    echo '   ';
    echo \html_writer::tag(
        'button',
        'Bỏ chọn môn',
        array('id' => 'btn_remove_subject_from_list_mon'),
    );
}

function defineListArray(){
    global $USER;
    $arr = get_global($USER->id);
    if($arr == NULL){
        $arr = array('newkkt' => array(
            'listmonhoc' => array(
                'values' => array(),
                'index' => 0,
            ),
            'listkhoicon' => array(
                'values' => array(),
                'index' => 0,
            )
        ));
        set_global($USER->id, $arr);
    } else if(!array_key_exists('newkkt', $arr)){
        $arr += ['newkkt' => array(
            'listmonhoc' => array(
                'values' => array(),
                'index' => 0,
            ),
            'listkhoicon' => array(
                'values' => array(),
                'index' => 0,
            )
        )];
        set_global($USER->id, $arr);
    } else{
        $arrnewkkt = $arr['newkkt'];
        if(!array_key_exists('listmonhoc', $arrnewkkt)){
            $arr['newkkt'] += ['listmonhoc' => array(
                'values' => array(),
                'index' => 0,
            )];
            set_global($USER->id, $arr);
        }
        if(!array_key_exists('listkhoicon', $arrnewkkt)){
            $arr['newkkt'] += ['listkhoicon' => array(
                'values' => array(),
                'index' => 0,
            )];
            set_global($USER->id, $arr);
        }
    }

}

function alreadyAddMonhoc($newmonhoc){
    global $USER;
    $arr = get_global($USER->id);
    $cur_listmon = $arr['newkkt']['listmonhoc']['values'];

    if($cur_listmon == null){
        return false;
    } else{
        if(in_array($newmonhoc, $cur_listmon)){
            return true;
        }
    }
    return false;
}

function alreadyAddKhoiCon($newkhoicon){
    global $USER;
    $arr = get_global($USER->id);
    $cur_listkhoi = $arr['newkkt']['listkhoicon']['values'];

    if($cur_listkhoi == null){
        return false;
    } else{
        if(in_array($newkhoicon, $cur_listkhoi)){
            return true;
        }
    }
    return false;
}
?>