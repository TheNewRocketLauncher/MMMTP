<?php

function print_CTDT_as_HTML($id){
    $ctdt = get_ctdt_byID($id);

    // echo json_encode($ctdt);
    /// Function Turn CTDT to array 

    print_ttc($ctdt);
    print_muctieu_daotao($ctdt);    
    print_klkt($ctdt);
    print_qtdt($ctdt);
    print_ctct($ctdt);
    print_ndct($ctdt);

    // print_cdr($ctdt);
}

function print_cdr($ctdt){
    
    global $DB;
    echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>1.2.2. Chuẩn đầu ra của chương trình giáo dục</strong></h4>"; echo "<br>";

    $all_ma_cdr_ctdt = $DB->get_records('eb_cdr_thuoc_ctdt', ['ma_ctdt' => $ctdt->ma_ctdt]);

    // echo json_encode($all_ma_cdr_ctdt);

    $arr_loai_cdr = array();
    $arr_list_cdr = array();
    foreach($all_ma_cdr_ctdt as $item){
        $cdr = $DB->get_record('eb_chuandaura_ctdt', ['ma_cdr' => $item->ma_cdr]);
        $loai_cdr = $DB->get_record('eb_loai_cdr', ['ma_loai' => $cdr->ma_loai]);

        if(!in_array($cdr->ma_loai, array_keys($arr_loai_cdr))){
            $iloai = $DB->get_record('eb_loai_cdr', ['ma_loai' => $cdr->ma_loai]);
            $arr_loai_cdr += [$iloai->ma_loai => $iloai->ten];
        } else{
        }
        
        $arr_list_cdr[] = $cdr;
    }

    foreach($arr_loai_cdr as $key => $iloai){
        echo "<h4 ><strong style='margin-left: 70px;font-weight: 600; font-family: auto;'> ❖ " . $iloai ."</strong></h4>";
        
        foreach($arr_list_cdr as $a => $icdr){
            if($icdr->ma_loai == $key){
                echo"<h4 style='margin-left: 7% ; margin-bottom: 0; font-family: auto;'> - ". $icdr->ten . "</h4>"; echo "<br>";
    
                $arr_list_cdrcon = $DB->get_records('eb_chuandaura_ctdt', ['ma_cdr_cha' => $icdr->ma_cdr]);
                foreach($arr_list_cdrcon as $icon){
                    echo "<h4 style='margin-left: 10%; margin-bottom: 0; font-family: auto;'> • " . $icon->ten . "</h4>"; echo "<br>";
    
                }
            }
        }
    }
}

function print_ttc($ctdt){
    echo "
    <h3 style='text-transform: uppercase '>
        <strong style='font-weight: 200; font-family: auto;'>Tên chương trình: " . $ctdt->mota ."</span></strong>
    </h3>"; echo "<br>";

}

function print_muctieu_daotao($ctdt){

    global $DB;
    
    //--------------------------MỤC TIÊU CHUNG--------------------------//
    echo "<br>";echo "<br>";
    echo "
        <h3 style='text-transform: uppercase '>
            <strong style='font-weight: 600; font-family: auto;'>1. <span style='text-decoration:underline'>Mục tiêu đào tạo</span></strong>
        </h3>"; echo "<br>";
    echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>1.1. Mục tiêu chung</strong></h3>";

    echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $ctdt->muctieu_daotao . "</p>";

    //--------------------------MỤC TIÊU CỤ THỂ--------------------------//
    
    echo "<h3 style='text-transform: uppercase '>
        <strong style='font-weight: 600; font-family: auto;'>1.2. Mục tiêu cụ thể - Chuẩn đầu ra của chương trình đào tạo</strong>
        </h3>"; echo "<br>";
    echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>1.2.1. Mục tiêu cụ thể</strong></h4>"; 

    echo "<p style='font-size: 20px; font-family: auto; margin-left:70px'> • ". $ctdt->muctieu_cuthe . "</p>";

    //--------------------------CHUẨN ĐẦU RA--------------------------//
    print_cdr($ctdt);
    
    //--------------------------CƠ HỘI NGHỆ NGHIỆP--------------------------//

    echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>1.3. Cơ hội nghề nghiệp</strong></h3>"; echo "<br>";
    echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $ctdt->cohoi_nghenghiep . "</p>";

}

function print_tgdt($ctdt){
    echo "
                <h3 style='text-transform: uppercase '>
                    <strong style='font-weight: 600; font-family: auto;'>2. <span style='text-decoration:underline'>Thời gian đào tạo: 
                    </span><span style='text-transform: lowercase'>" .$ctdt->thoigian_daotao. "</span></strong>
                </h3>"; echo "<br>";
}

