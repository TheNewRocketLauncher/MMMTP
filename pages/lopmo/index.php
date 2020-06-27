<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/lopmo_model.php');
require_once('../../js.php');


// require_once('../factory.php');
$page = optional_param('page', 0, PARAM_INT);
$search = trim(optional_param('search', '', PARAM_NOTAGS));
// Create button with method post
function button_method_post($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "post"))
    .html_writer::tag('input', ' ', array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}

// Create button with method get
function button_method_get($btn_name, $btn_value) {
    $btn = html_writer::start_tag('form', array('method' => "get"))
    .html_writer::tag('input', null, array('type' => "submit", 'name' => $btn_name, 'id' => $btn_name, 'value' => $btn_value))
    .html_writer::end_tag('form');
    return $btn;
}
class simplehtml_form extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;
        $mform->addElement('html', '        


        ');
    }
    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}
global $COURSE;


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_lopmo', 'block_educationpgrs'));
// Title.
$PAGE->set_title(get_string('label_lopmo', 'block_educationpgrs') );
$PAGE->set_heading(get_string('head_lopmo', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();

// Search
require_once('../../form/lopmo/mo_lopmo_form.php');
$form_search = new lopmo_search();

// Process form
if ($form_search->is_cancelled()) {
    // Process button cancel
} else if ($form_search->no_submit_button_pressed()) {
    // $form_search->display();
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
        array('id' => 'btn_delete_lopmo', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone ',
        array('id' => 'btn_clone_lopmo', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:100px; height:35px; background-color: white; color:black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_lopmo', 'onClick' => "window.location.href='create.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px;width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

$table = get_lopmo_checkbox($search, $page);
echo html_writer::table($table);


$baseurl = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', ['search' => $search]);
echo $OUTPUT->paging_bar(count(get_lopmo_checkbox($search, -1)->data), $page, 5, $baseurl);




//TRỎ ĐẾN FORM TƯƠNG ỨNG CỦA MÌNH TRONG THƯ MỤC FORM
// require_once('../../form/lopmo/danhsach_lopmo_form.php');
// $mform = new danhsach_lopmo_form();


$count = 1;
if(array_key_exists('mmmy',$_SESSION)){
    echo 'the s';
    echo 'the end';


    foreach ($table->data as $data) {
      
    }
        
    
 }

 // Footere
echo $OUTPUT->footer();

    // ?>
