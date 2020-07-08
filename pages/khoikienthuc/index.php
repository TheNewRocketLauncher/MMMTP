<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');
require_once('../../js.php');

global $USER;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
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

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_khoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php'));

// Title.
$PAGE->set_title(get_string('label_khoikienthuc', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('label_khoikienthuc', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

///-------------------------------------------------------------------------------------------------------///
//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
require_once('../../form/khoikienthuc/index_form.php');
$mform = new index_form();

// Form processing
if ($mform->is_cancelled()) {
    
} else if ($mform->no_submit_button_pressed()) {
} else if ($fromform = $mform->get_data()) {
} else if ($mform->is_submitted()) {
} else {
    $mform->set_data($toform);
    $mform->display();
}

//searching
$form_search = new kkt_seach();


if ($form_search->is_cancelled()) {
    
} else if ($form_search->no_submit_button_pressed()) {
    
} else if ($fromform = $form_search->get_data()) {
    
    $search = $form_search->get_data()->kkt_content_seach;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/khoikienthuc/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
    
} else if ($form_search->is_submitted()) {
    
    $form_search->display();
} else {
    
    $toform;
    $toform->kkt_content_seach = $search;
    $form_search->set_data($toform);
    
    $form_search->display();
}
///////////////////////////////////////////////////////



$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Xóa',
        array('id' => 'btn_delete_kkt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone BDT',
        array('id' => 'btn_clone_kkt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_kkt', 'onClick' => "window.location.href='add_kkt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';


// Print table
$table = get_kkt_table($courseid,$search, $page ); 
echo html_writer::table($table);


$baseurl = new \moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_kkt_table( $courseid, $search, -1)->data), $page, 5, $baseurl);



 // Footer
echo $OUTPUT->footer();

function vn_to_str($str)
{
   $unicode = array(
      'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
      'd' => 'đ|Đ',
      'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
      'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
      'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
      'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
      'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
   );
   foreach ($unicode as $nonUnicode => $uni) {
      $str = preg_replace("/($uni)/i", $nonUnicode, $str);
   }
   $str = str_replace(' ', '_', $str);
   return strtolower($str);
}

function findContent($str, $key)
{
   $result = false;
   $_str = vn_to_str($str);
   $_key = vn_to_str($key);
   if (strstr($_str, $_key)) {
      $result = true;
   } else {
      $result = false;
   }
   return $result;
}

function get_kkt_table($courseid, $key_search = '', $page = 0)
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('', 'STT', 'Mã khối', 'ID loại KKT', 'Tên khối', 'Mô tả');
    $allkkts = get_list_kkt();
    $stt = 1;
    foreach ($allkkts as $i) {

        if (findContent($idata->ma_decuong, $key_search) || $key_search == '') {

            if ($page < 0) { // Get all data without page

                $checkbox = html_writer::tag('input', ' ', array('class' => 'kktcheckbox', 'type' => "checkbox", 'name' => $i->id, 'id' => 'bdt' . $i->id, 'value' => '0', 'onclick' => "changecheck($i->id)"));
                if ($i->id_loai_ktt == 0 ){
                    $loaiktt = "Bắt buộc";
                }
                else{
                    $loaiktt = "Tự chọn";
                }
                $url = new \moodle_url('/blocks/educationpgrs/pages/khoikienthuc/chitiet_kkt.php', ['ma_khoi' => $i->ma_khoi]);
                $ten_url = \html_writer::link($url, $i->ma_khoi);
                $table->data[] = [$checkbox, (string) $stt, $ten_url, $loaiktt, (string) $i->ten_khoi, (string) $i->mota];
                $stt = $stt + 1;
            } else if ($pos_in_table >= $page * 5 && $pos_in_table < $page * 5 + 5) {

                $checkbox = html_writer::tag('input', ' ', array('class' => 'kktcheckbox', 'type' => "checkbox", 'name' => $i->id, 'id' => 'bdt' . $i->id, 'value' => '0', 'onclick' => "changecheck($i->id)"));
                if ($i->id_loai_ktt == 0 ){
                    $loaiktt = "Bắt buộc";
                }
                else{
                    $loaiktt = "Tự chọn";
                }
                $url = new \moodle_url('/blocks/educationpgrs/pages/khoikienthuc/chitiet_kkt.php', ['ma_khoi' => $i->ma_khoi]);
                $ten_url = \html_writer::link($url, $i->ma_khoi);
                $table->data[] = [$checkbox, (string) $stt, $ten_url, $loaiktt, (string) $i->ten_khoi, (string) $i->mota];
                $stt = $stt + 1;
            }

            $pos_in_table = $pos_in_table + 1;

        }
    }
    return $table;
}

