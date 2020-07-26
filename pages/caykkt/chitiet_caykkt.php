<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/caykkt_model.php');
require_once('../../model/global_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("caykkt", "edit");

$ma_cay_khoikienthuc = optional_param('ma_cay', NULL,  PARAM_NOTAGS);



///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_caykhoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/caykkt/index.php'));
// Title.
$PAGE->set_title('Chi tiết cây');
$PAGE->set_heading('Chi tiết cây');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

// EXPORT KKT here




$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Chỉnh sửa',
        array('id' => 'btn_editmode', 'onClick' => "window.location.href='edit_caykkt_ttc.php?ma_cay=$ma_cay_khoikienthuc&edit_mode=1'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone',
        array('id' => 'btn_clone', 'onClick' => "window.location.href='edit_caykkt_ttc.php?ma_cay=$ma_cay_khoikienthuc'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Trở về',
        array('id' => 'btn_back', 'onClick' => "window.location.href='index.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
     . html_writer::end_tag('div')
    . '<br>';
echo $action_form;
echo '<br>';

if($ma_cay_khoikienthuc != NULL){
    print_ctcaykkt_table_caykkt($ma_cay_khoikienthuc);
}






 // Footer
echo $OUTPUT->footer();

///----------------------------------------------------------------------------------------------------------------------///        
/// FUNCTION

function print_ctcaykkt_table_caykkt($ma_cay_khoikienthuc){
    $list_caykkt = get_list_caykkt_byMaCay($ma_cay_khoikienthuc);
    // echo json_encode($list_caykkt);

    foreach($list_caykkt as $item){
        if($item->ma_tt != NULL && $item->ma_khoicha != NULL && $item->ma_khoi != 'caykkt'){
            $khoi = get_kkt_byMaKhoi($item->ma_khoi);
            echo '<h4>' . $item->ma_tt . ' ' . $khoi->ten_khoi . '<h4>';

            print_ctcaykkt_table_kkt($item->ma_khoi);
        }
    }

}


function print_ctcaykkt_table_kkt($ma_khoi){
    print_preview_table_kkt(get_list_monhoc($ma_khoi), get_list_khoicon($ma_khoi));
}

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

function print_preview_table_kkt($arrmamon, $arr_makhoi){
    global $DB, $USER;

    $allmonhocs = array();
    $stt = 1;

    $table = new html_table();
    $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');

    if($arrmamon != NULL){
        
        foreach($arrmamon as $key => $item){
            $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $item]);
            $table->data[] = [(string) $stt, (string) $item, (string) $imonhoc['tenmonhoc_vi'],
                                (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                                (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']];
            $stt++;
        }
    }

    if($arr_makhoi != NULL){
        foreach($arr_makhoi as $item){
            $khoi = get_kkt_byMaKhoi($item);
            
            $table->data[] = [$stt, $khoi->mota, '', '', '' , '', ''];
            $stt++;

            $listmonthuockhoi = get_monthuockhoi($item);
            if($listmonthuockhoi != NULL){
                foreach($listmonthuockhoi as $mon){
                    $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $mon->mamonhoc]);
                    $table->data[] = ['', (string) $mon->mamonhoc, (string) $imonhoc['tenmonhoc_vi'],
                                        (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                                        (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']];
                }
            }
        }
    }
    
    if($table->data != NULL){
        echo html_writer::table($table);
    }
}