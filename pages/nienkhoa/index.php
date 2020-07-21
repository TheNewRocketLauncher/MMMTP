<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nienkhoa_model.php');
require_once('../../js.php');

// require_once('../factory.php');
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));
// Create button with method post
global $COURSE;

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_nienkhoa', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_nienkhoa', 'block_educationpgrs') . ' - Course ID: ' );
$PAGE->set_heading(get_string('head_nienkhoa', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Create table
$table = get_nienkhoa_checkbox($search, $page);

// Search
require_once('../../form/nienkhoa/mo_nienkhoa_form.php');
$form_search = new nienkhoa_search();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->nienkhoa_search;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/nienkhoa/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->nienkhoa_search = $search;
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
        'Xóa ',
        array('id' => 'btn_delete_nienkhoa', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép ',
        array('id' => 'btn_clone_nienkhoa', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_nienkhoa', 'onClick' => "window.location.href='create.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;


echo '<br>';

// Print table
echo html_writer::table($table);
// Pagination
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_nienkhoa_checkbox($search, -1)->data), $page, 20, $baseurl);


// Footer
echo $OUTPUT->footer();


function get_nienkhoa_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $count = 20;
   $table = new html_table();
   $table->head = array('', 'STT','Bậc đào tạo','Hệ đào tạo',  'Mã niên khóa đào tạo','Tên niên khóa đào tạo', 'Mô tả');
   $allnienkhoas = $DB->get_records('eb_nienkhoa', []);
   $stt = 1 + $page * $count;
   $pos_in_table = 1;
   foreach ($allnienkhoas as $inienkhoa) {
      if (findContent($inienkhoa->ten_nienkhoa, $key_search) || $key_search == '') {

      $checkbox = html_writer::tag('input', ' ', array('class' => 'nienkhoacheckbox', 'type' => "checkbox", 'name' => $inienkhoa->id, 'id' => 'bdt' . $inienkhoa->id, 'value' => '0', 'onclick' => "changecheck($inienkhoa->id)"));
      $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/update.php', ['id' => $inienkhoa->id]);
      $ten_url = \html_writer::link($url, $inienkhoa->ten_nienkhoa);


      if ($page < 0) { // Get all data without page
         $table->data[] = [$checkbox, (string) $stt,(string)$inienkhoa->ma_bac,(string)$inienkhoa->ma_he,(string)$inienkhoa->ma_nienkhoa,$ten_url, (string) $inienkhoa->mota];
         $stt = $stt + 1;
      } else if ($pos_in_table > $page * $count && $pos_in_table <= $page * $count + $count) {
         $table->data[] = [$checkbox, (string) $stt,(string)$inienkhoa->ma_bac,(string)$inienkhoa->ma_he,(string)$inienkhoa->ma_nienkhoa,$ten_url, (string) $inienkhoa->mota];
         $stt = $stt + 1;
      }
      $pos_in_table = $pos_in_table + 1;

      }
   }
   return $table;
}
