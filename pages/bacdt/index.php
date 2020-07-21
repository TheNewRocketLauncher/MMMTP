<?php
require_once(__DIR__ . '/../../../../config.php');
// require_once($CFG->libdir.'/pdflib.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');
require_once('../../js.php');

global $COURSE, $GLOBALS;
var_dump($_REQUEST);
$courseid = optional_param('courseid', SITEID, PARAM_INT) || 1;
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_bacdt', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_bacdt', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_bacdt', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Create table
$table = get_bacdt_checkbox($search, $page);

// Search
require_once('../../form/bacdt/qlbac_form.php');
$form_search = new bacdt_seach();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->bacdt_seach;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/bacdt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
    // redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/bacdt/index.php?search='.$search.'&amp;page='.$page);
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->bacdt_seach = $search;
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
        'Xóa',
        array('id' => 'btn_delete_bacdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép',
        array('id' => 'btn_clone_bacdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_bacdt', 'onClick' => "window.location.href='add_bdt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 130px; height:35px; padding: 0; background-color: white; color: black;')
        // array('id' => 'btn_add_bacdt', 'onClick' => "window.location.href='add_bdt.php'", 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #1177d1; color:#fff;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
require_permission($list);


echo '<br>';

// Print table
echo html_writer::table($table);
// Pagination
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_bacdt_checkbox($search, -1)->data), $page, 20, $baseurl);

// Footer
echo $OUTPUT->footer();

function get_bacdt_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $count = 20;
   $table = new html_table();
   $table->head = array('', 'STT', 'Mã bậc đào tạo','Tên bậc đào tạo', 'Mô tả');
   $allbacdts = $DB->get_records('eb_bacdt', []);
   $stt = 1 + $page * $count;
   $pos_in_table = 1;
   foreach ($allbacdts as $ibacdt) {
      if (findContent($ibacdt->ten, $key_search) || $key_search == '') {
         $checkbox = html_writer::tag('input', ' ', array('class' => 'bdtcheckbox', 'type' => "checkbox", 'name' => $ibacdt->id, 'id' => 'bdt' . $ibacdt->id, 'value' => '0', 'onclick' => "changecheck($ibacdt->id)"));
         $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/update_bdt.php', ['id' => $ibacdt->id]);
         $ten_url = \html_writer::link($url, $ibacdt->ten);
         if ($page < 0) { // Get all data without page
            $table->data[] = [$checkbox, (string) $stt,(string)$ibacdt->ma_bac, $ten_url, (string) $ibacdt->mota];
            $stt = $stt + 1;
         } else if ($pos_in_table > $page * $count && $pos_in_table <= $page * $count + $count) {
            $table->data[] = [$checkbox, (string) $stt,(string)$ibacdt->ma_bac, $ten_url, (string) $ibacdt->mota];
            $stt = $stt + 1;
         }
         $pos_in_table = $pos_in_table + 1;
      }
   }
   return $table;
}