//Khối lượng kiến thức
function print_klkt($ctdt){
    
    echo "
    <h3 style='text-transform: uppercase '>
        <strong style='font-weight: 600; font-family: auto;'>3. <span style='text-decoration:underline'>Khối lượng kiến thức toàn khóa: 
        </span><span style='text-transform: lowercase'>" .$ctdt->khoiluong_kienthuc. "</span></strong>
    </h3>"; echo "<br>";
}

//Quy trình đào tạo
function print_qtdt($ctdt){
    echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>4. <span style='text-decoration:underline'>QUY TRÌNH ĐÀO TẠO, ĐIỀU KIỆN TỐT NGHIỆP
                </span></strong>
            </h3>"; 
            

            
            echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>5.1. quy trình đào tạo</strong></h3>"; echo "<br>";
            echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $ctdt->quytrinh_daotao . "</p>";
            
            echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>5.2. điều kiện tốt nghiệp</strong></h3>"; echo "<br>";
            echo "<p style='font-size: 20px; font-family: auto; margin-left:30px'>". $ctdt->dienkien_totnghiep . "</p>";
}

//cấu trúc chương trình
function print_ctct($ctdt){
    echo "
    <h3 style='text-transform: uppercase '>
        <strong style='font-weight: 600; font-family: auto;'>6. <span style='text-decoration:underline'>CẤU TRÚC CHƯƠNG TRÌNH
        </span></strong>
    </h3>"; 
}

//nội dung chương trình
function print_ndct($ctdt){
    
    echo "
            <h3 style='text-transform: uppercase '>
                <strong style='font-weight: 600; font-family: auto;'>7. <span style='text-decoration:underline'>nội dung CHƯƠNG TRÌNH
                </span></strong>
            </h3>"; echo "<br>";

    

    print_ctcaykkt_table_caykkt($ctdt->ma_cay_khoikienthuc, $ctdt->ma_ctdt);

}



/////////////IN CAY KHOI KIEN THUC/////////////////////////////

function print_ctcaykkt_table_caykkt($ma_cay_khoikienthuc, $ma_ctdt){
    $list_caykkt = get_list_caykkt_byMaCay($ma_cay_khoikienthuc);

    foreach($list_caykkt as $item){
        if($item->ma_tt != NULL && $item->ma_khoicha != NULL && $item->ma_khoi != 'caykkt'){
            $khoi = get_kkt_byMaKhoi($item->ma_khoi);

            $ma_tt = '7.' . $item->ma_tt .' ' . $khoi->ten_khoi . '<br>';

            if( intval(count(explode('.',$item->ma_tt)) < 2)){
                echo "<h3 style='text-transform: uppercase '><strong style='font-weight: 600; font-family: auto;'>$ma_tt</strong></h3>"; echo "<br>";
            }else{
                echo "<h4 ><strong style='font-weight: 600; font-family: auto;'>$ma_tt</strong></h4>"; echo "<br>";
            }
            // echo '<h4>' . $item->ma_tt . ' ' . $khoi->ten_khoi . '<h4>';

            print_ctcaykkt_table_kkt($item->ma_khoi, $ma_ctdt);
        }
    }

}


function print_ctcaykkt_table_kkt($ma_khoi, $ma_ctdt){
    print_preview_table_kkt(get_list_monhoc($ma_khoi), get_list_khoicon($ma_khoi), $ma_ctdt);
}

function get_list_monhoc($ma_khoi){
    $all_monthuockhoi = get_monthuockhoi($ma_khoi);

    $listmon = array();
    foreach($all_monthuockhoi as $item){
        $listmon[] = $item->mamonhoc;
    }
    return $listmon;
}

function get_list_khoicon($ma_khoi){
    $all_khoi = get_list_khoicon_byMaKhoi($ma_khoi);

    $listkkt = array();
    foreach($all_khoi as $item){
        $listkkt[] = $item->ma_khoi;
    }
    
    return $listkkt;
}

