<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class index_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        // $mform->registerNoSubmitButton('newkkt');
        // $mform->addElement('submit', 'newkkt', get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
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

class kkt_seach extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $monhoc_seach = array();
        
        $monhoc_seach[] = &$mform->createElement('text', 'kkt_content_seach', 'none',  array('size'=>'40'));
        $monhoc_seach[] = &$mform->createElement('submit', 'kkt_btn_seach', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($monhoc_seach, 'seach_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
