<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

class index_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $mform->registerNoSubmitButton('newkkt');
        $mform->addElement('submit', 'newkkt', get_string('themkkt_btn_themkhoimoi', 'block_educationpgrs'));
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
