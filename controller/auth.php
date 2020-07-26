<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');
/* Các tài khoản superadmin có quyền truy cập cao nhất */
function get_list_role()
{
    global $DB;
    $list_role = $DB->get_records('role', []);
    $table = new html_table();
    $table->head = array('stt', 'Chức năng');
    $stt = 1;

    foreach ($list_role as $item) {
        $url = new \moodle_url('/blocks/educationpgrs/pages/quyen/update.php', ['id' => $item->id]);
        $ten_url = \html_writer::link($url, $item->shortname);
        $table->data[] = [(string) $stt, (string) $ten_url];
        $stt = $stt + 1;
    }

    return $table;
}

function get_list_quyen($role_id)
{
    global $DB;


    $table = new html_table();
    $table->head = array('stt', 'Chức năng', ' ');

    $list_quyen = $DB->get_records('eb_quyen', []);

    $stt = 1;
    foreach ($list_quyen as $item) {
        if (strpos($item->list_role, strval($role_id)) !== false) {
            $checkbox = html_writer::tag('input', ' ', array('class' => 'quyencheckbox', 'checked' => " ", 'type' => "checkbox", 'name' => $role_id, 'id' => $item->id, 'value' => '1', 'onclick' => "changecheck_quyen($item->id)"));
        } else {
            $checkbox = html_writer::tag('input', ' ', array('class' => 'quyencheckbox', 'type' => "checkbox", 'name' => $role_id, 'id' => $item->id, 'value' => '0', 'onclick' => "changecheck_quyen($item->id)"));
        }
        $table->data[] = [(string) $stt, (string) $item->ten, $checkbox];
        $stt = $stt + 1;
    }

    return $table;
}




function isHave($list, $item)
{

    if (strpos($list, $item) !== false) {
        return true;
    }
    return false;


    //cach 2
    //   if (str_contains('How are you', 'are')) { 
    //     echo 'true';
    // }
}


function require_permission($page, $chucnang)
{
    global $DB, $USER;
    $list_quyen = $DB->get_records('eb_quyen', []);
    if (count($list_quyen) < 1) {
        insert_quyen();
    }
    // Danh sách tài khoản super admin

    $hople = false;

    //check superadmin
    $super_admins = ['admin', 'admina'];
    $currentUser = $DB->get_record('user', ['id' => $USER->id]);
    foreach ($super_admins as $super_admin) {
        if ($currentUser->username == $super_admin) {
            $hople = true;
        }
    }



    // check cure
    $current_role = ($DB->get_record('role_assignments', ['userid' => $USER->id]))->roleid;
    $list_role = $DB->get_record('eb_quyen', ['page' => $page, 'chucnang' => $chucnang]);
    if (!$list_role) {
    } else if ($hople == false) {
        if (isHave($list_role->list_role, $current_role)) {
            $hople = true;
        }
    }


    // Xử lí nếu không hợp lệ thì in ra lỗi
    if ($hople) {
        // Do nothing
    } else {
        print_error('accessdenied', 'admin');
    }
}


