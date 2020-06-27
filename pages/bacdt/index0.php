<?php
require_once(__DIR__ . '/../../../../config.php');
// require_once($CFG->libdir.'/pdflib.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');
require_once("$CFG->libdir/tcpdf/tcpdf.php");
require_once('../../js.php');

global $COURSE, $GLOBALS;
var_dump($_REQUEST);
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_bacdt', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_bacdt', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_bacdt', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Create table
$table = get_bacdt_checkbox($search, $page);

// Search
require_once('../../form/bacdt/qlbac_form.php');
$form_search = new bacdt_seach();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->bacdt_seach;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/bacdt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
    // redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/bacdt/index.php?search='.$search.'&amp;page='.$page);
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->bacdt_seach = $search;
    $form_search->set_data($toform);
    // Displays form
    $form_search->display();
}

// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Xóa BDT',
        array('id' => 'btn_delete_bacdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone BDT',
        array('id' => 'btn_clone_bacdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_bacdt', 'onClick' => "window.location.href='add_bdt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
        // array('id' => 'btn_add_bacdt', 'onClick' => "window.location.href='add_bdt.php'", 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #1177d1; color:#fff;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

// Insert data if table is empty
if (!$DB->count_records('block_edu_bacdt', [])) {
    $param1 = new stdClass();
    $param2 = new stdClass();
    $param3 = new stdClass();
    // $param
    $param1->id = 1;
    $param1->ma_bac = 'DH';
    $param1->ten = 'Đại học';
    $param1->mota = 'Bậc Đại học HCMUS';
    // $param
    $param2->id = 2;
    $param2->ma_bac = 'CD';
    $param2->ten = 'Cao đẳng';
    $param2->mota = 'Bậc Cao đẳng HCMUS';
    // $param
    $param3->id = 3;
    $param3->ma_bac = 'DTTX';
    $param3->ten = 'Đào tạo từ xa';
    $param3->mota = 'Bậc Đào tạo từ xa HCMUS';
    insert_bacdt($param1);
    insert_bacdt($param2);
    insert_bacdt($param3);
}

// Add new BDT
$url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/add_bdt.php', []);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
// echo  \html_writer::link($url, $ten_url);
// echo '<br>';
echo '<br>';

// Print table
echo html_writer::table($table);
// Pagination
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_bacdt_checkbox($search, -1)->data), $page, 5, $baseurl);


// basic pdf



