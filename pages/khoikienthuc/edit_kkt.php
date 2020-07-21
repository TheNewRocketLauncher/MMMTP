<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;
define("EDIT_MODE_EDIT", 1);
define("EDIT_MODE_CLONE", 0);

$courseid = optional_param('courseid', SITEID, PARAM_INT);
$ma_khoi = optional_param('ma_khoi', NULL, PARAM_ALPHANUMEXT);
$edit_mode = optional_param('edit_mode', EDIT_MODE_CLONE, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));
if($edit_mode == 1){
    $PAGE->navbar->add('Cập nhật khối kiến thức');
} else{
    $PAGE->navbar->add('Thêm khối mới');
}
// Title.
if($edit_mode == 1){
    $PAGE->set_title('Cập nhật khối kiến thức');
} else{
    $PAGE->set_title(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
}
if($edit_mode == 1){
    $PAGE->set_heading('Cập nhật khối kiến thức');
} else{
    $PAGE->set_heading(get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
}
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

$mform = new editkkt_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/index.php");
} else if ($mform->no_submit_button_pressed()) {
    if($mform->get_submit_value('btn_cancle')){
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/index.php");
    } else if ($mform->get_submit_value('btn_review')){
        $arrmamon = $mform->get_submit_value('area_mamonhoc');
        $arr_makhoi = $mform->get_submit_value('area_ma_khoi');

        if(!is_array($arrmamon) && !is_array($arr_makhoi)){
            $mform->display();
            echo 'Không có gì để hiển thị';
        } else{
            $mform->display();
            print_table_Monthuockhoi($arrmamon, $arr_makhoi);
        }
    } else{
        $arrmamon = $mform->get_submit_value('area_mamonhoc');
        $arr_makhoi = $mform->get_submit_value('area_ma_khoi');

        if(is_array($arrmamon) || is_array($arr_makhoi)){
            if($mform->get_submit_value('btn_newkkt')){
                $fromform->txt_makhoi = $mform->get_submit_value('txt_makhoi');
                $fromform->select_loaikhoi = $mform->get_submit_value('select_loaikhoi');
                $fromform->select_xettren = $mform->get_submit_value('select_xettren');
                $fromform->txt_xettren_value = $mform->get_submit_value('txt_xettren_value');
                $fromform->txt_tenkkt = $mform->get_submit_value('txt_tenkkt');
                $fromform->txt_mota = $mform->get_submit_value('txt_mota');
                $fromform->area_mamonhoc = $mform->get_submit_value('area_mamonhoc');
                $fromform->area_ma_khoi = $mform->get_submit_value('area_ma_khoi');
                add_newkkt($fromform);
                redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/index.php");
            } else if($mform->get_submit_value('btn_edit')){
                $fromform->txt_makhoi = $mform->get_submit_value('txt_makhoi');
                $fromform->select_loaikhoi = $mform->get_submit_value('select_loaikhoi');
                $fromform->select_xettren = $mform->get_submit_value('select_xettren');
                $fromform->txt_xettren_value = $mform->get_submit_value('txt_xettren_value');
                $fromform->txt_tenkkt = $mform->get_submit_value('txt_tenkkt');
                $fromform->txt_mota = $mform->get_submit_value('txt_mota');
                $fromform->area_mamonhoc = $mform->get_submit_value('area_mamonhoc');
                $fromform->area_ma_khoi = $mform->get_submit_value('area_ma_khoi');
                $fromform->ma_khoi = $mform->get_submit_value('ma_khoi');
                edit_kkt($fromform);
                redirect("$CFG->wwwroot/blocks/educationpgrs/pages/khoikienthuc/index.php");
            }
        } else{
            echo 'Môn học phải ít nhất có một khối con hoặc một môn học';
            $mform->display();
        }
    } 
} else if ($fromform = $mform->get_data()) {
    // Submit form này làm cho page reload nhưng vẫn chạy setDefault ở bên dưới -> Mất sạch toàn bộ form data trước, 
    // Có lẽ data mất mát này được truyền sang page mới dưới dạng $_SESSION hoặc bằng $_POST ?!
} else {
    if($ma_khoi != NULL){
        $khoi = get_kkt_byMaKhoi($ma_khoi);
        $listmon = get_list_monhoc($ma_khoi);
        $listkhoi = get_list_khoicon($ma_khoi);

        $defaultData = array();

        if($edit_mode == EDIT_MODE_EDIT){
            $defaultData += ['edit_mode' => EDIT_MODE_EDIT];
            $defaultData += ['ma_khoi' => $ma_khoi];
            $defaultData += ['area_mamonhoc' => $listmon];
            $defaultData += ['area_ma_khoi' => $listkhoi];
            $defaultData += ['txt_tenkkt' => $khoi->ten_khoi];
            $defaultData += ['txt_makhoi' => $khoi->ma_khoi];
            $defaultData += ['txt_mota' => $khoi->mota];
            $defaultData += ['select_loaikhoi' => $khoi->id_loai_kkt];
            $defaultData += ['area_mamonhoc' => $listmon];
        } else if($edit_mode == EDIT_MODE_CLONE){
            $defaultData += ['edit_mode' => EDIT_MODE_CLONE];
            $defaultData += ['area_mamonhoc' => $listmon];
            $defaultData += ['area_ma_khoi' => $listkhoi];
            $defaultData += ['txt_tenkkt' => $khoi->ten_khoi];
            $defaultData += ['txt_mota' => $khoi->mota];
            $defaultData += ['select_loaikhoi' => $khoi->id_loai_kkt];
            $defaultData += ['area_mamonhoc' => $listmon];
        }

        if($khoi->id_loai_kkt == 1){
            $dieukien = get_dieukien_kkt(NULL, $khoi->ma_dieukien, NULL, NULL, NULL, NULL);
            switch ($dieukien->xet_tren) {
                case 'sotinchi':
                    $xet_tren = 0;
                    break;
                case 'sotietlythuyet':
                    $xet_tren = 1;
                    break;
                case 'sotietthuchanh':
                    $xet_tren = 2;
                    break;
                case 'sotiet_baitap':
                    $xet_tren = 3;
                    break;
                default:
                $xet_tren = NULL;
            }

            $defaultData += ['select_xettren' => $xet_tren];
            $defaultData += ['txt_xettren_value' => $dieukien->giatri_dieukien];
        }

        $mform->set_data($defaultData);

        $mform->display();
        print_table_Monthuockhoi($listmon, $listkhoi);
    } else if($mform->get_submit_value('ma_khoi') == NULL){
        echo 'Không tìm thấy mã khối';
    }
}

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
    $all_khoi = get_list_khoicon_byMaKhoi($ma_khoi);

    $listkkt = array();
    foreach($all_khoi as $item){
        $listkkt[] = $item->ma_khoi;
    }
    
    return $listkkt;
}

