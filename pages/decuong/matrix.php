<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/decuong_model.php');
require_once('../../model/chuandaura_ctdt_model.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$ma_ctdt = trim(optional_param('ma_ctdt', '', PARAM_NOTAGS));
if (!$ma_ctdt) {
    $ma_ctdt = 0;
}

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("decuong", "view");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/decuong/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_quanly_decuong', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/decuong/index.php'));

// Title.
$PAGE->set_title(get_string('label_quanly_decuong', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Sơ đồ MATRIX');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

global $DB;
$arr = array();


////////////////////////NEW RECORDs HERE///////////////////////////

////////////////////////NEW RECORDs HERE///////////////////////////

////////////////////////FORM///////////////////////////

class mform1 extends moodleform
{
    public function definition()
    {
        global $DB, $USER, $CFG, $COURSE;

        $mform = $this->_form;

        $mform->addElement('header', 'general_thong_tin_monhoc', 'Chọn chương trình đào tạo');
        $arr_ctdt = array();
        $arr_ctdt += ["0" => "Chọn chương trình đào tạo"];

        $all_ctdt = $DB->get_records('eb_ctdt', array(), '');
        foreach ($all_ctdt as $ictdt) {
            $arr_ctdt += [$ictdt->ma_ctdt => $ictdt->ma_ctdt];
            // , 'ma_bac'=> $ictdt->ma_bac, 'ma_he'=> $ictdt->ma_he , 'ma_nienkhoa'=> $ictdt->ma_nienkhoa, 'ma_nganh'=> $ictdt->ma_nganh , 'ma_chuyennganh'=> $ictdt->ma_chuyennganh];
        }


        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'sort_ctdt', 'Chọn chương trình đào tạo', $arr_ctdt);
        $eGroup[] = &$mform->createElement('submit', 'fetch_ctdt_1', 'Show Data', ['style' => "border-radius: 3px; width: 130px; height:40px; padding: 0; background-color: #1177d1; color: #fff"]);
        $mform->addGroup($eGroup, 'thongtinchung_group133',  'Chương trình đào tạo', array(' '),  false);
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

$mform = new mform1();



if ($mform->is_cancelled()) {
} else if ($mform->no_submit_button_pressed()) {
} else if ($fromform = $mform->get_data()) {
    $ma_ctdt = $mform->get_submit_value('sort_ctdt');
    if ($ma_ctdt != 0 && $ma_ctdt != '0') {

        redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/decuong/matrix.php?ma_ctdt=' . $ma_ctdt);
    }
} else if ($mform->is_submitted()) {

    $mform->display();
} else {

    $toform;


    $all_ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);


    $toform->ma_bac = $all_ctdt->ma_bac;
    $toform->ma_he = $all_ctdt->ma_he;
    $toform->ma_nienkhoa = $all_ctdt->ma_nienkhoa;
    $toform->ma_nganh = $all_ctdt->ma_nganh;
    $toform->ma_chuyennganh = $all_ctdt->ma_chuyennganh;

    $toform->sort_ctdt = $all_ctdt->ma_ctdt;

    // $toform->ten_chuandaura = $DB->get_record('eb_chuandaura_ctdt',['ma_cdr' => $all_ctdt->chuandaura])->ten;

    $mform->set_data($toform);

    // $mform->display();
}

////////////////////////FORM///////////////////////////


$arr_cdr = get_list_cdr_by_ctdt($ma_ctdt);


// function get_cdr_from_ctdt($ma_ctdt)
// {
//     global $DB;

//     $arr_chuandaura = $DB->get_records('eb_cdr_thuoc_ctdt', ['ma_ctdt' => $ma_ctdt]);


//     $arr_thongtin_chuandaura = array(); //chứa thông tin đầy đủ của một chuẩn đâu ra

//     foreach ($arr_chuandaura as $iarr_chuandaura) {
//         $arr_thongtin_chuandaura[] = get_thongtin_cdr($iarr_chuandaura->ma_cdr);
//     }


//     usort($arr_thongtin_chuandaura, function ($a, $b) {
//         return $a['ma_cdr'] < $b['ma_cdr'] ? -1 : 1;
//     });

//     return $arr_thongtin_chuandaura;
// }

function get_thongtin_cdr($ma_cdr)
{
    global $DB;

    $item = $DB->get_record('eb_chuandaura_ctdt', ['ma_cdr' => $ma_cdr]);

    if ($item->ma_cdr != null) {
        $resut = ['ma_cdr' => $item->ma_cdr, 'ten' => $item->ten, 'level' => $item->level, 'mota' => $item->mota];
        return $resut;
    }
}


$table = new html_table();
$table->head[] = ' ';

$list_monhoc = get_list_monhoc($ma_ctdt);

$link_cdr = $CFG->wwwroot . '/blocks/educationpgrs/pages/chuandauractdt/index.php';
$arr_head = array();
foreach ($arr_cdr as $item) {

    $table->head[] = "<a href='$link_cdr'>"  .  $item->ma_tt . "</a>";
    $arr_head[] = ['ten' => $item->ten, 'level' => intval($item->level), 'ma_cdr' => $item->ma_tt];
}

//data row
$len_head = count($table->head) - 1;


foreach ($list_monhoc as $iarr_1) {
    $link = $CFG->wwwroot . '/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php?ma_ctdt=' . $iarr_1['ma_ctdt'] . '&ma_decuong=' . $iarr_1['ma_decuong'] . '&mamonhoc=' . $iarr_1['mamonhoc'];
    $row = array();
    $row[] = "<a href='$link'>"
        . $iarr_1['mamonhoc'] .
        "</a>";

    for ($i = 0; $i < $len_head; $i++) { //contructor

        $row[] = ' ';
    }

    $cdr_monhoc_arr =  get_cdr($iarr_1['mamonhoc']);

    $len_monhoc = count($cdr_monhoc_arr);



    for ($i = 0; $i < $len_monhoc; $i++) {

        for ($j = 0; $j < $len_head; $j++) {

            if ($cdr_monhoc_arr[$i] == $arr_head[$j]['ma_cdr']) {


                $row[$j + 1] = 'x';
                for ($k = $j + 1; $k <= $len_head; $k++) {


                    // echo "<br>";
                    // echo $arr_head[$j]['ma_cdr'] . ' ' . $arr_head[$k]['ma_cdr'] . ' ';
                    // $temp = startsWith(strval($arr_head[$k]['ma_cdr']), strval($arr_head[$j]['ma_cdr']));
                    // echo $temp;
                    // if (startsWith(strval($arr_head[$j]['ma_cdr']), strval($arr_head[$k]['ma_cdr']))) {
                    //     echo "<br>";
                    //     echo $arr_head[$k]['level'] . ' ' . $arr_head[$k]['ma_cdr'];
                    //     echo "<br>";
                    //     echo $arr_head[$j]['level'] . ' ' . $arr_head[$j]['ma_cdr'];
                    // }

                    if ($arr_head[$k]['level'] > $arr_head[$j]['level'] && startsWith(strval($arr_head[$k]['ma_cdr']), strval($arr_head[$j]['ma_cdr']))) {
                        $row[$k + 1] = 'x';
                    }
                }
            }
        }
    }
    $table->data[] = $row;
}

$rsx_ctdt = $mform->get_submit_value('sort_ctdt');
if ($ma_ctdt) {
    $toform;


    $all_ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);


    $toform->ma_nienkhoa = $all_ctdt->ma_nienkhoa;
    $toform->ma_nganh = $all_ctdt->ma_nganh;
    $toform->ma_chuyennganh = $all_ctdt->ma_chuyennganh;

    $toform->sort_ctdt = $all_ctdt->ma_ctdt;


    $mform->set_data($toform);

    $mform->display();
    echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Biểu đồ</h2>";
    echo html_writer::table($table);
    // print_r($ma_ctdt);
    // print_r($list_monhoc);
} else {
    $mform->display();
    echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>CHƯA CHỌN CHƯƠNG TRÌNH ĐÀO TẠO</h2>";
}


function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}


