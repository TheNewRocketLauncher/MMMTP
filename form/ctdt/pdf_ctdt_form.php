<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class index_form extends moodleform
{

    public function definition()
    {
        global $CFG;
        $mform = $this->_form;
        global $DB;

        $arr_hedt = array();$arr_bacdt = array();
        
        $arr_bacdt += $DB->get_records('eb_bacdt', []);
        $arr_bacdt1 = array();
        $arr_bacdt1 += [''=>'Chọn bậc đào tạo'];
        foreach($arr_bacdt as $iarr_bacdt){
            $arr_bacdt1[] += [$iarr_bacdt->ma_bac => $iarr_bacdt->ma_bac];
        }

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'eb_bacdt', '', $arr_bacdt1, array());
        $mform->addGroup($eGroup, 'eb_bacdt', 'Chọn bậc đào tạo', array(' '), false);


        $arr_hedt += $DB->get_records('eb_hedt', []);
        $arr_hedt1 = array();
        $arr_hedt1 += [''=>'Chọn hệ đào tạo'];
        foreach($arr_hedt as $iarr_hedt){
            $arr_hedt1 += [$iarr_hedt->ma_he => $iarr_hedt->ma_he];
        }
        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'eb_hedt', '', $arr_hedt, array());
        $mform->addGroup($eGroup, 'eb_hedt', 'Chọn hệ đào tạo', array(' '), false);

        
        $arr_nkhoa = array();$arr_nganhdt = array();
        $arr_nkhoa += $DB->get_records('eb_nienkhoa', []);

        $arr_nkhoa1 = array();
        $arr_nkhoa1 += [''=>'Chọn khóa tuyển'];
        foreach($arr_nkhoa as $iarr_nkhoa){
            $arr_nkhoa1 += [$iarr_nkhoa->ma_nienkhoa => $iarr_nkhoa->ma_nienkhoa];
        }
        
        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'eb_nkhoa', '', $arr_nkhoa1, array());
        $mform->addGroup($eGroup, 'eb_bacdt', 'Chọn khóa tuyển', array(' '), false);

        
        
        $arr_nganhdt += $DB->get_records('eb_nganhdt', []);
        $arr_nganhdt1 = array();
        $arr_nganhdt1 += [''=>'Chọn ngành đào tạo'];
        foreach($arr_nganhdt as $iarr_nganhdt){
            $arr_nganhdt1 += [$iarr_nganhdt->ma_nganh => $iarr_nganhdt->ma_nganh];
        }

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'eb_nganhdt', '', $arr_nganhdt1, array());
        $mform->addGroup($eGroup, 'eb_bacdt', 'Chọn ngành', array(' '), false);


        $btn_get_pdf = array();
        
        $btn_get_pdf[] = &$mform->createElement('submit', 'btn_get_pdf', 'Tìm file PDF', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($btn_get_pdf, 'btn_get_pdf', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }

    function get_submit_value($elementname)
    {
        $mform = $this->_form;
        return $mform->getSubmitValue($elementname);
    }
}

