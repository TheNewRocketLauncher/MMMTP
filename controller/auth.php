<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');

/* Các tài khoản superadmin có quyền truy cập cao nhất */
function require_permission($list_hople)
{
  global $DB, $USER;

  // Danh sách tài khoản super admin
  $super_admins = ['admin', 'admina'];

  // Quyền của user hiện tại
  $role_user = $DB->get_record('role_assignments', ['userid' => $USER->id]);
  $hople = false;

  // Kiểm tra role của user có nằm trong danh sách role có quyền hợp lệ của trang hay không?
  foreach ($list_hople as $item) {
    if ($item == $role_user->roleid)
      $hople = true;
  }
  
  // Kiểm tra xem user có phải superadmin không?
  $currentUser = $DB->get_record('user', ['id' => $USER->id]);  
  foreach ($super_admins as $super_admin) {
    if($currentUser->username == $super_admin) {
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
