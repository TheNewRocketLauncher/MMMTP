<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');
require_once('../../controller/auth.php');
global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$link = optional_param('linkto', '', PARAM_NOTAGS);
if (!$link) {
    $link = null;
}

// Check permission.
require_login();
$context = \context_system::instance();

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Quản lý chuẩn đầu ra', new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php'));

// Title.
$PAGE->set_title('Import chuẩn đầu ra' . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import chuẩn đầu ra');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


class form1 extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('filepicker', 'userfile', 'CSV chuẩn đầu ra', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.csv'));
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
class form2 extends moodleform
{
    public function definition()
    {
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



$form = new form1();
$mform2 = new form2();
$array_toDB = array();
$table = new html_table(); // new table
$table_loai = new html_table(); // new table



//////////////////////////////////FORM 1 //////////////////////////////////

if ($form->is_cancelled()) {
} else if ($form->no_submit_button_pressed()) {
} else if ($fromform = $form->get_data()) {

    $name = $form->get_new_filename('userfile');


    $rex = $form->save_temp_file('userfile');

    redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/import/import_cdr_ctdt.php?linkto=' . $rex);

    // echo 'rex '. $rex;echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
} else if ($form->is_submitted()) {

    // $form->display();
    echo "<h2>Dữ liệu trống</h2>";
} else {


    $form->display();
}

//////////////////////////////////FORM 1 //////////////////////////////////






if ($mform2->is_cancelled()) {
} else if ($mform2->no_submit_button_pressed()) {
} else if ($fromform = $mform2->get_data()) {

    if (($handle = fopen($fromform->link, "r")) !== FALSE) {
        global $ma_cdr_cha;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {


            $arr = array();
            $arr_loai = array();

            if ($data[0] == 5 || $data[0] == '5') {
                $arr_loai[] = ['ma_loai' => $data[1], 'ten' => $data[2]];

                foreach ($arr_loai as $item) {

                    $param->ten = $item['ten'];
                    $param->ma_loai = $item['ma_loai'];
                    $arr_2 = get_ma_loai();

                    $check_db = -1;

                    $check_db = is_check($item,  $arr_2, "loai_cdr");
                    if ($check_db == 0) {
                        insert_loai_cdr($param);
                    }
                }
            }




            //
            if ($data[0] == 1 || $data[0] == '1') {
                $arr[] = ['ma_tt' => $data[1], 'ten' => $data[2], 'level' => $data[3], 'ma_loai' => $data[4]];

                foreach ($arr as $item) {

                    $param = new stdClass();
                    $param->ma_cdr = mt_rand();
                    if ($item['level'] == 1 || $item['level'] == '1') {
                        $param->ma_cdr_cha = 0;

                        $ma_cdr_cha = $param->ma_cdr;

                        // echo "<script>console.log('phongngu')</script>";

                        echo "<script>console.log($param->ma_cdr)</script>";
                    } else if ($item['level'] == 2 || $item['level'] == '2') {
                        $param->ma_cdr_cha = $ma_cdr_cha;
                    }


                    $param->ten = $item['ten'];
                    $param->level = $item['level'];
                    $param->ma_loai = $item['ma_loai'];

                    $arr_2 = get_ma_loai();
                    $check_db = -1;
                    $check_db = is_check($item,  $arr_2, "cdr_ctdt");
                    if ($check_db == 0) {
                        insert_cdr_ctdt($param);
                    }
                }
            }
        }
        fclose($handle);
    }
} else if ($mform2->is_submitted()) {
} else {

    $toform;
    $toform->link = $link;
    $mform2->set_data($toform);


    if ($link != null) {

        $arr = array();
        $arr_loai = array();
        if (($handle = fopen($link, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if ($data[0] == 5 || $data[0] == '5') {
                    $arr_loai[] = ['ma_loai' => $data[1], 'ten' => $data[2]];
                }
                if ($data[0] == 1 || $data[0] == '1') {
                    $arr[] = ['ma_tt' => $data[1], 'ten' => $data[2], 'level' => $data[3], 'ma_loai' => $data[4]];
                }
            }
            fclose($handle);
        }



        $table->head = ['Mã tt', 'Tên', 'level', 'Mã loại'];
        $table_loai->head = ['', 'Mã loại cdr', 'Tên'];
        $stt = 0;
        foreach ($arr_loai as $item) {
            $param = new stdClass();
            $stt++;

            $arr_2 = get_ma_loai();
            $check_db = -1;
            $check_table = is_check($item, $table_loai->data, "loai_cdr");
            if ($check_table == 0) {
                $check_db = is_check($item,  $arr_2, "loai_cdr");
            } else {
                $check_db = $check_table;
            }
            $param->stt = $stt;

            $param->ma_loai = $item['ma_loai'];
            $param->ten = $item['ten'];
            switch ($check_db) {
                case 0:
                    $table_loai->data[] = $param;
                    break;
                case 1:
                    echo "<br>";
                    echo "Mã loại " . $item['ma_loai'] . "trùng lặp";
                    echo "<br>";

                    break;
                default:
                    break;
            }
        }

        foreach ($arr as $item) {
            // ở đây check 2 lần trên db lvà table data

            $arr_2 = get();

            $check_db = -1;

            $check_table = is_check($item, $table->data, "cdr");

            if ($check_table == 0) {
                $check_db = is_check($item,  $arr_2, "cdr");
            } else {
                $check_db = $check_table;
            }

            $param = new stdClass();
            $param->ma_tt = $item['ma_tt'];
            $param->ten = $item['ten'];
            $param->level =  $item['level'];
            $param->ma_loai = $item['ma_loai'];



            switch ($check_db) {
                case 0:
                    $table->data[] = $param;
                    break;
                case 1:
                    echo "<br>";
                    echo "Mã tt " . $item['ma_tt'] . "trùng lặp";
                    echo "<br>";
                    break;
                    // case 2:
                    //     echo "<br>";
                    //     echo "Mã loại " . $item['ma_loai'] . "không tồn tại";
                    //     echo "<br>";
                    //     break;
                default:
                    break;
            }
            // switch ($check_db) {
            //     case 0:
            //         $table->data[] = $param;
            //         break;
            //     case 1:
            //         echo "<br>";
            //         echo "Short name " . $item['shortname'] . "trùng lặp";
            //         echo "<br>";
            //         print_r($param);
            //         break;
            //     case 2:
            //         echo "<br>";
            //         echo "Chương trình đào tạo " . $item['ma_ctdt'] . "không tồn tại";
            //         echo "<br>";
            //         print_r($param);
            //         break;
            //     case 3:
            //         echo "<br>";
            //         echo "Môn học " . $item['mamonhoc'] . "Không nằm trong ctdt " .   $item['ma_ctdt'];
            //         echo "<br>";
            //         print_r($param);
            //         break;
            //     case 4:
            //         echo "<br>";
            //         echo "Học kì " . $item['hocky'] . " không hợp lệ , vui lòng nhập trong khoảng ( 1 ,2 ,3 , 4)";
            //         echo "<br>";
            //         print_r($param);
            //         break;
            //     case 5:
            //         echo "<br>";
            //         echo "Năm học " . $item['namhoc'] . " không hợp lệ , vui lòng nhập số";
            //         echo "<br>";
            //         print_r($param);
            //         break;
            //     default:
            //         echo "<br>";
            //         echo "Dữ liệu này" . $item['shortname'] . "--------" .  $item['ma_ctdt'] . "------" . $item["mamonhoc"] .  "đã trùng lặp trong bảng";
            //         echo "<br>";
            //         print_r($param);
            //         break;
            // }
        }

        echo html_writer::table($table_loai);

        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo html_writer::table($table);


        if (count($table->data) > 0) {
            $mform2->display();
        } else {
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Không tìm thấy chuẩn đầu ra mới</h2>";
        }
    }
}



function get_ma_loai()
{
    global $DB, $USER, $CFG, $COURSE;
    $arr = array();
    $arr = $DB->get_records('eb_loai_cdr', []);
    return $arr;
}


function get()
{
    global $DB, $USER, $CFG, $COURSE;
    $arr = array();
    $arr = $DB->get_records('eb_chuandaura_ctdt', []);
    return $arr;
}
function insert_cdr_ctdt($param)
{
    global $DB;
    $DB->insert_record('eb_chuandaura_ctdt', $param);
}
function insert_loai_cdr($param)
{
    global $DB;
    $DB->insert_record('eb_loai_cdr', $param);
}

//check đúng => true
// Sai => false
function is_check($data, $arr, $typeTable)
{
    global $DB;

    //0 : check OKE
    //1 : trung ma_tt
    //2: Không có chương trình đào tạo này
    //3 : Môn học này không nằm trong chương trình đào tạo
    //4 : Sai hoc ky
    //check short name
    if ($typeTable == "loai_cdr") {
        foreach ($arr as $item) {
            if ($item->ma_loai == $data['ma_loai']) {
                return 1;
            }
        }
    } else {
        foreach ($arr as $item) {
            if ($item->ma_tt == $data['ma_tt']) {
                return 1;
                // }
            }
        }


        if ($data['level'] == 1) {
            if (!$DB->record_exists('eb_loai_cdr', ['ma_loai' => $data['ma_loai']])) {
                return 2;
            }
        }
    }



    // //check ctdt
    // $check_ctdt = $DB->record_exists('eb_ctdt', ['ma_ctdt' => $data['ma_ctdt']]);
    // if (!$check_ctdt) {
    //     return 2;
    // }


    // //check monhoc nay co trong ctdt nay khong
    // $flag = false;
    // $arr_monhoc = get_list_monhoc($data['ma_ctdt']);
    // foreach ($arr_monhoc as $item) {
    //     if ($item['mamonhoc'] == $data['mamonhoc']) {
    //         $flag = true;
    //     }
    // }
    // if ($flag == false) {
    //     return 3;
    // }

    // // check học kì có hợp lệ 
    // $os = array(1, 2, 3, 4);
    // if (!in_array($data['hocky'], $os)) {
    //     return 4;
    // }

    // //check năm học có phải là số k
    // if (!is_numeric($data['namhoc'])) {
    //     return 5;



    return 0;
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
// Footer
echo $OUTPUT->footer();
