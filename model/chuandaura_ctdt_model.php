<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');



function insert_chuandaura_ctdt($param)
{
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record('eb_chuandaura_ctdt', $param);
}
function update_chuandaura_ctdt($param)
{
    global $DB, $USER, $CFG, $COURSE;
    $DB->update_record('eb_chuandaura_ctdt', $param, $bulk = false);
}


function get_cdr_byID($id)
{
    global $DB;
    $result = $DB->get_record('eb_chuandaura_ctdt', ['id' => $id]);
    return $result;
}

function get_chuandaura_ctdt()
{
    global $DB;
    $result = $DB->get_records('eb_chuandaura_ctdt', []);
    $arr = array();
    foreach ($result as $iresult) {
        $arr[] = $iresult->ma_cdr;
    }
    return $arr;
}



function insert_cdr($param)
{
    global $DB, $USER, $CFG, $COURSE;
    return $DB->insert_record('eb_chuandaura_ctdt', $param);
}

function get_node_cdr_byMaCDR($ma_cay_cdr)
{
    global $DB, $USER, $CFG, $COURSE;
    $list_cdr = $DB->get_records('eb_chuandaura_ctdt', ['ma_cay_cdr' => $ma_cay_cdr]);
    return $list_cdr;
}

// function get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr)
// {
//     global $DB;
//     $result = $DB->get_record('eb_chuandaura_ctdt', ['ma_cay_cdr' => $ma_cay_cdr, 'level_cdr' => 0]);
//     return $result;
// }

// function get_list_cdr_byMaCayCDR($ma_cay_cdr)
// {
//     global $DB;
//     $result = $DB->get_records('eb_chuandaura_ctdt', ['ma_cay_cdr' => $ma_cay_cdr]);
//     return $result;
// }

function get_node_cdr($ma_cay_cdr, $ma_cdr)
{
    global $DB, $USER, $CFG, $COURSE;
    $cdr = $DB->get_record('eb_chuandaura_ctdt', ['ma_cay_cdr' => $ma_cay_cdr, 'ma_cdr' => $ma_cdr]);
    return $cdr;
}

// function can_edit_cdr($ma_cay_cdr){
//    $cdr = get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr);
//    return !$cdr->is_used;
// }

function can_edit_cdr($ma_cdr)
{
    global $DB;
    $cdr = $DB->get_record('eb_chuandaura_ctdt', ['ma_cdr' => $ma_cdr]);

    //Kiểm tra CĐR có trong ctđt
    if ($cdr->level == 1) {
        if ($DB->record_exists('eb_cdr_thuoc_ctdt', ['ma_cdr' => $ma_cdr])) {
            return false;
        }
    }
    // Kiểm tra chuẩn đầu ra có trong đề cương môn học eb_chuandaura
    $list_decuong = $DB->get_records('eb_chuandaura', []);
    $list_cdr_con = $DB->get_records('eb_chuandaura_ctdt', ['ma_cdr_cha' => $ma_cdr]);
    $arr_cdr_con = array();
    foreach($list_cdr_con as $item){
        $arr_cdr_con[] = $item->ma_cdr;
    }
    foreach ($list_decuong as $idc) {
        $arr_cdr_dc = explode(', ', $idc->ma_cdr);
        if(array_search($ma_cdr, $arr_cdr_dc)){
            return false;
        }
        foreach($arr_cdr_dc as $item){
            if(array_search($arr_cdr_dc, $arr_cdr_con)){
                return false;
            }
        }
    }

    return true;
}


// function lock_cdr($ma_cay_cdr){
//    global $DB, $USER, $CFG, $COURSE;
//    $cdr = get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr);
//    $cdr->is_used = 1;
//    update_chuandaura_ctdt($cdr);
// }

// function lock_cdr($ma_cay_cdr)
// {
//     global $DB, $USER, $CFG, $COURSE;
//     $cdr = get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr);
//     $cdr->is_used = 1;
//     update_chuandaura_ctdt($cdr);
// }

