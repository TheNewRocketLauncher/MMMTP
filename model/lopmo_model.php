<?php
require_once(__DIR__ . '/../../../config.php');
require_once('../../controller/support.php');
require_once('../../../../course/lib.php');
require_once('../../../../course/edit_form.php');
require_once("$CFG->libdir/formslib.php");

 



function insert_lopmo($param)
{   
   global $DB, $USER, $CFG, $COURSE;
   $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $param->ma_ctdt]);
   $monhoc = $DB->get_record('eb_monhoc', ['mamonhoc' => $param->mamonhoc]);
   $monhoc->lopmo = 1;
   $DB->update_record('eb_monhoc', $monhoc, $bulk = false);
   $data = new stdClass();
   $category_id= 1;
   $data->category = $category_id;
   $data->fullname = $param->full_name;
   $data->shortname = $param->ma_ctdt . $param->short_name;
   $data->summary = '<p>Đây là môn toán</p>';
   // Params
   $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false, 'noclean'=>true);
   // $coursecontext = context_course::instance($course->id);
   $catcontext = context_coursecat::instance( $category_id);
   $editoroptions['context'] = $catcontext; //
   // $editoroptions['subdirs'] = file_area_contains_subdirs($coursecontext, 'course', 'summary', 0);

   $editoroptions['subdirs'] = 0;
   // Insert course
   // if(Db->count_records)
   $course = create_course($data, $editoroptions);

   $param->course_id = $course->id;
      $DB->insert_record('eb_lop_mo', $param);
}

function get_lopmo_byID($id)
{
   global $DB, $USER, $CFG, $COURSE;
   $lopmo = $DB->get_record('eb_lop_mo', ['id' => $id]);
   return $lopmo;
}




function update_lopmo($param)
{   
   global $DB, $USER, $CFG, $COURSE;
   $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $param->ma_ctdt]);
   $param->ma_nienkhoa = $ctdt->ma_nienkhoa;
   $param->ma_nganh = $ctdt->ma_nganh;
   $DB->update_record('eb_lop_mo', $param, $bulk = false);
}



function get_kkt_byMaKhoi($ma_khoi)
{
   global $DB, $USER, $CFG, $COURSE;
   if (userIsAdmin()) {

   $kkt = $DB->get_record('eb_khoikienthuc', ['ma_khoi' => $ma_khoi]);
   }else{
       $kkt = NULL;
}
   return $kkt;
}


function get_makhoi_from_mactdt($ma_ctdt){
   global $DB;
   $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);
   $caykkt = $DB->get_record('eb_cay_khoikienthuc' , ['ma_cay_khoikienthuc'  => $ctdt->ma_cay_khoikienthuc]);
   $ma_khoi = $caykkt->ma_khoi;
   return $ma_khoi;
}

function get_list_monhoc_from_makhoi($ma_khoi){
   global $DB;
   $listmonhoc = $DB->get_records('eb_monthuockhoi', ['ma_khoi' => $ma_khoi]);
   return $listmonhoc;
}

function get_ctdt_by_mactdt($ma_ctdt){
   global $DB;


   $data = array();
   $ctdt = $DB->get_record('eb_ctdt', ['ma_ctdt' => $ma_ctdt]);
    

   $tenbac = $DB->get_record('eb_bacdt', ['ma_bac' => $ctdt->ma_bac]);
   $data[] =& $tenbac->ten;

   $hedt = $DB->get_record('eb_hedt', ['ma_he' => $ctdt->ma_he]);
   $data[] =& $hedt->ten;

   $nienkhoa = $DB->get_record('eb_nienkhoa', ['ma_nienkhoa' => $ctdt->ma_nienkhoa]);
   $data[] =& $nienkhoa->ten_nienkhoa;

   $nganhdt = $DB->get_record('eb_nganhdt', ['ma_nganh' => $ctdt->ma_nganh]);
   $data[] =& $nganhdt->ten;

   $chuyennganh = $DB->get_record('eb_chuyennganhdt', ['ma_chuyennganh' => $ctdt->ma_chuyennganh]);
   $data[] =& $chuyennganh->ten;

   $data[] =& $ctdt->mota;
   return $data;
}

