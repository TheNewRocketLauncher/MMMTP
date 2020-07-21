<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');
require_once('../../js.php');

// require_once('../factory.php');
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));

global $COURSE;

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_chuandauractdt', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_chuandauractdt', 'block_educationpgrs') . ' - Course ID: ' );
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
// Search
require_once('../../form/chuandauractdt/chuandaura_ctdt_form.php');
$form_search = new chuandaura_ctdt_search();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
} else if ($fromform = $form_search->get_data()) {
    // Redirect page
    $search = $form_search->get_data()->chuandaura_ctdt_search;
    $ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/chuandauractdt/index.php?search=' . $search . '&amp;page=' . $page;
    echo "<script type='text/javascript'>location.href='$ref'</script>";
} else if ($form_search->is_submitted()) {
    // Process button submitted
    $form_search->display();
} else {
    /* Default when page loaded*/
    $toform;
    $toform->chuandaura_ctdt_search = $search;
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
        'Import',
        array('onClick'=>"window.location.href='/moodle/blocks/educationpgrs/pages/chuandauractdt/import.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Xóa ',
        array('id' => 'btn_delete_chuandaura_ctdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Sao chép',
        array('id' => 'btn_clone_chuandaura_ctdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_chuandaura_ctdt', 'onClick' => "window.location.href='add_cdr.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';
$table = get_chuandaura_ctdt_checkbox($search, $page);
echo html_writer::table($table);


$baseurl = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_chuandaura_ctdt_checkbox($search, -1)->data), $page, 20, $baseurl);



$count = 1;
if(array_key_exists('mmmy',$_SESSION)){
    echo 'the s';
    echo 'the end';


    foreach ($table->data as $data) {
      
    }
        
    
 }

// Footer
echo $OUTPUT->footer();


function get_chuandaura_ctdt_checkbox($key_search = '', $page = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   $table->head = array('', 'STT','Tên chuẩn đầu ra', 'Trạng thái(CTĐT)',  'Mô tả', );
   $allchuandaura_ctdts = $DB->get_records('eb_chuandaura_ctdt', ['level_cdr' => 0]);
   usort($allchuandaura_ctdts, function($a, $b)
   {
      return strcmp($a->ma_cdr, $b->ma_cdr);
   });
   $stt = 1 + $page * 20;
   $pos_in_table = 1;

   foreach ($allchuandaura_ctdts as $item) {
      if (findContent($item->ten, $key_search) || $key_search == '') {

         if($item->level_cdr == 0){
            $checkbox = html_writer::tag('input', ' ', array('class' => 'chuandauractdtcheckbox', 'type' => "checkbox", 'name' => $item->id, 'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
      
            $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/chitiet_cdr.php', [ 'ma_cay_cdr' => $item->ma_cay_cdr]);
            $ten_url = \html_writer::link($url, $item->ten);
            if ($item->is_used == 0 ){
               $is_used = "Chưa được sử dụng";
            }
            else{
               $is_used = "Đã được sử dụng";
            }
            if ($page < 0) { // Get all data without page
               
               $table->data[] = [$checkbox, (string) $stt, (string) $ten_url, (string)$is_used, (string) $item->mota];
               $stt = $stt + 1;
            } else if ($pos_in_table > $page * 20 && $pos_in_table <= $page * 20 + 20) {
               $table->data[] = [$checkbox, (string) $stt, (string) $ten_url, (string)$is_used, (string) $item->mota];
               $stt = $stt + 1;
            }
            $pos_in_table = $pos_in_table + 1;
         }
      }
   }
   return $table;
}