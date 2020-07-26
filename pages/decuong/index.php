<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/decuong_model.php');
require_once('../../js.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
require_permission("decuong", "view");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/decuong/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_quanly_decuong', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/decuong/index.php'));

// Title.
$PAGE->set_title(get_string('label_quanly_decuong', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('label_decuong', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');

//searching
$form_search = new decuong_seach();


if ($form_search->is_cancelled()) {
    
} else if ($form_search->no_submit_button_pressed()) {
    
} else if ($fromform = $form_search->get_data()) {
    
    $search = $form_search->get_data()->decuong_content_seach;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/decuong/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
    
} else if ($form_search->is_submitted()) {
    
    $form_search->display();
} else {
    
    $toform;
    $toform->decuong_content_seach = $search;
    $form_search->set_data($toform);
    
    $form_search->display();
}
///////////////////////////////////////////////////////
// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Xóa',
        array('id' => 'btn_delete_decuongmonhoc', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép',
        array('id' => 'btn_clone_decuongmonhoc', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_them_decuongmonhoc', 'onClick' => "window.location.href='../monhoc/them_decuong_head.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';

// Print table
$table = get_decuong_table($search, $page);
echo html_writer::table($table);

$baseurl = new \moodle_url('/blocks/educationpgrs/pages/decuong/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_decuong_table($search, -1)->data), $page, 20, $baseurl);



// Footer
echo $OUTPUT->footer();


function get_decuong_table($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $count = 20;
   $table = new html_table();
   $table->head = array(' ','STT', 'Mã đề cương', 'Mã CTDT', 'Mã khối', 'Mã môn học', 'Mô tả');
   $alldatas = $DB->get_records('eb_decuong', []);
   $stt = 1 + $page * $count;
   foreach ($alldatas as $idata) {
      if (findContent($idata->ma_decuong, $key_search) || $key_search == '') {
      
         $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php',  ['ma_ctdt'=>$idata->ma_ctdt, 'mamonhoc'=>$idata->mamonhoc, 'ma_decuong'=>$idata->ma_decuong]);
         $ten_url = \html_writer::link($url, $idata->ma_decuong);
         $ten_khoi=get_name_khoikienthuc($idata->ma_ctdt,$idata->mamonhoc);
         
         if ($page < 0) { // Get all data without page
         
            $checkbox = html_writer::tag('input', ' ', array('class' => 'decuong_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'decuongmonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_decuongmonhoc($idata->id)"));

            $table->data[] = [$checkbox, (string) $stt, (string)$idata->ma_decuong,(string) $idata->ma_ctdt, $ten_khoi,$ten_url, (string)$idata->mota];
            $stt = $stt + 1;
         } else if ($pos_in_table >= $page * $count && $pos_in_table < $page * $count + $count) {

            $checkbox = html_writer::tag('input', ' ', array('class' => 'decuong_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'decuongmonhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_decuongmonhoc($idata->id)"));

            $table->data[] = [$checkbox, (string) $stt, $ten_url,(string) $idata->ma_ctdt, $ten_khoi,(string)$idata->mamonhoc, (string)$idata->mota];
            $stt = $stt + 1;
         }
         $pos_in_table = $pos_in_table + 1;

      }
   }
   return $table;
}