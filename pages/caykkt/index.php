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
        array('id' => 'btn_delete_caykkt', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #z; color:#fff;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Clone Cây KKT',
        array('id' => 'btn_clone_caykkt', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #1177d1; color:#fff;')
    )
    . '<br>'
    . html_writer::tag(
        'button',
        'Thêm mới',
        array('id' => 'btn_add_caykkt', 'onClick' => "window.location.href='add_caykkt.php'", 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #1177d1; color:#fff;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;

// Thêm mới
$url = new \moodle_url('/blocks/educationpgrs/pages/caykkt/newcaykkt.php', ['courseid' => $courseid]);
$ten_url = \html_writer::link($url, '<u><i>Thêm mới</i></u>');
echo  \html_writer::link($url, $ten_url);
echo '<br><br>';

// $btn_tao_caykkt = html_writer::tag('button','Tạo cây khối kiến thức', array('onClick' => "window.location.href='create.php'"));
// echo $btn_tao_caykkt;
// echo '<br>';




$table = get_cay_kkt_table();

echo html_writer::table($table);

echo '  ';
echo \html_writer::tag(
    'button',
    'Xóa caykkt',
    array('id' => 'btn_delete_caykkt'));

echo '<br>';
///END Table

 // Footere
echo $OUTPUT->footer();

function get_cay_kkt_table()
{
    global $DB, $USER, $CFG, $COURSE;
    $table = new html_table();
    $table->head = array('', 'STT', 'ID', 'Mã cây khối kiến thức', 'Mã khối', 'Tên cây', 'Mô tả');
    $rows = $DB->get_records('block_edu_cay_khoikienthuc', []);
    $stt = 1;
    foreach ($rows as $item) {
        if((string)$item->ma_khoicha == ""){
            $checkbox = html_writer::tag('input', ' ', array('class' => 'ckktcheckbox', 'type' => "checkbox", 'name' => $item->id,   'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
            $table->data[] = [$checkbox, (string) $stt, (string) $item->id, (string) $item->ma_cay_khoikienthuc, (string) $item->ma_khoi, (string) $item->ten_cay, (string) $item->mota];
            $stt = $stt + 1;
        }
    }
    return $table;
}

?>
