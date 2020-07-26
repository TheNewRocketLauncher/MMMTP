<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nienkhoa_model.php');
require_once('../../controller/validate.php');
require_once('../../js.php');

global $COURSE, $DB;
$id = optional_param('id', 0, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("nienkhoa", "edit");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nienkhoa/detail.php', ['id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_nienkhoa', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/nienkhoa'));
$nienkhoa = get_nienkhoa_byID($id);
$navbar_name = 'Khóa tuyển';
$title_heading = 'Khóa tuyển';
$ma_nienkhoa;
if ($nienkhoa) {
    $navbar_name = $nienkhoa->ten_nienkhoa;
    $title_heading = $nienkhoa->ten_nienkhoa;
    $ma_nienkhoa = $nienkhoa->ma_nienkhoa;
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
$table = get_nganhdt_of_khoatuyen($search, $page, $ma_nienkhoa);
// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end; margin-bottom: 15px; margin-top: -25px'))
    . html_writer::tag(
        'button',
        'Xóa',
        array('onClick' => 'delete_nganhdt_thuoc_khoatuyen("' . $ma_nienkhoa . '")', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép',
        array('onClick' => 'clone_nganhdt_thuoc_khoatuyen("' . $ma_nienkhoa . '")', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
$khoatuyen = '';
if ($DB->count_records('eb_nienkhoa', ['ma_nienkhoa' => $ma_nienkhoa])) {
    // $khoatuyen .= 'khóa tuyển';
    $khoatuyen .= ' - ' . $DB->get_record('eb_nienkhoa', ['ma_nienkhoa' => $ma_nienkhoa])->ten_nienkhoa;
}
$lb = '';
if ($ma_nienkhoa == '')
    $lb = '<br><p style="color:#1177d1; margin-left: 0; font-size: 1.5rem;">❖ Danh sách ngành đào tạo</p>';
else
    $lb = '<br><p style="color:#1177d1; margin-left: 0; font-size: 1.5rem;">❖ Danh sách ngành đào tạo ' . $khoatuyen . ' (' . $ma_nienkhoa . ')</p>';

// Form
require_once('../../form/nienkhoa/mo_nienkhoa_form.php');
$mform = new mo_nienkhoa_form();
$insert_form = new them_nganh_vao_nienkhoa_form();

// Form processing
if ($insert_form->is_cancelled()) {
    // Handle form cancel operation
} else if ($insert_form->no_submit_button_pressed()) {
    $insert_form->display();
} else if ($fromform = $insert_form->get_data()) {
    // Insert ngành vào khóa tuyển => Thêm vào bảng ngành thuộc khóa tuyển
    // Điều kiện: ngành tồn tại và liên kết giữa ngành <=> khóa tuyển chưa có
    if ($DB->count_records('eb_nganhdt', ['ma_nganh' => $fromform->manganh]) && !$DB->count_records('eb_nganh_thuoc_nienkhoa', ['ma_nganh' => $fromform->manganh, 'ma_nienkhoa' => $ma_nienkhoa])) {
        $DB->insert_record('eb_nganh_thuoc_nienkhoa', ['ma_nganh' => $fromform->manganh, 'ma_nienkhoa' => $ma_nienkhoa]);
    } else {
        echo '<i><b style = "font-size: 18px; color: red">Khóa tuyển đã có ngành này!</b></i>';
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
    // Handle form cancel operation
    redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/nienkhoa/index.php');
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    $param1 = new stdClass();
    $param1->id =  $fromform->idnienkhoa;
    $param1->ma_nienkhoa = $mform->get_data()->ma_nienkhoa;
    $param1->ten_nienkhoa = $mform->get_data()->ten_nienkhoa;
    $param1->mota = $mform->get_data()->mota;

    $current_data = $DB->get_record('eb_nienkhoa', ['ma_nienkhoa' => $param1->ma_nienkhoa]);
    if ($current_data->id == $param1->id || !$current_data) {
        $isUsed = false;
        $error = '';

        // Kiểm tra điều kiện
        if ($DB->count_records('eb_nganh_thuoc_nienkhoa', array('ma_nienkhoa' => $param1->ma_nienkhoa))) {
            $isUsed = true;
            $error = '<i><b style = "font-size: 18px; color: red">Khóa tuyển đang được sử dụng (table eb_nganh_thuoc_nienkhoa)</b></i><br>';
        }

        // Báo lỗi nếu ngành đang được sử dụng
        if ($isUsed) {
            echo $error;
        } else { // Cập nhật ngành
            update_nienkhoa($param1);
            if ($DB->count_records('eb_nienkhoa', ['id' => $param1->id])) {
                // Trường hợp thêm thành công
                echo '<h2>Cập nhật thành công!</h2><br>';
            } else {
                // Trường hợp sai id
                echo '<h2>Không tìm thấy khóa tuyển!</h2><br>';
            }
        }
    } else {
        echo "<strong>Dữ liệu đã tồn tại</strong><br>";
    }

    // Trang quản lý
    $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php');
    $linktext = get_string('label_nienkhoa', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit
    $mform->display();
} else {
    //Set default data from DB
    $toform;
    global $DB;
    $toform->idnienkhoa = $nienkhoa->id;
    $toform->ma_nienkhoa = $nienkhoa->ma_nienkhoa;
    $toform->ten_nienkhoa = $nienkhoa->ten_nienkhoa;
    $toform->mota = $nienkhoa->mota;
    $mform->set_data($toform);
    // In table
    echo $lb;
    echo $action_form;
    $table = get_nganhdt_of_khoatuyen($search, $page, $ma_nienkhoa);
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

function get_nganhdt_of_khoatuyen($key_search = '', $page = 0, $ma_nienkhoa = '')
{
    global $DB;
    $count = 20;
    $table = new html_table();
    $table->head = array('', 'STT', 'Mã ngành đào tạo', 'Tên ngành đào tạo', 'Mô tả');

    // Lấy các ngành thuộc khóa tuyển từ bảng eb_nganh_thuoc_nienkhoa
    $nganh_thuoc_nienkhoa = $DB->get_records('eb_nganh_thuoc_nienkhoa', ['ma_nienkhoa' => $ma_nienkhoa]);
    $allnganhdts = array();
    foreach ($nganh_thuoc_nienkhoa as $item) {
        $allnganhdts[] = $DB->get_record('eb_nganhdt', ['ma_nganh' => $item->ma_nganh]);
    }
    $stt = 1 + $page * $count;
    $pos_in_table = 1;
    foreach ($allnganhdts as $inganhdt) {
        if (findContent($inganhdt->ten, $key_search) || $key_search == '') {
            $checkbox = html_writer::tag('input', ' ', array('class' => 'nganhdtcheckbox', 'type' => "checkbox", 'name' => $inganhdt->id, 'id' => 'nganhdt' . $inganhdt->id, 'value' => '0', 'onclick' => "changecheck_nganhdt($inganhdt->id)"));
            $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/detail.php', ['id' => $inganhdt->id]);
            $ten_url = \html_writer::link($url, $inganhdt->ten);
            if ($page < 0) { // Get all data without page
                $table->data[] = [$checkbox, (string) $stt, (string)$inganhdt->ma_nganh, $ten_url, (string) $inganhdt->mota];
                $stt = $stt + 1;
            } else if ($pos_in_table > $page * $count && $pos_in_table <= $page * $count + $count) {
                $table->data[] = [$checkbox, (string) $stt, (string)$inganhdt->ma_nganh, $ten_url, (string) $inganhdt->mota];
                $stt = $stt + 1;
            }
            $pos_in_table = $pos_in_table + 1;
        }
    }
    return $table;
}
