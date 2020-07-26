<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../form/ctdt/pdf_ctdt_form.php');
require_once('../../controller/validate.php');
require_once('../../js.php');

global $COURSE, $DB;


    // Check permission.
    require_login();
    $context = \context_system::instance();
    require_once('../../controller/auth.php');
    require_permission("ctdt","edit");
    global $CFG;
    $CFG->cachejs = false;
    $PAGE->requires->js_call_amd('block_educationpgrs/module', 'init');
    
    // Setting up the page.
    $PAGE->set_url(new moodle_url('/blocks/educationpgrs/pages/bacdt/add_bdt.php', ['courseid' => $courseid]));
    $PAGE->set_context($context);
    $PAGE->set_pagelayout('standard');

    // Navbar.
    $PAGE->navbar->add('Các danh mục quản lý chung', new moodle_url('/blocks/educationpgrs/pages/main.php'));
    $PAGE->navbar->add('PDF CTDT', new moodle_url('/blocks/educationpgrs/pages/ctdt/pdf_ctdt.php'));

    // Title.
    $PAGE->set_title('PDF CTDT');
    $PAGE->set_heading('Xem file pdf chương trình đào tạo');

// Print header
echo $OUTPUT->header();


echo "<br><p style='color:#1177d1; margin-left: 0; font-size: 1.5rem;'>❖ Chọn chương trình đào tạo</p>";

$mform = new index_form();
$mform->display();



if ($mform->is_cancelled()) {
    
} else if ($mform->no_submit_button_pressed()) {
    
} else if ($fromform = $mform->get_data()) {

    $ma_nganh = $mform->get_submit_value('eb_nganhdt');

    $arr_ctdt = array();
    $arr_ctdt_tam = get_ctdt_form_nganh($ma_nganh);
    foreach($arr_ctdt_tam as $iarr_ctdt_tam){
        
        $chitietctdt = get_detail_ctdt( $iarr_ctdt_tam->ma_ctdt);
        
        $arr_ctdt[] = ['ten' => $chitietctdt->mota, 'ma_ctdt'=>$chitietctdt->ma_ctdt];
    }

    

    foreach($arr_ctdt as $iarr_ctdt){

        if($iarr_ctdt['ma_ctdt']){
            $action_form1 =
                html_writer::start_tag('div', array('style' => 'display: block; padding: 15px; text-align: center'))
                    .
                    html_writer::tag(
                        'tag',
                        "<a href='../pages/decuong/matrix.php' style='margin-bottom: 20px;text-align: start;float:left;width:100%;background-image:url(/moodle/theme/image.php/boost/core/1594902682/i/course);background-repeat: no-repeat;
                    line-height: 1.2;font-size: 1.640625rem; font-weight: 500; padding-left: 40px; color:#f60;
                    '>".$iarr_ctdt['ma_ctdt'].'-'. $iarr_ctdt['ten']."</a>",
                        array('id' => 'btn_delete_decuongmonhoc', 'onClick' => "window.location.href='../pages/decuong/matrix.php'",
                        'style' => 'margin:20px;')) 

                . html_writer::end_tag('div');
                
                echo $action_form1;
        }
    }
    



} else {
    
    
}



function get_ctdt_form_nganh($ma_nganh){
    global $DB;
    return $DB->get_records('eb_ctdt_thuoc_nganh', ['ma_nganh'=>$ma_nganh]);
}

function get_detail_ctdt($ma_ctdt){
    global $DB;
    return $DB->get_record('eb_ctdt', ['ma_ctdt'=>$ma_ctdt]);
}

// Footer
echo $OUTPUT->footer();
