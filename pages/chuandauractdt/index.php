<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');
require_once('../../js.php');

// require_once('../factory.php');
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));
// Create button with method post
global $COURSE;

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add(get_string('label_chuandauractdt', 'block_educationpgrs'));

// Title.
$PAGE->set_title(get_string('label_chuandauractdt', 'block_educationpgrs') . ' - Course ID: ' );
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
        'Xóa ',
        array('id' => 'btn_delete_chuandaura_ctdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone ',
        array('id' => 'btn_clone_chuandaura_ctdt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_chuandaura_ctdt', 'onClick' => "window.location.href='create.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
echo '<br>';
$table = get_chuandaura_ctdt_checkbox($search, $page);
echo html_writer::table($table);


$baseurl = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_chuandaura_ctdt_checkbox($search, -1)->data), $page, 5, $baseurl);



$count = 1;
if(array_key_exists('mmmy',$_SESSION)){
    echo 'the s';
    echo 'the end';


    foreach ($table->data as $data) {
      
    }
        
    
 }

// Footer
echo $OUTPUT->footer();