function get_cdr($mamonhoc)
{
    global $DB, $USER, $CFG, $COURSE;


    //find de cuong cua tung mon
    // find chuan dau ra cdtd cua de cuong do

    $list_ma_decuong =  $DB->get_records('eb_decuong', ['mamonhoc' => $mamonhoc], '', 'ma_decuong');
    $arr = array();

    foreach ($list_ma_decuong as $i) {

        $danhsach_cdr = $DB->get_records('eb_muctieumonhoc', ['ma_decuong' => $i->ma_decuong, 'mamonhoc' => $mamonhoc], '', 'danhsach_cdr');

        foreach ($danhsach_cdr as $i) {

            $arr[] = $i->danhsach_cdr;
        }
    }

    $arr_3 = array();
    foreach ($arr as $iarr) {

        $arr_2 = explode(', ', $iarr);

        foreach ($arr_2 as $iarr_2) {

            $arr_3[] = $iarr_2;
        }
    }

    usort($arr_3, function ($a, $b) {
        return  preg_replace("/[^0-9.]/", "", $a) < preg_replace("/[^0-9.]/", "", $b) ? -1 : 1;
    });


    return $arr_3;
}
function get_list_monhoc($ma_ctdt)
{
    global $DB, $USER, $CFG, $COURSE;
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


$table_cdr = new html_table();
$table_cdr->head[] = ['Mã thứ tự', 'Tên chuẩn đầu ra'];
foreach ($arr_cdr as $item) {
    $param = new stdClass();
    $param->ma_tt = $item->ma_tt;
    $param->ten = $item->ten;
    $table_cdr->data[] = $param;
}

echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Bảng chú thích chuẩn đầu ra </h2>";
echo html_writer::table($table_cdr);


// Footer
echo $OUTPUT->footer();
