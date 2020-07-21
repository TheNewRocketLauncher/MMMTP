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


function get_chuandaura_ctdt_byID($id)
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
   foreach($result as $iresult){
      $arr[] = $iresult->ma_cdr;
   }
   return $arr;

}



function insert_cdr($param){
   global $DB, $USER, $CFG, $COURSE;
   $DB->insert_record('eb_chuandaura_ctdt', $param);
}

function get_node_cdr_byMaCDR($ma_cay_cdr){
   global $DB, $USER, $CFG, $COURSE;
   $list_cdr = $DB->get_records('eb_chuandaura_ctdt', ['ma_cay_cdr' => $ma_cay_cdr]);
   return $list_cdr;
}

function get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr)
{
   global $DB;
   $result = $DB->get_record('eb_chuandaura_ctdt', ['ma_cay_cdr' => $ma_cay_cdr, 'level_cdr' => 0]);
   return $result;

}

function get_list_cdr_byMaCayCDR($ma_cay_cdr){
   global $DB;
   $result = $DB->get_records('eb_chuandaura_ctdt', ['ma_cay_cdr' => $ma_cay_cdr]);
   return $result;
}

function get_node_cdr($ma_cay_cdr, $ma_cdr){
   global $DB, $USER, $CFG, $COURSE;
   $cdr = $DB->get_record('eb_chuandaura_ctdt', ['ma_cay_cdr' => $ma_cay_cdr, 'ma_cdr' => $ma_cdr]);
   return $cdr;
}

function can_edit_cdr($ma_cay_cdr){
   $cdr = get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr);
   return !$cdr->is_used;
}

function lock_cdr($ma_cay_cdr){
   global $DB, $USER, $CFG, $COURSE;
   $cdr = get_chuandaura_ctdt_byMaCayCDR($ma_cay_cdr);
   $cdr->is_used = 1;
   update_chuandaura_ctdt($cdr);
}

function delete_node_cdr($ma_cay_cdr, $id)
{
   // Hàm kiểm tra $p là cdr cùng cha nằm phía sau $q hay không
   function sameFather($p, $q)
   {
      // Khởi tạo các biến
      $result = true;
      $level = $p->level_cdr;
      $arrIndex1 = explode('.', $p->ma_cdr);
      $arrIndex2 = explode('.', $q->ma_cdr);

      // Trả về false nếu 2 cdr khác cấp hoặc không nằm trong cùng một cây
      if ($p->level_cdr != $q->level_cdr || $p->ma_cay_cdr != $q->ma_cay_cdr)
         return false;

      // Trả về true nếu 2 cdr có cùng cấp là 1 và $p nằm sau $q
      if ($p->level_cdr == 1 && $arrIndex1[0] > $arrIndex2[0])
         return true;

      // Kiểm tra nếu 2 cdr có cùng cha      
      for ($i = 0; $i < $level - 1; $i++) {
         if ($arrIndex1[$i] != $arrIndex2[$i])
            $result = false;
      }

      // Nếu $p nằm trước hoặc ngang $q thì trả về false
      if ($arrIndex1[$level - 1] <= $arrIndex2[$level - 1])
         $result = false;

      // Trả về kết quả kiểm tra
      return $result;
   }   
   global $DB;
   $list_cdr = get_node_cdr_byMaCDR($ma_cay_cdr);
   $cdr = get_chuandaura_ctdt_byID($id);

   // Xóa các cdr-con của cdr cần xóa
   foreach ($list_cdr as $item) {
      if ($item->level_cdr > $cdr->level_cdr && strpos($item->ma_cdr, $cdr->ma_cdr) === 0) {
         $DB->delete_records('eb_chuandaura_ctdt', ['id' => $item->id]);
      }
   }

   // Xóa cdr
   $DB->delete_records('eb_chuandaura_ctdt', ['id' => $cdr->id]);

   /* Cập nhật mã cdr - các nội dung ảnh hưởng là các node cùng cây, cùng node cha, cùng level với $cdr */
   $same_level_in_tree = $DB->get_records('eb_chuandaura_ctdt', ['ma_cay_cdr' => $cdr->ma_cay_cdr, 'level_cdr' => $cdr->level_cdr]);
   foreach ($same_level_in_tree as $item) {

      // Xử lí các $cdr cùng cha nằm ở sau $cdr
      if (sameFather($item, $cdr)) {

         // Cập nhật các cdr con của item trước
         foreach ($list_cdr as $child) {
            if ($child->level_cdr > $item->level_cdr && strpos($child->ma_cdr, $item->ma_cdr) === 0) {

               // Cập nhật lại mã cdr
               $arrIndex = explode('.', $child->ma_cdr);
               $arrIndex[$item->level_cdr - 1]--;
               $newCode = '';
               foreach ($arrIndex as $index) {
                  ($newCode == '') ? $newCode .= $index : $newCode .= '.' . $index;
               }
               $child->ma_cdr = $newCode;
               $DB->update_record('eb_chuandaura_ctdt', $child, $bulk = false);
            }
         }

         // Cập nhật lại mã cdr
         $arrIndex = explode('.', $item->ma_cdr);
         $arrIndex[$item->level_cdr - 1]--;
         $newCode = '';
         foreach ($arrIndex as $index) {
            ($newCode == '') ? $newCode .= $index : $newCode .= '.' . $index;
         }
         $item->ma_cdr = $newCode;
         $DB->update_record('eb_chuandaura_ctdt', $item, $bulk = false);         
      }
   }
}

function delete_cdr_byMaCayCRT($ma_cay_cdr){
   global $DB, $USER, $CFG, $COURSE;
   $list = get_list_cdr_byMaCayCDR($ma_cay_cdr);

   foreach($list as $item){
      $DB->delete_records('eb_chuandaura_ctdt', ['id' => $item->id]);
   }
}