<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/decuong_model.php');
require_once('../../model/khoikienthuc_model.php');
require_once('../../model/chuandaura_ctdt_model.php');


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
require_permission("import", "");


// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/decuong/index.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
$PAGE->navbar->add('Import chương trình đào tạo', new moodle_url('/blocks/educationpgrs/pages/import/import_ctdt.php'));

// Title.
$PAGE->set_title(get_string('label_quanly_decuong', 'block_educationpgrs') . ' - Course ID: ' . $COURSE->id);
$PAGE->set_heading('Import chương trình đào tạo');
global $CFG;
$CFG->cachejs = false;
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");


class form1 extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('filepicker', 'userfile', 'File .CSV nhập vào chương trình đào tạo', null, array('maxbytes' => $maxbytes, 'accepted_types' => '.csv'));
        $mform->addRule('userfile', 'Khong phai file csv', 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'HIỂN THỊ DỮ LIỆU');
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
        $eGroup[] = &$mform->createElement('submit', 'btn_get_content', 'Tạo mới chương trình đào tạo');
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
$array_toDB = array(); // new table


//////////////////////////////////FORM 1 //////////////////////////////////

if ($form->is_cancelled()) {
} else if ($form->no_submit_button_pressed()) {
} else if ($fromform = $form->get_data()) {

    $name = $form->get_new_filename('userfile');


    $rex = $form->save_temp_file('userfile');

    redirect($CFG->wwwroot . '/blocks/educationpgrs/pages/import/import_ctdt.php?linkto=' . $rex);


    echo "<br>";
    echo "<br>";
    echo "<br>";
} else if ($form->is_submitted()) {

    $form->display();
    echo "<h2>Dữ liệu trống</h2>";
} else {

    $toform;

    $form->display();
}

//////////////////////////////////FORM 1 //////////////////////////////////

