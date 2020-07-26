<?php
require_once(__DIR__ . '/../../../../config.php');
// require_once($CFG->libdir.'/pdflib.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/bacdt_model.php');
require_once('../../controller/auth.php');
require_once('../../js.php');

global $COURSE, $GLOBALS, $DB;



// Check permission.
require_login();
$context = \context_system::instance();


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/quyen/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Quản lý quyền hạn');

// Title.
$PAGE->set_title('Quản lý quyền hạn');
$PAGE->set_heading('Quản lý quyền hạn');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();
require_permission("", "");

$table = get_list_role();
echo html_writer::table($table);





echo $OUTPUT->footer();
