<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
// require_once('../../controller/auth.php');
$list_quyen_id = required_param('list_quyen_id', PARAM_NOTAGS);
$role_id = required_param('role_id', PARAM_NOTAGS);
require_once('../../controller/auth.php');
require_permission("", "");
function updateQuyen($role_id, $list_quyen_id)
{

    // echo $role_id;
    // echo "update";

    // echo $list_quyen_id;

    global $DB;
    $list_quyen = $DB->get_records('eb_quyen', []);
    // echo $list_quyen;
    // foreach ($list_quyen as $item) {
    //     echo $item->ten;
    // }
    // // $arr_quyen_update = explode(",",$list_quyen_update);


    // // foreach($arr_quyen_update as $item){
    // //     $current_quyen = $DB->get_record('eb_quyen', ['id' => $item]);
    // //     if (!isHave($current_quyen->list_role, $role_id)) {
    // //     }
    // // }


    foreach ($list_quyen as $item) {
        echo " list_quyen_id ";
        echo $list_quyen_id;
        echo "- itemid ";

        echo $item->id;
        echo "- itemrole ";
        echo $item->list_role;

        echo " role_id ";
        echo $role_id;

        echo "<br>";
        // if (strpos($list_quyen_id, $item->id) !== false) {
        //     echo "co";
        // }
        $arr_list_quyen_id = explode(",", $list_quyen_id);

        // if (in_array($item->id, $arr_list_quyen_id)) {

        if (in_array($item->id, $arr_list_quyen_id)) {

            echo " co quyen nay ";
            if (strpos($item->list_role, $role_id) !== false) {
                // echo "nhung da co role nay";
            } else {

                // echo " nhung chua co role nay";
                $item->list_role = $item->list_role . "," . $role_id;
                // echo "list_role_new";
                $DB->update_record('eb_quyen', $item, $bulk = false);
                // echo $item->list_role;
            }
        } else {
            echo " k co quyen nay ";
            if (strpos($item->list_role, $role_id) !== false) {

                // echo "nhung co role nay";
                $arr_role = array();
                $arr_role = explode(",", $item->list_role);
                $inx = 0;
                foreach ($arr_role as $item2) {
                    if ($item2 == $role_id) {
                        unset($arr_role[$inx]);
                    }
                    $inx++;
                }
                $list_role = implode(",", $arr_role);
                $item->list_role = $list_role;
                $DB->update_record('eb_quyen', $item, $bulk = false);
                // echo "list_role_new";

                // echo $item->list_role;


                // echo "isHave";
            } else {
                // echo "nhung k co role nay";
            }
        }
    }

    // $current_quyen = $DB->get_record('eb_quyen', ['id' => $id]);
    // $current_quyen->list_role = $list_role_update;
    // $DB->update_record('eb_quyen', $current_quyen, $bulk = false);
    // return;
}


// Clone b?c dào t?o có id truy?n vào
updateQuyen($role_id, $list_quyen_id);
// return
// $output = "hello";
// echo $output;
// 
function checkExistArray($list, $item)
{
}


exit;
