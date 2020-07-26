<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');
require_once('../../controller/validate.php');
require_once('../../controller/auth.php');
require_once('../../js.php');

global $COURSE, $DB;

// Course ID, item ID
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT)) {
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}

// Check permission.
require_login();
$context = \context_system::instance();


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/quyen/update.php', ['id' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Quản lý quyền hạn', new moodle_url('/blocks/educationpgrs/pages/quyen/index.php'));
$quyen = ($DB->get_record("role", ['id' => $id]));
$navbar_name = '';
$title_heading = '';
if ($founded_id == true) {
    $navbar_name = $quyen->shortname;
    $title_heading = $quyen->shortname;
} else {
    // Do anything here
}

// Navar
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật quyền của ' . $title_heading);
$PAGE->set_heading('Cập nhật quyền của ' . $title_heading);
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_permission("", "");



$table = get_list_quyen($id);
echo html_writer::table($table);


$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Cập nhật',
        array('id' => 'btn_update_quyen', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: green; color: black;')
    )
    .
    html_writer::link(
        new moodle_url('/blocks/educationpgrs/pages/quyen/index.php'),
        html_writer::tag(
            'button',
            'Hủy',
            array(
                'id' => 'btn_update_quyen', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width:130px; height:35px; padding: 0; background-color: white; color:black;'
            )
        )
    )


    . '<br>';
echo $action_form;


// Footer
echo $OUTPUT->footer();
// function reload()
// {
//     redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/quyen/index.php');
// }