function print_table_Monthuockhoi($arrmamon, $arr_makhoi){
    global $DB, $USER;

    $stt = 1;
    if($arr_makhoi != NULL && is_array($arr_makhoi)){
        foreach($arr_makhoi as $item){
            $khoi = get_kkt_byMaKhoi($item);
            echo '<h2>[' . $khoi->ma_khoi . '] ' . $khoi->ten_khoi . '</h2>';

            $table = new html_table();
            $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');

            $listmonthuockhoi = get_monthuockhoi($item);
            if($listmonthuockhoi != NULL){
                foreach($listmonthuockhoi as $mon){
                    $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $mon->mamonhoc]);
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
    if($arrmamon != NULL && is_array($arrmamon)){
        echo '<h2>Danh sách các môn học</h2>';

        $table = new html_table();
        $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');
        
        foreach($arrmamon as $key => $item){
            $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $item]);
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
    if(is_array($fromform->area_mamonhoc)){
        $arr_mon = $fromform->area_mamonhoc;
    }

    $arr_makhoi = NULL;
    //Lấy danh sách khối con nếu có
    if(is_array($fromform->area_ma_khoi)){
        $arr_makhoi = $fromform->area_ma_khoi;
    }

    insert_kkt($param_khoi, $arr_mon, $arr_makhoi);
    echo 'Thêm mới thành công';
}

function edit_kkt($fromform){
    if(!can_edit_kkt($ma_khoi)){
        return false;
    }

    if($fromform->ma_khoi != null){
        delete_kkt_byMaKhoi($fromform->ma_khoi);
        add_newkkt($fromform);
    } else{
        echo 'Không tìm thấy mã khối';
    }
}

