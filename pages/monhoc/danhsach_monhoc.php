<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/monhoc_model.php');
require_once('../../js.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_monhoc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php'));

// Title.
$PAGE->set_title(get_string('label_monhoc', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_monhoc', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Create table
//$table = get_monhoc_checkbox($search, $page);

//searching
require_once('../../form/decuongmonhoc/them_decuongmonhoc_form.php');
$form_search = new monhoc_seach();


if ($form_search->is_cancelled()) {
    echo '<h2>Thêm không thành công</h2>';
} else if ($form_search->no_submit_button_pressed()) {
    
} else if ($fromform = $form_search->get_data()) {
    
    $search = $form_search->get_data()->monhoc_content_seach;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
    
} else if ($form_search->is_submitted()) {
    
    $form_search->display();
} else {
    
    $toform;
    $toform->monhoc_content_seach = $search;
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
        array('id' => 'btn_delete_monhoc', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép',
        array('id' => 'btn_clone_monhoc', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_monhoc', 'onClick' => "window.location.href='them_monhoc.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';


// // Print table
$table = get_monhoc_table($search, $page);
echo html_writer::table($table);



$baseurl = new \moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_monhoc_table($search, -1)->data), $page, 20, $baseurl);


// Footer
echo $OUTPUT->footer();


function get_monhoc_table($key_search = '', $page = 0)
{
   
   global $DB, $USER, $CFG, $COURSE;
   $count = 20;
   $table = new html_table();
   $table->head = array(' ', 'STT', 'Mã môn học', 'Tên môn hoc', 'Trạng thái' ,'Số tín chỉ','Loại học phần');
   $alldatas = $DB->get_records('eb_monhoc', []);
   $stt = 1 + $page * $count;
   foreach ($alldatas as $idata) {
      if (findContent($idata->tenmonhoc_vi, $key_search) || $key_search == '') {
            
         // url
         $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $idata->id]);
         $ten_url = \html_writer::link($url, $idata->tenmonhoc_vi);

        if($idata->loaihocphan==0)
        {
           $ten_loaihocphan="Bắt buộc";
        }
        else {
           $ten_loaihocphan="Tự chọn";
        }

         if ($page < 0) { // Get all data without page
			$lopmo;
      
		      if ($imonhoc->lopmo == 1){
		         $lopmo= "Đã mở" ; 
		      }
		      else{
		         $lopmo= "Chưa mở";
		      }
            // checkbox
            $checkbox = html_writer::tag('input', ' ', array('class' => 'monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_monhoc($idata->id)"));

            // add table
            $table->data[] = [$checkbox, (string) $stt, (string) $idata->mamonhoc, $ten_url, $lopmo, (string) $idata->sotinchi,$ten_loaihocphan];
            $stt = $stt + 1;
         } else if ($pos_in_table >= $page * $count && $pos_in_table < $page * $count + $count) {
			$lopmo;
      
		      if ($imonhoc->lopmo == 1){
		         $lopmo= "Đã mở" ; 
		      }
		      else{
		         $lopmo= "Chưa mở";
		      }
            // checkbox
            $checkbox = html_writer::tag('input', ' ', array('class' => 'monhoc_checkbox', 'type' => "checkbox", 'name' => $idata->id, 'id' => 'monhoc' . $idata->id, 'value' => '0', 'onclick' => "changecheck_monhoc($idata->id)"));

            // add table
            $table->data[] = [$checkbox, (string) $stt, (string) $idata->mamonhoc, $ten_url,$lopmo, (string) $idata->sotinchi,$ten_loaihocphan];
            $stt = $stt + 1;
         }
         $pos_in_table = $pos_in_table + 1;
      }
   }
   return $table;
}