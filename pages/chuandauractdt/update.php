<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');
require_once('../../model/ctdt_model.php');

global $COURSE,$DB;
$id = 1;
$founded_id = false;
if (optional_param('id', 0, PARAM_INT))
{
    $id = optional_param('id', 0, PARAM_INT);
    $founded_id = true;
}
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/update.php', ['id ' => $id]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add("Danh sách chuẩn đầu ra chương trình đào tạo", new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php'));

// Title.
$PAGE->set_title('Thêm chuẩn đầu ra chương trình đào tạo'  );
$PAGE->set_heading('Thêm chuẩn đầu ra chương trình đào tạo'  );
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');


// Navbar.
$chuandaura_ctdt = get_chuandaura_ctdt_byID($id);
$ctdt =  get_ctdt_byMa($chuandaura_ctdt->ma_ctdt);
$tenctdt ;
foreach ($ctdt as $item) {
    $tenctdt = $item->mota;
}

$navbar_name = 'Chuẩn đầu ra chương trình đào tạo';
$title_heading = 'Chuẩn đầu ra chương trình đào tạo';
if ($founded_id == true) {
    $navbar_name = $chuandaura_ctdt->ten;
    $title_heading = $chuandaura_ctdt->ten;
} else {
    // Something here
}
$PAGE->navbar->add($navbar_name);

// Title.
$PAGE->set_title('Cập nhật chuẩn đầu ra chương trình đào tạo' . $title_heading);
$PAGE->set_heading('Cập nhật chuẩn đầu ra chương trình đào tạo' . $title_heading);
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Form
require_once('../../form/chuandauractdt/chuandaura_ctdt_form.php');
$mform = new chuandaura_ctdt_edit_form();

// Form processing
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    $param1 = new stdClass();
    $param1->id =  $mform->get_data()->id;
    
    $param1->ten = $mform->get_data()->ten;
    $param1->mota = $mform->get_data()->mota;
    update_chuandaura_ctdt($param1);
    // Hiển thị thêm thành công
    echo '<h2>Cập nhật thành công!</h2>';
    echo '<br>';
    // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
    $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php', []);
    $linktext = get_string('label_chuandauractdt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit
} else {
    //Set default data from DB
    $toform;
    $toform->id = $chuandaura_ctdt->id;
    $toform->ma_cdr = $chuandaura_ctdt->ma_cdr;
    $toform->ten = $chuandaura_ctdt->ten;
    $toform->mota = $chuandaura_ctdt->mota;

    $mform->set_data($toform);
    $mform->display();
}

// Footer
// Footer
echo $OUTPUT->footer();