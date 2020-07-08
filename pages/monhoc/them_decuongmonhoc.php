
<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
// require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/tcpdf/tcpdf.php");
require_once('../../js.php');

global $COURSE, $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

$ma_decuong = optional_param('ma_decuong', '', PARAM_ALPHANUMEXT);
$ma_ctdt = optional_param('ma_ctdt', '', PARAM_ALPHANUMEXT);
$mamonhoc = optional_param('mamonhoc', '', PARAM_ALPHANUMEXT);

// $id = optional_param('id', 0, PARAM_INT);
$chitietmh = get_monhoc_by_mamonhoc($mamonhoc);


// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_quanly_decuong', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/decuong/index.php'));
$PAGE->navbar->add('Thêm đề cương môn học');

// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs'));
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');

$a = $chitietmh->mamonhoc;

///==========================================================================
$mform8 = new header_decuongmonhoc_form();

if ($mform8->is_cancelled()) {
} else if($mform8->no_submit_button_pressed()) {
} else if ($fromform = $mform8->get_data()) {
} else if ($mform8->is_submitted()) {
} else {
    //Set default data from DB
    $toform;
    $toform->ma_decuong_1 = $ma_decuong;
    $toform->ma_ctdt_1 = $ma_ctdt;
    
    $mform8->set_data($toform);

    // displays the form
    $mform8->display();
}

///===========================================================================
function get_name_khoikienthuc($ma_ctdt, $mamonhoc){
    global $DB;
    $listkhoi = $DB->get_records('block_edu_monthuockhoi', ['mamonhoc' => $mamonhoc]);

    foreach($listkhoi as $ikhoi){
        $listcay = $DB->get_records('block_edu_cay_khoikienthuc', ['ma_khoi' => $ikhoi->ma_khoi]);

        foreach($listcay as $icay){
            $ctdt_ss =  $DB->get_record('block_edu_ctdt', ['ma_cay_khoikienthuc' => $icay->ma_cay_khoikienthuc]);
            if($ctdt_ss->ma_ctdt == $ma_ctdt){
                
                $khoikienthuc = $DB->get_record('block_edu_khoikienthuc', ['ma_khoi' => $ikhoi->ma_khoi]);

                return $khoikienthuc->ten_khoi;
            }
        }
    }

}
//THONG TIN CHUNG
$mform1 = new thongtinchung_decuongmonhoc_form();

