<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/decuong_model.php');

global $COURSE;
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$link = optional_param('linkto', '', PARAM_NOTAGS);
if (!$link) {
    $link = null;
}

// Check permission.
require_login();
$context = \context_system::instance();
require_once('../../controller/auth.php');
$list = [1, 2, 3];
require_permission($list);

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/decuong/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add("Danh sách chuẩn đầu ra ctđt", new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php'));

// Title.

$PAGE->set_title("Import chuẩn đầu ra ctđt");
$PAGE->set_heading("Import chuẩn đầu ra ctđt");
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();


class form1 extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('filepicker', 'userfile', 'CSV chuẩn đầu ra chương trình đào tạo', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.csv'));
        $mform->addRule('userfile', 'Khong phai file csv', 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'GET');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
class form2 extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('hidden', 'link');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'insert to DB');
        $mform->addGroup($eGroup, 'thongtinchung_group15', '', array(' '),  false);
    }
    function validation($data, $files)
    {
        return array();
    }
    public function get_submit_value($elementname)
    {
        $mform = &$this->_form;
        return $mform->getSubmitValue($elementname);
    }
}


$form = new form1();
$mform2 = new form2();
$array_toDB = array();
$table = new html_table(); // new table


//////////////////////////////////FORM 1 //////////////////////////////////

if ($form->is_cancelled()) {
} else if ($form->no_submit_button_pressed()) {
} else if ($fromform = $form->get_data()) {



    $table->head = ['Mã cây chuẩn đầu ra', 'Mã chuẩn đầu ra', 'Tên', 'Mô tả', 'Level chuẩn đầu ra'];

    $name = $form->get_new_filename('userfile');


    $rex = $form->save_temp_file('userfile');

    redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/import/import_chuandauractdt.php?linkto=' . $rex);

    echo "<br>";
    echo "<br>";
    echo "<br>";
} else if ($form->is_submitted()) {

    // $form->display();
    echo "<h2>Dữ liệu trống</h2>";
} else {

    $toform;

    $form->display();
}

//////////////////////////////////FORM 1 //////////////////////////////////

if ($mform2->is_cancelled()) {
} else if ($mform2->no_submit_button_pressed()) {
} else if ($fromform = $mform2->get_data()) {


    if (($handle = fopen($fromform->link, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $arr = array();
            $arr[] = ['ma_cay_cdr' => $data[0], 'ma_cdr' => $data[1], 'ten' => $data[2], 'mota' => $data[3], 'level_cdr' => $data[4]];
            foreach ($arr as $item) {


                $param = new stdClass();
                $param->ma_cay_cdr = $item['ma_cay_cdr'];
                $param->ma_cdr = $item['ma_cdr'];
                $param->is_used = 0;
                $param->ten =  $item['ten'];
                $param->mota = $item['mota'];
                $param->level_cdr = $item['level_cdr'];
                $arr_2 = get();
                $check = is_check($param->ma_cdr, $param->ma_cay_cdr, $arr_2);
                if ($check == false) {
                    $check2 = is_check($param->ma_cdr, $param->ma_cay_cdr, $arr);
                    if ($check2 == false) {
                        if ($item['ma_cay_cdr'] == 'ma_cay_cdr' || $item['level_cdr'] == 'level_cdr') {
                        } else {
                            insert_cdr($param);
                        }
                    }
                }
            }
        }
        fclose($handle);
    }

    redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/chuandauractdt/index.php');
} else if ($mform2->is_submitted()) {
} else {

    $toform;
    $toform->link = $link;
    $mform2->set_data($toform);

    if ($link != null) {


        if (($handle = fopen($link, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $arr = array();

                $arr[] = ['ma_cay_cdr' => $data[0], 'ma_cdr' => $data[1], 'ten' => $data[2], 'mota' => $data[3], 'level_cdr' => $data[4]];

                foreach ($arr as $item) {

                    $param = new stdClass();
                    $param->ma_cay_cdr = $item['ma_cay_cdr'];
                    $param->ma_cdr = $item['ma_cdr'];
                    $param->ten =  $item['ten'];
                    $param->mota = $item['mota'];
                    $param->level_cdr = $item['level_cdr'];
                    $arr_2 = get();
                    $check = is_check($param->ma_cdr, $param->ma_cay_cdr, $arr_2);

                    if ($check == false) {
                        $check2 = is_check($param->ma_cdr, $param->ma_cay_cdr,  $table->data);
                        if ($check2 == false) {
                            if ($item['ma_cay_cdr'] == 'ma_cay_cdr' || $item['level_cdr'] == 'level_cdr') {
                            } else {


                                $table->data[] = $param;
                            }
                        }
                    }
                }
            }
            fclose($handle);
        }
        $table->head = ['Mã cây chuẩn đầu ra', 'Mã chuẩn đầu ra', 'Tên', 'Mô tả', 'Level chuẩn đầu ra'];

        echo html_writer::table($table);
        if (count($table->data) > 0) {
            $mform2->display();
        } else {
            echo "<h2 style='color: #1177d1;font-weight: 350; text-decoration: underline;'>Không có chuẩn đầu ra mới để thêm vào</h2>";
        }
    }
}

function insert_cdr($param)
{
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('eb_chuandaura_ctdt', $param);
}

function get()
{
    global $DB, $USER, $CFG, $COURSE;
    $arr = array();
    $arr = $DB->get_records('eb_chuandaura_ctdt', []);
    return $arr;
}
function is_check($ma_cdr, $ma_cay_cdr, $arr)
{

    foreach ($arr as $item) {
        if ($item->ma_cdr == $ma_cdr && $item->ma_cay_cdr == $ma_cay_cdr) {
            return true;
        }
    }
    return false;
}


// Footer
echo $OUTPUT->footer();
