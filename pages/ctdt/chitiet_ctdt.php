<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/ctdt_model.php');
require_once('../../model/khoikienthuc_model.php');

require_once("$CFG->libdir/tcpdf/tcpdf.php");
require_once('../../vendor/autoload.php');


///-------------------------------------------------------------------------------------------------------///
global $COURSE, $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$id = optional_param('id', '0' , PARAM_ALPHANUMEXT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/ctdt/newctdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/ctdt/index.php'));
$isExist = false;
if ($DB->count_records('eb_ctdt', ['id' => $id])) {
    $isExist = true;
}
if ($isExist) {
    $PAGE->navbar->add($DB->get_record('eb_ctdt', ['id' => $id])->mota, new moodle_url('/blocks/educationpgrs/pages/ctdt/chitiet_ctdt.php', ['id' => $id]));
}

// Title.
$PAGE->set_title(get_string('chitietctdt_lbl', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('chitietctdt_lbl', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

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

        exportmdf($mform->get_value());
        $mform->display();
    }
} else if ($fromform = $mform->get_data()) {
    // echo json_encode($fromform);
    if(can_edit_ctdt($id)){
        if (validateData()) {
            $param = new stdClass();
            $ma_ctdt = $fromform->mabac .
                $fromform->mahe .
                $fromform->manienkhoa .
                $fromform->manganh .
                $fromform->machuyennganh;
            $param->ma_ctdt = $ma_ctdt;
            $param->ma_chuyennganh = $fromform->machuyennganh;
            $param->ma_nganh = $fromform->manganh;
            $param->ma_nienkhoa = $fromform->manienkhoa;
            $param->ma_he = $fromform->mahe;
            $param->ma_bac = $fromform->mabac;
    
    
            $param->muctieu_daotao = $fromform->editor_muctieudt_chung['text'];
            $param->muctieu_cuthe = $fromform->editor_muctieudt_cuthe['text'];
            $param->chuandaura = $fromform->select_cdr;
            $param->cohoi_nghenghiep = $fromform->editor_muctieudt_chnn['text'];
    
    
            $param->thoigian_daotao = $fromform->txt_tgdt;
            $param->khoiluong_kienthuc = $fromform->txt_klkt;
            $param->doituong_tuyensinh = $fromform->txt_dtts;
    
            $param->quytrinh_daotao = $fromform->editor_qtdt['text'];
            $param->dieukien_totnghiep = $fromform->editor_qtdt['text'];
    
            $param->ma_cay_khoikienthuc = $fromform->select_caykkt;
            $param->mota = $fromform->txt_tct;
    
            insert_ctdt($param);
            echo '<h2>Cập nhật thành công!</h2>';
            echo '<br>';
            $url = new \moodle_url('/blocks/educationpgrs/pages/ctdt/index.php', ['courseid' => $courseid]);
            $linktext = get_string('label_ctdt', 'block_educationpgrs');
            echo \html_writer::link($url, $linktext);
        }
    } else{
        echo '<h2>Không thể chỉnh sửa chương trình đào tạo này!</h2>';
        echo '<br>';
        $url = new \moodle_url('/blocks/educationpgrs/pages/ctdt/index.php', ['courseid' => $courseid]);
        $linktext = get_string('label_ctdt', 'block_educationpgrs');
        echo \html_writer::link($url, $linktext);
    }
} else {
    
    $data = get_ctdt_byID($id);

    $info_ctdt = get_info_ctdtByID($id);

    $formdata = new stdClass();
    $formdata->txt_tct = $data->mota;
    $formdata->mabac = $data->ma_bac;
    $formdata->bacdt = $info_ctdt->ma_bac;

    $formdata->mahe = $data->ma_he;
    $formdata->hedt = $info_ctdt->ma_he;
    
    $formdata->manienkhoa = $data->ma_nienkhoa;
    $formdata->nienkhoa = $info_ctdt->ma_nienkhoa;

    $formdata->manganh = $data->ma_nganh;
    $formdata->nganhdt = $info_ctdt->ma_nganh;

    $formdata->machuyennganh = $data->ma_nganh;
    $formdata->chuyenganhdt = $info_ctdt->ma_nganh;

    $formdata->editor_muctieudt_chung['text'] = $data->muctieu_daotao;
    $formdata->editor_muctieudt_cuthe['text'] = $data->muctieu_cuthe;
    $formdata->select_cdr = $data->chuandaura; // 1
    $formdata->editor_muctieudt_chnn['text'] = $data->cohoi_nghenghiep;
    $formdata->txt_tgdt = $data->thoigian_daotao;
    $formdata->txt_klkt = $data->khoiluong_kienthuc;
    $formdata->txt_dtts = $data->doituong_tuyensinh;
    $formdata->editor_qtdt['text'] = $data->quytrinh_daotao;
    $formdata->editor_dktn['text'] = $data->dieukien_totnghiep;
    $formdata->select_caykkt = $data->ma_cay_khoikienthuc;
    $formdata->btn_complete = 'Cập nhật';

    $mform->set_data($formdata);
    $mform->display();
}

function validateData()
{
    return true;
}

// Export
if($isExist) {
    exportmdf($formdata);
}
else {
    echo 'Chương trình đào tạo không tìm thấy';
}

// PDF
// Export file
////////////////////////////////////////////////////////////////////////////////

function exportmdf($formdata)
{
    global $DB;
    $pdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch']);    

    /* Name */
    $formdata->tenbac = $DB->get_record('eb_bacdt', ['ma_bac' => $formdata->mabac])->ten;
    $formdata->tennganh = $DB->get_record('eb_nganhdt', ['ma_nganh' => $formdata->manganh])->ten;
    $formdata->tenhe = $DB->get_record('eb_hedt', ['ma_he' => $formdata->mahe])->ten;
    $formdata->tennienkhoa = $DB->get_record('eb_nienkhoa', ['ma_nienkhoa' => $formdata->manienkhoa])->ten_nienkhoa;
    $formdata->tenchuyennganh = $DB->get_record('eb_chuyennganhdt', ['ma_chuyennganh' => $formdata->machuyennganh])->ten;

    // Data for setting page
    $dataTitle;
    $dataTitle->chuyennganh = $formdata->tennganh;
    $dataTitle->bac =$formdata->tenbac;
    $dataTitle->he = $formdata->tenhe;
    $dataTitle->nienkhoa = $formdata->tennienkhoa;

    // Set Header
    $header = array(
        'odd' => array(
            'L' => array(
                'content' => '',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'serif',
                'color' => '#000000'
            ),
            'C' => array(
                'content' => '',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'serif',
                'color' => '#000000'
            ),
            'R' => array(
                'content' => 'Đại học khoa học tự nhiên',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'serif',
                'color' => '#000000'
            ),
            'line' => 1,
        ),
        'even' => array()
    );
    // $pdf->setHeader($header);

    // Set Footer
    $footer = array(
        'odd' => array(
            'C' => array(
                'content' => 'Chương trình đào tạo ' . $dataTitle->bac . ' ' . $dataTitle->he . ' - Ngành ' . $dataTitle->chuyennganh . ' - ' . $dataTitle->nienkhoa . ' - trang ' . '{PAGENO} / {nbpg}',
                'font-size' => 9,
                'font-style' => 'I',
                'font-family' => 'myTimes',
                'color' => '#000000'
            ),
            'line' => 1,
        ),
        'even' => array()
    );
    $pdf->setFooter($footer);

    // Custom Header & Footer
    $pdf->SetHTMLHeader('<img src="../mpdf/header.png"/>');

    // Header Table HTML
    $headerHTML = '<table>
    <tr>
    <th width = "50%" style = "display: flex; align-items: center;"><p style = "font-family: myTimes; font-style: normal;">ĐẠI HỌC QUỐC GIA TP.HCM</p></th>
    <th width = "50%" style = "display: flex; align-items: center;">ĐẠI HỌC QUỐC GIA TP.HCM</th>
    </tr></table>';
    // $pdf->SetHTMLHeader($headerHTML);

    // CSS
    $stylesheet = file_get_contents('../mpdf/style.css');
    $pdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

    // Body
    $pdf->AddPage();    

    /* Title */
    $pdf->Ln(15);
    $title = '<div style = "font-family: myTimes; text-align: center; line-height: 15px;"><b style = "font-size: 26.5px;">CHƯƠNG TRÌNH ĐÀO TẠO</b><h3 style = "font-size: 20px; text-transform: uppercase">NGÀNH ' . $formdata->tenchuyennganh . '</h3></div>';
    $pdf->writeHTML($title);   

    /* Introduce */
    $pdf->Ln(8);
    $pdf->SetFont('myTimes', '', 12);
    $pdf->WriteCell(45, 5, 'Tên chương trình');
    $pdf->WriteCell(35, 5,  ':  ' . $formdata->txt_tct);
    $pdf->Ln(8);
    $pdf->WriteCell(45, 5, 'Trình độ đào tạo');
    $pdf->WriteCell(35, 5, ':  ' . $formdata->tenbac);
    $pdf->Ln(8);
    $pdf->WriteCell(45, 5, 'Ngành đào tạo');
    $pdf->WriteCell(35, 5, ':  ' . $formdata->tennganh);
    $pdf->Ln(8);
    $pdf->WriteCell(45, 5, 'Mã ngành');
    $pdf->WriteCell(35, 5, ':  ' . $formdata->manganh);
    $pdf->Ln(8);
    $pdf->WriteCell(45, 5, 'Loại hình đào tạo');
    $pdf->WriteCell(35, 5, ':  ' . $formdata->tenhe);
    $pdf->Ln(8);
    $pdf->WriteCell(45, 5, 'Khóa tuyển');
    $pdf->WriteCell(35, 5, ':  ' . $formdata->tennienkhoa);
    $pdf->Ln(15);

    /* 1. MỤC TIÊU ĐÀO TẠO*/

    // data for test
    $testdata =
        '<p>Hậu phương, không cảm ứng được có người đuổi theo.<br>Bởi vậy, nói ra nơi đây, Trương Nhược Trần dừng bước lại, đem Hải Thủy bỏ trên đất.<br>Hải Thủy ngọc nhan tuyệt sắc, mà còn toàn không có bất kỳ biểu lộ gì kia, rốt cục có ba động, chắp tay
    trước ngực, áy náy nói: "Thật xin lỗi, Nhược Trần sư huynh. Kỳ thật, Hải Thủy đã sớm biết được, ngươi là Bất Động Minh Vương Đại Tôn hậu nhân. Nhưng thật sự là là Ấn Tuyết Thiên cảm thấy bất công, đem oán khí vung đến trên người của ngươi, mới có
    thể nói ra những lời kia. Hải Thủy phật tâm không rõ, lục căn không tịnh, không phải chân chính phật. Hải Thủy phật tâm không rõ, lục căn không tịnh, không phải chân chính phật</p>';

    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">1.&nbsp;&nbsp;<u>MỤC TIÊU ĐÀO TẠO</u><b/>');
    $pdf->Ln(4);
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">1.1&nbsp;&nbsp;MỤC TIÊU CHUNG<b/>');
    $html = '<div style = "font-family: myTimes; margin-left: 30px;">' . $formdata->editor_muctieudt_chung['text'] . '</div>';
    $pdf->writeHTML($html);
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">1.2&nbsp;&nbsp;MỤC TIÊU CỤ THỂ - CHUẨN ĐẦU RA CỦA CHƯƠNG TRÌNH ĐÀO TẠO<b/>');
    $pdf->Ln(4);
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">1.2.1&nbsp;&nbsp;Mục tiêu cụ thể<b/>');
    $html = '<div style = "font-family: myTimes; margin-left: 30px;">' . $formdata->editor_muctieudt_cuthe['text'] . '</div>';
    $pdf->writeHTML($html);
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">1.2.2&nbsp;&nbsp;Chuẩn đầu ra của chương trình giáo dục<b/>');
    // CDR1
    // $html = '<div style = "font-family: myTimes; margin-left: 30px;">'. $formdata->editor_muctieudt_chung['text'] .'</div>';
    // $pdf->writeHTML($html);
    // CDR2
    $pdf->Ln(2);
    // Hàm kiểm tra trong chuỗi hastack có đưuọc bắt đầu bằng chuỗi needle không
    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    $data_record = $DB->get_records('eb_chuandaura_ctdt', ['level_cdr' => 2]);
    foreach ($data_record as $item) {
        if (startsWith($item->ma_cdr, $formdata->select_cdr)) {
            // $topCdr = $DB->get_record('eb_chuandaura_ctdt', ['ma_cdr' => $item]);
            $topCdr = $item;
            $content = '<b style = "font-family: mysegoe;">❖ &nbsp;&nbsp;&nbsp;</b><b>' . $topCdr->mota . '</b>';
            // Đọc CDR con (f1)
            $content .= '<div style = "font-family: myTimes; margin-left: 30px; line-height: 20px;">';
            $cdr_f1 = $DB->get_records('eb_chuandaura_ctdt', ['level_cdr' => 3]);
            foreach ($cdr_f1 as $f1_item) {
                if (startsWith($f1_item->ma_cdr, $topCdr->ma_cdr)) {
                    $content .= '– &nbsp;&nbsp;' . $f1_item->mota;
                    // Đọc CDR chi tiết (f2)
                    $content .= '<div style = "font-family: myTimes; margin-left: 30px; line-height: 20px;">';
                    $cdr_f2 = $DB->get_records('eb_chuandaura_ctdt', ['level_cdr' => 4]);
                    foreach ($cdr_f2 as $f2_item) {
                        if (startsWith($f2_item->ma_cdr, $f1_item->ma_cdr)) {
                            $content .= '• &nbsp;&nbsp;' . $f2_item->mota . '<br>';
                        }
                    }
                    $content .= '</div>';
                }
            }
            $content .= '</div>';

            // End
            $html = '<div style = "font-family: myTimes; font-size: 16px;  margin-left: 30px;">' . $content . '</div>';
            $pdf->writeHTML($html);
        }
    }

    $table_content = '<table>
        <tr>
        <th width = "5%" style = "display: flex; align-items: center;"></th>
        <th width = "95%" style = "display: flex; align-items: center;">' . $html . '</th>
        </tr></table>';
    // $pdf->writeHTML($table_content, true, false, true, false, '');



    $pdf->Ln(3);
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">1.3&nbsp;&nbsp;CƠ HỘI NGHỀ NGHIỆP<b/>');
    $html = '<div style = "font-family: myTimes; margin-left: 30px;">' . $formdata->editor_muctieudt_chnn['text'] . '</div>';
    $pdf->writeHTML($html);

    /* 2. THỜI GIAN ĐÀO TẠO*/
    $thoigian = $formdata->txt_tgdt;
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">2.&nbsp;&nbsp;<u>THỜI GIAN ĐÀO TẠO</u>: ' . $thoigian . ' năm<b/>');
    $pdf->Ln(4);

    /* 3. KHỐI LƯỢNG KIẾN THỨC TOÀN KHÓA*/
    $tinchi = $formdata->txt_klkt;
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">3.&nbsp;&nbsp;<u>KHỐI LƯỢNG KIẾN THỨC TOÀN KHÓA</u>: ' . $tinchi . ' tín chỉ<b/>');
    $pdf->Ln(4);

    /* 4. ĐỐI TƯỢNG TUYỂN SINH*/
    // $text = '<p>Theo quy chế tuyển sinh đại học, cao đẳng hệ chính quy của Bộ Giáo dục và Đào tạo</p>';
    $text = '<p>' . $formdata->txt_dtts . '</p>';
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">4.&nbsp;&nbsp;<u>ĐỐI TƯỢNG TUYỂN SINH</u>');
    $html = '<div style = "font-family: myTimes; margin-left: 30px;">' . $text . '</div>';
    $pdf->writeHTML($html);

    /* 5. MỤC TIÊU ĐÀO TẠO*/
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">5.&nbsp;&nbsp;<u>QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP</u><b/>');
    $pdf->Ln(4);
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">5.1&nbsp;&nbsp;QUY TRÌNH ĐÀO TẠO<b/>');
    $html = '<div style = "font-family: myTimes; margin-left: 30px;">' . $formdata->editor_qtdt['text'] . '</div>';
    $pdf->writeHTML($html);
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">5.2&nbsp;&nbsp;ĐIỀU KIỆN TỐT NGHIỆP<b/>');
    $html = '<div style = "font-family: myTimes; margin-left: 30px;">' . $formdata->editor_dktn['text'] . '</div>';
    $pdf->writeHTML($html);

    /* 6. CẤU TRÚC CHƯƠNG TRÌNH*/
    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">6.&nbsp;&nbsp;<u>ĐỐI TƯỢNG TUYỂN SINH</u>');
    $pdf->Ln(4);
    function chitiet_tc_khoi($makhoi)
    {
        $result = get_tong_TC_BB($makhoi);
        return $result;
    }

    function fetch_data_cautruc($ma_cay_khoikienthuc)
    {
        function addStdClass($s1, $s2)
        {
            $result = $s1;
            $result->tc += $s2->tc;
            $result->bb += $s2->bb;
            $result->td += $s2->td;
            $result->all += $s2->all;
            return $result;
        }
        global $DB;
        $p1 = new stdClass();
        $p21 = new stdClass();
        $p22 = new stdClass();
        $p23 = new stdClass();
        // Khối kiến thức gốc
        $root = $DB->get_record('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => NULL]);
        // Khối F1
        $f1 = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => $root->ma_khoi]);
        $f1length = $DB->count_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => $root->ma_khoi]);
        $stt_f1 = 1;
        foreach ($f1 as $item) {
            if ($stt_f1 == 1) $p1 = chitiet_tc_khoi($item->ma_khoi);
            // In ra các khối con
            $f2 = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => $item->ma_khoi]);
            $stt_f2 = 1;
            foreach ($f2 as $item_child) {
                if ($stt_f1 == 1) {
                    $p1 = addStdClass($p1, chitiet_tc_khoi($item_child->ma_khoi));
                    $f3 = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => $item_child->ma_khoi]);
                    foreach ($f3 as $item_leaf) {
                        $p1 = addStdClass($p1, chitiet_tc_khoi($item_leaf->ma_khoi));
                    }
                }
                if ($stt_f1 == 2) {
                    $f3 = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => $item_child->ma_khoi]);
                    if ($stt_f2 == 1) {
                        $p21 = chitiet_tc_khoi($item_child->ma_khoi);
                        foreach ($f3 as $item_leaf) {
                            $p21 = addStdClass($p21, chitiet_tc_khoi($item_leaf->ma_khoi));
                        }
                    }
                    if ($stt_f2 == 2) {
                        $p22 = chitiet_tc_khoi($item_child->ma_khoi);
                        foreach ($f3 as $item_leaf) {
                            $p22 = addStdClass($p22, chitiet_tc_khoi($item_leaf->ma_khoi));
                        }
                    }
                    if ($stt_f2 == 3) {
                        $p23 = chitiet_tc_khoi($item_child->ma_khoi);
                        foreach ($f3 as $item_leaf) {
                            $p23 = addStdClass($p23, chitiet_tc_khoi($item_leaf->ma_khoi));
                        }
                    }
                }
                $stt_f2++;
            }
            $stt_f1++;
        }
        $output = '';
        // Lấy ra danh sách mã môn thuộc khối
        $data_record = $DB->get_records('eb_monthuockhoi', array('ma_khoi' => $makhoi), '', 'mamonhoc');
        $tongtc = $p1->all + $p21->all + $p22->all + $p23->all;
        // Dòng 1
        $output .= '
                <tr style = "width: 100%; font-family: myTimes; color:#fff">
                  <td style = "text-align: center">1</td>
                  <td colspan="2" style = "text-align: center"><b>Giáo dục đại cương (1)</b><br>(không kể Ngoại ngữ, GDTC, ..)</td>
                  <td style = "width:66px; text-align: center">' . $p1->bb . '</td>
                  <td style = "width:65px; text-align: center">' . $p1->tc . '</td>
                  <td style = "width:65px; text-align: center">' . $p1->td . '</td>
                  <td style = "width:66px; text-align: center">' . $p1->all . '</td>
                  <td rowspan="4" style = "text-align: center">' . $tongtc . '</td>
                  <td>' . $p1->ghichu . '</td>
                </tr>
                ';
        // Dòng 2
        $output .= '
               <tr style = "width: 100%; font-family: myTimes; color:#fff">
                   <td rowspan="3" style = "text-align: center">2</td>
                   <td rowspan="3" style = "text-align: center"><b>Giáo dục chuyên nghiệp:</td>
                   <td style = "text-align: center">Cơ sở ngành (2)</td>
                   <td style = "width:66px; text-align: center">' . $p21->bb . '</td>
                   <td style = "width:65px; text-align: center">' . $p21->tc . '</td>
                   <td style = "width:65px; text-align: center">' . $p21->td . '</td>
                   <td style = "width:66px; text-align: center">' . $p21->all . '</td>
                   <td>' . $p21->ghichu . '</td>
                   </tr>
                ';
        // Dòng 3
        $output .= '
               <tr style = "width: 100%; font-family: myTimes; color:#fff">
                   <td style = "text-align: center"><b>Ngành/ chuyên ngành (3)</b></td>
                   <td style = "width:66px; text-align: center">' . $p22->bb . '</td>
                   <td style = "width:65px; text-align: center">' . $p22->tc . '</td>
                   <td style = "width:65px; text-align: center">' . $p22->td . '</td>
                   <td style = "width:66px; text-align: center">' . $p22->all . '</td>
                   <td>' . $p22->ghichu . '</td>
                   </tr>
                ';
        // Dòng 4
        $output .= '
               <tr style = "width: 100%; font-family: myTimes; color:#fff">
                   <td style = "text-align: center">Tốt nghiệp (4)</td>
                   <td style = "width:66px; text-align: center">' . $p23->bb . '</td>
                   <td style = "width:65px; text-align: center">' . $p23->tc . '</td>
                   <td style = "width:65px; text-align: center">' . $p23->td . '</td>
                   <td style = "width:66px; text-align: center">' . $p23->all . '</td>
                   <td>' . $p23->ghichu . '</td>
                   </tr>
                ';

        return $output;
    }

    $table_head = '<table border = "1" cellspacing = "0" cellpadding ="5" style="width: 100%; font-family: myTimes !important; ">
    <tr style = "width: 100% !important;font-weight:200px !important; font-family: Arial !important; color:#fff; text-align:right">

        <th style = "font-family: Arial !important;margin:0; padding:4px; display: flex; align-items: center;"><b>STT</b></th>
        <th colspan="2" style = "margin:0; padding:4px; display: flex; align-items: center;">KHỐI KIẾN THỨC</b></th>
        <th colspan="4" style = "padding:0px; margin:0; display: flex; align-items: center; ">

            <table style = "width:100%; height:100%; border-style: none">
                <tr style = "border:0px;"><th style = "border:0px;">SỐ TÍN CHỈ</th></tr>
            </table>

            <table border = "1" style = "width:100%; border-style: none">
                <tr style = "padding: 0 auto !important; border-left:0px; border-right:0px; border-bottom:0px;">
                    <td style = "width:65px; border-bottom:0px;border-left:0px;"><b>Bắt <br> buộc</b></td>
                    <td style = "width:68px; border-bottom:0px;border-left:0px;"><b>Tự <br> chọn</b></td>
                    <td style = "width:68px; border-bottom:0px;border-left:0px;"><b>Tự <br> chọn <br> tự do</b></td>
                    <td style = "width:68px; border-bottom:0px;border-left:0px;"><b>Tổng <br> cộng</b></td>
                </tr>
            </table>
            
        </th>
        <th style = "margin:0; padding:4px;display: flex; align-items: center; width : 198px"><b>Tổng số <br> TC tích <br> lũy tốt <br> nghiệp</b></th>
        <th style = "margin:0; padding:4px;display: flex; align-items: center; "><b>GHI CHÚ</b></th>
    </tr>';
    $html = '<div style = "font-family: myTimes;">' . $table_head . fetch_data_cautruc($formdata->select_caykkt) . '</table>' . '</div><br>';
    $pdf->writeHTML($html);

    /* 7. NỘI DUNG CHƯƠNG TRÌNH*/
    function fetch_mon_thuockhoi($makhoi)
    {
        global $DB;
        $output = '';
        $tongtc = 0;
        // Lấy ra danh sách mã môn thuộc khối
        $data_record = $DB->get_records('eb_monthuockhoi', array('ma_khoi' => $makhoi), '', 'mamonhoc');
        // Lấy ra danh sách môn từ mã môn       
        $stt = 1;
        foreach ($data_record as $row) {
            $monhoc = $DB->get_record('eb_monhoc', array('mamonhoc' => $row->mamonhoc));
            $tongtc += $monhoc->sotinchi;
            $output .= '
               <tr style = "width: 100%; font-family: myTimes; color:#fff">
                   <td style = "text-align: center">' . $stt++ . '</td>
                   <td style = "text-align: center">' . $monhoc->mamonhoc . '</td>
                   <td >' . '<p style = "font-family: Arial !important; ">' . $monhoc->tenmonhoc_vi . '</p>' . '</td>
                   <td style = "text-align: center">' . $monhoc->sotinchi . '</td>                   
                   <td style = "width:66px; text-align: center;">' . $monhoc->sotietlythuyet . '</td>
                   <td style = "width:66px; text-align: center;">' . $monhoc->sotietthuchanh . '</td>
                   <td style = "width:66px; text-align: center;">' . $monhoc->sotiet_baitap . '</td>
                   <td style = "text-align: center">' . $monhoc->loaihocphan . '</td>
                   <td>' . $monhoc->ghichu . '</td>
                </tr>
                ';
        }
        // Lấy ra danh sách khối con thuộc khối: (getlistkhoiconbymakhoi)
        $khoi_goc = $DB->get_record('eb_cay_khoikienthuc', array('ma_khoi' => $makhoi, 'ma_tt' => 0));
        $khoi_con = $DB->get_records('eb_cay_khoikienthuc', array('ma_khoicha' => $makhoi, 'ma_cay_khoikienthuc' => $khoi_goc->ma_cay_khoikienthuc));
        foreach ($khoi_con as $khoi) {
            $output .= '
               <tr style = "width: 100%; font-family: myTimes; color:#fff">
                   <td>' . $stt++ . '</td>
                   <td colspan="8" style = "text-align: center">' . 'Chọn 6 tín chỉ từ các học phần sau' . '</td>
                </tr>
                ';
            //  Môn thuộc khối con
            $ds_mon = $DB->get_records('eb_monthuockhoi', array('ma_khoi' => $khoi->ma_khoi), '', 'mamonhoc');
            $sl = $DB->count_records('eb_monthuockhoi', array('ma_khoi' => $khoi->ma_khoi), '', 'mamonhoc');
            // $sl = 3;
            // Lấy ra danh sách môn từ mã môn
            $tmp = 0;
            foreach ($ds_mon as $row) {
                $monhoc = $DB->get_record('eb_monhoc', array('mamonhoc' => $row->mamonhoc));
                $tongtc += $monhoc->sotinchi;
                if ($tmp == 0) {
                    $output .= '
                   <tr style = "width: 100%; font-family: myTimes; color:#fff">
                       <td rowspan = "' . $sl . '">' . ' ' . '</td>
                       <td style = "text-align: center">' . $monhoc->mamonhoc . '</td>
                       <td >' . '<p style = "font-family: Arial !important; ">' . $monhoc->tenmonhoc_vi . '</p>' . '</td>
                       <td style = "text-align: center">' . $monhoc->sotinchi . '</td>                   
                       <td style = "width:66px; text-align: center;">' . $monhoc->sotietlythuyet . '</td>
                       <td style = "width:66px; text-align: center;">' . $monhoc->sotietthuchanh . '</td>
                       <td style = "width:66px; text-align: center;">' . $monhoc->sotiet_baitap . '</td>
                       <td style = "text-align: center">' . $monhoc->loaihocphan . '</td>
                       <td>' . $monhoc->ghichu . '</td>
                    </tr>
                    ';
                    $tmp++;
                } else {
                    $output .= '
                   <tr style = "width: 100%; font-family: myTimes; color:#fff">
                       <td style = "text-align: center">' . $monhoc->mamonhoc . '</td>
                       <td >' . '<p style = "font-family: Arial !important; ">' . $monhoc->tenmonhoc_vi . '</p>' . '</td>
                       <td style = "text-align: center">' . $monhoc->sotinchi . '</td>                   
                       <td style = "width:66px; text-align: center;">' . $monhoc->sotietlythuyet . '</td>
                       <td style = "width:66px; text-align: center;">' . $monhoc->sotietthuchanh . '</td>
                       <td style = "width:66px; text-align: center;">' . $monhoc->sotiet_baitap . '</td>
                       <td style = "text-align: center">' . $monhoc->loaihocphan . '</td>
                       <td>' . $monhoc->ghichu . '</td>
                    </tr>
                    ';
                }
            }
        }
        // $output .= '
        //        <tr style = "width: 100%; font-family: myTimes; color:#fff">
        //            <td>' . $stt++ . '</td>
        //            <td colspan="8" style = "text-align: center">' . 'Chọn 6 tín chỉ từ các học phần sau' . '</td>
        //         </tr>
        //         ';
        $output .= '
               <tr style = "width: 100%; font-family: myTimes; color:#fff">
                   <td colspan = "3" style = "text-align: center"><b>TỔNG CỘNG</b></td>
                   <td style = "text-align: center"><b>' . $tongtc . '</b></td>                   
                   <td style = "width:66px;">' . '' . '</td>
                   <td style = "width:66px;">' . '' . '</td>
                   <td style = "width:66px;">' . '' . '</td>
                   <td>' . '' . '</td>
                   <td>' . '' . '</td>
                </tr>
                ';
        return $output;
    }

    function check_condition($makhoi)
    {
        global $DB;
        // Lấy ra danh sách mã môn thuộc khối
        $count_mon = $DB->count_records('eb_monthuockhoi', array('ma_khoi' => $makhoi), '', 'mamonhoc');
        // Lấy ra danh sách khối cpn thuộc khối
        $khoi_goc = $DB->get_record('eb_cay_khoikienthuc', array('ma_khoi' => $makhoi, 'ma_tt' => 0));
        $count_khoi = $DB->count_records('eb_cay_khoikienthuc', array('ma_khoicha' => $makhoi, 'ma_cay_khoikienthuc' => $khoi_goc->ma_cay_khoikienthuc));
        if ($count_mon || $count_khoi) {
            return true;
        }
        return false;
    }

    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">7.&nbsp;&nbsp;<u>NỘI DUNG CHƯƠNG TRÌNH</u><b/>');
    $pdf->Ln(4);

    // Mã cây khối kiến thức
    $ma_cay_khoikienthuc =  $formdata->select_caykkt;
    // Khối kiến thức gốc
    $root = $DB->get_record('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => NULL]);
    // Khối F1
    $f1 = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => $root->ma_khoi]);
    $stt_f1 = 1;
    foreach ($f1 as $item) {
        // Lấy ra khối
        $khoikienthuc = $DB->get_record('eb_khoikienthuc', ['ma_khoi' => $item->ma_khoi]);
        $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">7.' . (string) ($stt_f1++) . '&nbsp;&nbsp;' . $khoikienthuc->ten_khoi . '<b/>');
        $html = '<div style = "font-size: 16px; font-family: myTimes;">' . $khoikienthuc->mota . '</div><br>';
        $pdf->writeHTML($html);
        // Nếu khối có môn học
        $table_head = '<table border = "1" cellspacing = "0" cellpadding ="5" style="width: 100%; font-family: myTimes !important; ">
                    <tr style = "width: 100%;font-weight:200px !important; font-family: Arial !important; color:#fff; text-align:right">
                        <th style = "font-family: Arial !important;margin:0; padding:4px; display: flex; align-items: center; width : 7%"><b>STT</b></th>
                        <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 13%"><b>MÃ<br> HỌC PHẦN</b></th>
                        <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 30%"><b>TÊN HỌC PHẦN</b></th>
                        <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 6%"><b>SỐ <br> TC</b></th>
                        <th colspan="3" style = "padding:0px; margin:0; display: flex; align-items: center; width : 198px">
                            <table style = "width:100%; height:100%; border-style: none">
                                <tr style = "border:0px;"><th style = "border:0px;">Số tiết</th></tr>
                            </table>
                            <table border = "1" style = "width:100%; border-style: none">
                                <tr style = "padding: 0 auto !important; border-left:0px; border-right:0px; border-bottom:0px;">
                                    <td style = "width:65px; border-bottom:0px;border-left:0px;"><b>Lý <br> thuyết</b></td>
                                    <td style = "width:68px; border-bottom:0px;border-left:0px;"><b>Thực <br> hành</b></td>
                                    <td style = "width:65px; border-bottom:0px;border-left:0px;border-right:0px;"><b>Bài tập</b></td>
                                </tr>
                            </table>
                        </th>
                        <th style = "margin:0; padding:4px;display: flex; align-items: center; width : 10%"><b>Loại học phần</b></th>
                        <th style = "margin:0; padding:4px;display: flex; align-items: center; width : 10%"><b>Ghi chú</b></th>
                    </tr>';
        $html = '<div style = "font-family: myTimes;">' . $table_head . fetch_mon_thuockhoi($khoikienthuc->ma_khoi) . '</table>' . '</div><br>';
       // Kiểm tra điều kiện in bảng
       $khoi_goc = $DB->get_record('eb_cay_khoikienthuc', array('ma_khoi' => $makhoi, 'ma_tt' => 0));
       $khoi_con = $DB->get_records('eb_cay_khoikienthuc', array('ma_khoicha' => $makhoi, 'ma_cay_khoikienthuc' => $khoi_goc->ma_cay_khoikienthuc));

        if (check_condition($khoikienthuc->ma_khoi)) {
            $pdf->writeHTML($html);
        }
        // In ra các khối con
        $f2 = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => $item->ma_khoi]);
        $stt_f2 = 1;
        foreach ($f2 as $item2) {
            $khoikienthuc_f2 = $DB->get_record('eb_khoikienthuc', ['ma_khoi' => $item2->ma_khoi]);
            $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">7.' . (string) ($stt_f1 - 1) . '.' . (string) ($stt_f2++) . '&nbsp;&nbsp;' . $khoikienthuc_f2->ten_khoi . '<b/>');
            $html = '<div style = "font-size: 16px; font-family: myTimes;">' . $khoikienthuc_f2->mota . '</div><br>';
            $pdf->writeHTML($html);            // Nếu khối có môn học
            $table_head = '<table border = "1" cellspacing = "0" cellpadding ="5" style="width: 100%; font-family: myTimes !important; ">
                        <tr style = "width: 100%;font-weight:200px !important; font-family: Arial !important; color:#fff; text-align:right">
                            <th style = "font-family: Arial !important;margin:0; padding:4px; display: flex; align-items: center; width : 7%"><b>STT</b></th>
                            <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 13%"><b>MÃ<br> HỌC PHẦN</b></th>
                            <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 30%"><b>TÊN HỌC PHẦN</b></th>
                            <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 6%"><b>SỐ <br> TC</b></th>
                            <th colspan="3" style = "padding:0px; margin:0; display: flex; align-items: center; width : 198px">
                                <table style = "width:100%; height:100%; border-style: none">
                                    <tr style = "border:0px;"><th style = "border:0px;">Số tiết</th></tr>
                                </table>
                                <table border = "1" style = "width:100%; border-style: none">
                                    <tr style = "padding: 0 auto !important; border-left:0px; border-right:0px; border-bottom:0px;">
                                        <td style = "width:65px; border-bottom:0px;border-left:0px;"><b>Lý <br> thuyết</b></td>
                                        <td style = "width:68px; border-bottom:0px;border-left:0px;"><b>Thực <br> hành</b></td>
                                        <td style = "width:65px; border-bottom:0px;border-left:0px;border-right:0px;"><b>Bài tập</b></td>
                                    </tr>
                                </table>
                            </th>
                            <th style = "margin:0; padding:4px;display: flex; align-items: center; width : 10%"><b>Loại học phần</b></th>
                            <th style = "margin:0; padding:4px;display: flex; align-items: center; width : 10%"><b>Ghi chú</b></th>
                        </tr>';
            $html = '<div style = "font-family: myTimes;">' . $table_head . fetch_mon_thuockhoi($khoikienthuc_f2->ma_khoi) . '</table>' . '</div><br>';
            if (check_condition($khoikienthuc_f2->ma_khoi)) {
                $pdf->writeHTML($html);
            } else {
                $f3 = $DB->get_records('eb_cay_khoikienthuc', ['ma_cay_khoikienthuc' => $ma_cay_khoikienthuc, 'ma_khoicha' => $item2->ma_khoi]);
                $stt_f3 = 1;
                foreach ($f3 as $item3) {
                    $khoikienthuc_f3 = $DB->get_record('eb_khoikienthuc', ['ma_khoi' => $item3->ma_khoi]);
                    $pdf->writeHTML('<b style = "font-family: myTimes; font-size: 16px">7.' . (string) ($stt_f1 - 1) . '.' . (string) ($stt_f2 - 1) . '.' . (string) ($stt_f3++) . '&nbsp;&nbsp;' . $khoikienthuc_f3->ten_khoi . '<b/>');
                    $html = '<div style = "font-size: 16px; font-family: myTimes;">' . $khoikienthuc_f3->mota . '</div><br>';
                    $pdf->writeHTML($html);                    // Nếu khối có môn học
                    $table_head = '<table border = "1" cellspacing = "0" cellpadding ="5" style="width: 100%; font-family: myTimes !important; ">
                                <tr style = "width: 100%;font-weight:200px !important; font-family: Arial !important; color:#fff; text-align:right">
                                    <th style = "font-family: Arial !important;margin:0; padding:4px; display: flex; align-items: center; width : 7%"><b>STT</b></th>
                                    <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 13%"><b>MÃ<br> HỌC PHẦN</b></th>
                                    <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 30%"><b>TÊN HỌC PHẦN</b></th>
                                    <th style = "margin:0; padding:4px; display: flex; align-items: center; width : 6%"><b>SỐ <br> TC</b></th>
                                    <th colspan="3" style = "padding:0px; margin:0; display: flex; align-items: center; width : 198px">
                                        <table style = "width:100%; height:100%; border-style: none">
                                            <tr style = "border:0px;"><th style = "border:0px;">Số tiết</th></tr>
                                        </table>
                                        <table border = "1" style = "width:100%; border-style: none">
                                            <tr style = "padding: 0 auto !important; border-left:0px; border-right:0px; border-bottom:0px;">
                                                <td style = "width:65px; border-bottom:0px;border-left:0px;"><b>Lý <br> thuyết</b></td>
                                                <td style = "width:68px; border-bottom:0px;border-left:0px;"><b>Thực <br> hành</b></td>
                                                <td style = "width:65px; border-bottom:0px;border-left:0px;border-right:0px;"><b>Bài tập</b></td>
                                            </tr>
                                        </table>
                                    </th>
                                    <th style = "margin:0; padding:4px;display: flex; align-items: center; width : 10%"><b>Loại học phần</b></th>
                                    <th style = "margin:0; padding:4px;display: flex; align-items: center; width : 10%"><b>Ghi chú</b></th>
                                </tr>';
                    $html = '<div style = "font-family: myTimes;">' . $table_head . fetch_mon_thuockhoi($khoikienthuc_f3->ma_khoi) . '</table>' . '</div><br>';
                    if (check_condition($khoikienthuc_f3->ma_khoi)) {
                        $pdf->writeHTML($html);
                    }
                }
            }
        }
        $pdf->writeHTML('ggg');
    }

    // Output
    $pdf->Output('CTDT.pdf', \Mpdf\Output\Destination::FILE);
    echo "<a href = 'CTDT.pdf'>Export PDF</a>";
}

// Print footer
echo $OUTPUT->footer();