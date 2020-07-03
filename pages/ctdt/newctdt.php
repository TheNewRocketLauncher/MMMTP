<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');
require_once("$CFG->libdir/tcpdf/tcpdf.php");

///-------------------------------------------------------------------------------------------------------///
global $COURSE, $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$tree = optional_param('tree', SITEID, PARAM_INT);
$qtdt = optional_param('qtdt', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/index.php'));
$PAGE->navbar->add(get_string('themctdt_lable', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php'));

// Title.
$PAGE->set_title(get_string('themctdt_title', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('themctdt_head', 'block_educationpgrs'));

// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
// Tạo form
require_once('../../form/ctdt/newctdt_form.php');
$mform = new newctdt_form();

// Form processing
if ($mform->is_cancelled()) {
    // Button cancel    
} else if ($mform->no_submit_button_pressed()) {
    if ($mform->get_submit_value('btn_review')) {
        // Something here
        exportpdf($mform->get_value());
        // echo "<script type='text/javascript'>location.href='CTDT.pdf'</script>";
    }
} else if ($fromform = $mform->get_data()) {
    if (validateData()) {
        $param = new stdClass();
        $ma_ctdt = $fromform->bacdt .
            $fromform->hedt .
            $fromform->khoatuyen .
            $fromform->nganhdt .
            $fromform->chuyenganh;
        $param->ma_ctdt = $ma_ctdt;
        $param->ma_chuyennganh = $fromform->chuyenganh;
        $param->ma_nganh = $fromform->nganhdt;
        $param->ma_nienkhoa = $fromform->khoatuyen;
        $param->ma_he = $fromform->hedt;
        $param->ma_bac = $fromform->bacdt;
        $param->muctieu_daotao = "a";
        $param->thoigian_daotao = $fromform->tgdt;
        $param->khoiluong_kienthuc = $fromform->klkt;
        $param->doituong_tuyensinh = $fromform->dtts;
        $param->quytrinh_daotao = "a";
        $param->dienkien_totnghiep = $fromform->bacdt;
        $param->ma_cay_khoikienthuc = "dda";
        $param->mota = "ad";
        insert_ctdt($param);
        redirect("$CFG->wwwroot/blocks/educationpgrs/pages/ctdt/index.php");
    }
    $mform->display();
} else {
    $x->txt_tgdt = 'set default MTP';
    $mform->set_data($x);
    $mform->display();
}

function validateData()
{
    return true;
}

// PDF
// Export file
////////////////////////////////////////////////////////////////////////////////
function exportpdf($formdata)
{
    // echo $mform->exportValues()->txt_tgdt;
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
    $pdf->setPageOrientation('', 1, 200);

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
    $pdf->SetFont('timesbd', '', 13, '', false);
    // add a page
    $pdf->AddPage();
    $ctct_name = "KỸ THUẬT PHẦN MỀM SS";
    $title = '<div style = "text-align: center; line-height: 15px;"><h1>CHƯƠNG TRÌNH ĐÀO TẠO<h3>NGÀNH ' . $ctct_name . '</h3></h1></div>';
    $pdf->writeHTML($title, true, false, true, false, '');

    // 0. INTRODUCE
    $pdf->SetFont('times', '', 12, '', false);
    $pdf->Cell(45, 5, 'Tên chương trình');
    $pdf->Cell(35, 5,  ':  '.$formdata->txt_tct);
    $pdf->Ln(8);
    $pdf->Cell(45, 5, 'Trình độ đào tạo');
    $pdf->Cell(35, 5, ':  '.$formdata->select_bacdt);
    $pdf->Ln(8);
    $pdf->Cell(45, 5, 'Ngành đào tạo');
    $pdf->Cell(35, 5, ':  '.$formdata->select_nganhdt);
    $pdf->Ln(8);
    $pdf->Cell(45, 5, 'Mã ngành');
    $pdf->Cell(35, 5, ':  '.$formdata->select_nganhdt);
    $pdf->Ln(8);
    $pdf->Cell(45, 5, 'Loại hình đào tạo');
    $pdf->Cell(35, 5, ':  '.$formdata->select_hedt);
    $pdf->Ln(8);
    $pdf->Cell(45, 5, 'Khóa tuyển');
    $pdf->Cell(35, 5, ':  '.$formdata->select_nienkhoa);
    $pdf->Ln(12);


    // 1. MỤC TIÊU ĐÀO TẠO
    $pdf->SetFont('timesbd', '', 13, '', false);
    $pdf->writeHTML('<style> u {font-weight:200px;}</style><br>1.&nbsp;&nbsp;<u>MỤC TIÊU ĐÀO TẠO</u>', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->writeHTML('<br>1.1 MỤC TIÊU CHUNG', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->SetFont('times', '', 13, '', false);


    $editor_content = '<div style = "width: 400px; height: 100px; border: 1px solid #c3c3c3; display: flex; justify-content: center;">
    <div style="width:600px; height: 70px;background-color:coral;">cuc</div><div style ="width: 70px; height: 70px;background-color:lightblue;">' .
    $formdata->editor_muctieudt_chung['text']
    . '</div></div>';

    $editor_content = '<table>
    <tr>
    <th width = "5%" style = "display: flex; align-items: center;"></th>
    <th width = "95%" style = "display: flex; align-items: center;">'.'mot voi 1 la 2'.'</th>
    </tr></table>';

    $pdf->writeHTML($editor_content, true, false, true, false, '');//1
    $pdf->SetFont('timesbd', '', 13, '', false);
    $pdf->writeHTML('<br>1.2 MỤC TIÊU CỤ THỂ - CHUẨN ĐẦU RA CỦA CHƯƠNG TRÌNH ĐÀO TẠO', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->writeHTML('<br>1.2.1 Mục tiêu cụ thể', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->SetFont('times', '', 13, '', false);
    $editor_content = $formdata->editor_muctieudt_chung['text'];
    $pdf->writeHTML($editor_content, true, false, true, false, '');
    $pdf->Ln(3);
    $pdf->SetFont('timesbd', '', 13, '', false);
    $pdf->writeHTML('<br>1.2.2 Chuẩn đầu ra của chương trình giáo dục', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->SetFont('times', '', 13, '', false);
    $editor_content = $formdata->editor_muctieudt_chung['text'];
    $pdf->writeHTML($editor_content, true, false, true, false, '');
    $pdf->Ln(3);
    $pdf->SetFont('timesbd', '', 13, '', false);
    $pdf->writeHTML('<br>1.3 CƠ HỘI NGHỀ NGHIỆP', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->SetFont('times', '', 13, '', false);
    $editor_content = $formdata->editor_muctieudt_chung['text'];
    $pdf->writeHTML($editor_content, true, false, true, false, '');//1
    $pdf->Ln(3);

    // 2. THỜI GIAN ĐÀO TẠO
    $pdf->SetFont('timesbd', '', 13, '', false);
    $thoigian = 8;
    // $pdf->writeHTML('<br>2.&nbsp;&nbsp;<u>THỜI GIAN ĐÀO TẠO</u>: '. $thoigian . ' năm', true, false, true, false, '');
    $pdf->writeHTML('<style> u {font-weight:200;}</style><br>2.&nbsp;&nbsp;<u>THỜI GIAN ĐÀO TẠO</u>: '. $thoigian . ' năm', true, false, true, false, '');

    $pdf->Ln(4);
    
    // 3. KHỐI LƯỢNG KIẾN THỨC TOÀN KHÓA
    $pdf->SetFont('timesbd', '', 13, '', false);
    $tinchi = 173;
    $pdf->writeHTML('<br>3.&nbsp;&nbsp;<u>KHỐI LƯỢNG KIẾN THỨC TOÀN KHÓA</u>: '. $tinchi . ' tín chỉ', true, false, true, false, '');
    $pdf->Ln(4);

    // 4. ĐỐI TƯỢNG TUYỂN SINH
    $pdf->SetFont('timesbd', '', 13, '', false);
    $tinchi = 173;
    $pdf->writeHTML('<br>4.&nbsp;&nbsp;ĐỐI TƯỢNG TUYỂN SINH<u></u>', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->SetFont('times', '', 13, '', false);
    $editor_content = $formdata->editor_muctieudt_chung['text'];
    $editor_content = '<blockquote>'.$formdata->editor_muctieudt_chung['text'].'</blockquote>';
    $pdf->writeHTML($editor_content, true, false, true, false, '');
    $pdf->Ln(3);

    //5. QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP
    $pdf->SetFont('timesbd', '', 13, '', false);
    $pdf->writeHTML('<br>5.&nbsp;&nbsp;<u>QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP</u>', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->writeHTML('<br>5.1 QUY TRÌNH ĐÀO TẠO', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->SetFont('times', '', 13, '', false);
    $editor_content = $formdata->editor_muctieudt_chung['text'];
    $pdf->writeHTML($editor_content, true, false, true, false, '');//1
    $pdf->Ln(3);
    $pdf->SetFont('timesbd', '', 13, '', false);
    $pdf->writeHTML('<br>5.2 ĐIỀU KIỆN TỐT NGHIỆP', true, false, true, false, '');
    $pdf->Ln(4);
    $pdf->SetFont('times', '', 13, '', false);
    $editor_content = $formdata->editor_muctieudt_chung['text'];
    $pdf->writeHTML($editor_content, true, false, true, false, '');//1
    $pdf->Ln(3);

    //6. CẤU TRÚC CHƯƠNG TRÌNH
    $pdf->SetFont('timesbd', '', 13, '', false);
    $pdf->writeHTML('<br>6.&nbsp;&nbsp;<u>CẤU TRÚC CHƯƠNG TRÌNH</u>', true, false, true, false, '');
    $pdf->Ln(4);
    function fetch_data_cautruc()
    {
        global $DB;
        $output = '';
        $data_record = $DB->get_records('block_edu_muctieumonhoc', array());
        foreach ($data_record as $row) {
            $output .= '
               <tr>
                   <td style = "text-align: center">' . $row->muctieu . '</td>
                   <td>' . $row->mota . '</td>
                   <td>' . $row->danhsach_cdr . '</td>
                </tr>
                ';
        }
        return $output;
    }
    $pdf->SetFont('times', '', 13, '', false);
    $table_content = '<table border = "1" cellspacing = "0" cellpadding ="5">
                    <tr style = "font-family: timesbd; background-color: rgb(0, 112, 192); color:#fff; text-align:center">
                        <th width = "15%" style = "display: flex; align-items: center;"><b>Mục tiêu</b></th>
                        <th width = "60%" style = "display: flex; align-items: center;"><b>Mô tả (mức tổng quát )</b></th>
                        <th width = "25%" style = "display: flex; align-items: center;"><b>CĐR CDIO<br>của chương trình</b></th>
                    </tr>';
    $table_content .= fetch_data_cautruc();
    $table_content .= '</table>';
    $pdf->Ln(1);
    $pdf->SetFont('times', '', 12, '', false);
    $pdf->setCellHeightRatio(2); //Tạo khoảng cách giữa các dòng trong 1 đoạn text
    $pdf->writeHTML($table_content, true, false, true, false, '');
    








    // 2. MÔ TẢ MÔN HỌC
    $pdf->SetFont('timesbd', '', 13, '', false);
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
        global $DB;
        $output = '';
        $data_record = $DB->get_records('block_edu_muctieumonhoc', array());
        foreach ($data_record as $row) {
            $output .= '
               <tr>
                   <td style = "text-align: center">' . $row->muctieu . '</td>
                   <td>' . $row->mota . '</td>
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
        global $DB;
        $output = '';
        $data_record = $DB->get_records('block_edu_chuandaura', array());
        foreach ($data_record as $row) {
            $output .= '
               <tr>
                   <td style = "text-align: center">' . $row->ma_cdr . '</td>
                   <td>' . $row->mota . '</td>
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
        global $DB;
        $output = '';
        $data_record = $DB->get_records('block_edu_kh_giangday_lt', []);
        $stt = 1;
        foreach ($data_record as $row) {
            $output .= '
               <tr>
                   <td style = "text-align: center">' . $stt . '</td>
                   <td>' . $row->ten_chude . '</td>
                   <td>' . $row->danhsach_cdr . '</td>
                   <td>' . $row->hoatdong_gopy . '</td>
                   <td>' . $row->hoatdong_danhgia . '</td>
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
        global $DB;
        $output = '';
        $data_record = $DB->get_records('block_edu_danhgiamonhoc', []);
        $stt = 1;
        foreach ($data_record as $row) {
            $output .= '
               <tr>
                   <td style = "text-align: center">' . $madanhgia . '</td>
                   <td>' . $row->tendanhgia . '</td>
                   <td>' . $row->motadanhgia . '</td>
                   <td>' . $row->chuandaura_danhgia . '</td>
                   <td>' . $row->tile_danhgia . '</td>
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
    $pdf->Output(__DIR__ . '/CTDT.pdf', 'F');
    echo "<a href = 'CTDT.pdf'>Export PDF</a>";
}



////////////////////////////////////////////////////////////////////////////////
// Print footer
echo $OUTPUT->footer();
