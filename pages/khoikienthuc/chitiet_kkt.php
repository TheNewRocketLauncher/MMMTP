<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;

$ma_khoi = optional_param('ma_khoi', 0, PARAM_ALPHANUMEXT);

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));
$PAGE->navbar->add(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php'));
// Title.
$PAGE->set_title(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

// EXPORT KKT here




$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-center;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Chỉnh sửa',
        array('id' => 'btn_editmode', 'onClick' => "window.location.href='edit_kkt.php?ma_khoi=$ma_khoi'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-center;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone',
        array('id' => 'btn_editmode', 'onClick' => "window.location.href='edit_kkt.php?ma_khoi=$ma_khoi&edit_mode=1'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-center;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Trở về',
        array('id' => 'btn_editmode', 'onClick' => "window.location.href='index.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>';
echo $action_form;
echo '<br>';








 // Footere
echo $OUTPUT->footer();

///----------------------------------------------------------------------------------------------------------------------///        
/// FUNCTION

function get_list_monhoc($ma_khoi){
    $all_monthuockhoi = get_monthuockhoi($ma_khoi);

    $listmon = array();
    foreach($all_monthuockhoi as $item){
        $listmon[] = $item->mamonhoc;
    }
    return $listmon;
}

function get_list_khoicon($ma_khoi){
    $all_khoi = get_list_kkt_byMaKhoi($ma_khoi);

    $listkkt = array();
    foreach($all_khoi as $item){
        $listkkt[] = $item->ma_khoi;
    }
    
    return $listkkt;
}

function print_table_Monthuockhoi($arrmamon, $arr_makhoi){
    global $DB, $USER;

    $stt = 1;
    if($arr_makhoi != NULL){
        foreach($arr_makhoi as $item){
            $khoi = get_kkt_byMaKhoi($item);
            echo '<h2>[' . $khoi->ma_khoi . '] ' . $khoi->ten_khoi . '</h2>';

            $table = new html_table();
            $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');

            $listmonthuockhoi = get_monthuockhoi($item);
            if($listmonthuockhoi != NULL){
                foreach($listmonthuockhoi as $mon){
                    $imonhoc = (array) $DB->get_record('block_edu_monhoc', ['mamonhoc' => $mon->mamonhoc]);
                    $table->data[] = [(string) $stt, (string) $imonhoc['mamonhoc'], (string) $imonhoc['tenmonhoc_vi'],
                                        (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                                        (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']];
                    $stt++;
                }
            }
            echo html_writer::table($table);
        }
    }

    $allmonhocs = array();
    if($arrmamon != NULL){
        echo '<h2>Danh sách các môn học</h2>';

        $table = new html_table();
        $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');
        
        foreach($arrmamon as $key => $item){
            $imonhoc = (array) $DB->get_record('block_edu_monhoc', ['mamonhoc' => $item]);
            $table->data[] = [(string) $stt, (string) $imonhoc['mamonhoc'], (string) $imonhoc['tenmonhoc_vi'],
                                (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                                (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']];
            $stt++;
        }
        echo html_writer::table($table);
    }
}

function add_newkkt($fromform){
    $param_khoi = new stdClass();
    $param_khoi->ma_khoi = $fromform->txt_makhoi;
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
    
    $arr_mon = NULL;
    //Lấy danh sách môn thuộc khối nếu có
    if($fromform->checkbox_comonhoc == true){
        $arr_mon = $fromform->area_mamonhoc;
    }

    $arr_makhoi = NULL;
    //Lấy danh sách khối con nếu có
    if($fromform->checkbox_cokhoicon == true){
        $arr_makhoi = $fromform->area_ma_khoi;
    }

    insert_kkt($param_khoi, $arr_mon, $arr_makhoi);
    echo 'Thêm mới thành công';
}

?>