// Process form
if ($mform1->is_cancelled()) {
    // Handle form cancel operation
} else if ($mform1->no_submit_button_pressed()) {
    $mform1->display();
} else if ($fromform = $mform1->get_data()) {
    /* Thực hiện insert */
    // Param
    $param1 = new stdClass();
    $param1->id = $mform1->get_data()->idhe; // The data object must have the property "id" set.
    $index_mabac = $mform1->get_data()->mabac;
    $allbacdts = $DB->get_records('block_edu_bacdt', []);
    $param1->ma_bac = $allbacdts[$index_mabac + 1]->ma_bac;
    $param1->ma_he = $mform1->get_data()->mahe;
    $param1->ten = $mform1->get_data()->tenhe;
    $param1->mota = $mform1->get_data()->mota;
    update_hedt($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
    $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_hedt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform1->is_submitted()) {
    // Button submit
} else {
    //Set default data from DB

    $chitietmonhoc = get_monhoc_by_mamonhoc($mamonhoc);

    $toform;
    
    // $toform->ma_decuong_1 = $ma_decuong;
    // $toform->ma_ctdt_1 = $ma_ctdt;

    $toform->masomonhoc_thongtinchung = $chitietmonhoc->mamonhoc;
    $toform->tenmonhoc1_thongtinchung = $chitietmonhoc->tenmonhoc_vi;
    $toform->tenmonhoc2_thongtinchung = $chitietmonhoc->tenmonhoc_en;
    $toform->loaihocphan = $chitietmonhoc->loaihocphan;
    $toform->sotinchi_thongtinchung = $chitietmonhoc->sotinchi;
    $toform->tietlythuyet_thongtinchung = $chitietmonhoc->sotietlythuyet;
    $toform->tietthuchanh_thongtinchung = $chitietmonhoc->sotietthuchanh;

    $thuoc_khoikienthuc_thongtinchung = get_name_khoikienthuc($ma_ctdt, $chitietmonhoc->mamonhoc);
    $toform->thuoc_khoikienthuc_thongtinchung = $thuoc_khoikienthuc_thongtinchung;


    $mform1->set_data($toform);
    $mform1->display();
}

///===========================================================================
//MO TA MON HOC
$mform0 = new mota_decuongmonhoc_form();

if ($mform0->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if($mform0->no_submit_button_pressed()) {
    //
    $mform->display();

} else if ($fromform = $mform0->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    // Thực hiện insert
    $param1 = new stdClass();
    // $param
    $param1->id = $mform->get_data()->idhe; // The data object must have the property "id" set.
    
    $index_mabac = $mform->get_data()->mabac;    
    
    $allbacdts = $DB->get_records('block_edu_bacdt', []);
    $param1->ma_bac = $allbacdts[$index_mabac + 1 ]->ma_bac;
    
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ten = $mform->get_data()->tenhe;
    $param1->mota = $mform->get_data()->mota;
    update_hedt($param1);
    
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    
    $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_hedt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    // $mform->display();


} else if ($mform0->is_submitted()) {
    //
} else {
    //Set default data from DB
    $toform;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;
    $toform->mota = $chitietmonhoc->mota;
    
    $mform0->set_data($toform);

    // displays the form
    $mform0->display();
}

///===========================================================================
//MUC TIEU MON HOC
$table2 = get_muctieu_monmhoc_by_madc($ma_decuong, $ma_ctdt, $mamonhoc);
echo '<br>';
$mform2 = new muctieumonhoc_decuongmonhoc_form();
if ($mform2->is_cancelled()) {
} else if ($mform2->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform2->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->ma_decuong = $fromform->ma_decuong;
    
    // $param2->muctieu = $fromform->muctieu_muctieumonhoc;
    $arr_muctieu = get_muctieu_monmhoc_by_madc_1($ma_decuong, $ma_ctdt, $mamonhoc);
    
    $clength = count($arr_muctieu);
    for($x = 0; $x < $clength; $x++) {
        $b[] = (int) filter_var((string)$arr_muctieu[$x], FILTER_SANITIZE_NUMBER_INT);
        
    }

    rsort($b);

    $param2->muctieu = 'G'. (int)($b[0] + 1);
    

    $param2->mota = $fromform->mota_muctieu_muctieumonhoc;
    
    // $param2->danhsach_cdr = $fromform->chuandaura_cdio_muctieumonhoc;
    $danhsach_cdr = $mform2->get_submit_value('chuandaura_cdio_muctieumonhoc');

    $str = '';
    foreach($danhsach_cdr as $item){
        $str .= $item . ', ';
    }
    $param2->danhsach_cdr = substr($str, 0, -1);

    insert_muctieumonhoc_table($param2);

    $table2 = get_muctieu_monmhoc_by_madc($param2->ma_decuong, $ma_ctdt, $mamonhoc);

    $mform2->display();
    
    echo html_writer::table($table2);
    echo \html_writer::tag(
        'button',
        'Xóa Mục Tiêu',
        array('id' => 'btn_delete_muctieumonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
    
}else if ($mform2->is_submitted()) {
    echo 'xin chao viet nam';
} else {    
    //Set default data from DB
    $toform;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;
    
    $mform2->set_data($toform);

	$mform2->display();
    echo html_writer::table($table2);

    echo \html_writer::tag(
        'button',
        'Xóa Mục Tiêu',
        array('id' => 'btn_delete_muctieumonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
}


///================================================================================
//CHUAN DAU RA MON HOC
$table3 = get_chuandaura_monmhoc_by_madc($ma_decuong, $ma_ctdt, $mamonhoc);
echo '<br>';
$mform3 = new chuandaura_decuongmonhoc_form();

// Process form
if ($mform3->is_cancelled()) {
} else if ($mform3->no_submit_button_pressed()) {
    // Button no_sumbit
} else if ($fromform = $mform3->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->ma_decuong = $fromform->ma_decuong;
    
    $ma_muctieu= $mform3->get_submit_value('muctieu');
    
    $rsx = get_allmuctieu($param2->ma_decuong, $ma_muctieu);
    $rsx_1 = intval($rsx) + 1;
    $param2->ma_cdr = $ma_muctieu . '.' . $rsx_1;


    $param2->mota = $fromform->mota_chuandaura;
    $param2->mucdo_utilize = $fromform->mucdo_itu_chuandaura;
    $param2->mucdo_teach = 1;
    $param2->mucdo_introduce = 1;

    
    insert_chuandaura_table($param2);
    $table3 = get_chuandaura_monmhoc_by_madc($param2->ma_decuong, $ma_ctdt, $mamonhoc);
	$mform3->display();
    echo html_writer::table($table3);
    echo \html_writer::tag(
        'button',
        'Xóa chuẩn đầu ra',
        array('id' => 'btn_delete_chuandauramonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
    
} else {
    $toform;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;

    $mform3->set_data($toform);
    $mform3->display();
    
    echo html_writer::table($table3);
    echo \html_writer::tag(
        'button',
        'Xóa chuẩn đầu ra',
        array('id' => 'btn_delete_chuandauramonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
}
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function get_allmuctieu($ma_decuong,$ma_chuandaura) {
    global $DB, $USER, $CFG, $COURSE;
    
    $all_CDR = $DB->get_records('block_edu_chuandaura', array('ma_decuong' => $ma_decuong));
    $arr_muctieu = array(); $arr = array();  $result;

    $stt = 1;
    foreach ($all_CDR as $i_CDR) {

        if(startsWith($i_CDR->ma_cdr, $ma_chuandaura)){
            $arr_muctieu[] = $i_CDR->ma_cdr;
        }
        
        $stt = $stt + 1;
    }
    

    rsort($arr_muctieu);

    $arr = explode(".", $arr_muctieu[0]);

    $len = count($arr);

    $result = $arr[$len-1];

    return $result;
}

//=================================================================================
//KE HOACH GIANG DAY LY THUYET
$table4 = get_kehoachgiangday_LT_by_ma_decuong($ma_decuong, $ma_ctdt, $mamonhoc);
echo '<br>';
$mform4 = new giangday_LT_decuongmonhoc_form();
if ($mform4->is_cancelled()) {
} else if ($mform4->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform4->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->ma_decuong = $fromform->ma_decuong;

    $param2->ten_chude = $fromform->chudegiangday;
    
    $danhsach_cdr = $mform4->get_submit_value('danhsach_cdr');
    
    $param2->hoatdong_gopy = $fromform->hoatdong_giangday;
    $param2->hoatdong_danhgia = $fromform->hoatdong_danhgia;

    $str = '';
    foreach($danhsach_cdr as $item){
        $str .= $item . ', ';
    }
    $param2->danhsach_cdr = substr($str, 0, -1);

    
    insert_kehoachgiangday_LT_table($param2);

    $table4 = get_kehoachgiangday_LT_by_ma_decuong($param2->ma_decuong, $ma_ctdt, $mamonhoc);
	$mform4->display();
    echo html_writer::table($table4);
    echo \html_writer::tag(
        'button',
        'Xóa kế hoạch giảng dạy',
        array('id' => 'btn_delete_khgdltmonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;

    $mform4->set_data($toform);
    $mform4->display();
    
    echo html_writer::table($table4);
    echo \html_writer::tag(
        'button',
        'Xóa kế hoạch giảng dạy',
        array('id' => 'btn_delete_khgdltmonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
}
echo '<br>';

//=================================================================================
//DANH GIA MON HOC
$table5 = get_danhgiamonhoc_by_ma_decuong($ma_decuong, $ma_ctdt, $mamonhoc);
echo '<br>';
$mform5 = new danhgia_decuongmonhoc_form();
if ($mform5->is_cancelled()) {
} else if ($mform5->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform5->get_data()) {
    $param2 = new stdClass();

    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->ma_decuong = $fromform->ma_decuong;
    $param2->madanhgia = $fromform->madanhgia;
    $param2->tendanhgia = $fromform->tendanhgia;
    $param2->motadanhgia = $fromform->motadanhgia;

    $danhsach_cdr = $mform5->get_submit_value('cacchuandaura_danhgia');
    

    $param2->tile_danhgia = $fromform->tile_danhgia;

    $str = '';
    foreach($danhsach_cdr as $item){
        $str .= $item . ', ';
    }
    $param2->chuandaura_danhgia = substr($str, 0, -2);

    insert_danhgiamonhoc_table($param2);

    $table5 = get_danhgiamonhoc_by_ma_decuong($fromform->ma_decuong, $ma_ctdt, $mamonhoc);
	$mform5->display();
    echo html_writer::table($table5);
    echo \html_writer::tag(
        'button',
        'Xóa đánh giá môn học',
        array('id' => 'btn_delete_danhgiamonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;

    $mform5->set_data($toform);
	$mform5->display();
    echo html_writer::table($table5);
    echo \html_writer::tag(
        'button',
        'Xóa đánh giá môn học',
        array('id' => 'btn_delete_danhgiamonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
}
echo '<br>';

//=================================================================================
//TAI NGUYEN MON HOC
$mform6 = new tainguyenmonhoc_decuongmonhoc_form();
echo '<br>';
$table6 = get_tainguyenmonhoc_by_ma_decuong($ma_decuong, $ma_ctdt, $mamonhoc);
echo '<br>';

// Process form
if ($mform6->is_cancelled()) {
} else if ($mform6->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform6->get_data()) {
    $param2 = new stdClass();

    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->ma_decuong = $fromform->ma_decuong;

    $param2->loaitainguyen = $mform6->get_submit_value('loaitainguyen');

    $param2->ten_tainguyen = $fromform->ten_tainguyen;

    $param2->mota_tainguyen = $fromform->mota_tainguyen;
    $param2->link_tainguyen = $fromform->link_tainguyen;
    

    
    insert_tainguyenmonhoc_table($param2);
    
    $table6 = get_tainguyenmonhoc_by_ma_decuong($fromform->ma_decuong, $ma_ctdt, $mamonhoc);
	$mform6->display();
    echo html_writer::table($table6);
    echo \html_writer::tag(
        'button',
        'Xóa tài nguyên môn học',
        array('id' => 'btn_delete_tainguyenmonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;


    $mform6->set_data($toform);
	$mform6->display();
    echo html_writer::table($table6);
    echo \html_writer::tag(
        'button',
        'Xóa tài nguyên môn học',
        array('id' => 'btn_delete_tainguyenmonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
}

//=================================================================================
//QUY DINH CHUNG
$mform7 = new quydinhchung_decuongmonhoc_form();
echo '<br>';

$table7 = get_quydinhchung_by_ma_decuong($ma_decuong, $ma_ctdt, $mamonhoc);

// Process form
if ($mform7->is_cancelled()) {
} else if ($mform7->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform7->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->ma_decuong = $fromform->ma_decuong;
    $param2->mota_quydinhchung = $fromform->mota_quydinhchung;

    insert_quydinhchung_monhoc_table($param2);
    $table7 = get_quydinhchung_by_ma_decuong($fromform->ma_decuong, $ma_ctdt, $mamonhoc);
    $mform7->display();
    
    echo html_writer::table($table7);
    echo \html_writer::tag(
        'button',
        'Xóa quy định chung môn học',
        array('id' => 'btn_delete_quydinhchungmonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;

    $mform7->set_data($toform);
	$mform7->display();
    echo html_writer::table($table7);
    echo \html_writer::tag(
        'button',
        'Xóa quy định chung môn học',
        array('id' => 'btn_delete_quydinhchungmonhoc', 'style'=>"border: none;width: auto; height:40px; background-color: #1177d1; color: #fff")
    );
    echo '<br>';
    
}
echo '<br>';


// PDF
// Export file
////////////////////////////////////////////////////////////////////////////////

class MYPDF extends TCPDF
{
   
    public function Header()
    {
        $this->setJPEGQuality(90);
        $this->SetFont('times', '', 12);
        $this->Image('../exportpdf/img/logo.png', 16.7, 10.9, 19.4, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Image('../exportpdf/img/logoR.png', 16.7, 10.7, 19.4, '', 'PNG', '', 'T', false, 300, 'R', false, false, 0, false, false, false);
        $this->Ln(4);
        $this->Cell(25, 1, '');
        $this->Cell(50, 1, 'Trường Đại học Khoa Học Tự Nhiên, ĐHQG-HCM        ');
        $this->Ln(7);
        $this->Cell(25, 1, '');
        $this->SetFont('timesbd', '', 12);
        $this->Cell(50, 1, 'Khoa Công Nghệ Thông Tin');
        $this->Ln(4);
        $this->Cell(50, 1, '_____________________________________________________________________________________');
        // $this->Cell(50, 5, '______________________________________', '', 0, 'C');

    }
    public function Footer()
    {
        $image_file = "img/bg_bottom_releve.jpg";
        $this->Image($image_file, 11, 241, 189, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->SetY(-20);
        $this->SetFont('freeserif', 'I', 11);
        $this->Ln(5);


        $this->Ln(5);
        $name = 'Các chủ đề nâng cao trong Công nghệ phần mềm';

        $this->Cell(30, 5, 'Đề cương môn học ');
        $this->SetFont('freeserif', 'BI', 11);
        $this->Cell(60, 5, $name);
        $this->SetFont('freeserif', '', 11);
        $titulos = explode("|", bottom_info);

        $num = $this->getAliasNumPage();
        $pagin = 'Trang ' . $this->getPage() . '/' . $this->getNumPages();
        $this->Cell(0, 5, $pagin, 0, 0, 'R');

        $this->Ln(15);
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetFooterMargin(400);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tấn sơn');
$pdf->SetTitle('Đề cương môn học');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set orientation
$pdf->setPageOrientation('',1,200);

// set header and footer fonts
$pdf->setHeaderFont(array('times', '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array('times', '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(15, 35, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// add font times new roman
$fontpath1 = '../exportpdf/font/times.ttf';
$fontpath2 = '../exportpdf/font/timesbd.ttf';
$fontpath3 = '../exportpdf/font/timesbi.ttf';
$fontpath4 = '../exportpdf/font/timesi.ttf';
$fontname1 = TCPDF_FONTS::addTTFfont($fontpath1, 'TrueTypeUnicode', '', 96);
$fontname2 = TCPDF_FONTS::addTTFfont($fontpath2, 'TrueTypeUnicode', '', 96);
$fontname3 = TCPDF_FONTS::addTTFfont($fontpath3, 'TrueTypeUnicode', '', 96);
$fontname4 = TCPDF_FONTS::addTTFfont($fontpath4, 'TrueTypeUnicode', '', 96);
// set font
$pdf->SetFont('timesbd', 'B', 13, '', false);

// add a page
$pdf->AddPage();

$ttc_body = $chitietmh->tenmonhoc_vi;

// 1. THÔNG TIN CHUNG
$ttc_header = '1. THÔNG TIN CHUNG:';
$pdf->writeHTML($ttc_header, true, false, true, false, '');
// set default form properties
$pdf->setFormDefaultProp(array('lineWidth' => 1, 'borderStyle' => 'solid', 'fillColor' => array(255, 255, 200), 'strokeColor' => array(255, 128, 128)));
$pdf->Ln(4);
$pdf->SetFont('times', '', 12, '', false);
// Name.Vi
$pdf->Cell(10, 5, '');
$pdf->Cell(65, 5, 'Tên môn học (tiếng Việt):');
$pdf->Cell(35, 5,  $chitietmh->tenmonhoc_vi);
$pdf->Ln(8);
// Name.En
$pdf->Cell(10, 5, '');
$pdf->Cell(65, 5, 'Tên môn học (tiếng Anh):');
$pdf->Cell(35, 5, $chitietmh->tenmonhoc_en);
$pdf->Ln(8);
// Last name
$pdf->Cell(10, 5, '');
$pdf->Cell(65, 5, 'Mã số môn học:');
$pdf->Cell(35, 5, $chitietmh->mamonhoc);
$pdf->Ln(8);
// 
$pdf->Cell(10, 5, '');
$pdf->Cell(65, 5, 'Số tín chỉ: ');
$pdf->Cell(35, 5, $chitietmh->sotinchi);
$pdf->Ln(8);
//
$pdf->Cell(20, 5, '');
$pdf->Cell(55, 5, 'Số tiết lý thuyết: ');
$pdf->Cell(35, 5, $chitietmh->sotietlythuyet);
$pdf->Ln(8);
// 
$pdf->Cell(20, 5, '');
$pdf->Cell(55, 5, 'Số tiết thực hành: ');
$pdf->Cell(115, 5, $chitietmh->sotietthuchanh);
$pdf->Ln(8);
//
$pdf->Cell(20, 5, '');
$pdf->Cell(55, 5, 'Số tiết tự học: ');
$pdf->Cell(35, 5, $chitietmh->sotiettuhoc);
$pdf->Ln(8);
// 
$pdf->Cell(10, 5, '');
$pdf->Cell(65, 5, 'Các môn học tiên quyết: ');
$pdf->Cell(35, 5, 'Không ');
$pdf->Ln(10);

// 2. MÔ TẢ MÔN HỌC
$pdf->SetFont('timesbd', 'B', 13, '', false);
$part_header = '2. MÔ TẢ MÔN HỌC (COURSE DESCRIPTION)';
$pdf->writeHTML($part_header, true, false, true, false, '');
$mtmh_body = $chitietmh->mota;
$pdf->Ln(1);
$pdf->SetFont('times', '', 12, '', false);
$pdf->setCellHeightRatio(2); //Tạo khoảng cách giữa các dòng trong 1 đoạn text
$pdf->writeHTML($mtmh_body, true, false, true, false, '');
$pdf->Ln(6);

// 3. MỤC TIÊU MÔN HỌC
function fetch_data_muctieu()
{
    GLOBAL $DB;
    $output = '';
    $data_record = $DB->get_records('block_edu_muctieumonhoc', array());  
    foreach ($data_record as $row) {
       $output .= '
               <tr>
                   <td style = "text-align: center">' . $row->muctieu. '</td>
                   <td>' . $row->mota. '</td>
                   <td>' . $row->danhsach_cdr . '</td>
                </tr>
                ';
    }
    return $output;
}
$pdf->SetFont('timesbd', '', 13, '', false);
$part_header = '3. MỤC TIÊU MÔN HỌC (COURSE GOALS)';
$pdf->writeHTML($part_header, true, false, true, false, '');
$pdf->SetFont('times', '', 13, '', false);
$pdf->writeHTML('Sinh viên học xong môn học này có khả năng :', true, false, true, false, '');
$table_content = '<table border = "1" cellspacing = "0" cellpadding ="5">
                    <tr style = "font-family: timesbd; background-color: rgb(0, 112, 192); color:#fff; text-align:center">
                        <th width = "15%" style = "display: flex; align-items: center;"><b>Mục tiêu</b></th>
                        <th width = "60%" style = "display: flex; align-items: center;"><b>Mô tả (mức tổng quát )</b></th>
                        <th width = "25%" style = "display: flex; align-items: center;"><b>CĐR CDIO<br>của chương trình</b></th>
                    </tr>';
$table_content .= fetch_data_muctieu();
$table_content .= '</table>';
$pdf->Ln(1);
$pdf->SetFont('times', '', 12, '', false);
$pdf->setCellHeightRatio(2); //Tạo khoảng cách giữa các dòng trong 1 đoạn text
$pdf->writeHTML($table_content, true, false, true, false, '');

// 4. CHUẨN ĐẦU RA MÔN HỌC 
function fetch_data_cdr()
{
    GLOBAL $DB;
    $output = '';
    $data_record = $DB->get_records('block_edu_chuandaura', array());  
    foreach ($data_record as $row) {
       $output .= '
               <tr>
                   <td style = "text-align: center">' . $row->ma_cdr. '</td>
                   <td>' . $row->mota. '</td>
                   <td style = "text-align: center">' . $row->mucdo_utilize . '</td>
                </tr>
                ';
    }
    return $output;
}
$pdf->SetFont('timesbd', '', 13, '', false);
$part_header = '4. CHUẨN ĐẦU RA MÔN HỌC';
$pdf->writeHTML($part_header, true, false, true, false, '');
$table_content = '<table border = "1" cellspacing = "0" cellpadding ="5">
                    <tr style = "font-family: timesbd; background-color: rgb(0, 112, 192); color:#fff; text-align:center">
                        <th width = "15%"><b>Chuẩn đầu ra</b></th>
                        <th width = "60%"><b>Mô tả (Mức chi tiết - hành động)</b></th>
                        <th width = "25%"><b>Mức độ (I/T/U)</b></th>
                    </tr>';
$table_content .= fetch_data_cdr();
$table_content .= '</table>';
$pdf->Ln(1);
$pdf->SetFont('times', '', 12, '', false);
$pdf->setCellHeightRatio(2); //Tạo khoảng cách giữa các dòng trong 1 đoạn text
$pdf->writeHTML($table_content, true, false, true, false, '');

// 5. KẾ HOẠCH GIẢNG DẠY LÝ THUYẾT
function fetch_data_lt()
{
    GLOBAL $DB;
    $output = '';
    $data_record = $DB->get_records('block_edu_kh_giangday_lt', []);
    $stt = 1;   
    foreach ($data_record as $row) {
       $output .= '
               <tr>
                   <td style = "text-align: center">' . $stt . '</td>
                   <td>' . $row->ten_chude . '</td>
                   <td>' . $row->danhsach_cdr . '</td>
                   <td>' . $row->hoatdong_gopy. '</td>
                   <td>' . $row->hoatdong_danhgia. '</td>
                </tr>
                ';
    }
    return $output;
}
$pdf->SetFont('timesbd', '', 13, '', false);
$part_header = '5. KẾ HOẠCH GIẢNG DẠY LÝ THUYẾT';
$pdf->writeHTML($part_header, true, false, true, false, '');
$table_content = '<table border = "1" cellspacing = "0" cellpadding ="5">
                    <tr style = "font-family: timesbd; background-color: rgb(0, 112, 192); color:#fff; text-align:center">
                        <th width = "10%"><b>STT</b></th>
                        <th width = "30%"><b>Tên chủ đề</b></th>
                        <th width = "20%"><b>Chuẩn đầu ra</b></th>
                        <th width = "25%"><b>Hoạt động dạy/<br>Hoạt động học (gợi ý)</b></th>
                        <th width = "15%"><b>Hoạt động đánh giá</b></th>
                    </tr>';
$table_content .= fetch_data_lt();
$table_content .= '</table>';
$pdf->Ln(1);
$pdf->SetFont('times', '', 12, '', false);
$pdf->setCellHeightRatio(2); //Tạo khoảng cách giữa các dòng trong 1 đoạn text
$pdf->writeHTML($table_content, true, false, true, false, '');

// 6. ĐÁNH GIÁ
function fetch_data_dg()
{
    GLOBAL $DB;
    $output = '';
    $data_record = $DB->get_records('block_edu_danhgiamonhoc', []);
    $stt = 1;   
    foreach ($data_record as $row) {
       $output .= '
               <tr>
                   <td style = "text-align: center">' . $madanhgia . '</td>
                   <td>' . $row->tendanhgia . '</td>
                   <td>' . $row->motadanhgia . '</td>
                   <td>' . $row->chuandaura_danhgia. '</td>
                   <td>' . $row->tile_danhgia. '</td>
                </tr>
                ';
    }
    return $output;
}
$pdf->SetFont('timesbd', '', 13, '', false);
$part_header = '6. ĐÁNH GIÁ';
$pdf->writeHTML($part_header, true, false, true, false, '');
$table_content = '<table border = "1" cellspacing = "0" cellpadding ="5">
                    <tr style = "font-family: timesbd; background-color: rgb(0, 112, 192); color:#fff; text-align:center">
                        <th width = "10%"><b>Mã</b></th>
                        <th width = "30%"><b>Tên</b></th>
                        <th width = "30%"><b>Mô tả (gợi ý)</b></th>
                        <th width = "15%"><b>Các chuẩn</b></th>
                        <th width = "15%"><b>Tỉ lệ (%)</b></th>
                    </tr>';
$table_content .= fetch_data_dg();
$table_content .= '</table>';
$pdf->Ln(1);
$pdf->SetFont('times', '', 12, '', false);
$pdf->setCellHeightRatio(2); //Tạo khoảng cách giữa các dòng trong 1 đoạn text
$pdf->writeHTML($table_content, true, false, true, false, '');


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// reset font stretching
$pdf->setFontStretching(10);

// reset font spacing
$pdf->setFontSpacing(0);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output(__DIR__ . '/decuong.pdf', 'F');
echo "<button style='border: none;width: auto; height:40px; background-color: #1177d1; color: #fff'><a href = 'decuong.pdf' style='color: #fff'>Export PDF</a></button>";

////////////////////////////////////////////////////////////////////////////////
// Print footer
echo $OUTPUT->footer();?>