function print_preview_table_kkt($arrmamon, $arr_makhoi, $ma_ctdt){
    global $DB, $USER;

    $allmonhocs = array();
    $stt = 1;

    $table = new html_table();
    $table->head = array('', 'STT', 'Mã', 'Tên', 'Số TC', 'LT', 'TH', 'BT', 'Tình trạng', 'Mở lớp');

    if($arrmamon != NULL){
        
        foreach($arrmamon as $key => $item){

            $imonhoc = $DB->get_record('eb_monhoc', ['mamonhoc' => $item]);

            $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $imonhoc->id]);
            $ten_url = \html_writer::link($url, $imonhoc->tenmonhoc_vi);
            $checkbox = html_writer::tag('input', ' ', array('class' => 'molop_checkbox', 'type' => "checkbox", 'name' => $imonhoc->id, 'id' => 'monhoc' . $imonhoc->mamonhoc, 'value' => '0', 'onclick' => "changecheck_chitiet_ctdt('".$imonhoc->mamonhoc."')"));
            
            $url_molop = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $imonhoc->id]);
            $ten_url_molop = \html_writer::link($url, 'Mở lớp');

            $tinhtrang = 'Chưa mở lớp nào';
            $num = count_molop_monhoc($item, $ma_ctdt);
            if($num != 0){
                $tinhtrang = 'Đã mở được ' . $num . ' lớp';
            }

            $table->data[] = [$checkbox, (string) $stt, (string) $item, (string) $ten_url,
                                (string) $imonhoc->sotinchi, (string) $imonhoc->sotietlythuyet,
                                (string) $imonhoc->sotietthuchanh, (string) $imonhoc->sotiet_baitap,
                             $tinhtrang, $ten_url_molop];
            $stt++;
        }
    }

    if($arr_makhoi != NULL){
        foreach($arr_makhoi as $item){
            $khoi = get_kkt_byMaKhoi($item);
            
            $table->data[] = ['', $stt, $khoi->mota, '', '', '' , '', '', '', ''];
            $stt++;

            $url_molop = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $imonhoc->id]);
            $ten_url_molop = \html_writer::link($url, 'Mở lớp');

            $tinhtrang = 'Chưa mở lớp nào';
            $num = count_molop_monhoc($item, $ma_ctdt);
            if($num != 0){
                $tinhtrang = 'Đã mở được ' . $num . ' lớp';
            }

            $listmonthuockhoi = get_monthuockhoi($item);
            if($listmonthuockhoi != NULL){
                foreach($listmonthuockhoi as $mon){
                    $imonhoc = (array) $DB->get_record('eb_monhoc', ['mamonhoc' => $mon->mamonhoc]);

                    $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/update_monhoc.php', ['id' => $imonhoc['id']]);
                    $ten_url = \html_writer::link($url, $imonhoc['tenmonhoc_vi']);
                    
                    $table->data[] = [$checkbox,'', (string) $mon->mamonhoc, (string) $ten_url,
                                        (string) $imonhoc['sotinchi'], (string) $imonhoc['sotietlythuyet'],
                                        (string) $imonhoc['sotietthuchanh'], (string) $imonhoc['sotiet_baitap'],
                                        $tinhtrang, $ten_url_molop];
                }
            }
        }
    }
    
    if($table->data != NULL){
        echo html_writer::table($table);
    }
}

function find_chuandaura_con($arr, $ma_cdr, $level, $ma_cay_cdr){

    $arr_result = array();

    foreach($arr as $iarr){
        if($iarr['level_cdr'] == $level && $iarr['ma_cay_cdr'] == $ma_cay_cdr){

            if(startsWith($iarr['ma_cdr'], $ma_cdr)){
                $arr_result[] = $iarr;
            }

        }
    }
    return $arr_result;
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function count_molop_monhoc($mamonhoc, $ma_ctdt){
    global $DB, $USER;
    return $DB->count_records('eb_lop_mo', ['mamonhoc' => $mamonhoc, 'ma_ctdt' => $ma_ctdt]);
}

function print_open_courseButton(){
    $action_form =
    html_writer::start_tag('div', array('style' => 'display: flex; justify-content:flex-end;'))
    . '<br>'
    . html_writer::tag(
        'button',
        'Mở lớp',
        array('id' => 'btn_open_course', 'style' => 'margin:0 5px;border: 1px solid #333; border-radius: 3px; width: 130px; height:35px; padding: 0; background-color: white; color: black;')
    )
    . '<br>'
    . html_writer::end_tag('div');
echo $action_form;
}

?>

<script> 
    function changecheck_chitiet_ctdt(mamonhoc)
    {
        alert(mamonhoc)
        // var id = 'monhoc' + mamonhoc;
        // if (document.getElementById(id).checked == false)
        // {
        //     document.getElementById(id).value = '0';
        // }
        // else
        // {
        //     document.getElementById(id).value = '1';
        // }
    }
</script>