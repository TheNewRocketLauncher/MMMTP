<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');
require_once('../../js.php');


// require_once('../factory.php');
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));
global $COURSE,$USER,$SESSION;

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_lopmo', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_lopmo', 'block_educationpgrs') );
$PAGE->set_heading(get_string('head_lopmo', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();

// Search
require_once('../../form/lopmo/mo_lopmo_form.php');
$form_search = new lopmo_search();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    echo '<h2>Thêm không thành công</h2>';
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->lopmo_search;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/lopmo/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->lopmo_search = $search;
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
        array('id' => 'btn_delete_lopmo', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép ',
        array('id' => 'btn_clone_lopmo', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_lopmo', 'onClick' => "window.location.href='create.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';

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

$table = get_lopmo_checkbox($search, $page);
echo html_writer::table($table);


$baseurl = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_lopmo_checkbox($search, -1)->data), $page, 20, $baseurl);


 // Footere
echo $OUTPUT->footer();


