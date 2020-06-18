
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
$id = optional_param('id', 0, PARAM_INT);
$chitietmh = get_monhoc_by_id_monhoc($id);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_monhoc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php'));
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

///===========================================================================
//THONG TIN CHUNG
$mform1 = new thongtinchung_decuongmonhoc_form();
$ttc_body;
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
    $toform;
    $toform->id = $chitietmh->id;
    $toform->masomonhoc_thongtinchung = $chitietmh->mamonhoc;
    $toform->tenmonhoc1_thongtinchung = $chitietmh->tenmonhoc_vi;
    $toform->tenmonhoc2_thongtinchung = $chitietmh->tenmonhoc_en;
    $toform->loaihocphan = $chitietmh->loaihocphan;
    $toform->sotinchi_thongtinchung = $chitietmh->sotinchi;
    $toform->tietlythuyet_thongtinchung = $chitietmh->sotietlythuyet;
    $toform->tietthuchanh_thongtinchung = $chitietmh->sotietthuchanh;

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
    //
    $index_mabac = $mform->get_data()->mabac;    
    // $param1->ma_bac = $mform->get_data()->mabac;
    $allbacdts = $DB->get_records('block_edu_bacdt', []);
    $param1->ma_bac = $allbacdts[$index_mabac + 1 ]->ma_bac;
    // echo $allbacdts[$index_mabac +1]->ma_bac;    
    $param1->ma_he = $mform->get_data()->mahe;
    $param1->ten = $mform->get_data()->tenhe;
    $param1->mota = $mform->get_data()->mota;
    update_hedt($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    //edit file index.php tương ứng trong thư mục page. trỏ đến đường dẫn chứa file đó
    $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
    $linktext = get_string('label_hedt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
    // $mform->display();


} else if ($mform0->is_submitted()) {
    //
} else {
    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->mota = $chitietmh->mota;
    // $toform->mota_decuong = $chitietmh->mota;
    
    $mform0->set_data($toform);

    // displays the form
    $mform0->display();
}

///===========================================================================
//MUC TIEU MON HOC
$table2 = get_muctieu_monmhoc_by_mamonhoc($a);
echo '<br>';
$mform2 = new muctieumonhoc_decuongmonhoc_form();
if ($mform2->is_cancelled()) {
} else if ($mform2->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform2->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->muctieu = $fromform->muctieu_muctieumonhoc;
    $param2->mota = $fromform->mota_muctieu_muctieumonhoc;
    $param2->danhsach_cdr = $fromform->chuandaura_cdio_muctieumonhoc;
    insert_muctieumonhoc_table($param2);
    $table2 = get_muctieu_monmhoc_by_mamonhoc($param2->mamonhoc);
	$mform2->display();
    echo html_writer::table($table2);
    echo \html_writer::tag(
        'button',
        'Xóa Muc Tieu',
        array('id' => 'btn_delete_muctieumonhoc')
    );
    echo '<br>';
    
} else {
    //Set default data from DB
    $toform;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $mform2->set_data($toform);
	$mform2->display();
    echo html_writer::table($table2);
    echo \html_writer::tag(
        'button',
        'Xóa Muc Tieu',
        array('id' => 'btn_delete_muctieumonhoc')
    );
    echo '<br>';
    
}

///================================================================================
//CHUAN DAU RA MON HOC
$table3 = get_chuandaura_monmhoc_by_mamonhoc($a);
echo '<br>';
$mform3 = new chuandaura_decuongmonhoc_form();

// Process form
if ($mform3->is_cancelled()) {
} else if ($mform3->no_submit_button_pressed()) {
    // Button no_sumbit
} else if ($fromform = $mform3->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->ma_cdr = $fromform->chuandaura;
    $param2->mota = $fromform->mota_chuandaura;
    $param2->mucdo_utilize = $fromform->mucdo_itu_chuandaura;
    $param2->mucdo_teach = 1;
    $param2->mucdo_introduce = 1;
    insert_chuandaura_table($param2);
    $table3 = get_chuandaura_monmhoc_by_mamonhoc($param2->mamonhoc);
	$mform3->display();
    echo html_writer::table($table3);
    echo \html_writer::tag(
        'button',
        'Xóa chuẩn đầu ra',
        array('id' => 'btn_delete_chuandauramonhoc')
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $mform3->set_data($toform);
	$mform3->display();
    echo html_writer::table($table3);
    echo \html_writer::tag(
        'button',
        'Xóa chuẩn đầu ra',
        array('id' => 'btn_delete_chuandauramonhoc')
    );
    echo '<br>';
    
}

//=================================================================================
//KE HOACH GIANG DAY LY THUYET
$table4 = get_kehoachgiangday_LT_by_mamonhoc($a);
echo '<br>';
$mform4 = new giangday_LT_decuongmonhoc_form();
if ($mform4->is_cancelled()) {
} else if ($mform4->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform4->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->ten_chude = $fromform->chudegiangday;
    $param2->danhsach_cdr = $fromform->danhsach_cdr;
    $param2->hoatdong_gopy = $fromform->hoatdong_giangday;
    $param2->hoatdong_danhgia = $fromform->hoatdong_danhgia;
    insert_kehoachgiangday_LT_table($param2);
    $table4 = get_kehoachgiangday_LT_by_mamonhoc($param2->mamonhoc);
	$mform4->display();
    echo html_writer::table($table4);
    echo \html_writer::tag(
        'button',
        'Xóa kế hoạch giảng dạy',
        array('id' => 'btn_delete_khgdltmonhoc')
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $mform4->set_data($toform);
	$mform4->display();
    echo html_writer::table($table4);
    echo \html_writer::tag(
        'button',
        'Xóa kế hoạch giảng dạy',
        array('id' => 'btn_delete_khgdltmonhoc')
    );
    echo '<br>';
    
}
echo '<br>';

//=================================================================================
//DANH GIA MON HOC
$table5 = get_danhgiamonhoc_by_mamonhoc($a);
echo '<br>';
$mform5 = new danhgia_decuongmonhoc_form();
if ($mform5->is_cancelled()) {
} else if ($mform5->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform5->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->madanhgia = $fromform->madanhgia;
    $param2->tendanhgia = $fromform->tendanhgia;
    $param2->motadanhgia = $fromform->motadanhgia;
    $param2->chuandaura_danhgia = $fromform->cacchuandaura_danhgia;
    $param2->tile_danhgia = $fromform->tile_danhgia;
    insert_danhgiamonhoc_table($param2);
    $table5 = get_danhgiamonhoc_by_mamonhoc($fromform->mamonhoc);
	$mform5->display();
    echo html_writer::table($table5);
    echo \html_writer::tag(
        'button',
        'Xóa đánh giá môn học',
        array('id' => 'btn_delete_danhgiamonhoc')
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $mform5->set_data($toform);
	$mform5->display();
    echo html_writer::table($table5);
    echo \html_writer::tag(
        'button',
        'Xóa đánh giá môn học',
        array('id' => 'btn_delete_danhgiamonhoc')
    );
    echo '<br>';
    
}
echo '<br>';

//=================================================================================
//TAI NGUYEN MON HOC
$mform6 = new tainguyenmonhoc_decuongmonhoc_form();
echo '<br>';
$table6 = get_tainguyenmonhoc_by_mamonhoc($a);
echo '<br>';

// Process form
if ($mform6->is_cancelled()) {
} else if ($mform6->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform6->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->loaitainguyen = $fromform->loaitainguyen;
    $param2->mota_tainguyen = $fromform->mota_tainguyen;
    $param2->link_tainguyen = $fromform->link_tainguyen;
    insert_tainguyenmonhoc_table($param2);
    $table6 = get_tainguyenmonhoc_by_mamonhoc($fromform->mamonhoc);
	$mform6->display();
    echo html_writer::table($table6);
    echo \html_writer::tag(
        'button',
        'Xóa tài nguyên môn học',
        array('id' => 'btn_delete_tainguyenmonhoc')
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $mform6->set_data($toform);
	$mform6->display();
    echo html_writer::table($table6);
    echo \html_writer::tag(
        'button',
        'Xóa tài nguyên môn học',
        array('id' => 'btn_delete_tainguyenmonhoc')
    );
    echo '<br>';
    
}

//=================================================================================
//QUY DINH CHUNG
$mform7 = new quydinhchung_decuongmonhoc_form();
echo '<br>';
$table7 = get_quydinhchung_by_mamonhoc($a);

// Process form
if ($mform7->is_cancelled()) {
} else if ($mform7->no_submit_button_pressed()) {
    // Button no_submit
} else if ($fromform = $mform7->get_data()) {
    $param2 = new stdClass();
    $param2->mamonhoc = $fromform->mamonhoc;
    $param2->mota_quydinhchung = $fromform->mota_quydinhchung;
    insert_quydinhchung_monhoc_table($param2);
    $table7 = get_quydinhchung_by_mamonhoc($fromform->mamonhoc);
	$mform7->display();
    echo html_writer::table($table7);
    echo \html_writer::tag(
        'button',
        'Xóa quy định chung môn học',
        array('id' => 'btn_delete_quydinhchungmonhoc')
    );
    echo '<br>';
    
} else {
    $toform;
    $toform->mamonhoc = $chitietmh->mamonhoc;
    $mform7->set_data($toform);
	$mform7->display();
    echo html_writer::table($table7);
    echo \html_writer::tag(
        'button',
        'Xóa quy định chung môn học',
        array('id' => 'btn_delete_quydinhchungmonhoc')
    );
    echo '<br>';
    
}
echo '<br>';


// PDF
// Export file
////////////////////////////////////////////////////////////////////////////////



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tấn sơn');
$pdf->SetTitle('Đề cương môn học');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(
    '../img/img.jpg',
    25,
    'Truong Dai hoc KHTN - HCM',
    'Khoa Cong nghe thong tin'
);

// set header and footer fonts
$pdf->setHeaderFont(Array('freeserif', '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array('freeserif', '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('freeserif', 'B', 13);

// add a page
$pdf->AddPage();

$ttc_body = $chitietmh->tenmonhoc_vi;

// 1. THÔNG TIN CHUNG
$ttc_header = '<h2>1. THÔNG TIN CHUNG</h2>';
$pdf->writeHTML($ttc_header, true, false, true, false, '');


// set default form properties
$pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));

// $pdf->SetFont('helvetica', 'BI', 18);
// $pdf->Cell(0, 5, 'Example of Form', 0, 1, 'C');
$pdf->Ln(4);

$pdf->SetFont('freeserif', '', 12);

// Name.Vi
$pdf->Cell(10, 5, '');
$pdf->Cell(55, 5, 'Tên môn học (tiếng Việt)');
$pdf->Cell(35, 5,  $chitietmh->tenmonhoc_vi);
$pdf->Ln(6);

// Name.En
$pdf->Cell(10, 5, '');
$pdf->Cell(55, 5, 'Tên môn học (tiếng Anh)');
$pdf->Cell(35, 5, $chitietmh->tenmonhoc_en);
$pdf->Ln(6);

// Last name
$pdf->Cell(10, 5, '');
$pdf->Cell(55, 5, 'Mã số môn học');
$pdf->Cell(35, 5, $chitietmh->mamonhoc);
$pdf->Ln(6);

// 
$pdf->Cell(10, 5, '');
$pdf->Cell(55, 5, 'Số tín chỉ: ');
$pdf->Cell(35, 5, $chitietmh->sotinchi);
$pdf->Ln(6);

//
$pdf->Cell(10, 5, '');
$pdf->Cell(55, 5, 'Số tiết lý thuyết ');
$pdf->Cell(35, 5, $chitietmh->sotietlythuyet);
$pdf->Ln(6);

// 
$pdf->Cell(10, 5, '');
$pdf->Cell(55, 5, 'Số tiết thực hành ');
$pdf->Cell(35, 5, $chitietmh->sotietthuchanh);
$pdf->Ln(6);

//
$pdf->Cell(10, 5, '');
$pdf->Cell(55, 5, 'Số tiết tự học ');
$pdf->Cell(35, 5, $chitietmh->sotietlythuyet);
$pdf->Ln(6);

// 
$pdf->Cell(10, 5, '');
$pdf->Cell(55, 5, 'Các môn học tiên quyết ');
$pdf->Cell(35, 5, 'Không ');
$pdf->Ln(10);

// // reset font stretching
// $pdf->setFontStretching(10);

// // reset font spacing
// $pdf->setFontSpacing(0);

// 2. MÔ TẢ MÔN HỌC
$pdf->SetFont('freeserif', 'B', 13);
$mtmh_header = '<h2>2. MÔ TẢ MÔN HỌC</h2>';
$pdf->writeHTML($mtmh_header, true, false, true, false, '');
$mtmh_body = '<p>Môn học này nhằm cung cấp cho sinh viên một cái nhìn tổng quát về lĩnh vực Công nghệ phần mềm,
các kiến thức nền tảng liên quan đến các thành phần chính yếu trong lĩnh vực công nghệ phần mềm
(khái niệm về phần mềm, các tiến trình, các phương pháp, kỹ thuật phát triển phần mềm, các phương
pháp tổ chức quản lý, công cụ và môi trường phát triển và triển khai phần mềm...). Môn học cũng giúp
xây dựng kiến thức nền tảng cho chuyên ngành Kỹ thuật phần mềm nhằm tạo sự sẵn sàng cho các môn
học chuyên sâu hơn ở các năm sau. Môn học cũng giúp sinh viên có những trải nghiệm thực tế về quá
trình xây dựng một phần mềm ở mức độ đơn giản một cách có hệ thống và có phương pháp.</p>';
$pdf->Ln(4);
$pdf->SetFont('freeserif', '', 12);
$pdf->Cell(100, 5, '');
$pdf->writeHTML($mtmh_body, true, false, true, false, '');
$pdf->Ln(6);

// 3. MỤC TIÊU MÔN HỌC
$pdf->SetFont('freeserif', 'B', 13);
$mtmh_header = '<h2>3. MỤC TIÊU MÔN HỌC</h2>';
$pdf->writeHTML($mtmh_header, true, false, true, false, '');
// Danh sách mục tiêu môn học
$mtmh_body = get_muctieu_monmhoc_by_mamonhoc($a);
// 
$pdf->Ln(4);
$pdf->SetFont('freeserif', '', 12);
$pdf->Cell(100, 5, '');
// $pdf->writeHTML($mtmh_body, true, false, true, false, '');
$pdf->Ln(10);

//MUCTIEU TABLE
$header = array('Mục tiêu', 'Mô tả (mức chi tiết)', 'Chuẩn đầu ra CDIO của chương trình');

$data_table = $DB->get_records('block_edu_muctieumonhoc', array('mamonhoc' => $a));

foreach($data_table as $i){
    $arr[] = [(string)$i->muctieu,(string)$i->mota, (string)$i->danhsach_cdr ];
}


$pdf->SetFillColor(0, 0, 255);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0);
$pdf->SetFont('', 'B');
// Header
$w = array(60, 60, 60);
$num_headers = count($header);
for($i = 0; $i < $num_headers; ++$i) {
    $pdf->Cell($w[$i], 15, $header[$i], 1, 0, 'center', 1,'' , 1);
}
$pdf->Ln();
// Color and font restoration
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
// Data
$fill = 0;
foreach($arr as $row) {
    
    $pdf->Cell($w[0], 15, $row[0], 'LR', 0, 'L', $fill);
    $pdf->Cell($w[1], 15, $row[1], 'LR', 0, 'L', $fill);
    $pdf->Cell($w[2], 15, $row[2], 'LR', 0, 'R', $fill);
    
    
    $pdf->Ln();
    $fill=!$fill;
}
$pdf->Cell(array_sum($w), 0, '', 'T');


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// reset font stretching
$pdf->setFontStretching(10);

// reset font spacing
$pdf->setFontSpacing(0);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output(__DIR__.'/example_063.pdf', 'F');
echo "<a href = 'example_063.pdf'>Export PDF</a>";


////////////////////////////////////////////////////////////////////////////////
// Print footer
echo $OUTPUT->footer();
?>