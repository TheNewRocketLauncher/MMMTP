<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
require_once('../../js.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/xsdasdasdem_bacdt.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_decuong', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_decuong', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('head_decuong', 'block_educationpgrs'));

// Print header
echo $OUTPUT->header();

//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
$id = optional_param('id', 0, PARAM_INT);
$ma_decuong = optional_param('ma_decuong', '', PARAM_ALPHANUMEXT);
$ma_ctdt = optional_param('ma_ctdt', '', PARAM_ALPHANUMEXT);
$mamonhoc = optional_param('mamonhoc', '', PARAM_ALPHANUMEXT);

require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');
$chitietmh = get_tainguyenmonhoc_by_mamonhoc_1($id);
$mform = new update_tainguyenmonhoc_decuongmonhoc_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    $param1 = new stdClass();    
    
    $param1->id = $fromform->id;
    $param1->mamonhoc = $fromform->mamonhoc;
    $param1->ma_decuong = $fromform->ma_decuong;

    $param1->loaitainguyen = $fromform->loaitainguyen;
    $param1->mota_tainguyen = $fromform->mota_tainguyen;
    $param1->link_tainguyen = $fromform->link_tainguyen;

    update_tainguyenmonhoc_table($param1);
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';

    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php', ['ma_ctdt'=>$ma_ctdt, 'mamonhoc'=>$mamonhoc, 'ma_decuong'=>$ma_decuong]);
    echo \html_writer::link($url, 'Trở về trang trước');
} else if ($mform->is_submitted()) {
    // Button submit
} else {
    //Set default data from DB
    $toform;
    $toform->id = $chitietmh->id;
    $toform->mamonhoc = $mamonhoc;
    $toform->ma_decuong = $ma_decuong;
    $toform->ma_ctdt = $ma_ctdt;

    $toform->loaitainguyen = $chitietmh->loaitainguyen;
    $toform->mota_tainguyen = $chitietmh->mota_tainguyen;
    $toform->link_tainguyen = $chitietmh->link_tainguyen;
    
    $mform->set_data($toform);
    $mform->display();
}

// Print footer
echo $OUTPUT->footer();


function get_tainguyenmonhoc_by_mamonhoc($mamonhoc)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Loại tài nguyên', 'Mô tả (gợi ý)', 'Link đính kèm');
   $alldatas = $DB->get_records('eb_tainguyenmonhoc', ['mamonhoc' => $mamonhoc]);
   $stt = 1;
   foreach ($alldatas as $idata) {
      $checkbox = html_writer::tag('input', ' ', array('class' => 'tainguyenmonhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'tainguyenmonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_tainguyenmonhoc($idata->id)"));
      $table->data[] = [$checkbox, (string) $stt, (string) $idata->loaitainguyen, (string) $idata->mota_tainguyen, (string) $idata->link_tainguyen];
      $stt = $stt + 1;
   }
   return $table;
}