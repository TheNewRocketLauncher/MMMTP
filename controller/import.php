<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../config.php');

/* Insert DB - cần cập nhật CDR của CTDT */
function insertDatabase()
{
    global $DB;
    // $Bậc
    $param = new stdClass();
    $param->ma_bac = 'DH';
    $param->ten = 'Đại học';
    if (!$DB->count_records('eb_bacdt', ['ma_bac' => 'DH'])) $DB->insert_record('eb_bacdt', $param);
    // $Hệ
    $param = new stdClass();
    $param->ma_bac = 'DH';
    $param->ma_he = 'DHCQ';
    $param->ten = 'Chính quy';
    if (!$DB->count_records('eb_hedt', ['ma_he' => 'DHCQ'])) $DB->insert_record('eb_hedt', $param);
    // $khóa tuyển
    $param = new stdClass();
    $param->ma_bac = 'DH';
    $param->ma_he = 'DHCQ';
    $param->ma_nienkhoa = 'DHCQ2016';
    $param->ten_nienkhoa = 'Khóa tuyển 2016';
    if (!$DB->count_records('eb_nienkhoa', ['ma_nienkhoa' => 'DHCQ2016'])) $DB->insert_record('eb_nienkhoa', $param);
    // $Ngành ĐT
    $param = new stdClass();
    $param->ma_bac = 'DH';
    $param->ma_he = 'DHCQ';
    $param->ma_nienkhoa = 'DHCQ2016';
    $param->ma_nganh = 'DHCQ2016KTPM';
    $param->ten = 'Kỹ thuật phần mềm';
    if (!$DB->count_records('eb_nganhdt', ['ma_nganh' => 'DHCQ2016KTPM'])) $DB->insert_record('eb_nganhdt', $param);
    // $Chuyên ngành ĐT
    $param = new stdClass();
    $param->ma_bac = 'DH';
    $param->ma_he = 'DHCQ';
    $param->ma_nienkhoa = 'DHCQ2016';
    $param->ma_nganh = 'DHCQ2016KTPM';
    $param->ma_chuyennganh = 'DHCQ2016KTPM1';
    $param->ten = 'Kỹ thuật phần mềm (1)';
    if (!$DB->count_records('eb_chuyennganhdt', ['ma_chuyennganh' => 'DHCQ2016KTPM1'])) $DB->insert_record('eb_chuyennganhdt', $param);
    // Cây khối kiến thức
    //1
    $param = new stdClass();
    $param->ma_cay_khoikienthuc = '2khoi1594803907';
    $param->ma_tt = '0';
    $param->ma_khoi = 'GDDC';
    $param->ma_khoicha = NULL;
    $param->ten_cay = 'GIÁO DỤC ĐẠI CƯƠNG';
    $param->mota = '';
    $DB->insert_record('eb_cay_khoikienthuc', $param);
    //2
    $param = new stdClass();
    $param->ma_cay_khoikienthuc = '2khoi1594803907';
    $param->ma_tt = '1';
    $param->ma_khoi = 'LLTH';
    $param->ma_khoicha = 'GDDC';
    $param->ten_cay = 'GIÁO DỤC ĐẠI CƯƠNG';
    $param->mota = '';
    $DB->insert_record('eb_cay_khoikienthuc', $param);
    //3
    $param = new stdClass();
    $param->ma_cay_khoikienthuc = '2khoi1594803935';
    $param->ma_tt = '0';
    $param->ma_khoi = 'GDCN';
    $param->ma_khoicha = NULL;
    $param->ten_cay = 'GIÁO DỤC CHUYÊN NGHIỆP';
    $param->mota = '';
    $DB->insert_record('eb_cay_khoikienthuc', $param);
    //4
    $param = new stdClass();
    $param->ma_cay_khoikienthuc = '2khoi1594803935';
    $param->ma_tt = '1';
    $param->ma_khoi = 'KHXH';
    $param->ma_khoicha = 'GDCN';
    $param->ten_cay = 'GIÁO DỤC CHUYÊN NGHIỆP';
    $param->mota = '';
    $DB->insert_record('eb_cay_khoikienthuc', $param);
    //5
    $param = new stdClass();
    $param->ma_cay_khoikienthuc = '2khoi1594803935';
    $param->ma_tt = '2';
    $param->ma_khoi = 'LLTH';
    $param->ma_khoicha = 'GDCN';
    $param->ten_cay = 'GIÁO DỤC CHUYÊN NGHIỆP';
    $param->mota = '';
    $DB->insert_record('eb_cay_khoikienthuc', $param);
    //6
    $param = new stdClass();
    $param->ma_cay_khoikienthuc = '2caykkt1594804099';
    $param->ma_tt = NULL;
    $param->ma_khoi = 'caykkt';
    $param->ma_khoicha = NULL;
    $param->ten_cay = 'Cây FIRST';
    $param->mota = 'Cây FIRST';
    $param->mota = '';
    $DB->insert_record('eb_cay_khoikienthuc', $param);
    //7
    $param = new stdClass();
    $param->ma_cay_khoikienthuc = '2caykkt1594804099';
    $param->ma_tt = '1';
    $param->ma_khoi = 'GDDC';
    $param->ma_khoicha = 'caykkt';
    $param->ten_cay = 'Cây FIRST';
    $param->mota = 'Cây FIRST';
    $param->mota = '';
    $DB->insert_record('eb_cay_khoikienthuc', $param);
    //8
    $param = new stdClass();
    $param->ma_cay_khoikienthuc = '2caykkt1594804099';
    $param->ma_tt = '2';
    $param->ma_khoi = 'GDCN';
    $param->ma_khoicha = 'caykkt';
    $param->ten_cay = 'Cây FIRST';
    $param->mota = 'Cây FIRST';
    $DB->insert_record('eb_cay_khoikienthuc', $param);

    // Chuẩn đầu ra CTDT cần cập nhật lại

    // CTDT
    //1
    $param = new stdClass();
    $param->ma_ctdt = 'test';
    $param->ma_chuyennganh  = 'DHCQ2016KTPM';
    $param->ma_nganh = 'DHCQ2016KTPM';
    $param->ma_nienkhoa = 'DHCQ2016';
    $param->ma_he = 'DHCQ';
    $param->ma_bac = 'DH';
    $param->muctieu_daotao = '<p>Mục tiêu của CTDT nhằm đào tạo ra các sinh viên tốt nghiệp</p>';
    $param->muctieu_cuthe = '<p>Có trách nhiệm, đạo đức nghề nghiệp\r\n<br>Có đầy đủ các kỹ năng cá nhân</p>';
    $param->chuandaura = '1';
    $param->cohoi_nghenghiep = '<p>Có các cơ hội nghề nghiệp triển vọng<br></p>';
    $param->thoigian_daotao = '4';
    $param->khoiluong_kienthuc = '137';
    $param->doituong_tuyensinh = 'Theo quy chế chung của BGQ và ĐT';
    $param->quytrinh_daotao = '<p>Căn cứ Quy chế học vụ theo Hệ thống tín chỉ trường DH. KHTN</p>';
    $param->dieukien_totnghiep = '<p>Tích lũy đủ 137 tín chỉ theo yêu cầu của nội dung chương trình</p>';
    $param->ma_cay_khoikienthuc = '2caykkt1594804099';
    $param->mota = 'Cử nhân SMT';
    $DB->insert_record('eb_ctdt', $param);
    //2 
    $param = new stdClass();
    $param->ma_ctdt = 'test2';
    $param->ma_chuyennganh  = 'DHCQ2016KTPM';
    $param->ma_nganh = 'DHCQ2016KTPM';
    $param->ma_nienkhoa = 'DHCQ2016';
    $param->ma_he = 'DHCQ';
    $param->ma_bac = 'DH';
    $param->muctieu_daotao = '<p>Mục tiêu của CTDT nhằm đào tạo ra các sinh viên tốt nghiệp</p>';
    $param->muctieu_cuthe = '<p>Có trách nhiệm, đạo đức nghề nghiệp\r\n<br>Có đầy đủ các kỹ năng cá nhân</p>';
    $param->chuandaura = '1';
    $param->cohoi_nghenghiep = '<p>Có các cơ hội nghề nghiệp triển vọng<br></p>';
    $param->thoigian_daotao = '4';
    $param->khoiluong_kienthuc = '137';
    $param->doituong_tuyensinh = 'Theo quy chế chung của BGQ và ĐT';
    $param->quytrinh_daotao = '<p>Căn cứ Quy chế học vụ theo Hệ thống tín chỉ trường DH. KHTN</p>';
    $param->dieukien_totnghiep = '<p>Tích lũy đủ 137 tín chỉ theo yêu cầu của nội dung chương trình</p>';
    $param->ma_cay_khoikienthuc = '2caykkt1594804099';
    $param->mota = 'Cử nhân SMT';
    $DB->insert_record('eb_ctdt', $param);

    // Khối kiến thức
    //1
    $param = new stdClass();
    $param->ma_khoi = 'KHXH';
    $param->id_loai_kkt = 0;
    $param->co_dieukien = 0;
    $param->ma_dieukien = NULL;
    $param->ten_khoi = 'Khoa học xã hội';
    $param->mota = '';
    $DB->insert_record('eb_khoikienthuc', $param);
    //2
    $param = new stdClass();
    $param->ma_khoi = 'LLTH';
    $param->id_loai_kkt = 0;
    $param->co_dieukien = 0;
    $param->ma_dieukien = NULL;
    $param->ten_khoi = 'Lý luận triết học';
    $param->mota = '';
    $DB->insert_record('eb_khoikienthuc', $param);
    //3
    $param = new stdClass();
    $param->ma_khoi = 'GDDC';
    $param->id_loai_kkt = 0;
    $param->co_dieukien = 0;
    $param->ma_dieukien = NULL;
    $param->ten_khoi = 'GIÁO DỤC ĐẠI CƯƠNG';
    $param->mota = '';
    $DB->insert_record('eb_khoikienthuc', $param);
    //4
    $param = new stdClass();
    $param->ma_khoi = 'GDCN';
    $param->id_loai_kkt = 0;
    $param->co_dieukien = 0;
    $param->ma_dieukien = NULL;
    $param->ten_khoi = 'GIÁO DỤC CHUYÊN NGHIỆP';
    $param->mota = '';
    $DB->insert_record('eb_khoikienthuc', $param);


    // Môn học
    //1
    $param = new stdClass();
    $param->mamonhoc = 'MATH01';
    $param->tenmonhoc_vi = 'Toán';
    $param->tenmonhoc_en = 'Toán';
    $param->lopmo = NULL;
    $param->loaihocphan = 'BB';
    $param->sotinchi = 4;
    $param->sotietlythuyet = 4;
    $param->sotietthuchanh = 4;
    $param->sotiet_baitap = 4;
    $param->ghichu = '';
    $param->mota = '';
    $DB->insert_record('eb_monhoc', $param);
    //2
    $param = new stdClass();
    $param->mamonhoc = 'HOA01';
    $param->tenmonhoc_vi = 'Hóa';
    $param->tenmonhoc_en = 'Hóa';
    $param->lopmo = NULL;
    $param->loaihocphan = 'BB';
    $param->sotinchi = 3;
    $param->sotietlythuyet = 4;
    $param->sotietthuchanh = 5;
    $param->sotiet_baitap = 6;
    $param->ghichu = '';
    $param->mota = '';
    $DB->insert_record('eb_monhoc', $param);
    //3
    $param = new stdClass();
    $param->mamonhoc = 'TTHCM';
    $param->tenmonhoc_vi = 'Tư tưởng HCM';
    $param->tenmonhoc_en = 'Tư tưởng HCM';
    $param->lopmo = NULL;
    $param->loaihocphan = 'BB';
    $param->sotinchi = 2;
    $param->sotietlythuyet = 4;
    $param->sotietthuchanh = 6;
    $param->sotiet_baitap = 8;
    $param->ghichu = '';
    $param->mota = '';
    $DB->insert_record('eb_monhoc', $param);
    //4
    $param = new stdClass();
    $param->mamonhoc = 'DLDCS';
    $param->tenmonhoc_vi = 'Đường lối ĐCSVN';
    $param->tenmonhoc_en = 'Đường lối ĐCSVN';
    $param->lopmo = NULL;
    $param->loaihocphan = 'BB';
    $param->sotinchi = 3;
    $param->sotietlythuyet = 5;
    $param->sotietthuchanh = 7;
    $param->sotiet_baitap = 9;
    $param->ghichu = '';
    $param->mota = '';
    $DB->insert_record('eb_monhoc', $param);

    // Môn thuộc khối
    //1
    $param = new stdClass();
    $param->mamonhoc = 'MATH01';
    $param->ma_khoi = 'KHXH';
    $DB->insert_record('eb_monthuockhoi', $param);
    //2
    $param = new stdClass();
    $param->mamonhoc = 'HOA01';
    $param->ma_khoi = 'KHXH';
    $DB->insert_record('eb_monthuockhoi', $param);
    //3
    $param = new stdClass();
    $param->mamonhoc = 'TTHCM';
    $param->ma_khoi = 'LLTH';
    $DB->insert_record('eb_monthuockhoi', $param);
    //4
    $param = new stdClass();
    $param->mamonhoc = 'DLDCS';
    $param->ma_khoi = 'LLTH';
    $DB->insert_record('eb_monthuockhoi', $param);
}
