<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/global_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;

$ma_khoi = optional_param('ma_khoi', 0, PARAM_NOTAGS);

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/add_kkt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));
// $PAGE->navbar->add($DB->get_record('eb_khoikienthuc', ['ma_khoi' => $ma_khoi])->ten_khoi, new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/chitiet_kkt.php', ['ma_khoi' => $ma_khoi]));
$isExist = false;
if ($DB->count_records('eb_khoikienthuc', ['ma_khoi' => $ma_khoi])) {
    $isExist = true;
}
if ($isExist) {
    $PAGE->navbar->add($DB->get_record('eb_khoikienthuc', ['ma_khoi' => $ma_khoi])->ten_khoi, new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/chitiet_kkt.php', ['ma_khoi' => $ma_khoi]));
}

// Title.
$PAGE->set_title(get_string('chitietkkt_lbl', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('chitietkkt_lbl', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();
require_once('../../controller/auth.php');
require_permission("khoikienthuc", "edit");
///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/newkkt_form.php');

$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Chỉnh sửa',
        array('id' => 'btn_ctkkt_edit', 'onClick' => "window.location.href='edit_kkt.php?ma_khoi=$ma_khoi&edit_mode=1'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone',
        array('id' => 'btn_ctkkt_clone', 'onClick' => "window.location.href='edit_kkt.php?ma_khoi=$ma_khoi'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Trở về',
        array('id' => 'btn_ctkkt_back', 'onClick' => "window.location.href='index.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
     . html_writer::end_tag('div')
    . '<br>';

echo $action_form;
print_table_kkt($ma_khoi);






 // Footer
echo $OUTPUT->footer();

///----------------------------------------------------------------------------------------------------------------------///        
/// FUNCTION

function print_table_kkt($ma_khoi){
    $khoi = get_kkt_byMaKhoi($ma_khoi);
    echo '<h4>[' . $khoi->ma_khoi . '] ' . $khoi->ten_khoi . '<h4>';
    echo '<br>';
    echo '<h4>' . $khoi->mota . '<h4>';
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
    } else{
        echo 'Khối rỗng';
    }
}


?>