<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class ask_for_update_form extends moodleform
{

    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('submit', 'btn_update', 'Chỉnh sửa');
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