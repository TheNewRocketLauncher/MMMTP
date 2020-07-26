<?php

function is_check($arr, $ma_bac, $ma_he, $ma_nienkhoa, $ma_nganh, $ma_chuyennganh)
{
    foreach ($arr as $item) {
        if ($ma_bac != '') {
            if ($item->ma_bac == $ma_bac && $ma_he == '') {
                return false;
            }
            if ($ma_he != '') {
                if ($item->ma_bac == $ma_bac && $item->ma_he == $ma_he && $ma_nienkhoa == '') {
                    return false;
                }
                if ($ma_nienkhoa != '') {
                    if ($item->ma_bac == $ma_bac && $item->ma_he == $ma_he && $item->ma_nienkhoa == $ma_nienkhoa && $ma_nganh == '') {
                        return false;
                    }
                    if ($ma_nganh != '') {
                        if ($item->ma_bac == $ma_bac && $item->ma_he == $ma_he && $item->ma_nienkhoa == $ma_nienkhoa && $item->ma_nganh == $ma_nganh && $ma_chuyennganh == '') {
                            return false;
                        }
                        if ($ma_chuyennganh != '') {
                            if ($item->ma_bac == $ma_bac && $item->ma_he == $ma_he && $item->ma_nienkhoa == $ma_nienkhoa && $item->ma_nganh == $ma_nganh && $item->ma_chuyennganh == $ma_chuyennganh) {
                                return false;
                            }
                        }
                    }
                }
            }
        }
    }
    return true;
}
