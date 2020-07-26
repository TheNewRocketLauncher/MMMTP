<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');
// require_once('../../js.php');

global $COURSE;

// $ma_cay_cdr = optional_param('ma_cay_cdr', NULL, PARAM_NOTAGS);
// $error = optional_param('error', 0, PARAM_NOTAGS);

///-------------------------------------------------------------------------------------------------------///
// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/create.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add("Danh sách chuẩn đầu ra chương trình đào tạo", new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php'));
$PAGE->navbar->add('Thêm chuẩn đầu ra chương trình đào tạo');
// Title.
$PAGE->set_title('Thêm chuẩn đầu ra chương trình đào tạo'  );
$PAGE->set_heading('Thêm chuẩn đầu ra chương trình đào tạo'  );
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
// Print header
echo $OUTPUT->header();
require_once('../../controller/auth.php');
require_permission("chuandauractdt", "edit");

///-------------------------------------------------------------------------------------------------------///
// Form
require_once('../../form/chuandauractdt/add_chuandaura_form.php');
$mform = new chitiet_cdr_form();

// // Action
// $action_form =
//     html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
//     . '<br>'
//     . html_writer::tag(
//         'button',
//         'Xóa CĐR',
//         array('id' => 'btn_del_cdr', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
//     )
//     . '<br>'
//     . html_writer::end_tag('div');
// echo $action_form;
// echo '<br>';

// if($error == 1){
//     echo '<h4> Chuẩn đầu ra đang được sử dụng nên không thể sửa được! </h4>';
//     echo "<br>";
// }

// if($ma_cay_cdr != NULL){
//     if(get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr)->is_used){
//         echo '<h4> Chuẩn đầu ra đang được sử dụng nên không thể sửa được! </h4>';
//     }
// } else{
//     redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/index.php');
// }


$mform->display();
// Process form
// if ($mform->is_cancelled()) {
//     redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/index.php');
// } else if ($mform->no_submit_button_pressed()) {
//     $data = $mform->get_value();

//     if(can_edit_cdr($data->ma_cay_cdr)){
//         if($data->select_cdr_node == 0){
//             add_new_node($data);
//             redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/chitiet_cdr.php?ma_cay_cdr=' .$data->ma_cay_cdr);
//         } else{
//             add_new_childNode($data);
//             redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/chitiet_cdr.php?ma_cay_cdr=' .$data->ma_cay_cdr);
//         }
//     } else{
//         redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/chitiet_cdr.php?ma_cay_cdr=' .$data->ma_cay_cdr.'&error=1');
//     }

//     $mform->display();
// } else if ($fromform = $mform->get_data()) {
//     redirect($CFG->wwwroot.'/blocks/educationpgrs/pages/chuandauractdt/update.php?ma_cay_cdr=' .$fromform->ma_cay_cdr);
// } else {
//     if($ma_cay_cdr != NULL){
//         $cdr = get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr);

//         $toform = new stdClass();
//         $toform->select_cdr = $ma_cay_cdr;
//         $toform->txt_ten_cdr = $cdr->ten;
//         $toform->ma_cay_cdr = $ma_cay_cdr;
//         $toform->is_used = $cdr->is_used;
//         $mform->set_data($toform);
//     }
// }

// print_table_cdr($ma_cay_cdr);
// Action
// $action_form =
//     html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-start;'))
//     . '<br>'
//     . html_writer::tag(
//         'button',
//         'Xoá node',
//         array('id' => 'btn_del_node_cdr', 'style' => 'margin:0 10px;border: 0px solid #333; width: auto; height:35px; background-color: #fa4b1b; color:#fff;')
//     )
//     . '<br>'
//     . html_writer::end_tag('div');
// echo $action_form;
// echo '<br>';

// Footer
echo $OUTPUT->footer();

// function add_new_node($data){
//     $list_current_cdr = get_list_cdr_byMaCayCDR($data->ma_cay_cdr);
//     usort($list_current_cdr, function($a, $b)
//     {
//         return strcmp($a->ma_cdr, $b->ma_cdr);
//     });

//     $max_node = 0;
//     foreach($list_current_cdr as $item){
//         if($max_node < $item->ma_cdr && $item->level_cdr == 1){
//             $max_node = $item->ma_cdr;
//         }
//     }
//     $max_node++;

//     $param = new stdClass();
//     $param->ma_cay_cdr = $data->ma_cay_cdr;
//     $param->ma_cdr = $max_node;
//     $param->ten = $data->txt_ten;
//     $param->mota = $data->mota;
//     $param->is_used = 0;
//     $param->level_cdr = 1;
//     insert_chuandaura_ctdt($param);
// }

// function add_new_childNode($data){
//     $list_current_cdr = get_list_cdr_byMaCayCDR($data->ma_cay_cdr);
//     usort($list_current_cdr, function($a, $b)
//     {
//         return strcmp($a->ma_cdr, $b->ma_cdr);
//     });
//     $cdr = get_node_cdr($data->ma_cay_cdr, $data->select_cdr_node);
//     $level = $cdr->level_cdr;
//     $level++;

//     $max_node = $data->select_cdr_node . '.0';
//     foreach($list_current_cdr as $item){
//         if($item->level_cdr == $level && strpos($item->ma_cdr, $data->select_cdr_node) === 0){
//             $max_node = $item->ma_cdr;
//         }
//     }

//     $max_node = 'DM' . (string) $max_node;
//     $max_node++;
//     $max_node = substr($max_node, 2, 999);

//     $param = new stdClass();
//     $param->ma_cay_cdr = $data->ma_cay_cdr;
//     $param->ma_cdr = $max_node;
//     $param->ten = $data->txt_ten;
//     $param->mota = $data->mota;
//     $param->is_used = 0;
//     $param->level_cdr = $level;
//     insert_chuandaura_ctdt($param);
// }

// function print_table_cdr($ma_cay_cdr){
//     $list_cdr = get_list_cdr_byMaCayCDR($ma_cay_cdr);
//     usort($list_cdr, function($a, $b)
//     {
//         return strcmp($a->ma_cdr, $b->ma_cdr);
//     });

//     $table = new html_table();
//     $table->head = array('', 'Mã Chuẩn đầu ra', 'Nội dung', 'Mô tả');
//     foreach ($list_cdr as $item) {
//         if($item->ma_cdr != NULL){
//             $checkbox = html_writer::tag('input', ' ', array('class' => 'cdr_checkbox', 'type' => "checkbox", 'name' => $item->id, 'id' => 'bdt' . $item->id, 'value' => '0', 'onclick' => "changecheck($item->id)"));
//             $table->data[] = [$checkbox, (string) $item->ma_cdr, (string) $item->ten, (string) $item->mota];
//         }
//     }

//     echo html_writer::table($table);
// }