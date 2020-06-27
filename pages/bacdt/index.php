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



// Export inpage
// create new PDF document
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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PDS');
$pdf->SetTitle('PDS');
$pdf->SetSubject('PDS Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 044', PDF_HEADER_STRING);
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

// $pdf->SetFont('times', '', 14, '', true);
$pdf->SetFont('freeserif', '', 14, '', false);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

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
$table2 = get_bacdt();
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