if ($mform2->is_cancelled()) {
} else if ($mform2->no_submit_button_pressed()) {
} else if ($fromform = $mform2->get_data()) {

    if ($fromform->link != null) {

        $index = 1;
        $arr_thongtin_ctdt = array();
        $arr_muctieuchung = array();
        $arr_muctieucuthe = array();
        $arr_chuandaura_ctdt = array();
        $arr_loai_cdr = array();
        $arr_cohoinghenghiep = array();
        $thoigian_daotao;
        $khoiluongkienthuc;
        $doituongtuyensinh;
        $quytrinhdaotao;
        $dieukientotnghiep;
        $arr_khoikienthuc = array();
        $arr_caykhoikienthuc = array();
        $arr_monhoc = array();

        if (($handle = fopen($fromform->link, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                global $ma_cdr_cha;

                if ($data[0] == 9 || $data[0] == '9') {
                    $arr_thongtin_ctdt[] = [
                        'ma_bac' => $data[1], 'ten_bac' => $data[2], 'ma_he' => $data[3], 'ten_he' => $data[4],
                        'ma_nienkhoa' => $data[5], 'ten_nienkhoa' => $data[6], 'ma_nganh' => $data[7], 'ten_nganh' => $data[8],
                        'ma_chuyennganh' => $data[9], 'ten_chuyennganh' => $data[10], 'ten_chuongtrinh' => $data[11], 'ma_ctdt' => $data[12], 'mota' => $data[13]
                    ];
                } else
                if ($data[0] == 1 || $data[0] == '1') {
                    $arr_muctieuchung[] = ['title_muctieuchung' => $data[1]];
                } else
                if ($data[0] == 1.1 || $data[0] == '1.1') {
                    $arr_muctieuchung[] = ['noidung_muctieuchung' => $data[1]];
                } else
                if ($data[0] == 1.2 || $data[0] == '1.2') {
                    $arr_muctieucuthe[] = ['noidung_muctieucuthe' => $data[1]];
                } else
                if ($data[0] == 1.3 || $data[0] == '1.3') {
                    $arr_chuandaura_ctdt[] = ['ma_tt' => $data[1], 'ten' => $data[2], 'level' => $data[3], 'ma_loai' => $data[4]];
                } else
                if ($data[0] == 4 || $data[0] == '4') {
                    $arr_cohoinghenghiep[] = ['title_cohoi' => $data[1]];
                } else
                if ($data[0] == 5 || $data[0] == '5') {
                    $arr_loai_cdr[] = ['ma_loai' => $data[1], 'ten' => $data[2]];
                } else
                if ($data[0] == 1.4 || $data[0] == '1.4') {
                    $arr_cohoinghenghiep[] = ['noidung_cohoi' => $data[1]];
                } else
                if ($data[0] == 1.5 || $data[0] == '1.5') {
                    $thoigian_daotao = $data[1];
                } else
                if ($data[0] == 1.6 || $data[0] == '1.6') {
                    $khoiluongkienthuc = $data[1];
                } else
                if ($data[0] == 1.7 || $data[0] == '1.7') {
                    $doituongtuyensinh = $data[1];
                } else
                if ($data[0] == 1.8 || $data[0] == '1.8') {
                    $quytrinhdaotao = $data[1];
                } else
                if ($data[0] == 1.9 || $data[0] == '1.9') {
                    $dieukientotnghiep = $data[1];
                } else
                if ($data[0] == 2.4 || $data[0] == '2.4') {
                    $arr_caykhoikienthuc[] =  ['ma_tt' => $data[1], 'ma_khoi' => $data[2], 'ma_khoicha' => $data[3]];
                } else
                if ($data[0] == 2.5 || $data[0] == '2.5') {
                    $arr_monhoc[] =  ['mamonhoc' => $data[1], 'tenmonhoc' => $data[2], 'sotc' => $data[3], 'sotiet_lt' => $data[4], 'sotiet_th' => $data[5], 'sotiet_bt' => $data[6], 'loaihocphan' => $data[7], 'ghichu' => $data[8]];
                } else
                if (($data[0] == 2.3 || $data[0] == '2.3')) {

                    if ($data[1] != 0) {

                        // Continue khoi
                        $ma_khoi = $data[2];
                        $current_khoi = $arr_khoikienthuc[$ma_khoi];

                        if ($current_khoi !== NULL) {
                            $arr_khoikienthuc[$ma_khoi] = push_data_to_khoi_copy($current_khoi, $data, $ma_khoi);
                        } else {
                            $arr_khoikienthuc[$ma_khoi] = array();
                            $arr_khoikienthuc[$ma_khoi] = push_data_to_khoi_copy($current_khoi, $data, $ma_khoi);
                        }
                    }
                }
            }


            fclose($handle);
        }


        /////////////////////////CHECK/////////////////////////

        // $is_check_ctdt_hople = check_ctdt_hople($arr_thongtin_ctdt);
        $is_check_ctdt_hople = true;
        echo "<strong style='text-decoration: underline;'>LOG</strong>";
        echo "<br>";

        if (!$is_check_ctdt_hople) { // hople
            echo 'Chương trình đào tạo <strong>' . $arr_thongtin_ctdt[0]['ma_ctdt'] . ' - ' . $arr_thongtin_ctdt[0]['ten_chuongtrinh'] . '</strong> không hợp lệ hoặc đã tồn tại';
            echo "<br>";
        }

        if ($is_check_ctdt_hople) {

            //insert chuan dau ra

            foreach ($arr_loai_cdr as $item) {

                $param->ten = $item['ten'];
                $param->ma_loai = $item['ma_loai'];
                $arr_2 = get_ma_loai();

                $check_db = -1;

                $check_db = is_check($item,  $arr_2, "loai_cdr");
                if ($check_db == 0) {
                    insert_loai_cdr($param);
                }
            }

            foreach ($arr_chuandaura_ctdt as $item) {

                $param = new stdClass();
                $param->ma_cdr = mt_rand();
                if ($item['level'] == 1 || $item['level'] == '1') {
                    $param->ma_cdr_cha = 0;

                    $ma_cdr_cha = $param->ma_cdr;
                } else if ($item['level'] == 2 || $item['level'] == '2') {
                    $param->ma_cdr_cha = $ma_cdr_cha;
                }
                $param->ten = $item['ten'];
                $param->level = $item['level'];
                $param->ma_loai = $item['ma_loai'];

                $arr_2 = get();
                $check_db = -1;
                $check_db = is_check($item,  $arr_2, "cdr_ctdt");
                if ($check_db == 0) {
                    insert_cdr_ctdt($param);
                    if ($item['level'] == 1 || $item['level'] == '1') {
                        $param->ma_ctdt = $arr_thongtin_ctdt[0]['ma_ctdt'];
                        insert_ctdt_noi_cdr($param);
                    }
                }
            }


            //     $param = new stdClass();
            //     $param->ma_cay_cdr = $item['ma_cay_cdr'];
            //     $param->ma_cdr = $item['ma_cdr'];
            //     $param->ten =  $item['ten'];
            //     $param->mota = $item['mota'];
            //     $param->level_cdr = $item['level_cdr'];

            //     $arr_2 = get();
            //     $check = is_check($param->ma_cdr, $param->ma_cay_cdr, $arr_2);

            //     if ($check == false) {
            //         $check2 = is_check($param->ma_cdr, $param->ma_cay_cdr,  $i_chuandaura);
            //         if ($check2 == false) {
            //             if ($item['ma_cay_cdr'] == 'ma_cay_cdr' || $item['level_cdr'] == 'level_cdr') {
            //             } else {
            //                 $i_chuandaura[] = [
            //                     'ma_cay_cdr' => $item['ma_cay_cdr'], 'ma_cdr' => $item['ma_cdr'],
            //                     'ten' => $item['ten'], 'mota' => $item['mota'], 'level_cdr' => $item['level_cdr']
            //                 ];
            //             }
            //         } else {
            //             echo 'Chuẩn đầu ra <strong>' . $item['ma_cdr'] . ' - ' . $item['ma_cay_cdr'] . ' - ' . $item['ten'] . '</strong> lặp lại';
            //             echo "<br>";
            //         }
            //     } else {
            //         echo 'Chuẩn đầu ra  <strong>' . $item['ma_cdr'] . ' - ' . $item['ma_cay_cdr'] . ' - ' . $item['ten'] . '</strong> lặp lại';
            //         echo "<br>";
            //     }
            // }
            // if (count($i_chuandaura) > 0) {

            //     foreach ($i_chuandaura as $ii_chuandaura) {

            //         $param = new stdClass();
            //         $param->ma_cay_cdr = $ii_chuandaura['ma_cay_cdr'];
            //         $param->ma_cdr = $ii_chuandaura['ma_cdr'];
            //         $param->ten =  $ii_chuandaura['ten'];
            //         $param->mota = $ii_chuandaura['mota'];
            //         $param->is_used = 0;
            //         $param->level_cdr = $ii_chuandaura['level_cdr'];

            //         // insert('eb_chuandaura_ctdt', $param);
            //         // lock_cdr($param->ma_cay_cdr);
            //     }
            // }


            //insert mon hoc

            foreach ($arr_monhoc as $iarr_monhoc) {

                $check = requiredRules('eb_monhoc', 'mamonhoc',  $iarr_monhoc['mamonhoc']);
                if ($check) {
                    $param = new stdClass();
                    $param->mamonhoc = $iarr_monhoc['mamonhoc'];
                    $param->tenmonhoc_vi = $iarr_monhoc['tenmonhoc'];
                    $param->tenmonhoc_en =  ' ';
                    $param->lopmo = 0;
                    $param->loaihocphan = ' ';

                    $param->sotinchi = $iarr_monhoc['sotc'];
                    $param->sotietlythuyet = $iarr_monhoc['sotiet_lt'];
                    $param->sotietthuchanh =  $iarr_monhoc['sotiet_th'];
                    $param->sotiet_baitap = $iarr_monhoc['sotiet_bt'];
                    $param->ghichu = $iarr_monhoc['ghichu'];
                    $param->mota = null;

                    insert('eb_monhoc', $param);
                } else {
                    echo 'Môn học <strong>' . $iarr_monhoc['mamonhoc'] . ' - ' . $iarr_monhoc['tenmonhoc'] . '</strong> lặp lại';
                    echo "<br>";
                }
            }

            //insert khoi kien thuc

            $check_kkt = 0;

            $arr_error_khoikienthuc = get_errors_khoi_when_insert($arr_khoikienthuc);

            foreach ($arr_error_khoikienthuc as $iarr_error_khoikienthuc) {
                echo 'Khối kiến thức <strong> ' . $iarr_error_khoikienthuc['ma_khoi'] . '</strong> lặp lại';
                echo "<br>";
                $check_kkt = 1;
            }



            if ($check_kkt == 0) {
                insert_import_kkt($arr_khoikienthuc);
            }


            //insert cay khoi kien thuc

            $cay_tong_hop_1 = tonghop_cay($arr_khoikienthuc, $arr_caykhoikienthuc);
            $cay_tong_hop_1[0] = [
                'ten_cay' => $arr_caykhoikienthuc[0]['ma_khoi'], 'mota' => $arr_caykhoikienthuc[0]['ma_khoicha'],
                'ma_tt' => $arr_caykhoikienthuc[0]['ma_tt']
            ];


            $ma_cay_kkt = insert_import_caykkt($cay_tong_hop_1);

            //insert ctdt

            //ctdt
            $param_ctdt = new stdClass();

            $param_ctdt->ma_ctdt = $arr_thongtin_ctdt[0]['ma_ctdt'];
            // $param_ctdt->ma_bac = $arr_thongtin_ctdt[0]['ma_bac'];
            // $param_ctdt->ma_he = $arr_thongtin_ctdt[0]['ma_he'];
            // $param_ctdt->ma_nienkhoa = $arr_thongtin_ctdt[0]['ma_nienkhoa'];
            // $param_ctdt->ma_nganh = $arr_thongtin_ctdt[0]['ma_nganh'];
            // $param_ctdt->ma_chuyennganh = $arr_thongtin_ctdt[0]['ma_chuyennganh'];


            $muctieu_daotao = array();
            $muctieu_daotao[] .= $arr_muctieuchung[0]['title_muctieuchung'];
            foreach ($arr_muctieuchung as $iarr_muctieuchung) {
                if ($iarr_muctieuchung['noidung_muctieuchung']) {
                    $muctieu_daotao[] .= $iarr_muctieuchung['noidung_muctieuchung'];
                }
            }
            $param_ctdt->muctieu_daotao = $muctieu_daotao[0];



            $muctieu_cuthe = array();
            foreach ($arr_muctieucuthe as $iarr_muctieucuthe) {
                if ($iarr_muctieucuthe['noidung_muctieucuthe']) {
                    $muctieu_cuthe[] .= $iarr_muctieucuthe['noidung_muctieucuthe'];
                }
            }
            $param_ctdt->muctieu_cuthe = $muctieu_cuthe[0];


            // $param_ctdt->chuandaura = $i_chuandaura[1]['ma_cay_cdr']; //chua biet insert sao


            $cohoi_nghenghiep = array();
            $cohoi_nghenghiep[] .= $arr_cohoinghenghiep[0]['title_cohoi'];
            foreach ($arr_cohoinghenghiep as $iarr_cohoinghenghiep) {
                if ($iarr_cohoinghenghiep['noidung_cohoi']) {
                    $cohoi_nghenghiep[] .= $iarr_cohoinghenghiep['noidung_cohoi'];
                }
            }
            $param_ctdt->cohoi_nghenghiep = $cohoi_nghenghiep[0];

            $param_ctdt->thoigian_daotao = $thoigian_daotao;

            $param_ctdt->khoiluong_kienthuc = $khoiluongkienthuc;

            $param_ctdt->doituong_tuyensinh = $doituongtuyensinh;

            $param_ctdt->quytrinh_daotao = $quytrinhdaotao;

            $param_ctdt->dieukien_totnghiep = $dieukientotnghiep;

            $param_ctdt->ma_cay_khoikienthuc = $ma_cay_kkt;

            $param_ctdt->mota = $arr_thongtin_ctdt[0]['mota'];



            // if ($param_ctdt->chuandaura != null && $param_ctdt->chuandaura != '') {

            insert('eb_ctdt', $param_ctdt);
            // }
        }
    }
} else if ($mform2->is_submitted()) {
} else { //SETTING BEFORE


    $toform;
    $toform->link = $link;
    $mform2->set_data($toform);

    $ma_decuong = null;

    if ($link != null) {
        $index = 1;

        $arr_thongtin_ctdt = array();
        $arr_muctieuchung = array();
        $arr_muctieucuthe = array();
        $arr_chuandaura_ctdt = array();
        $arr_loai_cdr = array();
        $arr_cohoinghenghiep = array();
        $arr_loai_cdr = array();
        $thoigian_daotao;
        $khoiluongkienthuc;
        $doituongtuyensinh;
        $quytrinhdaotao;
        $dieukientotnghiep;
        $arr_khoikienthuc = array();
        $arr_caykhoikienthuc = array();
        $arr_monhoc = array();

        if (($handle = fopen($link, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if ($data[0] == 9 || $data[0] == '9') {
                    $arr_thongtin_ctdt[] = [
                        'ma_bac' => $data[1], 'ten_bac' => $data[2], 'ma_he' => $data[3], 'ten_he' => $data[4],
                        'ma_nienkhoa' => $data[5], 'ten_nienkhoa' => $data[6], 'ma_nganh' => $data[7], 'ten_nganh' => $data[8],
                        'ma_chuyennganh' => $data[9], 'ten_chuyennganh' => $data[10], 'ten_chuongtrinh' => $data[11], 'ma_ctdt' => $data[12], 'mota' => $data[13]
                    ];
                } else
                    if ($data[0] == 1 || $data[0] == '1') {
                    $arr_muctieuchung[] = ['title_muctieuchung' => $data[1]];
                } else
                    if ($data[0] == 1.1 || $data[0] == '1.1') {
                    $arr_muctieuchung[] = ['noidung_muctieuchung' => $data[1]];
                } else
                    if ($data[0] == 1.2 || $data[0] == '1.2') {
                    $arr_muctieucuthe[] = ['noidung_muctieucuthe' => $data[1]];
                } else
                    if ($data[0] == 1.3 || $data[0] == '1.3') {
                    $arr_chuandaura_ctdt[] = ['ma_tt' => $data[1], 'ten' => $data[2], 'level' => $data[3], 'ma_loai' => $data[4]];
                } else
                    if ($data[0] == 5 || $data[0] == '5') {
                    $arr_loai_cdr[] = ['ma_loai' => $data[1], 'ten' => $data[2]];
                } else
                    if ($data[0] == 4 || $data[0] == '4') {
                    $arr_cohoinghenghiep[] = ['title_cohoi' => $data[1]];
                } else
                    if ($data[0] == 1.4 || $data[0] == '1.4') {
                    $arr_cohoinghenghiep[] = ['noidung_cohoi' => $data[1]];
                } else
                    if ($data[0] == 1.5 || $data[0] == '1.5') {
                    $thoigian_daotao = $data[1];
                } else
                    if ($data[0] == 1.6 || $data[0] == '1.6') {
                    $khoiluongkienthuc = $data[1];
                } else
                    if ($data[0] == 1.7 || $data[0] == '1.7') {
                    $doituongtuyensinh = $data[1];
                } else
                    if ($data[0] == 1.8 || $data[0] == '1.8') {
                    $quytrinhdaotao = $data[1];
                } else
                    if ($data[0] == 1.9 || $data[0] == '1.9') {
                    $dieukientotnghiep = $data[1];
                } else
                    if ($data[0] == 2.4 || $data[0] == '2.4') {
                    $arr_caykhoikienthuc[] =  ['ma_tt' => $data[1], 'ma_khoi' => $data[2], 'ma_khoicha' => $data[3]];
                } else
                    if ($data[0] == 2.5 || $data[0] == '2.5') {
                    $arr_monhoc[] =  ['mamonhoc' => $data[1], 'tenmonhoc' => $data[2], 'sotc' => $data[3], 'sotiet_lt' => $data[4], 'sotiet_th' => $data[5], 'sotiet_bt' => $data[6], 'loaihocphan' => $data[7], 'ghichu' => $data[8]];
                } else
                    if (($data[0] == 2.3 || $data[0] == '2.3')) {

                    if ($data[1] != 0) {

                        // Continue khoi
                        $ma_khoi = $data[2];
                        $current_khoi = $arr_khoikienthuc[$ma_khoi];

                        if ($current_khoi !== NULL) {
                            $arr_khoikienthuc[$ma_khoi] = push_data_to_khoi_copy($current_khoi, $data, $ma_khoi);
                        } else {
                            $arr_khoikienthuc[$ma_khoi] = array();
                            $arr_khoikienthuc[$ma_khoi] = push_data_to_khoi_copy($current_khoi, $data, $ma_khoi);
                        }
                    }
                }
            }


            fclose($handle);
        }


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        class mfrom_thongtinchung extends moodleform
        {
            public function definition()
            {
                global $CFG;
                $mform = $this->_form;

                $mform->addElement('text', 'tenchuongtrinh', 'Tên chương trình', 'size=50');
                $mform->disabledIf('tenchuongtrinh', '');
                $mform->addElement('text', 'trinhdodaotao', 'Trình độ đào tạo', 'size=50');
                $mform->disabledIf('trinhdodaotao', '');
                $mform->addElement('text', 'nganhdaotao', 'Ngành đào tạo', 'size=50');
                $mform->disabledIf('nganhdaotao', '');
                $mform->addElement('text', 'manganh', 'Mã ngành', 'size=50');
                $mform->disabledIf('manganh', '');
                $mform->addElement('text', 'loaihinhdaotao', 'Loại hình đào tạo', 'size=50');
                $mform->disabledIf('loaihinhdaotao', '');
                $mform->addElement('text', 'khoatuyen', 'Khóa tuyển', 'size=50');
                $mform->disabledIf('khoatuyen', '');
            }

            function validation($data, $files)
            {
                return array();
            }
        }

        // $is_check_ctdt_hople = check_ctdt_hople($arr_thongtin_ctdt);
        $is_check_ctdt_hople = true;

        if (!$is_check_ctdt_hople) { // hople
            echo '<br>Chương trình đào tạo <strong>' . $arr_thongtin_ctdt[0]['ma_ctdt'] . ' - ' . $arr_thongtin_ctdt[0]['ten_chuongtrinh'] . '</strong> không hợp lệ hoặc đã tồn tại';
            echo "<br>";
            return;
        }

        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";

        $mform_thongtinchung = new mfrom_thongtinchung();


        $toform;
        $toform->tenchuongtrinh = $arr_thongtin_ctdt[0]['ten_chuongtrinh'];
        $toform->trinhdodaotao = $arr_thongtin_ctdt[0]['ten_bac'];
        $toform->nganhdaotao = $arr_thongtin_ctdt[0]['ten_nganh'];
        $toform->manganh = $arr_thongtin_ctdt[0]['ma_nganh'];
        $toform->loaihinhdaotao = $arr_thongtin_ctdt[0]['ten_he'];
        $toform->khoatuyen = $arr_thongtin_ctdt[0]['ten_nienkhoa'];

        $mform_thongtinchung->set_data($toform);
        $mform_thongtinchung->display();





        ////////////////////////////////////////MỤC TIÊU CHUNG////////////////////////////////////////////////////
        echo "<br>";
        echo "<br>";
        echo "
                <h3 style='text-transform: uppercase '>
                    <strong style='font-weight: 600; font-family: auto;'>1. <span style='text-decoration:underline'>Mục tiêu đào tạo</span></strong>
                </h3>";
        echo "<br>";
        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>1.1. Mục tiêu chung</strong></h3>";

        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>" . $arr_muctieuchung[1]['title_muctieuchung'] . "</p>";

        foreach ($arr_muctieuchung as $iarr_muctieuchung) {
            if ($iarr_muctieuchung['noidung_muctieuchung']) {
                echo "<p style='font-size: 20px; font-family: auto; margin-left:70px'> • " . $iarr_muctieuchung['noidung_muctieuchung'] . "</p>";
            }
        }


        echo "<h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>1.2. Mục tiêu cụ thể - Chuẩn đầu ra của chương trình đào tạo</strong>
                </h3>";
        echo "<br>";
        echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>1.2.1. Mục tiêu cụ thể</strong></h4>";

        foreach ($arr_muctieucuthe as $iarr_muctieucuthe) {
            if ($iarr_muctieucuthe['noidung_muctieucuthe']) {
                echo "<p style='font-size: 20px; font-family: auto; margin-left:70px'> • " . $iarr_muctieucuthe['noidung_muctieucuthe'] . "</p>";
            }
        }

        ////////////////////////////////////////CHUẨN ĐẦU RA////////////////////////////////////////////////////
        echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>1.2.2. Chuẩn đầu ra của chương trình giáo dục</strong></h4>";
        echo "<br>";

        $i_loaicdr = array();
        $stt = 0;
        foreach ($arr_loai_cdr as $item) {
            $param = new stdClass();
            $stt++;

            $arr_2 = get_ma_loai();
            $check_db = -1;
            $check_table = is_check($item, $i_loaicdr, "loai_cdr");
            if ($check_table == 0) {
                $check_db = is_check($item,  $arr_2, "loai_cdr");
            } else {
                $check_db = $check_table;
            }
            $param->stt = $stt;
            $param->ma_loai = $item['ma_loai'];
            $param->ten = $item['ten'];
            switch ($check_db) {
                case 0:
                    $i_loaicdr[] = $param;
                    break;
                case 1:
                    echo "<br>";
                    echo "Mã loại " . $item['ma_loai'] . "trùng lặp";
                    echo "<br>";

                    break;
                default:
                    break;
            }
        }




        $i_chuandaura = array();
        foreach ($arr_chuandaura_ctdt as $item2) {



            $arr_2 = get();

            $check_db = -1;
            $check_table = is_check($item2, $i_chuandaura, "cdr");

            if ($check_table == 0) {
                $check_db = is_check($item2,  $arr_2, "cdr");
            } else {
                $check_db = $check_table;
            }
            $param = new stdClass();
            $param->ma_tt = $item2['ma_tt'];
            $param->ten = $item2['ten'];
            $param->level =  $item2['level'];
            $param->ma_loai = $item2['ma_loai'];


            switch ($check_db) {
                case 0:
                    $i_chuandaura[] = $param;
                    break;


                default:
                    break;
            }
        }

        $inxOld = -100;
        foreach ($i_chuandaura as $ii_chuandaura) {

            $i_loaicdr;
            $inx = -1;
            $arr_maloai = array_column($i_loaicdr, 'ma_loai');

            if ($ii_chuandaura->level == 1 || $ii_chuandaura->level == '1') {
                $inx = array_search($ii_chuandaura->ma_loai, $arr_maloai);
                if ($inx >= 0 && $inxOld != $inx) {
                    echo "<h4 ><strong style='margin-left: 70px;font-weight: 600; font-family: auto;'> ❖ " . $i_loaicdr[$inx]->ten . "</strong></h4>";
                    $inxOld = $inx;
                }

                echo "<h4 ><strong style='margin-left: 9% ; margin-bottom: 0; font-family: auto;'> - " . $ii_chuandaura->ten . "</strong></h4>";
            } else if ($ii_chuandaura->level == 2 || $ii_chuandaura->level == '2') {

                echo "<h4 style='margin-left: 12%; margin-bottom: 0; font-family: auto;'> • " . $ii_chuandaura->ten . "</h4>";
                echo "<br>";
            }
        }

        // echo json_encode($arr_chuandaura_ctdt);


        ////////////////////////////////////////CƠ HỘI NGHỀ NGHIỆP////////////////////////////////////////////////////

        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>1.3. Cơ hội nghề nghiệp</strong></h3>";
        echo "<br>";


        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>" . $arr_cohoinghenghiep[1]['title_cohoi'] . "</p>";

        foreach ($arr_cohoinghenghiep as $iarr_cohoinghenghiep) {

            if ($iarr_cohoinghenghiep['noidung_cohoi']) {
                echo "<p style='font-size: 20px; font-family: auto; margin-left:70px'> • " . $iarr_cohoinghenghiep['noidung_cohoi'] . "</p>";
            }
        }

        ////////////////////////////////////////THỜI GIAN ĐÀO TẠO////////////////////////////////////////////////////


        echo "
                <h3 style='text-transform: uppercase '>
                    <strong style='font-weight: 600; font-family: auto;'>2. <span style='text-decoration:underline'>Thời gian đào tạo: 
                    </span><span style='text-transform: lowercase'>" . $thoigian_daotao . "</span></strong>
                </h3>";
        echo "<br>";

        ////////////////////////////////////////KHỐI LƯỢNG KIẾN THỨC TOÀN KHÓA////////////////////////////////////////////////////


        echo "
                <h3 style='text-transform: uppercase '>
                    <strong style='font-weight: 600; font-family: auto;'>3. <span style='text-decoration:underline'>Khối lượng kiến thức toàn khóa: 
                    </span><span style='text-transform: lowercase'>" . $khoiluongkienthuc . "</span></strong>
                </h3>";
        echo "<br>";


        ////////////////////////////////////////ĐỐI TƯỢNG TUYỂN SINH////////////////////////////////////////////////////

        // echo "<h3 style='text-transform: uppercase '><strong>4. đối tượng tuyển sinh</strong></h3>" . "<h4>". $doituongtuyensinh ."</h3>";

        echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>4. <span style='text-decoration:underline'>đối tượng tuyển sinh: 
                </span></strong>
            </h3>";


        echo "<h4 style='text-transform: lowercase; font-weight: 500; font-size: 20px; font-family: auto; margin-left:30px'>" . $doituongtuyensinh . "</h4>";


        ////////////////////////////////////////QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP////////////////////////////////////////////////////

        echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>4. <span style='text-decoration:underline'>QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP
                </span></strong>
            </h3>";



        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>5.1. quy trình đào tạo</strong></h3>";
        echo "<br>";
        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>" . $quytrinhdaotao . "</p>";

        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>5.2. điều kiện tốt nghiệp</strong></h3>";
        echo "<br>";
        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>" . $dieukientotnghiep . "</p>";


        ////////////////////////////////////////CẤU TRÚC CHƯƠNG TRÌNH////////////////////////////////////////////////////

        echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>6. <span style='text-decoration:underline'>CẤU TRÚC CHƯƠNG TRÌNH
                </span></strong>
            </h3>";



        ////////////////////////////////////////NỘI DUNG CHƯƠNG TRÌNH////////////////////////////////////////////////////
        echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>7. <span style='text-decoration:underline'>nội dung CHƯƠNG TRÌNH
                </span></strong>
            </h3>";
        echo "<br>";





        if ($is_check_ctdt_hople) {

            //in cac node con ra
            print_content($arr_khoikienthuc, $arr_caykhoikienthuc, $arr_monhoc);


            echo "<strong style='text-decoration: underline;'>LOG</strong>";
            echo "<br>";

            $is_error = print_errors($arr_khoikienthuc, $arr_caykhoikienthuc, $arr_monhoc);

            if (
                count($arr_thongtin_ctdt) > 0 && count($arr_muctieuchung) > 0 && count($arr_muctieucuthe) > 0 &&
                count($arr_chuandaura_ctdt) > 0 && count($arr_cohoinghenghiep) > 0 && count($arr_khoikienthuc) > 0
                && count($arr_caykhoikienthuc) > 0 && count($arr_monhoc) > 0 && $is_error == 0
            ) {
                $mform2->display();
            } else {
                echo "<h2 style='color: #960202;font-weight: 350; text-decoration: underline;'>Vui lòng kiểm tra lại dữ liệu</h2>";
            }

            /////////////////////////////////CREATE MONHOC/////////////////////////////////

            foreach ($arr_monhoc as $iarr_monhoc) {


                $param_monhoc = new stdClass();

                $param_monhoc->mamonhoc = $iarr_monhoc['mamonhoc'];
                $param_monhoc->tenmonhoc_vi = $iarr_monhoc['tenmonhoc'];
                $param_monhoc->tenmonhoc_en = '';
                $param_monhoc->lopmo = '';
                $param_monhoc->loaihocphan = $iarr_monhoc['loaihocphan'];
                $param_monhoc->sotinchi = $iarr_monhoc['sotc'];
                $param_monhoc->sotietlythuyet = $iarr_monhoc['sotiet_lt'];
                $param_monhoc->sotietthuchanh = $iarr_monhoc['sotiet_th'];
                $param_monhoc->sotiet_baitap = $iarr_monhoc['sotiet_bt'];
                $param_monhoc->ghichu = $iarr_monhoc['ghichu'];
                $param_monhoc->mota = '';

                $is_check_monhoc = requiredRules('eb_monhoc', 'mamonhoc', $param_monhoc->mamonhoc);

                if (!$is_check_monhoc) {
                    // echo 'Môn học <strong>'.$param_monhoc->mamonhoc . ' - ' . $param_monhoc->tenmonhoc_vi . '</strong> không hợp lệ hoặc đã tồn tại'; 
                    // echo "<br>";
                }
            }


            /////////////////////////////////CREATE KHOI KIEN THUC////////////////////////////////


            foreach ($arr_tem1 as $iarr_tem1) { // vcay khoi kien thuc

                $param_khoikienthuc = new stdClass();

                $param_khoikienthuc->ma_khoi = $iarr_tem1['ma_khoi'];
                $param_khoikienthuc->id_loai_kkt;
                $param_khoikienthuc->co_dieukien;
                $param_khoikienthuc->ma_dieukien;
                $param_khoikienthuc->ten_khoi = $iarr_tem1['ten_khoi'];
                $param_khoikienthuc->mota = $iarr_tem1['mota'];



                $is_check_khoikienthuc = requiredRules('eb_khoikienthuc', 'ma_khoi', $param_khoikienthuc->ma_khoi);
                $is_check_monthuockhoi = check_monthuockhoi('eb_monthuockhoi', $param_khoikienthuc->ma_khoi,  $iarr_tem1['list_monhoc']);
                $is_check_caykhoikienthuc = requiredRules('eb_cay_khoikienthuc', 'ma_cay_khoikienthuc', $param_khoikienthuc->ma_khoi);

                if (!$is_check_khoikienthuc) {
                    echo 'Khối kiến thức <strong>' . $param_khoikienthuc->ma_khoi . ' - ' . $param_khoikienthuc->ten_khoi  . '</strong> không hợp lệ hoặc đã tồn tại';
                    echo "<br>";
                }
                if (!$is_check_monthuockhoi) {
                    echo 'Môn thuộc khối <strong>' . $param_khoikienthuc->ma_khoi . ' - ' . $param_khoikienthuc->ten_khoi  . '</strong> không hợp lệ hoặc đã tồn tại';
                    echo "<br>";
                }
                if (!$is_check_caykhoikienthuc) {
                    echo 'Cây khối kiến thức <strong>' . $iarr_tem1['ma_caykhoikienthuc'] . ' - ' . $iarr_tem1['ten_cay']  . '</strong> không hợp lệ hoặc đã tồn tại';
                    echo "<br>";
                }
            }
        }
    }
}



function print_errors($arr_khoikienthuc, $arr_caykhoikienthuc, $arr_monhoc)
{
    $arr_error_khoi = get_errors_khoi($arr_khoikienthuc, $arr_caykhoikienthuc);
    $check = 0;

    foreach ($arr_error_khoi as $iarr_error_khoi) {
        echo "<p>Khối kiến thức <strong>" . $iarr_error_khoi['ma_khoi'] . ' - ' . $iarr_error_khoi['ten_khoi'] . "</strong> chưa được khai báo hoặc chưa được sử dụng</p>";
        $check = 1;
    }
    $arr_error_monhoc = get_errors_monhoc($arr_khoikienthuc, $arr_error_khoi, $arr_caykhoikienthuc, $arr_monhoc);

    // foreach($arr_error_monhoc as $iarr_error_monhoc){
    //     echo "<p>Môn học <strong> $iarr_error_monhoc </strong> chưa được khai báo hoặc chưa được sử dụng</p>";
    // $check = 1;
    // }

    return $check;
}

function print_content($arr_khoikienthuc, $arr_caykhoikienthuc, $arr_monhoc)
{

    $cay_tong_hop = tonghop_cay($arr_khoikienthuc, $arr_caykhoikienthuc);

    // echo json_encode($cay_tong_hop); 

    $root_node = get_root_node($cay_tong_hop);

    $node_conlai = find_all_nodecon($cay_tong_hop, $root_node);

    // echo json_encode($cay_tong_hop); echo '<br>';echo '<br>';echo '<br>';echo '<br>';

    // echo 'xin chao ' .json_encode($root_node); echo '<br>';


    in_cay_tonghop($node_conlai, $root_node, $arr_monhoc);
}

function in_cay_tonghop($node_conlai, $root_node, $arr_monhoc)
{


    $node_conlai1 = $node_conlai; // mang ban dau;
    $root_node1 = $root_node; // nut root 



    //+neu khối có môn học (in khoi, in môn ra)
    $arr_tam = find_nodecon($node_conlai1, $root_node1);


    if (count($arr_tam) > 0) {


        for ($i = 0; $i < count($arr_tam); $i++) {

            $iarr_tam = $arr_tam[$i];
            $len = count($iarr_tam['monbb']);
            $list_monhoc = gop_monbb_montc($iarr_tam);



            $ma_tt = '7.' . $iarr_tam['ma_tt'] . ' ' . $iarr_tam['ten_khoi'] . '<br>';

            //check level của mỗi ma_tt
            if (intval(count(explode('.', $iarr_tam['ma_tt'])) < 2)) {
                echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>$ma_tt</strong></h3>";
                echo "<br>";
            } else {
                echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>$ma_tt</strong></h4>";
                echo "<br>";
            }
            ///
            if (count($list_monhoc) > 0) {
                foreach ($list_monhoc as $ilist_monhoc) {

                    $arr_mamonhoc = array();
                    $table =  new html_table();
                    $table->head = ['STT', 'MÃ HỌC PHẦN', 'TÊN HỌC PHẦN', 'SỐ TC', 'LÝ THUYẾT', 'THỰC HÀNH', 'BÀI TẬP', 'LOẠI HỌC PHẦN', 'GHI CHÚ'];
                    $idx = 1;
                    // list mon bắt buộc
                    if ($ilist_monhoc['monbb']) {
                        foreach ($ilist_monhoc['monbb'] as $mamonhoc) {



                            $chitiet_monhoc = getDetailMonhoc($mamonhoc, $arr_monhoc);

                            if ($chitiet_monhoc) {


                                $table->data[] = [
                                    $idx, $chitiet_monhoc['mamonhoc'], $chitiet_monhoc['tenmonhoc'], $chitiet_monhoc['sotc'],
                                    $chitiet_monhoc['sotiet_lt'], $chitiet_monhoc['sotiet_th'], $chitiet_monhoc['sotiet_bt'],
                                    $chitiet_monhoc['loaihocphan'], $chitiet_monhoc['ghichu']
                                ];

                                $idx++;
                            }
                        }
                    }
                    // list mon tự chọn
                    if ($ilist_monhoc['montc']) {
                        foreach ($ilist_monhoc['montc'] as $tc_monhoc) {
                            // echo json_encode($tc_monhoc); echo '<br>';


                            $table->data[] = [$idx, $tc_monhoc['ghichu'], '', '', '', '', '',  '', ''];


                            foreach ($tc_monhoc['listmon'] as $mamonhoc) {

                                $chitiet_monhoc = getDetailMonhoc($mamonhoc, $arr_monhoc);
                                if ($chitiet_monhoc) {

                                    $table->data[] = [
                                        '', $chitiet_monhoc['mamonhoc'], $chitiet_monhoc['tenmonhoc'], $chitiet_monhoc['sotc'],
                                        $chitiet_monhoc['sotiet_lt'], $chitiet_monhoc['sotiet_th'], $chitiet_monhoc['sotiet_bt'],
                                        $chitiet_monhoc['loaihocphan'], $chitiet_monhoc['ghichu']
                                    ];

                                    $idx++;
                                }
                            }
                        }
                    }
                    if (count($table->data) > 0) {
                        echo html_writer::table($table);
                        echo '<br>';
                    }
                }
            }


            if (count($arr_tam) > 0) {

                in_cay_tonghop($node_conlai1, $iarr_tam, $arr_monhoc);
            }
        }
    } else {
    }
}

function tonghop_cay($arr_khoikienthuc, $arr_caykhoikienthuc)
{

    $arr_tam = array();

    // $arr_tam[] = [
    //     'ma_tt'=>$arr_caykhoikienthuc[0]['ma_tt'], 'ma_khoi'=>$arr_caykhoikienthuc[0]['ma_khoi'],
    //     'ma_khoicha'=>$arr_caykhoikienthuc[0]['ma_khoicha'],
    //     'monbb'=>null, 'montc'=>null
    //     ];



    // $arr_khoikienthuc_copy = array();
    // foreach($arr_khoikienthuc as $iarr_khoikienthuc){

    //     for($i=0; $i<count($arr_caykhoikienthuc); $i++){
    //         if($arr_caykhoikienthuc[$i]['ma_khoi'] == $iarr_khoikienthuc['ma_khoi']){
    //             $arr_khoikienthuc_copy[] = [
    //             'ma_khoi'=>$iarr_khoikienthuc['ma_khoi'] ,'ma_khoicha'=>$arr_caykhoikienthuc[$i]['ma_khoicha'],
    //             'monbb'=>$iarr_khoikienthuc['monbb'], 'montc'=>$iarr_khoikienthuc['montc'],
    //             'ma_tt'=>$arr_caykhoikienthuc[$i]['ma_tt']];
    //         }
    //     }

    // }


    // foreach($arr_caykhoikienthuc as $iarr_caykhoikienthuc){

    //     foreach($arr_khoikienthuc_copy as $iarr_khoikienthuc){


    //         if($iarr_khoikienthuc['ma_khoicha'] == $iarr_caykhoikienthuc['ma_khoi']){


    //             $arr_tam[] = [
    //             'ma_tt'=>$iarr_khoikienthuc['ma_tt'], 'ma_khoi'=>$iarr_khoikienthuc['ma_khoi'],
    //             'ma_khoicha'=>$iarr_khoikienthuc['ma_khoicha'],
    //             'monbb'=>$iarr_khoikienthuc['monbb'], 'montc'=>$iarr_khoikienthuc['montc']
    //             ];



    //         }
    //     }

    // }

    $root_node = get_root_node($arr_caykhoikienthuc);



    foreach ($arr_caykhoikienthuc as $iarr_caykhoikienthuc) {
        $level_cay = explode('.', $iarr_caykhoikienthuc['ma_tt']);

        if (count($level_cay) == 1) { // dai cuong va hoi

            $arr_tam[] = [
                'ma_tt' => $iarr_caykhoikienthuc['ma_tt'], 'ma_khoi' => $iarr_caykhoikienthuc['ma_khoi'],
                'ma_khoicha' => $root_node['ma_tt']
            ];

            $node_cons =  find_node_con($arr_caykhoikienthuc, $iarr_caykhoikienthuc['ma_tt']);

            foreach ($node_cons as $inode_cons) {

                $arr_tam[] = [
                    'ma_tt' => $inode_cons['ma_tt'], 'ma_khoi' => $inode_cons['ma_khoi'],
                    'ma_khoicha' => $inode_cons['ma_khoicha']
                ];
            }
        }
    }

    // echo 'xin chao ' . json_encode($arr_tam);
    $arr_final = array();

    $root_node1 = get_root_node($arr_tam);

    $arr_final[] = [
        'ma_tt' => $root_node1['ma_tt'], 'ma_khoi' => $root_node1['ma_khoi'],
        'ma_khoicha' => $root_node1['ma_khoicha'], 'monbb' => $root_node1['monbb'],
        'montc' => $root_node1['montc'], 'ten_khoi' => $root_node1['ten_khoi']
    ];

    foreach ($arr_tam as $iarr_tam) {

        foreach ($arr_khoikienthuc as $iarr_khoikienthuc) {
            if ($iarr_tam['ma_khoi'] == $iarr_khoikienthuc['ma_khoi']) {

                $arr_final[] = [
                    'ma_tt' => $iarr_tam['ma_tt'], 'ma_khoi' => $iarr_tam['ma_khoi'],
                    'ma_khoicha' => $iarr_tam['ma_khoicha'], 'monbb' => $iarr_khoikienthuc['monbb'],
                    'montc' => $iarr_khoikienthuc['montc'], 'ten_khoi' => $iarr_khoikienthuc['ten_khoi']
                ];
            }
        }
    }

    // foreach($arr_caykhoikienthuc as $iarr_caykhoikienthuc){

    //     $level_cay = explode('.', $iarr_caykhoikienthuc['ma_tt']);

    //     if($iarr_caykhoikienthuc['ma_tt'] != 0 && $iarr_caykhoikienthuc['ma_tt'] != '0'){ //khong phai node dau tien

    //         $node_con =  find_node_con($arr_caykhoikienthuc, $iarr_caykhoikienthuc['ma_tt']);

    //         // if($node_con){
    //         //     $arr_tam[] = ['ma_tt'=>$node_con['ma_tt'], 'ma_khoi'=>$node_con['ma_khoi'], 'ma_khoicha'=>$node_con['ma_khoicha']];
    //         // }


    //     }

    // }

    return $arr_final;
}
function get_errors_khoi($arr_khoikienthuc, $arr_caykhoikienthuc)
{

    $arr_errors = array();

    $arr_khoikienthuc_copy = array();
    foreach ($arr_khoikienthuc as $iarr_khoikienthuc) {

        $check = 0;
        for ($i = 0; $i < count($arr_caykhoikienthuc); $i++) {

            if ($arr_caykhoikienthuc[$i]['ma_khoi'] == $iarr_khoikienthuc['ma_khoi']) {
                $check = 1;
            }
        }
        if ($check == 0) {
            $arr_errors[] = $iarr_khoikienthuc;
        }
    }




    return $arr_errors;
}
function get_errors_khoi_when_insert($arr_khoikienthuc)
{
    global $DB, $USER, $CFG, $COURSE;
    $arr_errors = array();


    foreach ($arr_khoikienthuc as $iarr_khoikienthuc) {
        $check = 0;

        if (!$DB->record_exists('eb_khoikienthuc', ['ma_khoi' => $iarr_khoikienthuc['ma_khoi']])) {
            $check = 1;
        }
        if ($check == 0) {
            $arr_errors[] = $iarr_khoikienthuc;
        }
    }

    return $arr_errors;
}
function get_errors_monhoc($arr_khoikienthuc, $arr_error_khoi, $arr_caykhoikienthuc, $arr_monhoc)
{

    $arr_error = array();
    $arr_khoi_availble = array();

    foreach ($arr_khoikienthuc as $iarr_khoikienthuc) { // get cac khoi khong bị error trước đó
        $check = 0;
        foreach ($arr_error_khoi as $iarr_error_khoi) {
            if ($iarr_khoikienthuc['ma_khoi'] == $iarr_error_khoi['ma_khoi']) {
                $check = 1;
            }
        }
        if ($check == 0) {
            $arr_khoi_availble[] = $iarr_khoikienthuc;
        }
    }


    //check every monhoc

    foreach ($arr_khoi_availble as $iarr_khoi_availble) {

        $list_monhoc = gop_monbb_montc($iarr_khoi_availble);


        foreach ($list_monhoc as $ilist_monhoc) {

            if ($ilist_monhoc['monbb']) {
                foreach ($ilist_monhoc['monbb'] as $mamonhoc) {


                    $chitiet_monhoc = getDetailMonhoc($mamonhoc, $arr_monhoc);
                    if (!$chitiet_monhoc) {

                        $arr_error[] = $mamonhoc;
                    }
                }
            }

            if ($ilist_monhoc['montc']) {
                foreach ($ilist_monhoc['montc'] as $tc_monhoc) {
                    // echo json_encode($tc_monhoc); echo '<br>';


                    $table->data[] = [$idx, $tc_monhoc['ghichu'], '', '', '', '', '',  '', ''];


                    foreach ($tc_monhoc['listmon'] as $mamonhoc) {

                        $chitiet_monhoc = getDetailMonhoc($mamonhoc, $arr_monhoc);
                        if (!$chitiet_monhoc) {
                            $arr_error[] = $mamonhoc;
                        }
                    }
                }
            }
        }
    }

    return $arr_error;
}

function print_table_kkt($ma_khoi)
{
    print_preview_table_kkt(get_list_monhoc($ma_khoi), get_list_khoicon($ma_khoi));
}

function get()
{
    global $DB, $USER, $CFG, $COURSE;
    $arr = array();
    $arr = $DB->get_records('eb_chuandaura_ctdt', []);
    return $arr;
}
function is_check($data, $arr, $typeTable)
{
    global $DB;
    if ($typeTable == "loai_cdr") {
        foreach ($arr as $item) {
            if ($item->ma_loai == $data['ma_loai']) {
                return 1;
            }
        }
    } else {
        foreach ($arr as $item) {
            if ($item->ma_tt == $data['ma_tt']) {
                return 1;
                // }
            }
        }
        // if ($data['level'] == 1) {
        //     if (!$DB->record_exists('eb_loai_cdr', ['ma_loai' => $data['ma_loai']])) {
        //         return 2;
        //     }
        // }
    }
    return 0;
}
function find_node_con($arr_caykhoikienthuc, $ma_tt)
{
    $item;
    $arr = array();
    $level = explode('.', $ma_tt);

    foreach ($arr_caykhoikienthuc as $iarr_caykhoikienthuc) {

        $level_cay = explode('.', $iarr_caykhoikienthuc['ma_tt']);

        if (count($level_cay) == intval(count($level)) + 1 && startsWith($iarr_caykhoikienthuc['ma_tt'], $ma_tt)) {

            $arr[] = $iarr_caykhoikienthuc;
        }
    }
    return $arr;
}

function gop_monbb_montc($item)
{
    $arr = array();


    $arr[] = ['monbb' => $item['monbb'], 'montc' => $item['montc']];


    // echo json_encode($item['monbb']);echo '<br>';
    return $arr;
}
function get_list_monhoc($ma_khoi)
{
    $all_monthuockhoi = get_monthuockhoi($ma_khoi);

    $listmon = array();
    foreach ($all_monthuockhoi as $item) {
        $listmon[] = $item->mamonhoc;
    }
    return $listmon;
}

function getDetailMonhoc($mamonhoc, $arr_monhoc)
{
    global $DB, $USER, $CFG, $COURSE;
    $monhoc =  $DB->get_record('eb_monhoc', ['mamonhoc' => $mamonhoc]);

    if ($monhoc) {
        return [
            'mamonhoc' => $monhoc->mamonhoc, 'tenmonhoc' => $monhoc->tenmonhoc_vi,
            'sotc' => $monhoc->sotinchi, 'sotiet_lt' => $monhoc->sotietlythuyet, 'sotiet_th' => $monhoc->sotietthuchanh,
            'sotiet_bt' => $monhoc->sotiet_baitap, 'loaihocphan' => $monhoc->loaihocphan, 'ghichu' => $monhoc->ghichu
        ];
    } else {
        foreach ($arr_monhoc as $iarr_monhoc) {
            if ($iarr_monhoc['mamonhoc'] == $mamonhoc) {
                return $iarr_monhoc;
            }
        }
    }
}

function get_list_khoicon($ma_khoi)
{
    $all_khoi = get_list_khoicon_byMaKhoi($ma_khoi);

    $listkkt = array();
    foreach ($all_khoi as $item) {
        $listkkt[] = $item->ma_khoi;
    }

    return $listkkt;
}

function print_preview_table_kkt($arrmamon, $arr_makhoi)
{
    global $DB, $USER;

    $allmonhocs = array();
    $stt = 1;

    $table = new html_table();
    $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');

    if ($arrmamon != NULL) {

        foreach ($arrmamon as $key => $item) {
            $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $item]);
            $table->data[] = [
                (string) $stt, (string) $item, (string) $imonhoc['tenmonhoc_vi'],
                (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']
            ];
            $stt++;
        }
    }

    if ($arr_makhoi != NULL) {
        foreach ($arr_makhoi as $item) {
            $khoi = get_kkt_byMaKhoi($item);

            $table->data[] = [$stt, $khoi->mota, '', '', '', '', ''];
            $stt++;

            $listmonthuockhoi = get_monthuockhoi($item);
            if ($listmonthuockhoi != NULL) {
                foreach ($listmonthuockhoi as $mon) {
                    $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $mon->mamonhoc]);
                    $table->data[] = [
                        '', (string) $mon->mamonhoc, (string) $imonhoc['tenmonhoc_vi'],
                        (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                        (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']
                    ];
                }
            }
        }
    }

    echo html_writer::table($table);
}

////////////////////COPY////////////////////
function print_table_kkt_copy($ma_khoi, $item)
{

    print_preview_table_kkt_copy(get_list_monhoc_copy($ma_khoi, $item), get_list_khoicon_copy($ma_khoi));
}

function get_list_monhoc_copy($ma_khoi, $item)
{
    $all_monthuockhoi = get_monthuockhoi($ma_khoi);

    $listmon = array();
    foreach ($all_monthuockhoi as $item1) {
        $listmon[] = $item1->mamonhoc;
    }

    //check them nhung mon co trong file csv vua import
    if ($item['monbb']) {
        for ($i = 0; $i < count($item->monbb); $i++) {
            $listmon[] = $item->monbb[$i];
        }
    }

    if (count($item['montc'])) {
        $arr_tam =  get_list_mon_form_montc($item['montc']);
        foreach ($arr_tam as $iarr_tam) {
            $listmon[] = $iarr_tam;
        }
    } else {
        // khong co mon hoc trong khoi $ma_khoi
    }


    return $listmon;
}

function get_list_khoicon_copy($ma_khoi)
{
    $all_khoi = get_list_khoicon_byMaKhoi($ma_khoi);

    $listkkt = array();
    foreach ($all_khoi as $item) {
        $listkkt[] = $item->ma_khoi;
    }



    echo json_encode($listkkt);

    return $listkkt;
}

function print_preview_table_kkt_copy($arrmamon, $arr_makhoi)
{
    global $DB, $USER;

    $allmonhocs = array();
    $stt = 1;

    $table = new html_table();
    $table->head = array('STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT');

    if ($arrmamon != NULL) {

        foreach ($arrmamon as $key => $item) {
            $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $item]);
            $table->data[] = [
                (string) $stt, (string) $item, (string) $imonhoc['tenmonhoc_vi'],
                (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']
            ];
            $stt++;
        }
    }

    if ($arr_makhoi != NULL) {
        foreach ($arr_makhoi as $item) {
            $khoi = get_kkt_byMaKhoi($item);

            $table->data[] = [$stt, $khoi->mota, '', '', '', '', ''];
            $stt++;

            $listmonthuockhoi = get_monthuockhoi($item);
            if ($listmonthuockhoi != NULL) {
                foreach ($listmonthuockhoi as $mon) {
                    $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $mon->mamonhoc]);
                    $table->data[] = [
                        '', (string) $mon->mamonhoc, (string) $imonhoc['tenmonhoc_vi'],
                        (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                        (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap']
                    ];
                }
            }
        }
    }

    echo html_writer::table($table);
}

