<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once('../../model/khoikienthuc_model.php');

class newkkt_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general0', get_string('themctdt_thongtintongquat', 'block_educationpgrs'));
        $mform->setExpanded('general0', true);
        ///----------------------------------------------------------------------------------------------------------------------///         

        $arr_loaikhoi = array(
            0 => 'Bắt buộc',
            1 => 'Tự chọn'
        );
        $arr_xettren = array(
            0 => 'Tín chỉ',
            1 => 'Tiết lý thuyết',
            2 => 'Tiết thực hành',
            3 => 'Tiết bài tập'
        );
        $arr_loaikhoi = array(
            0 => 'Bắt buộc',
            1 => 'Tự chọn'
        );
        $arr_dieukien = array(
            0 => 'Có điều kiện',
            1 => 'Không điều kiện'
        );
        $arr_xettren_op = array(
            0 => 'Tối thiểu',
            1 => 'Tối đa'
        );

        $mform->addElement('text', 'txt_tenkkt', get_string('themkkt_lbl_tenkhoi', 'block_educationpgrs'), 'size="200"');
        $mform->addRule('txt_tenkkt', 'Tên khối không được trống', 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('text', 'txt_makhoi', get_string('themkkt_lbl_makhoi', 'block_educationpgrs'), 'size="200"');
        $mform->addRule('txt_makhoi', 'Mã khối không được để trống', 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'select_loaikhoi', '', $arr_loaikhoi);
        $mform->addGroup($eGroup, 'gtxt_loaikhoi', get_string('themkkt_lbl_loaikhoi', 'block_educationpgrs'), array(' '), false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'select_operator', '', $arr_xettren_op);
        $eGroup[] = &$mform->createElement('text', 'txt_xettren_value', '', 'size="5"');
        $eGroup[] = &$mform->createElement('select', 'select_xettren', '', $arr_xettren);
        $mform->addGroup($eGroup, 'gtxt_loaidieukien', get_string('themkkt_lbl_xettren', 'block_educationpgrs'), array(' '), false);

        $mform->hideIf('gtxt_loaidieukien', 'select_loaikhoi', 'eq', 0);

        $mform->addElement('text', 'txt_mota', get_string('themkkt_lbl_mota', 'block_educationpgrs'), 'size="200"');

        $mform->registerNoSubmitButton('btn_addkhoicon');

        // $mform->addElement('checkbox', 'checkbox_cokhoicon', 'Có khối con');
        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        $mform->addElement('autocomplete', 'area_ma_khoi', 'Chọn các khối con', $this->get_listkkt(), $options);
        $mform->hideIf('area_ma_khoi', 'select_loaikhoi', 'eq', 1);

        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        $mform->addElement('autocomplete', 'area_mamonhoc', 'Chọn các môn học', $this->get_listmonhoc(), $options);

        $mform->addElement('submit', 'btn_review', 'Xem trước');
        // $mform->registerNoSubmitButton('btn_review');
        $mform->registerNoSubmitButton('btn_cancle');
        // $mform->registerNoSubmitButton('btn_newkkt');
        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_newkkt', get_string('themkkt_btn_complete', 'block_educationpgrs'));
        $eGroup[] = &$mform->createElement('submit', 'btn_cancle', get_string('themkkt_btn_cancel', 'block_educationpgrs'));
        $mform->addGroup($eGroup, 'gbtn', '', array(' '), false);
    }

    function validation($data, $files)
    {
        
    }

    function get_submit_value($elementname)
    {
        $mform = &$this->_form;
        return $mform->getSubmitValue($elementname);
    }
    
    function get_listmonhoc()
    {
        global $CFG, $DB;
        $allmonhoc = $DB->get_records('eb_monhoc');
        if ($allmonhoc == null) {
            return null;
        } else {
            $arr_mamonhoc = array();
            foreach ($allmonhoc as $imonhoc) {
                $arr_mamonhoc += array($imonhoc->mamonhoc => $imonhoc->mamonhoc);
            }
        }
        return $arr_mamonhoc;
    }

    function get_listkkt()
    {
        global $CFG, $DB;
        $all_khoi = $DB->get_records('eb_khoikienthuc', []);
        if ($all_khoi == null) {
            return null;
        } else {
            $arr_kkt = array();
            foreach ($all_khoi as $item) {
                $arr_kkt += array($item->ma_khoi => $item->ma_khoi);
            }
        }
        return $arr_kkt;
    }
}

