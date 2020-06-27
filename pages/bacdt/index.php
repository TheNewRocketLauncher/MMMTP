<?php
require_once(__DIR__ . '/../../../../config.php');
// require_once($CFG->libdir.'/pdflib.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');
require_once('../../exporter/tcpdf.php');
require_once('../../js.php');

global $COURSE, $GLOBALS;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_bacdt', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_bacdt', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_bacdt', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $head = $OUTPUT->header();

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
$url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/add_bdt.php', ['courseid' => $courseid]);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới </i></u>');
echo  \html_writer::link($url, $ten_url);
echo '<br>';
echo '<br>';

// Create table
$table = get_bacdt_checkbox($courseid);
echo html_writer::table($table);

// Button delete BDT
echo '  ';
echo \html_writer::tag(
    'button',
    'Xóa BDT',
    array('id' => 'btn_delete_bacdt')
);
echo '<br>';

// basic pdf



// Export inpage
// create new PDF document
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo.jpg';
        $this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('times', '', 20);
        // Title
        $this->Cell(-15, 15, 'Đại học Khoa hoc Tu Nhien - DHQG HCM', 0, false, 'C', 0, '', 0, false, 'M', 'M');

    } 
}

class MYPDF1 extends TCPDF {
	public function Header() {
		$this->setJPEGQuality(90);
        // $this->Image('logo.png', 120, 10, 75, 0, 'PNG');
        $this->SetFont('freeserif', '', 20);
        $this->Image('logo.png', 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


	}
	public function Footer() {
		$this->SetY(-15);
        // $this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
        $this->SetFont('freeserif', '', 17);
		$this->Cell(0, 10, 'DHKHTN - DHQG TP.HCM', 0, false, 'C');
	}
	public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
		$this->SetXY($x+20, $y); // 20 = margin left
		$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
		$this->Cell($width, $height, $textval, 0, false, $align);
	}
}
$pdf = new MYPDF1(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PDS');
$pdf->SetTitle('PDS');
$pdf->SetSubject('PDS Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 044', PDF_HEADER_STRING);
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

// set default font subsetting mode
$pdf->setFontSubsetting(false);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.

// $pdf->SetFont('times', '', 14, '', true);
$pdf->SetFont('freeserif', '', 14, '', false);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD
<br><br><br><h1>Hello form US Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;
$pdf->Ln(25);
// Write table
$table2 = get_bacdt($courseid);
$output = html_writer::table($table2);
$pdf->writeHTML('<h2>Danh mục bậc đào tạo<h2>');
$pdf->writeHTML($output);
// // Print text using writeHTMLCell()
// $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// Export file
$pdf->Output(__DIR__ . '/ds_bacdt.pdf', 'F');
// Link to read file
$export_url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/ds_bacdt.pdf', []);
$export_url_name = \html_writer::link($export_url, '<u><i> Export PDF </i></u>');
echo '<br>';
echo  \html_writer::link($export_url, $export_url_name);
echo '<br>';

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
// $pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

// Footer
echo $OUTPUT->footer();