function get_list_mon_form_montc($montc)
{
    $arr = array();
    for ($i = 0; $i < count($montc); $i++) {

        for ($j = 0; i < count($montc['TC' . (intval($j) + 1)]['listmon']); $j++) {

            $arr[] = $montc['TC' . (intval($i) + 1)]['listmon'][$j];
        }
    }

    return $arr;
}

////////////////////////////////////////////



function push_data_to_khoi($old_khoi, $data)
{
    $current_khoi = $old_khoi;

    if ($current_khoi == NULL) {
        $current_khoi = array();
    }

    if ($data[3] == 'ttc') {

        $current_khoi['ten_khoi'] = $data[4];
        $current_khoi['mota'] = $data[5];
    } else if ($data[3] == 'BB') {

        $index = 5;
        $current_khoi['monbb'] = array();
        while ($data[$index] != NULL) {
            $current_khoi['monbb'][] = $data[$index];
            $index++;
        }
    } else if (strpos($data[3], 'TC') === 0) {

        if ($data[4] == 'mon') {

            $index = 5;
            $current_khoi['montc'][$data[3]]['listmon'] = array();
            while ($data[$index] != NULL) {
                $current_khoi['montc'][$data[3]]['listmon'][] = $data[$index];
                $index++;
            }
        } else if ($data[4] == 'dk') {

            $current_khoi['montc'][$data[3]]['ghichu'] = $data[5];
            $current_khoi['montc'][$data[3]]['xet_tren'] = $data[6];
            $current_khoi['montc'][$data[3]]['giatri_dieukien'] = $data[7];
        }
    }
    return $current_khoi;
}
function push_data_to_khoi_copy($old_khoi, $data, $ma_khoi)
{
    $current_khoi = $old_khoi;

    if ($current_khoi == NULL) {
        $current_khoi = array();
    }

    if ($data[3] == 'ttc') {

        $current_khoi['ten_khoi'] = $data[4];
        $current_khoi['mota'] = $data[5];
        $current_khoi['ma_khoi'] = $ma_khoi;
    } else if ($data[3] == 'BB') {

        $index = 5;
        $current_khoi['monbb'] = array();
        while ($data[$index] != NULL) {
            $current_khoi['monbb'][] = $data[$index];
            $index++;
        }
    } else if (strpos($data[3], 'TC') === 0) {

        if ($data[4] == 'mon') {

            $index = 5;
            $current_khoi['montc'][$data[3]]['listmon'] = array();
            while ($data[$index] != NULL) {
                $current_khoi['montc'][$data[3]]['listmon'][] = $data[$index];
                $index++;
            }
        } else if ($data[4] == 'dk') {

            $current_khoi['montc'][$data[3]]['ghichu'] = $data[5];
            $current_khoi['montc'][$data[3]]['xet_tren'] = $data[6];
            $current_khoi['montc'][$data[3]]['giatri_dieukien'] = $data[7];
        }
    }
    return $current_khoi;
}