function insert_quyen()
{
    global $DB;

    $dataObj1 = new stdClass();
    $dataObj1->id = '1';
    $dataObj1->page = 'bacdt';
    $dataObj1->chucnang = 'view';
    $dataObj1->ten = 'Xem bậc đào tạo';
    $dataObj1->list_role = "1,2,3";

    $dataObj1_ = new stdClass();
    $dataObj1_->id = '2';
    $dataObj1_->page = 'bacdt';
    $dataObj1_->chucnang = 'edit';
    $dataObj1_->ten = 'Chỉnh sửa bậc đào tạo ( Sửa, Xóa , Clone)';
    $dataObj1_->list_role = "1,2,3";

    $dataObj2 = new stdClass();
    $dataObj2->id = '3';
    $dataObj2->page = 'caykkt';
    $dataObj2->chucnang = 'view';
    $dataObj2->ten = 'Xem cây khối kiến thức';
    $dataObj2->list_role = "1,2,3";

    $dataObj2_ = new stdClass();
    $dataObj2_->id = '4';
    $dataObj2_->page = 'caykkt';
    $dataObj2_->chucnang = 'edit';
    $dataObj2_->ten = 'Chỉnh sửa cây khối kiến thức ( Sửa, Xóa , Clone)';
    $dataObj2_->list_role = "1,2,3";

    $dataObj3_ = new stdClass();
    $dataObj3_->id = '5';
    $dataObj3_->page = 'chuandauractdt';
    $dataObj3_->chucnang = 'view';
    $dataObj3_->ten = 'Xem chuẩn đầu ra chương trình đào tạo';
    $dataObj3_->list_role = "1,2,3";

    $dataObj3 = new stdClass();
    $dataObj3->id = '6';
    $dataObj3->page = 'chuandauractdt';
    $dataObj3->chucnang = 'edit';
    $dataObj3->ten = 'Chỉnh sửa chuẩn đầu ra chương trình đào tạo ( Sửa, Xóa , Clone)';
    $dataObj3->list_role = "1,2,3";

    $dataObj4 = new stdClass();
    $dataObj4->id = '7';
    $dataObj4->page = 'chuyennganhdt';
    $dataObj4->chucnang = 'view';
    $dataObj4->ten = 'Xem chuyên ngành đào tạo';
    $dataObj4->list_role = "1,2,3";

    $dataObj4_ = new stdClass();
    $dataObj4_->id = '8';
    $dataObj4_->page = 'chuyennganhdt';
    $dataObj4_->chucnang = 'edit';
    $dataObj4_->ten = 'Chỉnh sửa chuyên ngành đào tạo ( Sửa, Xóa , Clone)';
    $dataObj4_->list_role = "1,2,3";

    $dataObj5_ = new stdClass();
    $dataObj5_->id = '9';
    $dataObj5_->page = 'ctdt';
    $dataObj5_->chucnang = 'view';
    $dataObj5_->ten = 'Xem chương trình đào tạo';
    $dataObj5_->list_role = "1,2,3";

    $dataObj5 = new stdClass();
    $dataObj5->id = '10';
    $dataObj5->page = 'ctdt';
    $dataObj5->chucnang = 'edit';
    $dataObj5->ten = 'Chỉnh sửa chương trình đào tạo ( Sửa, Xóa , Clone)';
    $dataObj5->list_role = "1,2,3";

    $dataObj6 = new stdClass();
    $dataObj6->id = '11';
    $dataObj6->page = 'decuong';
    $dataObj6->chucnang = 'view';
    $dataObj6->ten = 'Xem đề cương môn học';
    $dataObj6->list_role = "1,2,3";

    $dataObj6_ = new stdClass();
    $dataObj6_->id = '12';
    $dataObj6_->page = 'decuong';
    $dataObj6_->chucnang = 'edit';
    $dataObj6_->ten = 'Chỉnh sửa đề cương môn học ( Sửa, Xóa , Clone)';
    $dataObj6_->list_role = "1,2,3";

    $dataObj7 = new stdClass();
    $dataObj7->id = '13';
    $dataObj7->page = 'hedt';
    $dataObj7->chucnang = 'view';
    $dataObj7->ten = 'Xem hệ đào tạo';
    $dataObj7->list_role = "1,2,3";

    $dataObj7_ = new stdClass();
    $dataObj7_->id = '14';
    $dataObj7_->page = 'hedt';
    $dataObj7_->chucnang = 'edit';
    $dataObj7_->ten = 'Chỉnh sửa hệ đào tạo ( Sửa, Xóa , Clone)';
    $dataObj7_->list_role = "1,2,3";

    $dataObj8 = new stdClass();
    $dataObj8->id = '15';
    $dataObj8->page = 'khoikienthuc';
    $dataObj8->chucnang = 'view';
    $dataObj8->ten = 'Xem khối kiến thức';
    $dataObj8->list_role = "1,2,3";

    $dataObj8_ = new stdClass();
    $dataObj8_->id = '16';
    $dataObj8_->page = 'khoikienthuc';
    $dataObj8_->chucnang = 'edit';
    $dataObj8_->ten = 'Chỉnh sửa khối kiến thức ( Sửa, Xóa , Clone)';
    $dataObj8_->list_role = "1,2,3";

    $dataObj9 = new stdClass();
    $dataObj9->id = '17';
    $dataObj9->page = 'lopmo';
    $dataObj9->chucnang = 'view';
    $dataObj9->ten = 'Xem lớp mở';
    $dataObj9->list_role = "1,2,3";

    $dataObj9_ = new stdClass();
    $dataObj9_->id = '18';
    $dataObj9_->page = 'lopmo';
    $dataObj9_->chucnang = 'edit';
    $dataObj9_->ten = 'Chỉnh sửa lớp mở ( Sửa, Xóa , Clone)';
    $dataObj9_->list_role = "1,2,3";

    $dataObj10 = new stdClass();
    $dataObj10->id = '19';
    $dataObj10->page = 'monhoc';
    $dataObj10->chucnang = 'view';
    $dataObj10->ten = 'Xem môn học';
    $dataObj10->list_role = "1,2,3";

    $dataObj10_ = new stdClass();
    $dataObj10_->id = '20';
    $dataObj10_->page = 'monhoc';
    $dataObj10_->chucnang = 'edit';
    $dataObj10_->ten = 'Chỉnh sửa môn học ( Sửa, Xóa , Clone)';
    $dataObj10_->list_role = "1,2,3";

    $dataObj11 = new stdClass();
    $dataObj11->id = '21';
    $dataObj11->page = 'nganhdt';
    $dataObj11->chucnang = 'view';
    $dataObj11->ten = 'Xem ngành đào tạo';
    $dataObj11->list_role = "1,2,3";

    $dataObj11_ = new stdClass();
    $dataObj11_->id = '22';
    $dataObj11_->page = 'nganhdt';
    $dataObj11_->chucnang = 'edit';
    $dataObj11_->ten = 'Chỉnh sửa ngành đào tạo ( Sửa, Xóa , Clone)';
    $dataObj11_->list_role = "1,2,3";

    $dataObj12 = new stdClass();
    $dataObj12->id = '23';
    $dataObj12->page = 'nienkhoa';
    $dataObj12->chucnang = 'view';
    $dataObj12->ten = 'Xem niên khóa';
    $dataObj12->list_role = "1,2,3";

    $dataObj12_ = new stdClass();
    $dataObj12_->id = '24';
    $dataObj12_->page = 'nienkhoa';
    $dataObj12_->chucnang = 'edit';
    $dataObj12_->ten = 'Chỉnh sửa niên khóa ( Sửa, Xóa , Clone)';
    $dataObj12_->list_role = "1,2,3";

    $dataObj13 = new stdClass();
    $dataObj13->page = 'import';
    $dataObj13->chucnang = '';
    $dataObj13->ten = 'Các chức năng import';
    $dataObj13->list_role = "1,2,3";



    $DB->insert_record('eb_quyen', $dataObj1);
    $DB->insert_record('eb_quyen', $dataObj1_);
    $DB->insert_record('eb_quyen', $dataObj7);
    $DB->insert_record('eb_quyen', $dataObj7_);
    $DB->insert_record('eb_quyen', $dataObj2);
    $DB->insert_record('eb_quyen', $dataObj2_);
    $DB->insert_record('eb_quyen', $dataObj3_);
    $DB->insert_record('eb_quyen', $dataObj3);

    $DB->insert_record('eb_quyen', $dataObj4);
    $DB->insert_record('eb_quyen', $dataObj4_);
    $DB->insert_record('eb_quyen', $dataObj5_);

    $DB->insert_record('eb_quyen', $dataObj5);
    $DB->insert_record('eb_quyen', $dataObj6);
    $DB->insert_record('eb_quyen', $dataObj6_);

    $DB->insert_record('eb_quyen', $dataObj8);
    $DB->insert_record('eb_quyen', $dataObj8_);
    $DB->insert_record('eb_quyen', $dataObj9);
    $DB->insert_record('eb_quyen', $dataObj9_);
    $DB->insert_record('eb_quyen', $dataObj10);
    $DB->insert_record('eb_quyen', $dataObj10_);
    $DB->insert_record('eb_quyen', $dataObj11);
    $DB->insert_record('eb_quyen', $dataObj11_);
    $DB->insert_record('eb_quyen', $dataObj12);
    $DB->insert_record('eb_quyen', $dataObj12_);
    $DB->insert_record('eb_quyen', $dataObj13);
}