// function delete_node_cdr($ma_cay_cdr, $id)
// {
//     // Hàm kiểm tra $p là cdr cùng cha nằm phía sau $q hay không
//     function sameFather($p, $q)
//     {
//         // Khởi tạo các biến
//         $result = true;
//         $level = $p->level_cdr;
//         $arrIndex1 = explode('.', $p->ma_cdr);
//         $arrIndex2 = explode('.', $q->ma_cdr);

//         // Trả về false nếu 2 cdr khác cấp hoặc không nằm trong cùng một cây
//         if ($p->level_cdr != $q->level_cdr || $p->ma_cay_cdr != $q->ma_cay_cdr)
//             return false;

//         // Trả về true nếu 2 cdr có cùng cấp là 1 và $p nằm sau $q
//         if ($p->level_cdr == 1 && $arrIndex1[0] > $arrIndex2[0])
//             return true;

//         // Kiểm tra nếu 2 cdr có cùng cha      
//         for ($i = 0; $i < $level - 1; $i++) {
//             if ($arrIndex1[$i] != $arrIndex2[$i])
//                 $result = false;
//         }

//         // Nếu $p nằm trước hoặc ngang $q thì trả về false
//         if ($arrIndex1[$level - 1] <= $arrIndex2[$level - 1])
//             $result = false;

//         // Trả về kết quả kiểm tra
//         return $result;
//     }
//     global $DB;
//     $list_cdr = get_node_cdr_byMaCDR($ma_cay_cdr);
//     $cdr = get_cdr_byID($id);

//     // Xóa các cdr-con của cdr cần xóa
//     foreach ($list_cdr as $item) {
//         if ($item->level_cdr > $cdr->level_cdr && strpos($item->ma_cdr, $cdr->ma_cdr) === 0) {
//             $DB->delete_records('eb_chuandaura_ctdt', ['id' => $item->id]);
//         }
//     }

//     // Xóa cdr
//     $DB->delete_records('eb_chuandaura_ctdt', ['id' => $cdr->id]);

//     /* Cập nhật mã cdr - các nội dung ảnh hưởng là các node cùng cây, cùng node cha, cùng level với $cdr */
//     $same_level_in_tree = $DB->get_records('eb_chuandaura_ctdt', ['ma_cay_cdr' => $cdr->ma_cay_cdr, 'level_cdr' => $cdr->level_cdr]);
//     foreach ($same_level_in_tree as $item) {

//         // Xử lí các $cdr cùng cha nằm ở sau $cdr
//         if (sameFather($item, $cdr)) {

//             // Cập nhật các cdr con của item trước
//             foreach ($list_cdr as $child) {
//                 if ($child->level_cdr > $item->level_cdr && strpos($child->ma_cdr, $item->ma_cdr) === 0) {

//                     // Cập nhật lại mã cdr
//                     $arrIndex = explode('.', $child->ma_cdr);
//                     $arrIndex[$item->level_cdr - 1]--;
//                     $newCode = '';
//                     foreach ($arrIndex as $index) {
//                         ($newCode == '') ? $newCode .= $index : $newCode .= '.' . $index;
//                     }
//                     $child->ma_cdr = $newCode;
//                     $DB->update_record('eb_chuandaura_ctdt', $child, $bulk = false);
//                 }
//             }

//             // Cập nhật lại mã cdr
//             $arrIndex = explode('.', $item->ma_cdr);
//             $arrIndex[$item->level_cdr - 1]--;
//             $newCode = '';
//             foreach ($arrIndex as $index) {
//                 ($newCode == '') ? $newCode .= $index : $newCode .= '.' . $index;
//             }
//             $item->ma_cdr = $newCode;
//             $DB->update_record('eb_chuandaura_ctdt', $item, $bulk = false);
//         }
//     }
// }

function delete_cdr_byID($id)
{
    global $DB, $USER, $CFG, $COURSE;
    $cdr = get_cdr_byID($id);
    $listcon = get_list_cdrcon($cdr->ma_cdr);

    foreach ($listcon as $item) {
        $DB->delete_records('eb_chuandaura_ctdt', ['id' => $item->id]);
    }
    $DB->delete_records('eb_chuandaura_ctdt', ['id' => $id]);
}