function insert($table_name, $param)
{
    global $DB, $USER, $CFG, $COURSE;
    $DB->insert_record($table_name, $param);
}

function requiredRules($db_name, $sen, $des)
{
    global $DB, $USER, $CFG, $COURSE;
    $item = $DB->get_record($db_name, [$sen => $des]);

    if ($item) {
        return false;
    }
    return true;
}
function check_monthuockhoi($table_name, $ma_khoi, $arr_monhoc)
{

    global $DB, $USER, $CFG, $COURSE;



    foreach ($arr_monhoc as $iarr_monhoc) {

        $item = $DB->get_record($table_name, ['ma_khoi' => $ma_khoi, 'mamonhoc' => $iarr_monhoc['mamonhoc']]);

        if ($item) {
            return false;
        }
    }
    return true;
}

function get_khoikienthuccon($arr_khoikienthuc, $arr_khoicon)
{
    $arr_result = array();
    $arr_mon = array('monhoc' => []);


    foreach ($arr_khoicon as $iarr_khoicon) {
        foreach ($arr_khoikienthuc as $iarr_khoikienthuc) {

            if ($iarr_khoikienthuc['ma_khoi'] == $iarr_khoicon) { // tim thay khoi con

                // $monhoc = find_monhoc_BB($arr_monhoc, $iarr_khoikienthuc['mon_BB']);
                // $arr_mon[] = $monhoc;

                $arr_result[] = $iarr_khoikienthuc;
            }
        }
    }


    return $arr_result;
}
function find_monhoc_BB($arr_monhoc, $arr_khoicon)
{
    $arr =  array();
    foreach ($arr_khoicon as $iarr_khoicon) {


        foreach ($arr_monhoc as $iarr_monhoc) {

            if ($iarr_monhoc['mamonhoc'] == $iarr_khoicon) {
                $arr[] = $iarr_monhoc;
            }
        }
    }
    return $arr;
}
function find_chuandaura_con($arr, $ma_cdr, $level, $ma_cay_cdr)
{

    $arr_result = array();

    foreach ($arr as $iarr) {
        if ($iarr['level_cdr'] == $level && $iarr['ma_cay_cdr'] == $ma_cay_cdr) {

            if (startsWith($iarr['ma_cdr'], $ma_cdr)) {
                $arr_result[] = $iarr;
            }
        }
    }
    return $arr_result;
}

