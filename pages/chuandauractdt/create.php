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


    $ma_cdr_cha = $mform->get_submit_value('ma_cdr_cha');
    $rsx = handle($ma_cdr_cha);
    $tempt_1 =  explode(".", $ma_cdr_cha);
    $level = count($tempt_1); //level
    if($ma_cdr_cha ==0 ){
        $level =0;
    }

    $param1->ma_cdr = $rsx;
    $param1->have_ctdt = 0;
    
    $param1->ten = $mform->get_data()->ten;
    $param1->mota = $mform->get_data()->mota;
    $param1->level_cdr = intval($level) +1 ;

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

function handle( $ma_cdr_cha){
    global $DB, $USER, $CFG, $COURSE;
    if($ma_cdr_cha == "0"){
        $max = 0 ;
        $maxNew = 0 ;
        $maxOld = 0;
        $maxResult = 0 ;
        $rows_cdr = $DB->get_records('block_edu_chuandaura_ctdt', []);
        usort($rows_cdr, function($a, $b)
        {
           return strcmp($a->ma_cdr, $b->ma_cdr);
        });
        foreach ($rows_cdr as $item) {
            if($item->level_cdr == "1" ){     
                $maxOld = $maxNew; 
                if( $maxNew < getLastValue($item->ma_cdr)){
                    $maxNew = getLastValue($item->ma_cdr);
                }
                if (($maxNew-$maxOld)>1 && $maxResult == 0  ){
                    $maxResult = $maxOld  +1;
                }
            }        
        }  
        $max = $maxResult == 0 ? ($maxNew+1) : $maxResult;

        return $max;
    }
    
    else if (intval($ma_cdr_cha) >= 1) {
        $rows = $DB->get_record('block_edu_chuandaura_ctdt', ['ma_cdr' => $ma_cdr_cha]);
        $level_cha = $rows->level_cdr;
        $level_con = intval($level_cha) + 1;
        $rows_cdr = $DB->get_records('block_edu_chuandaura_ctdt', []);
        usort($rows_cdr, function($a, $b)
        {
           return strcmp($a->ma_cdr, $b->ma_cdr);
        });


        $maxNew = 0 ;
        $maxOld = 0;
        $maxResult = 0 ;
        foreach ($rows_cdr as $item) {
            if($item->level_cdr == $level_con && startsWith($item->ma_cdr ,$ma_cdr_cha)){ 
                $maxOld = $maxNew; 
                if( $maxNew < getLastValue($item->ma_cdr)){
                    $maxNew = getLastValue($item->ma_cdr);
                }
                if (($maxNew-$maxOld)>1 && $maxResult == 0  ){
                    $maxResult = $maxOld  +1;
                }
            }        
        }        
        $max = $maxResult == 0 ? ($maxNew+1) : $maxResult;
        $result = $ma_cdr_cha . '.' . ($max);
        return $result; 
    }

}

function startsWith($haystack, $needle) // kiem tra trong chuỗi hastack có đưuọc bắt đầu bằng chuỗi needle ko
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
function cmp($a, $b) {
    return strcmp($a->datatemp, $b->datatemp);
}
function getLastValue($item){
    $temp = explode(".",$item);
    $count = count($temp)-1;
    
    return $temp[$count];
}
// Footer
echo $OUTPUT->footer();