function get_loai_cdr(){
    global $DB;
    $all_loai = $DB->get_records('eb_loai_cdr', []);

    $arr = array();
    if(empty($all_loai)){
        generate_default_loai_cdr();
        $all_loai = $DB->get_records('eb_loai_cdr', []);
    }

    foreach($all_loai as $item){
        $arr += [$item->ma_loai => $item->ten];
    }

    return $arr;
}

function generate_default_loai_cdr(){
    global $DB;

    $arr_loaicdr = [1 => 'Kiến thức',
                    2 => 'Kỹ năng mềm',
                    3 => 'Ngữ cảnh, trách nhiệm và đạo đức',
                    4 => 'Phương pháp khoa học và nghiên cứu',
                    5 => 'Hình thành ý tưởng, thiết kết và hiện thực hoá hệ thông CNTT',
                    6 => 'Kiểm chứng, vận hành, bảo trì và phát triển hệ thống CNTT',];
    foreach($arr_loaicdr as $key => $item){
        $param = new stdClass();
        $param->ma_loai = $key;
        $param->ten = $item;
        $DB->insert_record('eb_loai_cdr', $param);
    }
}


function get_cdr_byMaCDR($ma_cdr)
{
    global $DB;
    $result = $DB->get_record('eb_chuandaura_ctdt', ['ma_cdr' => $ma_cdr]);
    return $result;
}

function exist_ma_cdr($ma_cdr){
    global $DB;
    return $DB->record_exists('eb_chuandaura_ctdt', ['ma_cdr' => $ma_cdr]);
}

function add_cdr_to_cdr($id, $ten){
    global $DB;
    $cdr = get_cdr_byID($id);

    $param = new stdClass();
    $param->ten = $ten;
    $param->ma_cdr_cha = $cdr->ma_cdr;
    $param->ma_cdr = "C" . $cdr->ma_cdr;
    $param->level = 2;
    $param->ma_loai = $cdr->ma_loai;

    // echo json_encode($param);

    while(exist_ma_cdr($param->ma_cdr)){
        $param->ma_cdr++;
    } 

    insert_cdr($param);
}

function delete_cdrcon_byID($id){
    global $DB;
    $DB->delete_records('eb_chuandaura_ctdt', ['id' => $id]);
}

function get_list_cdrcon($ma_cdr){
    global $DB;
    $list =  $DB->get_records('eb_chuandaura_ctdt', ['ma_cdr_cha' => $ma_cdr]);
    return $list;
}

function get_list_cdr_thuoc_ctdt($ma_ctdt){
    global $DB;
    return $DB->get_records('eb_cdr_thuoc_ctdt', ['ma_ctdt' => $ma_ctdt]);
}

function delete_cdr_thuoc_ctdt($id){
    global $DB;
    $DB->delete_records('eb_cdr_thuoc_ctdt', ['id' => $id]);
}
function get_list_cdr_by_ctdt($ma_ctdt)
{
    global $DB;
    $list_ma_cdr = $DB->get_records('eb_cdr_thuoc_ctdt', ['ma_ctdt' => $ma_ctdt]);

    $arr_result = array();
    $stt = 1;
    foreach ($list_ma_cdr as $item) {

        $item_cdr = $DB->get_record('eb_chuandaura_ctdt', ['ma_cdr' => $item->ma_cdr]);
        $item_cdr->ma_tt = $stt;
        $arr_result[] = $item_cdr;
        if ($item_cdr->level == 1 || $item_cdr->level == '1') {


            $list_cdr_con = $DB->get_records('eb_chuandaura_ctdt', ['ma_cdr_cha' => $item->ma_cdr]);
            $stt_con = 1;
            foreach ($list_cdr_con as $item_cdr_con) {
                $item_cdr_con->ma_tt = $stt . "." . $stt_con;
                $arr_result[] = $item_cdr_con;
                $stt_con++;
            }
        }
        $stt++;
    }
    return $arr_result;
}

function get_cdr_thuoc_ctdt($ma_cdr, $ma_ctdt){
    global $DB;
    return $DB->get_record('eb_cdr_thuoc_ctdt', ['ma_cdr' => $ma_cdr, 'ma_ctdt' => $ma_ctdt]);
}