function get_root_node($arr_caykhoikienthuc)
{

    // return current(array_filter($arr_caykhoikienthuc, function($e) { return $e['ma_tt']==null || $e['ma_tt']== ''  || $e['ma_khoicha']==null   || $e['ma_khoicha']==''; }));
    // return current(array_filter($arr_caykhoikienthuc, function($e) { return $e['ma_tt']==0 || $e['ma_tt']== '0'; }));

    foreach ($arr_caykhoikienthuc as $iarr_caykhoikienthuc) {
        if ($iarr_caykhoikienthuc['ma_tt'] == 0 || $iarr_caykhoikienthuc['ma_tt'] == '0') {
            return $iarr_caykhoikienthuc;
        }
    }
}
function get_khoi_cha($arr_caykhoikienthuc, $ma_khoi_cha)
{

    return current(array_filter($arr_caykhoikienthuc, function ($e) use ($ma_khoi_cha) {
        return $e['ma_khoi'] == $ma_khoi_cha;
    }));
}
function get_all_thanhphan_cay($arr_caykhoikienthuc, $ma_cay_khoikienthuc_cha)
{

    $arr = array();

    foreach ($arr_caykhoikienthuc as $iarr_caykhoikienthuc) {

        if (($iarr_caykhoikienthuc['ma_tt'] != null || $iarr_caykhoikienthuc['ma_tt'] != '') &&
            ($iarr_caykhoikienthuc['ma_khoicha'] != null || $iarr_caykhoikienthuc['ma_khoicha'] != '')
        ) {

            if ($iarr_caykhoikienthuc['ma_caykhoikienthuc'] == $ma_cay_khoikienthuc_cha) {
                $arr[] =  $iarr_caykhoikienthuc;
            }
        }
    }

    return $arr;
}
function add_contentkhoi_to_khoi($arr_caykhoikienthuc, $arr_khoikienthuc)
{



    foreach ($arr_khoikienthuc as $iarr_khoikienthuc) {


        // $khoi = array_filter($arr_caykhoikienthuc, function($e) { return $e['ma_khoi']== $iarr_khoikienthuc['ma_khoi'] ; });
        $arr = array();

        foreach ($arr_caykhoikienthuc as $iarr_caykhoikienthuc) {

            $iarr_caykhoikienthuc['list_monhoc'] = array();

            if ($iarr_caykhoikienthuc['ma_khoi'] == $iarr_khoikienthuc['ma_khoi']) {


                $iarr_caykhoikienthuc['list_monhoc'] = $iarr_khoikienthuc['list_monhoc'];
            }
        }
    }
}
function insert_cdr_ctdt($param)
{
    global $DB;
    $DB->insert_record('eb_chuandaura_ctdt', $param);
}
function insert_loai_cdr($param)
{
    global $DB;
    $DB->insert_record('eb_loai_cdr', $param);
}


