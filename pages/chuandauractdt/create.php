<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/chuandaura_ctdt_model.php');

global $COURSE;

// Setting up the page.
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/create.php', []));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

// Navbar.
$PAGE->navbar->add("Danh sách chuẩn đầu ra chương trình đào tạo", new moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php'));
$PAGE->navbar->add('Thêm chuẩn đầu ra chương trình đào tạo');

// Title.
$PAGE->set_title('Thêm chuẩn đầu ra chương trình đào tạo'  );
$PAGE->set_heading('Thêm chuẩn đầu ra chương trình đào tạo'  );
$PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');

// Print header
echo $OUTPUT->header();

// Form
require_once('../../form/chuandauractdt/chuandaura_ctdt_form.php');
$mform = new chuandaura_ctdt_form();

// Process form
if ($mform->is_cancelled()) {
    // Handle form cancel operation
} else if ($mform->no_submit_button_pressed()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    /* Thực hiện insert */
    $param1 = new stdClass();
    $param1->ma_ctdt = $mform->get_submit_value('ma_ctdt_cdr');

    $ma_cdr_cha = $mform->get_submit_value('ma_cdr_cha');
    
    
    // $param1->ma_cdr = $mform->get_data()->ma_cdr;
    $rsx = handle($param1->ma_ctdt, $ma_cdr_cha);


    $param1->ma_cdr = $rsx;

    


    $param1->ten = $mform->get_data()->ten;
    $param1->mota = $mform->get_data()->mota;
    insert_chuandaura_ctdt($param1);

    // Hiển thị thêm thành công
    echo '<h2>Thêm mới thành công!</h2>';
    echo '<br>';
    // Link đến trang danh sách
    $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php', []);
    $linktext = get_string('label_chuandauractdt', 'block_educationpgrs');
    echo \html_writer::link($url, $linktext);
} else if ($mform->is_submitted()) {
    // Button submit
    echo "<h2 style ='color:red;' ><b>Thêm mới thất bại! </b></h2>";
    $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/create.php', []);
    echo '<br>';

    $linktext = "Thêm mới chuẩn đầu ra chương trình đào tạo";
    echo \html_writer::link($url, $linktext);
} else {
    $mform->set_data($toform);
    $mform->display();
}



function handle($ma_ctdt, $ma_cdr_cha){

    
    
    global $DB, $USER, $CFG, $COURSE;

    //Trường hợp ma_cdr_cha = "chọn chuẩn đẩu ra"
    // if(count(explode(" ",$ma_cdr_cha)) >2  ){
        
    // }
    // $all_ctdt_cdr = $DB->get_records('block_edu_chuandaura_ctdt', ['ma_ctdt'=>$ma_ctdt]);

    // $count = 0 ;
    // foreach ($all_ctdt_cdr as $item) {
    //     if (strlen($item->ma_cdr) <=2 ){
    //         $count ++;
    //     }
    // }


    // for strlen


    if( intval($ma_cdr_cha) >=1){
        $tempt_1 =  explode(".", $ma_cdr_cha);
        $level = count($tempt_1); //level
        $level_con = intval($level) +1;
    }else{
        $level =0;
        $level_con = 1;
        
    }
    
    
    $lev = array(); $save = array(); $tempt_2 = array();$tempt = array();$tempt_3 = array();$tempt_4= array();

    
    $All_ctdt = $DB->get_records('block_edu_chuandaura_ctdt', ['ma_ctdt'=>$ma_ctdt]);

    

    foreach($All_ctdt as $i_ctdt){
        $lev =  explode(".", $i_ctdt->ma_cdr);

        $len = count($lev); // do dai cua moi ma_cdr

        $save[] = [ 'level' => $len, 'data' => $i_ctdt->ma_cdr];


    }



    //save = [{level: 1, data:1}, {level:2, data:1.1}, {level:3, data:1.2.1}]

    foreach($save as $isave){

        if($isave['level'] == $level_con && startsWith($isave['data'], $ma_cdr_cha)){
            $tempt_2[] = $isave;
        }
    }
    

    // vidu: ma_cdr_cha = 1.1 => ket qua: tempt_2 =  [{level:3, data: 1.1.1} , {level:3, data: 1.1.2}]

    foreach($tempt_2 as $itempt){
        $tempt_3[] = $itempt['data'];
        
    }

    //sort

    rsort($tempt_3);
    
    $tempt_4= explode(".", $tempt_3[0]);

    $len_1 = count($tempt_4);

    $result = $tempt_4[$len_1-1];


    
    $rsx_1 = intval($result) + 1;

    $result = $ma_cdr_cha . '.' . $rsx_1;
    if ($level_con == 1 ){
        $result = $rsx_1;
    }

    return $result;
    // return 'khong';
}

function startsWith($haystack, $needle) // kiem tra trong chuỗi hastack có đưuọc bắt đầu bằng chuỗi needle ko
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
// Footer
echo $OUTPUT->footer();