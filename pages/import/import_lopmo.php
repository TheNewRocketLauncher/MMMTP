<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');

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
require_once('../../controller/auth.php');
require_permission("import", "");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Quản lý lớp mở', new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php'));

// Title.
$PAGE->set_title('Quản lý lớp mở' . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import lớp mở');
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

        $mform->addElement('filepicker', 'userfile', 'CSV lớp mở', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.csv'));
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



//////////////////////////////////FORM 1 //////////////////////////////////

if ($form->is_cancelled()) {
} else if ($form->no_submit_button_pressed()) {
} else if ($fromform = $form->get_data()) {

    $name = $form->get_new_filename('userfile');


    $rex = $form->save_temp_file('userfile');

    redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/import/import_lopmo.php?linkto=' . $rex);

    // echo 'rex '. $rex;echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
} else if ($form->is_submitted()) {

    // $form->display();
    echo "<h2>Dữ liệu trống</h2>";
} else {

    $toform;

    $form->display();
}

//////////////////////////////////FORM 1 //////////////////////////////////

if ($mform2->is_cancelled()) {
} else if ($mform2->no_submit_button_pressed()) {
} else if ($fromform = $mform2->get_data()) {

    if (($handle = fopen($fromform->link, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {


            $arr = array();


            if ($data[0] == 1 || $data[0] == '1') {

                $arr[] = [
                    'mamonhoc' => $data[1], 'fullname' => $data[2], 'shortname' => $data[3], 'ma_ctdt' => $data[4],
                    'namhoc' => $data[5], 'hocky' => $data[6], 'mota' => $data[7]
                ];
                foreach ($arr as $item) {

                    $param = new stdClass();

                    $param->mamonhoc = $item['mamonhoc'];
                    $param->full_name = $item['fullname'];
                    $param->short_name = $item['shortname'];
                    $param->ma_ctdt = $item['ma_ctdt'];
                    $param->nam_hoc = $item['namhoc'];
                    $param->hoc_ky = $item['hocky'];
                    $param->mota = $item['mota'];

                    // ở đây check 1 lần trên db là đủ, vì khi chạy mỗi vòng lặp sẽ mỗi record ddc insert vào

                    $check_db = -1;


                    $arr_2 = get();

                    $check_db = is_check($item,  $arr_2);

                    if ($check_db == 0) {
                        insert_lopmo($param);
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

        if (($handle = fopen($link, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($data[0] == 1 || $data[0] == '1') {

                    $arr[] = [
                        'mamonhoc' => $data[1], 'fullname' => $data[2], 'shortname' => $data[3], 'ma_ctdt' => $data[4],
                        'namhoc' => $data[5], 'hocky' => $data[6], 'mota' => $data[7]
                    ];
                }
            }
            fclose($handle);
        }



        $table->head = [
            'Mã môn học', 'Tên đầy đủ', 'Tên viết tắt', 'Mã ctđt', 'Năm học', 'Học kỳ', 'Mô tả'
        ];

        foreach ($arr as $item) {
            // ở đây check 2 lần trên db lvà table data

            $arr_2 = get();

            $check_db = -1;

            $check_table = is_check($item, $table->data);
            // echo "<br>";
            // echo "checktable" . $check_table;
            // echo "<br>";

            if ($check_table == 0) {
                $check_db = is_check($item,  $arr_2);
            } else {
                $check_db = $check_table;
            }

            $param = new stdClass();
            $param->mamonhoc = $item['mamonhoc'];
            $param->fullname = $item['fullname'];
            $param->short_name =  $item['shortname'];
            $param->ma_ctdt = $item['ma_ctdt'];
            $param->namhoc = $item['namhoc'];
            $param->hocky = $item['hocky'];
            $param->mota = $item['mota'];


            switch ($check_db) {
                case 0:
                    $table->data[] = $param;
                    break;
                case 1:
                    echo "<br>";
                    echo "Short name " . $item['shortname'] . "trùng lặp";
                    echo "<br>";
                    print_r($param);
                    break;
                case 2:
                    echo "<br>";
                    echo "Chương trình đào tạo " . $item['ma_ctdt'] . "không tồn tại";
                    echo "<br>";
                    print_r($param);
                    break;
                case 3:
                    echo "<br>";
                    echo "Môn học " . $item['mamonhoc'] . "Không nằm trong ctdt " .   $item['ma_ctdt'];
                    echo "<br>";
                    print_r($param);
                    break;
                case 4:
                    echo "<br>";
                    echo "Học kì " . $item['hocky'] . " không hợp lệ , vui lòng nhập trong khoảng ( 1 ,2 ,3 , 4)";
                    echo "<br>";
                    print_r($param);
                    break;
                case 5:
                    echo "<br>";
                    echo "Năm học " . $item['namhoc'] . " không hợp lệ , vui lòng nhập số";
                    echo "<br>";
                    print_r($param);
                    break;
                default:
                    echo "<br>";
                    echo "Dữ liệu này" . $item['shortname'] . "--------" .  $item['ma_ctdt'] . "------" . $item["mamonhoc"] .  "đã trùng lặp trong bảng";
                    echo "<br>";
                    print_r($param);
                    break;
            }
        }


        // echo "<br>";
        // print_r($table->data);
        // echo "<br>";
        echo html_writer::table($table);


        if (count($table->data) > 0) {
            $mform2->display();
        } else {
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Không tìm lớp mở mới</h2>";
        }
    }
}


function get()
{
    global $DB, $USER, $CFG, $COURSE;
    $arr = array();
    $arr = $DB->get_records('eb_lop_mo', []);
    return $arr;
}

//check đúng => true
// Sai => false
function is_check($data, $arr)
{
    global $DB;

    //0 : check OKE
    //1 : sai short name
    //2: Không có chương trình đào tạo này
    //3 : Môn học này không nằm trong chương trình đào tạo
    //4 : Sai hoc ky
    //check short name

    $arr_lopmo = $arr;
    foreach ($arr_lopmo as $item) {
        if ($item->short_name == $data['shortname']) {
            return 1;
        }
    }



    //check ctdt
    $check_ctdt = $DB->record_exists('eb_ctdt', ['ma_ctdt' => $data['ma_ctdt']]);
    if (!$check_ctdt) {
        return 2;
    }


    //check monhoc nay co trong ctdt nay khong
    $flag = false;
    $arr_monhoc = get_list_monhoc($data['ma_ctdt']);
    foreach ($arr_monhoc as $item) {
        if ($item['mamonhoc'] == $data['mamonhoc']) {
            $flag = true;
        }
    }
    if ($flag == false) {
        return 3;
    }

    // check học kì có hợp lệ 
    $os = array(1, 2, 3, 4);
    if (!in_array($data['hocky'], $os)) {
        return 4;
    }

    //check năm học có phải là số k
    if (!is_numeric($data['namhoc'])) {
        return 5;
    }



    return 0;
}

function get_list_monhoc($ma_ctdt)
{
    global $DB;
    $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);

    // Lưu danh sách mã môn học
    $list_mamonhoc = array();

    // Lấy ra cây khối kiến thức của CTDT 
    $caykkt = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);


    $decuong = $DB->get_record('eb_decuong', ['ma_ctdt' => $ma_ctdt]);

    // Với mỗi khối kiến thức, lấy ra các khối con có thể có
    foreach ($caykkt as $item) {
        // Thêm các mã môn học thuộc khối vào $list_mamonhoc
        $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $item->ma_khoi]);

        foreach ($data_records as $data) {
            $tmp = array();
            $tmp['mamonhoc'] = $data->mamonhoc;
            $tmp['ma_decuong'] = $decuong->ma_decuong;
            $tmp['ma_ctdt'] = $ctdt->ma_ctdt;

            if (in_array($tmp, $list_mamonhoc)) {
            } else {
                $list_mamonhoc[] = $tmp;
            }
        }

        // Kiểm tra xem khối có khối con hay không? Điều kiện: có 1 khối cùng tên và có ma_tt = 0
        if ($DB->count_records('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0])) {
            $khoicha = $DB->get_record('eb_cay_khoikienthuc', ['ma_khoi'  => $item->ma_khoi, 'ma_tt' => 0]);

            // Lấy ra các khối con: có cùng mã cây khối kiến thức và có mã khối cha = mã khối của item
            $listkhoicon = $DB->get_records('eb_cay_khoikienthuc', ['ma_khoicha'  => $khoicha->ma_khoi, 'ma_cay_khoikienthuc' => $khoicha->ma_cay_khoikienthuc]);

            // Lấy ra các mã môn học thuộc các khối con
            foreach ($listkhoicon as $khoicon) {
                $data_records = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $khoicon->ma_khoi]);
                foreach ($data_records as $data) {
                    $tmp = array();
                    $tmp['mamonhoc'] = $data->mamonhoc;
                    $tmp['ma_decuong'] = $decuong->ma_decuong;
                    $tmp['ma_ctdt'] = $ctdt->ma_ctdt;
                    $list_mamonhoc[] = $tmp;
                }
            }
        }
    }

    // Trả về danh sách mã môn học
    return $list_mamonhoc;
}

// Footer
echo $OUTPUT->footer();
