<?php

// Standard config file and local library.  
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/global_model.php');
$mamonhoc = required_param('mamonhoc', PARAM_ALPHA);
function delete_monthuockhoi_global($mamonhoc) {
    global $DB, $USER;

    // $global_string = get_global($USER->id);
    // if($global_string['newkkt']['listmonhoc']['index'] == 1){
    //     $global_string['newkkt']['listmonhoc']['values'] = array();
    //     $global_string['newkkt']['listmonhoc']['index'] == 0;
    //     set_global($USER->id, $global_string);
    // } else 

    if (($key = array_search($mamonhoc, $listmonhoc)) !== false) {
        $listmonhoc = $global_string['newkkt']['listmonhoc']['values'];
        unset($listmonhoc[$key]);
        $global_string['newkkt']['listmonhoc']['values'] = $listmonhoc;
        $global_string['newkkt']['listmonhoc']['index']--;

        if($global_string['newkkt']['listmonhoc']['values'] == null){
            $global_string['newkkt']['listmonhoc']['values'] = array();
        }
        if($global_string['newkkt']['listmonhoc']['index'] == null){
            $global_string['newkkt']['listmonhoc']['index'] = 0;
        }
        set_global($USER->id, $global_string);
    }
}

// Xóa b?c dào t?o có id truy?n vào
delete_monthuockhoi_global($mamonhoc);
// return
echo $mamonhoc;
exit;