function get_ma_loai()
{
    global $DB, $USER, $CFG, $COURSE;
    $arr = array();
    $arr = $DB->get_records('eb_loai_cdr', []);
    return $arr;
}


function find_mininode($arr_tem1, $node_root)
{
    $arr = array();
    echo 'amkhoi' . $node_root['ma_khoi'];
    echo '<br>';

    foreach ($arr_tem1 as $iarr_tem1) {
        echo $iarr_tem1['ma_khoi'] . '- ' . $iarr_tem1['ma_khoicha'];
        echo '<br>';
        if ($iarr_tem1['ma_khoicha'] == $node_root['ma_khoi']) {
            $arr[]  = $iarr_tem1;
        }
    }
    return $arr;
    // return array_filter($arr_tem1, function($e) { return  $node_root['ma_khoi'] == $e['ma_khoicha']; });
}
function find_nodecon($cay_tong_hop, $node_root)
{
    $arr = array();

    $level = explode('.', $node_root['ma_tt']);

    foreach ($cay_tong_hop as $icay_tong_hop) {

        $level_cay = explode('.', $icay_tong_hop['ma_tt']);

        if (($icay_tong_hop['ma_khoicha'] == $node_root['ma_khoi']) ||
            ($icay_tong_hop['ma_khoicha'] == $node_root['ma_tt'] ||
                (count($level_cay) == intval(count($level)) + 1 && startsWith($icay_tong_hop['ma_tt'], $node_root['ma_tt'])))
        ) {

            $arr[]  = $icay_tong_hop;
        }
    }



    return $arr;
    // return array_filter($arr_tem1, function($e) { return  $node_root['ma_khoi'] == $e['ma_khoicha']; });
}
function insert_ctdt_noi_cdr($item)
{
    global $DB;
    $param = new stdClass();
    $param->ma_cdr = $item->ma_cdr;
    $param->ma_ctdt = $item->ma_ctdt;
    $DB->insert_record("eb_cdr_thuoc_ctdt", $param);
}
function find_all_nodecon($cay_tong_hop, $root_node)
{
    $arr = array();
    foreach ($cay_tong_hop as $icay_tong_hop) {

        if ($icay_tong_hop['ma_khoi'] != $root_node['ma_khoi']) {

            $arr[]  = $icay_tong_hop;
        }
    }

    return $arr;
}
function print_any($arr_khoikienthuc, $arr_caykhoikienthuc)
{

    $arr_bandau = $node_conlai; // mang ban dau;
    $noderoot = $node_root; // nut root 

    $arr_tam = find_nodecon($arr_bandau, $noderoot);

    if ($node_root['danhdau'] && count($node_root['list_monhoc']) == 0) {


        echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>"
            . $node_root['danhdau'] . '. ' . $node_root['ten_cay'] .
            "</strong></h3>";
        echo "<br>";

        echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>" . $node_root['mota'] . "</p>";
    }




    foreach ($arr_tam as $iarr_tam) {

        if (count($iarr_tam['list_monhoc']) > 0) {

            $table =  new html_table();
            if ($iarr_tam['danhdau']) { //cac khoi chinh

                $arr_mini_node = find_mininode($arr_bandau, $iarr_tam);

                $table->head = ['STT', 'MÃ HỌC PHẦN', 'TÊN HỌC PHẦN', 'SỐ TC', 'LÝ THUYẾT', 'THỰC HÀNH', 'BÀI TẬP', 'LOẠI HỌC PHẦN', 'GHI CHÚ'];

                $idx = 1;
                foreach ($iarr_tam['list_monhoc'] as $imonhoc) {

                    $table->data[] = [
                        $idx, $imonhoc['mamonhoc'], $imonhoc['tenmonhoc'], $imonhoc['sotc'], $imonhoc['sotiet_lt'],
                        $imonhoc['sotiet_th'], $imonhoc['sotiet_bt'], $imonhoc['loaihocphan'], $imonhoc['ghichu']
                    ];
                    $idx++;
                }

                if (count($arr_mini_node) == 0) {
                } else {
                    foreach ($arr_mini_node as $iarr_mini_node) {
                        $table->data[] = [$idx, $iarr_mini_node['mota'], '', '', '', '', '', '', ''];

                        foreach ($iarr_mini_node['list_monhoc'] as $i_mini_node_monhoc) {
                            $table->data[] = [
                                '', $i_mini_node_monhoc['mamonhoc'], $i_mini_node_monhoc['tenmonhoc'], $i_mini_node_monhoc['sotc'], $i_mini_node_monhoc['sotiet_lt'],
                                $i_mini_node_monhoc['sotiet_th'], $i_mini_node_monhoc['sotiet_bt'], $i_mini_node_monhoc['loaihocphan'], $i_mini_node_monhoc['ghichu']
                            ];
                        }
                    }
                }

                echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>"
                    . $iarr_tam['danhdau'] . '. ' . $iarr_tam['ten_cay'] .
                    "</strong></h4>";
                echo "<br>";

                echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>" . $iarr_tam['mota'] . "</p>";
            }


            echo html_writer::table($table);
        }


        if (count($arr_tam) > 0) {
            print_any($arr_bandau, $iarr_tam);
        }
    }
}
function check_ctdt_hople($arr_thongtin_ctdt)
{
    global $DB;


    $ctdt = $DB->get_records('eb_ctdt', [
        'ma_ctdt' => $arr_thongtin_ctdt[0]->ma_ctdt, 'ma_bac' => $arr_thongtin_ctdt[0]['ma_bac'], 'ma_he' => $arr_thongtin_ctdt[0]['ma_he'],
        'ma_nienkhoa' => $arr_thongtin_ctdt[0]['ma_nienkhoa'], 'ma_nganh' => $arr_thongtin_ctdt[0]['ma_nganh'], 'ma_chuyennganh' => $arr_thongtin_ctdt[0]['ma_chuyennganh']
    ]);

    if (count($ctdt) == 0) {
        return true;
    }
    return false;
}
function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
// Footer
echo $OUTPUT->footer();
