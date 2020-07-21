<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');


// require_once('../factory.php');
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));
$ma_ctdt = trim(optional_param('ctdt', '', PARAM_NOTAGS));
// Create button with method post
global $COURSE;

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_lopmo', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_lopmo', 'block_educationpgrs'));
$PAGE->set_heading(get_string('head_lopmo', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();

// Select
require_once('../../form/lopmo/view_lopmo_form.php');
$form_select = new select_ctdt_form();
echo "<h3 style='color: 1177d1;text-decoration: underline; '><strong>Danh sách lớp mở</strong></h3>";

// Process form
if ($form_select->is_cancelled()) {
    // Process button cancel
} else if ($form_select->no_submit_button_pressed()) {
    // Process button nosubmit
} else if ($fromform = $form_select->get_data()) {
    // Redirect page
    $ma_ctdt = $form_select->get_data()->mactdt;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/lopmo/view.php?ctdt=' . $ma_ctdt . '&search=' . $search . '&page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
} else if ($form_select->is_submitted()) {
    // Process button submitted
    $form_select->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->mactdt = $ma_ctdt;
    $form_select->set_data($toform);
    // Displays form
    $form_select->display();
}
function get_lopmo_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('', 'STT','Mã môn học', 'Tên khóa học', 'Giáo viên phụ trách', 'Mô tả');
   $alllopmos = $DB->get_records('eb_lop_mo', []);
   $stt = 1 + $page * 20;
   $pos_in_table = 1;

   foreach ($alllopmos as $item) {
      if (findContent($item->full_name, $key_search) || $key_search == '') {

      $checkbox = html_writer::tag('input', ' ', array('class' => 'lopmocheckbox', 'type' => "checkbox", 'name' => $item->id, 'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
      $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/update.php', [ 'id' => $item->id]);
      $ten_url = \html_writer::link($url, $item->full_name);


      if ($page < 0) { // Get all data without page
         $table->data[] = [$checkbox, (string) $stt,(string)$item->mamonhoc, (string)$item->full_name, (string) $item->assign_to, (string) $item->mota];
         $stt = $stt + 1;
      } else if ($pos_in_table > $page * 20 && $pos_in_table <= $page * 20 + 20) {
         $table->data[] = [$checkbox, (string) $stt,(string)$item->mamonhoc, (string)$item->full_name, (string) $item->assign_to, (string) $item->mota];
         $stt = $stt + 1;
      }
      $pos_in_table = $pos_in_table + 1;

      }
   }
   return $table;
}

$table = get_lopmo($search, $page, $ma_ctdt);
echo html_writer::table($table);
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_lopmo_checkbox($search, -1)->data), $page, 20, $baseurl);

// Semester
$action_form= get_danhmuc_lopmo();
echo "<h3 style='margin-top: 30px; color: 1177d1;text-decoration: underline; '><strong>Danh mục lớp mở</strong></h3>";
echo $action_form;

// Footer
echo $OUTPUT->footer();