class editkkt_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        ///----------------------------------------------------------------------------------------------------------------------///        
        $mform->addElement('header', 'general0', get_string('themctdt_thongtintongquat', 'block_educationpgrs'));
        $mform->setExpanded('general0', true);
        ///----------------------------------------------------------------------------------------------------------------------///         

        $arr_loaikhoi = array(
            0 => 'Bắt buộc',
            1 => 'Tự chọn'
        );
        $arr_xettren = array(
            0 => 'Tín chỉ',
            1 => 'Tiết lý thuyết',
            2 => 'Tiết thực hành',
            3 => 'Tiết bài tập'
        );
        $arr_loaikhoi = array(
            0 => 'Bắt buộc',
            1 => 'Tự chọn'
        );
        $arr_dieukien = array(
            0 => 'Có điều kiện',
            1 => 'Không điều kiện'
        );
        $arr_xettren_op = array(
            0 => 'Tối thiểu',
            1 => 'Tối đa'
        );

        $mform->addElement('text', 'txt_tenkkt', get_string('themkkt_lbl_tenkhoi', 'block_educationpgrs'), 'size="200"');
        $mform->addRule('txt_tenkkt', 'Tên khối không được trống', 'required', 'extraruledata', 'server', false, false);

        $mform->addElement('text', 'txt_makhoi', get_string('themkkt_lbl_makhoi', 'block_educationpgrs'), 'size="200"');
        $mform->addRule('txt_makhoi', 'Mã khối không được để trống', 'required', 'extraruledata', 'server', false, false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'select_loaikhoi', '', $arr_loaikhoi);
        $mform->addGroup($eGroup, 'gtxt_loaikhoi', get_string('themkkt_lbl_loaikhoi', 'block_educationpgrs'), array(' '), false);

        $eGroup = array();
        $eGroup[] = &$mform->createElement('select', 'select_operator', '', $arr_xettren_op);
        $eGroup[] = &$mform->createElement('text', 'txt_xettren_value', '', 'size="5"');
        $eGroup[] = &$mform->createElement('select', 'select_xettren', '', $arr_xettren);
        $mform->addGroup($eGroup, 'gtxt_loaidieukien', get_string('themkkt_lbl_xettren', 'block_educationpgrs'), array(' '), false);

        $mform->hideIf('gtxt_loaidieukien', 'select_loaikhoi', 'eq', 0);

        $mform->addElement('text', 'txt_mota', get_string('themkkt_lbl_mota', 'block_educationpgrs'), 'size="200"');

        $mform->registerNoSubmitButton('btn_addkhoicon');

        // $mform->addElement('checkbox', 'checkbox_cokhoicon', 'Có khối con');
        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        $mform->addElement('autocomplete', 'area_ma_khoi', 'Chọn các khối con', $this->get_listkkt(), $options);
        $mform->hideIf('area_ma_khoi', 'select_loaikhoi', 'eq', 1);

        //$mform->addElement('checkbox', 'checkbox_comonhoc', 'Có môn học');
        $options = array(
            'multiple' => true,
            'noselectionstring' => 'Empty',
        );
        $mform->addElement('autocomplete', 'area_mamonhoc', 'Chọn các môn học', $this->get_listmonhoc(), $options);

        $mform->registerNoSubmitButton('btn_review');
        $mform->registerNoSubmitButton('btn_cancle');
        $mform->registerNoSubmitButton('btn_edit');
        $mform->registerNoSubmitButton('btn_newkkt');
        
        $mform->addElement('submit', 'btn_review', 'Xem trước');

        $eGroup = array();
        $eGroup[] = &$mform->createElement('submit', 'btn_edit', 'Lưu');
        $eGroup[] = &$mform->createElement('submit', 'btn_newkkt', 'Tạo mới');
        $eGroup[] = &$mform->createElement('submit', 'btn_cancle', get_string('themkkt_btn_cancel', 'block_educationpgrs'));
        $mform->addGroup($eGroup, 'gbtn', '', array(' '), false);

        $mform->addElement('hidden', 'edit_mode', '0');
        $mform->addElement('hidden', 'ma_khoi', '');
        // $mform->disabledIf('txt_makhoi', 'edit_mode', 'eq', '0');
        $mform->hideIf('btn_edit', 'edit_mode', 'eq', '0');
        $mform->hideIf('btn_newkkt', 'edit_mode', 'eq', '1');
    }

    function validation($data, $files)
    {
        
    }

    function get_submit_value($elementname)
    {
        $mform = &$this->_form;
        return $mform->getSubmitValue($elementname);
    }
    
    function get_listmonhoc()
    {
        global $CFG, $DB;
        $allmonhoc = $DB->get_records('eb_monhoc');
        if ($allmonhoc == null) {
            return null;
        } else {
            $arr_mamonhoc = array();
            foreach ($allmonhoc as $imonhoc) {
                $arr_mamonhoc += array($imonhoc->mamonhoc => $imonhoc->mamonhoc);
            }
        }
        return $arr_mamonhoc;
    }

    function get_listkkt()
    {
        global $CFG, $DB;
        $all_khoi = $DB->get_records('eb_khoikienthuc', []);
        if ($all_khoi == null) {
            return null;
        } else {
            $arr_kkt = array();
            foreach ($all_khoi as $item) {
                $arr_kkt += array($item->ma_khoi => $item->ma_khoi);
            }
        }
        return $arr_kkt;
    }
}

class test_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;

        $mform->addElement('text', 'text', 'text');
        
        $mform->addElement('submit', 'btn_submit', 'submit');
        $mform->addElement('submit', 'btn_noSubmit', 'noSubmit');
    }

    function validation($data, $files)
    {
        
    }

    function get_submit_value($elementname)
    {
        $mform = &$this->_form;
        return $mform->getSubmitValue($elementname);
    }
}
