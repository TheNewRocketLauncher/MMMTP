<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class qlbac_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        // Header
        $mform->addElement('header', 'general', 'Quản lý thông tin');

        // id
        $idbac = array();
        $idbac[] = &$mform->createElement('text', 'idbac', 'none', 'size="70"');
        $mform->addGroup($idbac, 'idbac', 'ID', array(' '), false);

        // Mã bậc
        $mabac = array();
        $mabac[] = &$mform->createElement('text', 'mabac', 'none', 'size="70"');
        $mform->addGroup($mabac, 'mabac', 'Mã bậc đào tạo', array(' '), false);

        // Tên bậc
        $tenbac = array();
        $tenbac[] = &$mform->createElement('text', 'tenbac', 'none', 'size="70"');
        $mform->addGroup($tenbac, 'tenbac', 'Tên bậc đào tạo', array(' '), false);

        // Mô tả
        $mota = array();
        $mota[] = &$mform->createElement('textarea', 'mota', '', 'wrap="virtual" rows="7" cols="75"');
        $mform->addGroup($mota, 'mota', 'Mô tả', array(' '), false);

        // Button
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', 'Thực hiện');
        $buttonarray[] = $mform->createElement('cancel', null, 'Hủy');
        $mform->addGroup($buttonarray, 'buttonarr', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