require_once('../../model/monhoc_model.php');
// create new PDF document
class MYPDF extends TCPDF
{
    public function Header()
    {
        $this->setJPEGQuality(90);
        // $this->Image('logo.png', 120, 10, 75, 0, 'PNG');
        $this->SetFont('times', '', 12);
        $this->Image('logo.png', 16.7, 10.9, 19.4, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Image('logoR.png', 16.7, 10.7, 19.4, '', 'PNG', '', 'T', false, 300, 'R', false, false, 0, false, false, false);
        $this->Ln(4);
        $this->Cell(25, 1, '');
        $this->Cell(50, 1, 'Trường Đại học Khoa Học Tự Nhiên, ĐHQG-HCM        ');
        $this->Ln(7);
        $this->Cell(25, 1, '');
        $this->SetFont('timesbd', '', 12);
        $this->Cell(50, 1, 'Khoa Công Nghệ Thông Tin');
        $this->Ln(4);
        $this->Cell(50, 1, '______________________________________________________________________________________');
        // $this->Cell(50, 5, '______________________________________', '', 0, 'C');

    }
    public function Footer()    
    {
        // $this->SetFont('times', '', 12);
        // $this->Cell(50, 1, '______________________________________________________________________________________');

        // $this->Ln(3);
        // $this->Cell(25, 1, '');
        // $this->Cell(50, 1, 'Trường Đại học Khoa Học Tự Nhiên, ĐHQG-HCM        ');
        // $this->Ln(7);
        // $this->Cell(25, 1, '');
        // $this->SetFont('timesbd', '', 12);
        // $this->Cell(50, 1, 'Khoa Công nghệ Thông tin');
        // $this->Ln(5);
        

        $image_file = "img/bg_bottom_releve.jpg";
        $this->Image($image_file, 11, 241, 189, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->SetY(-35);
        $this->SetFont('freeserif', 'I', 11);
        $this->Ln(5);


        $this->Ln(5);
        $name ='Nhập môn Công nghệ phần mềm';
 
        $this->Cell(30, 5, 'Đề cương môn học ');
        $this->SetFont('freeserif', 'BI', 11);
        $this->Cell(60, 5, $name);
        $this->SetFont('freeserif', '', 11);
        $titulos = explode("|",bottom_info);
        // $pagin = 'Trang '.$this->getAliasNumPage().'/'.$this->getAliasNbPages();
        // $pagin = 'Trang '.$this->getAliasNumPage().'/'.$this->getAliasNbPages();
        // $pagin = 'Trang '.$this->getAliasNumPage() . '//' . $this->getAliasNbPages();
        // $pagin = 'Trang '.$this->getAliasNumPage() . '//' . $this->getAliasNbPages();
        $num = $this->getAliasNumPage();
        $pagin = 'Trang ' . $this->getPage() . '/' . $this->getNumPages();
        $this->Cell( 0, 5, $pagin, 0, 0, 'R' ); 
    
        $this->Ln(15);

        // $fontpath1='font/times.ttf';
        // $fontpath2='font/timesbd.ttf';
        // $fontpath3='font/timesbi.ttf';
        // $fontpath4='font/timessi.ttf';
        // $this->writeHTML('
        // <style>
        // i {
        //     font-style:freeserif;
        //     font-family: times;     
        // </style>
        // <i>Đề cương môn học <b>Nhập môn công nghệ phần mềm</b></i>', true, false, true, false, '');
     
    //     $titulos = explode("|",bottom_info);        
    // $this->Cell(0, 10,  $titulos[$this->page].' Trang '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');


    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tấn sơn');
$pdf->SetTitle('Đề cương môn học');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data


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
if (@file_exists(dirname(_FILE_).'/lang/eng.php')) {
    require_once(dirname(_FILE_).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// add font times new roman
$fontpath1='font/times.ttf';
$fontpath2='font/timesbd.ttf';
$fontpath3='font/timesbi.ttf';
$fontpath4='font/timesi.ttf';
$fontname1 = TCPDF_FONTS::addTTFfont('font', 'TrueTypeUnicode', '', 96);
// $fontname2 = TCPDF_FONTS::addTTFfont($fontpath2, 'TrueTypeUnicode', '', 96);
// $fontname3 = TCPDF_FONTS::addTTFfont($fontpath3, 'TrueTypeUnicode', '', 96);
// $fontname4 = TCPDF_FONTS::addTTFfont($fontpath4, 'TrueTypeUnicode', '', 96);
// set font
$pdf->SetFont('timesbd', 'B', 13, '', false);

// add a page
$pdf->AddPage();

$ttc_body = $chitietmh->tenmonhoc_vi;

// 1. THÔNG TIN CHUNG
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Ln(4);

$ttc_header = '1. THÔNG TIN CHUNG:';
$pdf->writeHTML($ttc_header, true, false, true, false, '');


// set default form properties
$pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));


$pdf->Ln(4);

$pdf->SetFont('times', 'I', 12, '', false);

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
$mtmh_header = '2. MÔ TẢ MÔN HỌC (COURSE DESCRIPTION)';
$pdf->writeHTML($mtmh_header, true, false, true, false, '');
$mtmh_body = $chitietmh->mota;
$pdf->Ln(1);
$pdf->SetFont('times', '', 12, '', false);
$pdf->setCellHeightRatio(2);//Tạo khoảng cách giữa các dòng trong 1 đoạn text
$pdf->writeHTML($mtmh_body, true, false, true, false, '');
$pdf->Ln(6);

// 3. MỤC TIÊU MÔN HỌC
$pdf->SetFont('timesbd', 'B', 13, '', false);
$mtmh_header = '3. MỤC TIÊU MÔN HỌC (COURSE GOALS)';
$pdf->writeHTML($mtmh_header, true, false, true, false, '');
// Danh sách mục tiêu môn học
$mtmh_body = get_muctieu_monmhoc_by_mamonhoc($a);
$pdf->Ln(2);
$pdf->SetFont('times', '', 12, '', false);
$pdf->writeHTML('Sinh viên học xong môn học này có khả năng:');
$pdf->Ln(1);

//MUCTIEU TABLE

$header = array('Mục tiêu', 'Mô tả (mức chi tiết)', 'CĐR CDIO của chương trình');

$data_table = $DB->get_records('block_edu_muctieumonhoc', array('mamonhoc' => $a));

foreach($data_table as $i){
    $arr[] = [(string)$i->muctieu,(string)$i->mota, (string)$i->danhsach_cdr ];
}


$pdf->SetFillColor(0,112,192);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('timesbd', 'B',12, '', false);

// Header
$w = array(20, 120, 40);
$num_headers = count($header);
for($i = 0; $i < $num_headers; ++$i) {
    $pdf->Cell($w[$i], 15, $header[$i], 1, 0, 'center', 1,'' , 1);
}
$pdf->Ln();
// Color and font restoration
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('times', '', 12, '', false);
// Data
$fill = 0;
foreach($arr as $row) {
    
    $pdf->Cell($w[0], 15, $row[0], 'LR', 0, 'C', $fill);
    $pdf->Cell($w[1], 15, $row[1], 'LR', 0, 'C', $fill);
    $pdf->Cell($w[2], 15, $row[2], 'LR', 0, 'C', $fill);
    
    
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
$pdf->Output(__DIR__.'/ds_bacdt.pdf', 'F');
echo "<a href = 'ds_bacdt.pdf'>Export PDF</a>";


////////////////////////////////////////////////////////////////////////////////
// Print footer
echo $OUTPUT->footer();
?>