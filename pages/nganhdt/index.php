<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/nganhdt_model.php');
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
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_nganh', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_nganh', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading(get_string('head_nganh', 'block_educationpgrs'));
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Create table
$table = get_nganhdt_checkbox($search, $page);

// Search
require_once('../../form/nganhdt/qlnganh_form.php');
$form_search = new nganhdt_search();

// Process form
if ($form_search->is_cancelled()) {
    echo '<h2>Thêm không thành công</h2>';
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->nganhdt_search;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/nganhdt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->nganhdt_search = $search;
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
        array('id' => 'btn_delete_nganhdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép',
        array('id' => 'btn_clone_nganhdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_nganhdt', 'onClick' => "window.location.href='add_nganhdt.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;


echo '<br>';


// Print table
echo html_writer::table($table);
// Pagination
$baseurl = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_nganhdt_checkbox($search, -1)->data), $page, 20, $baseurl);



// Footer
echo $OUTPUT->footer();


function get_nganhdt_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $count = 20;
   $table = new html_table();
   $table->head = array('', 'STT','Bậc đào tạo','Hệ đào tạo','Niên khóa đào tạo', 'Mã ngành đào tạo','Tên ngành đào tạo', 'Mô tả');
   $allnganhdts = $DB->get_records('eb_nganhdt', []);
   $stt = 1 + $page * $count;
   $pos_in_table = 1;
   foreach ($allnganhdts as $inganhdt) {
      if (findContent($inganhdt->ten, $key_search) || $key_search == '') {
         $checkbox = html_writer::tag('input', ' ', array('class' => 'nganhdtcheckbox', 'type' => "checkbox", 'name' => $inganhdt->id, 'id' => 'nganhdt' . $inganhdt->id, 'value' => '0', 'onclick' => "changecheck_nganhdt($inganhdt->id)"));
         $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/update_nganhdt.php', ['id' => $inganhdt->id]);
         $ten_url = \html_writer::link($url, $inganhdt->ten);
         if ($page < 0) { // Get all data without page
            $table->data[] = [$checkbox, (string) $stt,(string)$inganhdt->ma_bac,(string)$inganhdt->ma_he,(string)$inganhdt->ma_nienkhoa,(string)$inganhdt->ma_nganh, $ten_url, (string) $inganhdt->mota];
            $stt = $stt + 1;
         } else if ($pos_in_table > $page * $count && $pos_in_table <= $page * $count + $count) {
            $table->data[] = [$checkbox, (string) $stt,(string)$inganhdt->ma_bac,(string)$inganhdt->ma_he,(string)$inganhdt->ma_nienkhoa,(string)$inganhdt->ma_nganh, $ten_url, (string) $inganhdt->mota];
            $stt = $stt + 1;
         }
         $pos_in_table = $pos_in_table + 1;
      }
   }
   return $table;
}
