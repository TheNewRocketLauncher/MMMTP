<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/ctdt_model.php');
$id = required_param('id', PARAM_INT);

if(can_edit_ctdt($id)){
    delete_ctdt($id);
    echo json_encode(['error' => 0]);
} else{
    echo json_encode(['error' => 1, 'errorMess' => 'Chuong trình dào t?o dang du?c s? d?ng']);
}

exit;

