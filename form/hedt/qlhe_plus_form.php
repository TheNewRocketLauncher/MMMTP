<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once("../../js.php");

class qlhe_plus_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        // Header
        $mform->addElement('header', 'general', 'Quản lý thông tin');

        // ID
        $idhe = array();
        $idhe[] = &$mform->createElement('text', 'idhe', 'none', 'size="70"');
        $mform->addGroup($idhe, 'idhe', 'ID', array(' '), false);

        // Mã bậc
        $mabac = array();
        $allbacdts = $DB->get_records('eb_bacdt', []);
        $arr_mabac = array();
        foreach ($allbacdts as $ibacdt) {
            $arr_mabac += [$ibacdt->ma_bac => $ibacdt->ma_bac];
        }
        $mabac[] = &$mform->createElement('select', 'mabac', 'test select:', $arr_mabac, array());
        $mform->addGroup($mabac, 'mabac', 'Mã bậc đào tạo', array(' '), false);

        // Ma he
        $mahe = array();
        $allhedts = $DB->get_records('eb_hedt', []);
        $arr_mahe = array();
        foreach ($allhedts as $ihedt) {
            $arr_mahe += [$ihedt->ma_he => $ihedt->ma_he];
        }
        $mahe[] = &$mform->createElement('select', 'mahe', 'test select:', $arr_mahe, array());
        $mform->addGroup($mahe, 'mahe', 'Mã hệ đào tạo', array(' '), false);

        // Tên hệ
        $tenhe = array();
        $tenhe[] = &$mform->createElement('text', 'tenhe', 'B', 'size="70"');
        $mform->addGroup($tenhe, 'tenhe', 'Tên hệ đào tạo', array(' '), false);

        // Mô tả
        $mota = array();
        $mota[] = &$mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
        $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);

        // Button
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Thực hiện');
        $buttonarray[] = $mform->createElement('cancel', null, 'Hủy');
        $mform->addGroup($buttonarray, 'buttonar', '', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }

    function get_editor_options()
    {
        $editoroptions = [
            // 'subdirs' => 0,
            // 'maxbytes' => 0,
            // 'maxfiles' => 0,
            // 'noclean' => false,
            // 'trusttext' => false
        ];
        return $editoroptions;
    }
}
