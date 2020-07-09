<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/caykkt_model.php');
require_once('../../js.php');

global $DB, $USER, $CFG, $COURSE;

$courseid = optional_param('courseid', SITEID, PARAM_INT);

// Force user login in course (SITE or Course).
if ($courseid == SITEID) {
    require_login();
    $context = \context_system::instance();
} else {
    require_login($courseid);
    $context = \context_course::instance($courseid); // Create instance base on $courseid
}



///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/caykkt/index.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add(get_string('label_ctdt', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add(get_string('label_caykhoikienthuc', 'block_educationpgrs'), new moodle_url('/blocks/educationpgrs/pages/caykkt/index.php'));
// Title.
$PAGE->set_title(get_string('label_caykhoikienthuc', 'block_educationpgrs') . ' - Course ID: ' .$COURSE->id);
$PAGE->set_heading(get_string('label_caykhoikienthuc', 'block_educationpgrs'));
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

echo $OUTPUT->header();

// Action
$action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Xóa Cây KKT',
        array('id' => 'btn_delete_caykkt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone Cây KKT',
        array('id' => 'btn_clone_caykkt', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 150px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_caykkt', 'onClick' => "window.location.href='add_caykkt_ttc.php'", 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 100px; height:35px; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

echo '<br>';


$table = get_cay_kkt_table();
echo html_writer::table($table);

///END Table

 // Footere
echo $OUTPUT->footer();

function get_cay_kkt_table()
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('', 'STT', 'Tên cây', 'Mô tả');
    $rows = $DB->get_records('block_edu_cay_khoikienthuc', ['ma_khoi' => 'caykkt', 'ma_khoicha' => NULL, 'ma_tt' => NULL]);
    $stt = 1;
    foreach ($rows as $item){
        $url = new \moodle_url('/blocks/educationpgrs/pages/caykkt/chitiet_caykkt.php', ['ma_cay' => $item->ma_cay_khoikienthuc]);
        $ten_cay = \html_writer::link($url, $item->ten_cay);

        $checkbox = html_writer::tag('input', ' ', array('class' => 'ckktcheckbox', 'type' => "checkbox", 'name' => $item->id,   'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
        $table->data[] = [$checkbox, (string) $stt, (string) $ten_cay, (string) $item->mota];
        $stt = $stt + 1;
    }
    return $table;
}

?>