function get_lopmo($key_search = '', $page = 0, $ma_ctdt = '')
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   // Get course by ctdt   
   $alllopmos = $DB->get_records('eb_lop_mo', []);
   if ($ma_ctdt != '') {
      $alllopmos = $DB->get_records('eb_lop_mo', ['ma_ctdt' => $ma_ctdt]);
   }
   // Position
   $stt = 1 + $page * 20;
   $pos_in_table = 1;
   // Empty row
   $table->data[] = [];
   // Loop DB
   foreach ($alllopmos as $item) {
      if (findContent($item->full_name, $key_search) || $key_search == '') {
      $course_id = 1;
      $course_id = $item->course_id;
      $url = new \moodle_url('/course/view.php', [ 'id' => $course_id]);
      $ten_url = \html_writer::link($url, $item->full_name);
      if ($page < 0) { // Get all data without page
         $html = '<div style = "font-size: 1.640625rem; font-weight: 300; line-height: 1.2;background-image: url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat; padding-left: 50px;">'.$ten_url.'</div>'.'<div style = "text-align: center">' . $item->mota . '</div>';
         $table->data[] = [$html];
         $stt = $stt + 1;
      } else if ($pos_in_table > $page * 20 && $pos_in_table <= $page * 20 + 20) {
         $html = '<div style = "font-size: 1.640625rem; font-weight: 300; line-height: 1.2;background-image: url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat; padding-left: 50px;">'.$ten_url.'</div>'.'<div style = "text-align: center">' . $item->mota . '</div>';
         $table->data[] = [$html];
         $stt = $stt + 1;
      }
      $pos_in_table = $pos_in_table + 1;

      }
   }
   return $table;
}


function get_danhmuc_lopmo()
{
   global $DB;
   // Begin
   $action_form =
   html_writer::start_tag('div', array('style' => 'display: block; padding: 15px;'));

   // Lấy ra danh sách danh mục
   $arr_danhmuc = array();
   $alllopmos = $DB->get_records('eb_lop_mo', []);
   foreach($alllopmos as $ilopmo) {
      // print_r($ilopmo); 
      $data = new stdClass();
      $data->nam_hoc = $ilopmo->nam_hoc;
      $data->hoc_ky = $ilopmo->hoc_ky;
      // Thêm vào danh sách

      $isExist = false;
      foreach ($arr_danhmuc as $item) {
         if ($item->nam_hoc == $data->nam_hoc && $item->hoc_ky == $data->hoc_ky)
            $isExist = true;
      }
      if (!$isExist)
         $arr_danhmuc[] = $data;     
   }

   // In ra danh sách danh mục
   foreach($arr_danhmuc as $item) {
      // $infor->nam_hoc = 2017;
      // $infor->hoc_ky = 3;
      $tendanhmuc = "Học kỳ " . $item->hoc_ky . " (". $item->nam_hoc . "-" . ($item->nam_hoc + 1) . ")";
      $ref = $CFG->wwwroot . 'view_semester.php?namhoc=' . $item->nam_hoc . '&hocky=' . $item->hoc_ky;

      $action_form .= html_writer::tag(
         'button',
         "<p style='margin:0'><a href='".$ref."' style='color:#fff;font-size: 24px;'>".$tendanhmuc."</a></p>",
         array(
            'onClick' => "window.location.href='".$ref."'",
            'style' => 'margin:20px;border: none;border-radius: 40px 10px 40px 10px;width: 250px; height:150px;background-color: #1177d1;color: #fff;'
         )
      );      
   }

   // End
   $action_form .= html_writer::end_tag('div');

   // Return
   return $action_form;
}

function get_lopmo_thuoc_danhmuc($key_search = '', $page = 0, $nam_hoc = 0, $hoc_ky = 0)
{
   global $DB, $USER, $CFG, $COURSE;
   $table = new html_table();
   // Get course by ctdt   
   $alllopmos = $DB->get_records('eb_lop_mo', ['nam_hoc' => $nam_hoc, 'hoc_ky' => $hoc_ky]);
   // $alllopmos = $DB->get_records('eb_lop_mo', []);
   // Position
   $stt = 1 + $page * 20;
   $pos_in_table = 1;
   // Empty row
   $table->data[] = [];
   // Loop DB
   foreach ($alllopmos as $item) {
      if (findContent($item->full_name, $key_search) || $key_search == '') {
      $course_id = 1;
      $course_id = $item->course_id;
      $url = new \moodle_url('/course/view.php', [ 'id' => $course_id]);
      $ten_url = \html_writer::link($url, $item->full_name);
      if ($page < 0) { // Get all data without page
         $html = '<div style = "font-size: 1.640625rem; font-weight: 300; line-height: 1.2;background-image: url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat; padding-left: 50px;">'.$ten_url.'</div>'.'<div style = "text-align: center">' . $item->mota . '</div>';
         $table->data[] = [$html];
         $stt = $stt + 1;
      } else if ($pos_in_table > $page * 20 && $pos_in_table <= $page * 20 + 20) {
         $html = '<div style = "font-size: 1.640625rem; font-weight: 300; line-height: 1.2;background-image: url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat; padding-left: 50px;">'.$ten_url.'</div>'.'<div style = "text-align: center">' . $item->mota . '</div>';
         $table->data[] = [$html];
         $stt = $stt + 1;
      }
      $pos_in_table = $pos_in_table + 1;
      }
   }
   return $table;
}