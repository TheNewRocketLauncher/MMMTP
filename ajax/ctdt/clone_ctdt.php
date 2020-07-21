<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once('../../model/ctdt_model.php');
$id = required_param('id', PARAM_INT);

$ctdt = get_ctdt_byID($id);
$new_ma_ctdt = $ctdt->ma_ctdt . '1';
while(get_ctdt_byMa($new_ma_ctdt)){
    $new_ma_ctdt++;
}
$ctdt->ma_ctdt = $new_ma_ctdt;
unset($ctdt->id);

insert_ctdt($ctdt);

exit;