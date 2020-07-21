<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
require_once('../../model/decuong_model.php');
require_once('../../model/khoikienthuc_model.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$link = optional_param('linkto', NULL, PARAM_NOTAGS);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/decuong/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Import khối kiến thức', new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));

// Title.
$PAGE->set_title('Import Khối kiến thức' . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import Khối kiến thức');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


class form1 extends moodleform{
    public function definition(){
        global $CFG;
        $mform = $this->_form;
        
        $mform->addElement('filepicker', 'userfile', 'CSV Khối kiến thức', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.csv'));
        $mform->addRule('userfile', 'Khong phai file csv', 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'GET');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
class form2 extends moodleform{
    public function definition(){
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('hidden', 'link');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'insert to DB');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }
    function validation($data, $files)
    {
        return array();
    }
    public function get_submit_value($elementname)
    {
        $mform = &$this->_form;
        return $mform->getSubmitValue($elementname);
    }
}


$mform1 = new form1();
$mform2 = new form2();


//////////////////////////////////FORM 1 //////////////////////////////////

$mform1->display();

if ($mform1->is_cancelled()) {
    
} else if ($mform1->no_submit_button_pressed()) {
    
} else if ($fromform = $mform1->get_data()) {

    $name = $mform1->get_new_filename('userfile');
    $rex = $mform1->save_temp_file('userfile');

    redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/import/import_kkt.php?linkto='.$rex);
}



if ($mform2->is_cancelled()) {
    
} else if ($mform2->no_submit_button_pressed()) {
    
} else if ($fromform = $mform2->get_data()) {
    $link = $fromform->link;

    $list_khoi = array();
    if (($handle = fopen( $link, "r")) !== FALSE) {
        $stt = 0;
        $num_khoi = 1;

        while(($data = fgetcsv($handle, 5000, ",")) !== FALSE){
            //pass 0
            if($data[0] != 0){
                // Continue khoi
                $ma_khoi = $data[1];
                $current_khoi = $list_khoi[$ma_khoi];
                
                if($current_khoi !== NULL){
                    $list_khoi[$ma_khoi] = push_data_to_khoi($current_khoi, $data);
                } else{
                    $list_khoi[$ma_khoi] = array();
                    $list_khoi[$ma_khoi] = push_data_to_khoi($current_khoi, $data);
                }
            }
        }

        fclose($handle);
    }

    $error = check_valid_subject($list_khoi);
    if($error['error'] != 1){
        insert_import_kkt($list_khoi);
    } else{
        echo '<h3>Không thể import file vì các lỗi sau:</h3>';
        echo '<br>';
        foreach($error['errorMess'] as $e){
            echo  '<h6>' .$e. '</h6>';
            echo '<br>';
        }
    }
    
    // insert_import_kkt($list_khoi);
} else{
    $toform;
    $toform->link = $link;
    $mform2->set_data($toform);
    
    if($link != null){
        
        $list_khoi = array();
        if (($handle = fopen( $link, "r")) !== FALSE) {
            $stt = 0;
            $num_khoi = 1;

            while(($data = fgetcsv($handle, 5000, ",")) !== FALSE){
                //pass 0
                if($data[0] != 0){
                    // Continue khoi
                    $ma_khoi = $data[1];
                    $current_khoi = $list_khoi[$ma_khoi];
                    
                    if($current_khoi !== NULL){
                        $list_khoi[$ma_khoi] = push_data_to_khoi($current_khoi, $data);
                    } else{
                        $list_khoi[$ma_khoi] = array();
                        $list_khoi[$ma_khoi] = push_data_to_khoi($current_khoi, $data);
                    }
                }
            }

            fclose($handle);
        }
        // echo json_encode($list_khoi);
        print_preview_table_kkt($list_khoi);
        $mform2->display();
        // insert_import_kkt($list_khoi);
    }
}


// Footer
echo $OUTPUT->footer();
///-------------------------------------------------------------------------------------------------------------------///
//FUNCTION

function push_data_to_khoi($old_khoi, $data){
    $current_khoi = $old_khoi;
    
    if($current_khoi == NULL){
        $current_khoi = array();
    }

    if($data[2] == 'ttc'){

        $current_khoi['ten_khoi'] = $data[3];
        $current_khoi['mota'] = $data[4];
    } else if($data[2] == 'BB'){

        $index = 4;
        $current_khoi['monbb'] = array();
        while($data[$index] != NULL){
            $current_khoi['monbb'][] = $data[$index];
            $index++;
        }

    } else if(strpos($data[2], 'TC') === 0){

        if($data[3] == 'mon'){

            $index = 4;
            $current_khoi['montc'][$data[2]]['listmon'] = array();
            while($data[$index] != NULL){
                $current_khoi['montc'][$data[2]]['listmon'][] = $data[$index];
                $index++;
            }
        } else if($data[3] == 'dk'){
    
            $current_khoi['montc'][$data[2]]['ghichu'] = $data[4];
            $current_khoi['montc'][$data[2]]['xet_tren'] = $data[5];
            $current_khoi['montc'][$data[2]]['giatri_dieukien'] = $data[6];
        }
    }
    return $current_khoi;
}

function print_preview_table_kkt($list_khoi){  
    global $DB, $USER;

    foreach($list_khoi as $key => $item){
        $stt = 1;
        echo '<h4> ' .$key. ' ' . $item['ten_khoi'];
        $table = new html_table();
        $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');

        if(!empty($item['monbb'])){
            foreach($item['monbb'] as $key => $imon){
                if(is_monhoc_exist($imon)){
                    $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $imon]);
                    $table->data[] = [(string) $stt, (string) $imon, (string) $imonhoc['tenmonhoc_vi'],
                                        (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                                        (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']];
                    $stt++;
                } else{
                    $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $imon]);
                    $table->data[] = [(string) $stt, (string) $imon, '?', '?', '?', '?', '?'];
                    $stt++;
                }
            }
        }

        if(!empty($item['montc'])){
            foreach($item['montc'] as $key => $ikhoi){
                $table->data[] = [ '', $ikhoi['ghichu'], '', '', '', '', ''];
                foreach($ikhoi['listmon'] as $imon){
                    if(is_monhoc_exist($imon)){
                        $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $imon]);
                        $table->data[] = [(string) $stt, (string) $imon, (string) $imonhoc['tenmonhoc_vi'],
                                            (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                                            (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']];
                        $stt++;
                    } else{
                        $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $imon]);
                        $table->data[] = [(string) $stt, (string) $imon, '?', '?', '?', '?', '?'];
                        $stt++;
                    }
                }
            }
        }
        
        echo html_writer::table($table);
    }
    
    $error = check_valid_subject($list_khoi);
    if($error['error'] == 1){
        foreach($error['errorMess'] as $e){
            echo  '<h6>' .$e. '</h6>';
            echo '<br>';
        }
    }
}

function check_valid_subject($list_khoi){
    $result = ['error' => 0,
                'errorMess' => array()];

    foreach($list_khoi as $key => $item){
        if(!empty($item['monbb'])){
            foreach($item['monbb'] as $imon){
                if(!is_monhoc_exist($imon)){
                    $result['error'] = 1;
                    $e = 'Mã môn học ' . $imon .' không tồn tại';
                    $result['errorMess'][] = $e;
                }
            }
        }
        if(!empty($item['montc'])){
            foreach($item['montc'] as $key => $ikhoi){
                foreach($ikhoi['listmon'] as $imon){
                    if(!is_monhoc_exist($imon)){
                        $result['error'] = 1;
                        $result['errorMess'][] = 'Mã môn học ' . $imon .' không tồn tại';
                    }
                }
            }
        }
    }

    return $result;
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

function print_preview_import_kkt($ttc, $arrmamon, $arrkhoi){
    global $DB, $USER;

    $allmonhocs = array();
    $stt = 1;

    $table = new html_table();
    $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');

    if($arrmamon != NULL){
        
        
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
