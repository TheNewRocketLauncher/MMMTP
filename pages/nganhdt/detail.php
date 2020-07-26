<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nganhdt_model.php');
require_once('../../js.php');

global $COURSE, $DB;
$id = optional_param('id', 0, PARAM_INT);
$ma_nganh = $DB->get_record('eb_nganhdt', ['id' => $id])->ma_nganh;
$ma_nienkhoa = optional_param('ma_nienkhoa', '', PARAM_ALPHANUMEXT);
$page = optional_param('page', 0, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("nganhdt", "edit");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nganhdt/update_nganhdt.php', ['id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add("Quản lý ngành đào tạo", new moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php'));
$nganhdt = get_nganhdt_byID($id);
$navbar_name = 'Ngành đào tạo';
$title_heading = 'Ngành đào tạo';
$ma_nganh;
if ($nganhdt) {
    $navbar_name = $nganhdt->ten;
    $title_heading = $nganhdt->ten;
    $ma_nganh = $nganhdt->ma_nganh;
} else {
    // Something here
}
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title($title_heading);
$PAGE->set_heading($title_heading);
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

/* Danh mục CTĐT */

// Create table
$table = get_ctdt_of_nganhdt($search, $page, $ma_nienkhoa, $id);
// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end; margin-bottom: 15px; margin-top: -25px'))
    . html_writer::tag(
        'button',
        'Xóa',
        array('onclick' => 'delete_ctdt_thuoc_nganh("' . $ma_nganh . '")', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép',
        array('onclick' => 'clone_ctdt_thuoc_nganh("' . $ma_nganh . '")', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
$ten_nganh = '';
if ($DB->count_records('eb_nganhdt', ['ma_nganh' => $ma_nganh])) {
    // $khoatuyen .= 'khóa tuyển';
    $ten_nganh .= $DB->get_record('eb_nganhdt', ['ma_nganh' => $ma_nganh])->ten;
}
$lb = '';
if ($ma_nganh == '')
    $lb = '<br><p style="color:#1177d1; margin-left: 0; font-size: 1.5rem;">❖ Danh sách chương trình đào tạo</p>';
else
    $lb = '<br><p style="color:#1177d1; margin-left: 0; font-size: 1.5rem;">❖ Danh sách chương trình đào tạo ' . $ten_nganh . ' (' . $ma_nganh . ')</p>';

// Form
require_once('../../form/nganhdt/qlnganh_form.php');
$mform = new qlnganh_form();
$insert_form = new them_ctdt_vao_form();

// Form processing
if ($insert_form->is_cancelled()) {
    // Handle form cancel operation
} else if ($insert_form->no_submit_button_pressed()) {
    $insert_form->display();
} else if ($fromform = $insert_form->get_data()) {
    // Insert CTĐT vào ngành => Thêm vào bảng ctdt thuộc ngành
    // Điều kiện: ctđt tồn tại và liên kết giữa ngành <=> ctđt chưa có
    if ($DB->count_records('eb_ctdt', ['ma_ctdt' => $fromform->mactdt]) && !$DB->count_records('eb_ctdt_thuoc_nganh', ['ma_ctdt' => $fromform->mactdt, 'ma_nganh' => $ma_nganh])) {
        $DB->insert_record('eb_ctdt_thuoc_nganh', ['ma_ctdt' => $fromform->mactdt, 'ma_nganh' => $ma_nganh]);
    } else {
        echo '<i><b style = "font-size: 18px; color: red">Ngành đã có CTĐT này!</b></i>';
    }
    $insert_form->display();
} else if ($insert_form->is_submitted()) {
    // Button submit
    $insert_form->display();
} else {
    $insert_form->display();
}

// Form processing
if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/nganhdt/index.php');
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    // Param
    $param1 = new stdClass();
    $param1->id = $fromform->idnganh; // The data object must have the property "id" set.
    $param1->ma_nganh = $mform->get_data()->manganh;
    $param1->ten = $mform->get_data()->tennganh;
    $param1->mota = $mform->get_data()->mota;

    $current_data = $DB->get_record('eb_nganhdt', ['ma_nganh' => $param1->ma_nganh]);
    if ($current_data->id == $param1->id || !$current_data) {
        $isUsed = false;
        $error = '';

        // Kiểm tra điều kiện
        if ($DB->count_records('eb_nganh_thuoc_nienkhoa', array('ma_nganh' => $param1->ma_nganh))) {
            $isUsed = true;
            $error = '<i><b style = "font-size: 18px; color: red">Ngành đang được sử dụng (table eb_nganh_thuoc_nienkhoa)</b></i><br>';
        }

        // Báo lỗi nếu ngành đang được sử dụng
        if ($isUsed) {
            echo $error;
        } else { // Cập nhật ngành
            update_nganhdt($param1);
            if ($DB->count_records('eb_nganhdt', ['id' => $param1->id])) {
                // Trường hợp thêm thành công
                echo '<h2>Cập nhật thành công!</h2><br>';
            } else {
                // Trường hợp sai id
                echo '<h2>Không tìm thấy ngành đào tạo!</h2><br>';
            }
        }
    } else { // Tìm thấy đã có dữ liệu trùng lặp với param1
        echo "<strong>Dữ liệu đã tồn tại</strong><br>";
    }

    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
    $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php');
    $linktext = get_string('label_nganh', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit    
    $mform->display();
} else {
    //Set default data from DB
    global $DB;
    $toform;
    $toform->idnganh = $id;
    $toform->manganh = $nganhdt->ma_nganh;
    $toform->tennganh = $nganhdt->ten;
    $toform->mota = $nganhdt->mota;
    $mform->set_data($toform);
    // In table
    echo $lb;
    echo $action_form;
    $table = get_ctdt_of_nganhdt($search, $page, $ma_nienkhoa, $id);
    echo html_writer::table($table);
    // Displayform
    echo '<br><p style="color:#1177d1; margin-left: 0; font-size: 1.5rem;">❖ Quản lý thông tin</p>';
    $mform->display();
}

// Giữ param cho trang
echo "<script>document.getElementsByClassName('mform')[0].action = '?id=" . $id . "'</script>";
echo "<script>document.getElementsByClassName('mform')[1].action = '?id=" . $id . "'</script>";
// Footer
echo $OUTPUT->footer();

function get_ctdt_of_nganhdt($key_search = '', $page = 0, $ma_nienkhoa = '', $id_nganh)
{
    global $DB;
    $param = new stdClass();
    $param->ma_ctdt = 'test';
    $param->ma_nganh = 'DHCQ2016KTPM';
    $param->ma_nienkhoa = 'DHCQ2016';
    $param->ma_he = 'DHCQ';
    $param->ma_bac = 'DH';
    $param->muctieu_daotao = '<p>Mục tiêu của CTDT nhằm đào tạo ra các sinh viên tốt nghiệp</p>';
    $param->muctieu_cuthe = '<p>Có trách nhiệm, đạo đức nghề nghiệp\r\n<br>Có đầy đủ các kỹ năng cá nhân</p>';
    $param->chuandaura = '1';
    $param->cohoi_nghenghiep = '<p>Có các cơ hội nghề nghiệp triển vọng<br></p>';
    $param->thoigian_daotao = '4';
    $param->khoiluong_kienthuc = '137';
    $param->doituong_tuyensinh = 'Theo quy chế chung của BGQ và ĐT';
    $param->quytrinh_daotao = '<p>Căn cứ Quy chế học vụ theo Hệ thống tín chỉ trường DH. KHTN</p>';
    $param->dieukien_totnghiep = '<p>Tích lũy đủ 137 tín chỉ theo yêu cầu của nội dung chương trình</p>';
    $param->ma_cay_khoikienthuc = '2caykkt1594804099';
    $param->mota = 'Cử nhân SMT';
    if (!$DB->count_records('eb_ctdt', ['ma_ctdt' => 'test']))
        $DB->insert_record('eb_ctdt', $param);
    //2 
    $param = new stdClass();
    $param->ma_ctdt = 'test2';
    $param->ma_nganh = 'DHCQ2016KTPM2';
    $param->ma_nienkhoa = 'DHCQ2019';
    $param->ma_he = 'DHCQ';
    $param->ma_bac = 'DH';
    $param->muctieu_daotao = '<p>Mục tiêu của CTDT nhằm đào tạo ra các sinh viên tốt nghiệp</p>';
    $param->muctieu_cuthe = '<p>Có trách nhiệm, đạo đức nghề nghiệp\r\n<br>Có đầy đủ các kỹ năng cá nhân</p>';
    $param->chuandaura = '1';
    $param->cohoi_nghenghiep = '<p>Có các cơ hội nghề nghiệp triển vọng<br></p>';
    $param->thoigian_daotao = '4';
    $param->khoiluong_kienthuc = '137';
    $param->doituong_tuyensinh = 'Theo quy chế chung của BGQ và ĐT';
    $param->quytrinh_daotao = '<p>Căn cứ Quy chế học vụ theo Hệ thống tín chỉ trường DH. KHTN</p>';
    $param->dieukien_totnghiep = '<p>Tích lũy đủ 137 tín chỉ theo yêu cầu của nội dung chương trình</p>';
    $param->ma_cay_khoikienthuc = '2caykkt1594804099';
    $param->mota = 'Cử nhân SMT';
    if (!$DB->count_records('eb_ctdt', ['ma_ctdt' => 'test2']))
        $DB->insert_record('eb_ctdt', $param);

    $count = 20;
    $table = new html_table();
    $table->head = array('', 'STT', 'Tên đầy đủ', 'Thời gian đào tạo', 'Khối lượng kiến thức', 'Mục tiêu đào tạo', 'Cơ hội nghề nghiệp');

    // Lấy các CTDT thuộc ngành
    $ma_nganh = $DB->get_record('eb_nganhdt', ['id' => $id_nganh])->ma_nganh;
    $ctdt_thuoc_nganh = $DB->get_records('eb_ctdt_thuoc_nganh', ['ma_nganh' => $ma_nganh]);
    $allctdts = array();
    foreach ($ctdt_thuoc_nganh as $item) {
        $allctdts[] = $DB->get_record('eb_ctdt', ['ma_ctdt' => $item->ma_ctdt]);
    }

    // // Nếu có khóa tuyển như params truyền vào thì lấy những CTĐT thuộc khóa tuyển đó    
    // if ($ma_nienkhoa != '') {
    //     $allctdts = $DB->get_records('eb_ctdt', []);
    // }

    $stt = 1 + $page * $count;
    $pos_in_table = 1;
    foreach ($allctdts as $ictdt) {
        if (findContent($ictdt->ten, $key_search) || $key_search == '') {
            $checkbox = html_writer::tag('input', ' ', array('class' => 'ctdtcheckbox', 'type' => "checkbox", 'name' => $ictdt->id, 'id' => 'bdt' . $ictdt->id, 'value' => '0', 'onclick' => "changecheck($ictdt->id)")); // id là bdt để dùng lại changecheck của BĐT
            $url = new \moodle_url('/blocks/educationpgrs/pages/ctdt/chitiet_ctdt.php', ['id' => $ictdt->id]);
            $ten_url = \html_writer::link($url, $ictdt->mota);
            if ($page < 0) { // Get all data without page
                $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $ictdt->thoigian_daotao, (string) $ictdt->khoiluong_kienthuc, (string) $ictdt->muctieu_daotao, (string) $ictdt->cohoi_nghenghiep];
                $stt = $stt + 1;
            } else if ($pos_in_table > $page * $count && $pos_in_table <= $page * $count + $count) {
                $table->data[] = [$checkbox, (string) $stt, $ten_url, (string) $ictdt->thoigian_daotao, (string) $ictdt->khoiluong_kienthuc, (string) $ictdt->muctieu_daotao, (string) $ictdt->cohoi_nghenghiep];
                $stt = $stt + 1;
            }
            $pos_in_table = $pos_in_table + 1;
        }
    }
    return $table;
}
