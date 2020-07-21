<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/hedt_model.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/hedt/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_hedt', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_hedt', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_hedt', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Create table
$table = get_hedt_checkbox($search, $page);

// Search
require_once('../../form/hedt/qlhe_form.php');
$form_search = new hedt_search();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->hedt_search;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/hedt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->hedt_search = $search;
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
        array('id' => 'btn_delete_hedt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép',
        array('id' => 'btn_clone_hedt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_hedt', 'onClick' => "window.location.href='add_hdt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

echo '<br>';

// Print table
echo html_writer::table($table);

// Pagination
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_hedt_checkbox($search, -1)->data), $page, 20, $baseurl);

// Footer
echo $OUTPUT->footer();


function get_hedt_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $count = 20;
   $table = new html_table();
   $table->head = array('', 'STT', 'Bậc đào tạo', 'Mã hệ đào tạo','Tên hệ đào tạo', 'Mô tả');
   $allhedts = $DB->get_records('eb_hedt', []);
   $stt = 1 + $page * $count;
   $pos_in_table = 1;
   foreach ($allhedts as $ihedt) {
      if (findContent($ihedt->ten, $key_search) || $key_search == '') {
         $checkbox = html_writer::tag('input', ' ', array('class' => 'hdtcheckbox', 'type' => "checkbox", 'name' => $ihedt->id, 'id' => 'hdt' . $ihedt->id, 'value' => '0', 'onclick' => "changecheck_hedt($ihedt->id)"));
         $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/update_hdt.php', ['id' => $ihedt->id]);
         $ten_url = \html_writer::link($url, $ihedt->ten);
         if ($page < 0) { // Get all data without page
            $table->data[] = [$checkbox, (string) $stt, (string) $ihedt->ma_bac,(string)$ihedt->ma_he, $ten_url, (string) $ihedt->mota];
            $stt = $stt + 1;
         } else if ($pos_in_table > $page * $count && $pos_in_table <= $page * $count + $count) {
            $table->data[] = [$checkbox, (string) $stt, (string) $ihedt->ma_bac,(string)$ihedt->ma_he, $ten_url, (string) $ihedt->mota];
            $stt = $stt + 1;
         }
         $pos_in_table = $pos_in_table + 1;
      }
   }
   return $table;
}
