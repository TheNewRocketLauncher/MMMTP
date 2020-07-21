<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");

// Form select ctdt
class select_ctdt_form extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Select CTDT
        $ctdt_select = array();
        $allctdts = $DB->get_records('eb_ctdt', []);
        $arr_mactdt = array();
        $arr_mactdt += ['' => 'Chọn Chương trình đào tạo...'];

        foreach ($allctdts as $ictdt) {
            $arr_mactdt += [$ictdt->ma_ctdt => $ictdt->ma_ctdt];
        }
        $ctdt_select[] = &$mform->createElement('select', 'mactdt', 'select:', $arr_mactdt, array());
        $ctdt_select[] = &$mform->createElement('submit', 'btn_ctdt_select', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($ctdt_select, 'ctdt_select_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }

    function get_value() {
        $mform = & $this->_form;
        $data = $mform->exportValues();
        return (object)$data;
    }
}

class search_lopmo_thuocdanhmuc extends moodleform
{
    public function definition()
    {
        global $CFG, $DB;
        $mform = $this->_form;
        
        // Search        
        $lopmo_search = array();
        // $lopmo_search[] = &$mform->createElement('text', 'lopmo_search', 'none',  array('size'=>'40', 'onkeydown'=>"return event.key != 'Enter';"));
        $lopmo_search[] = &$mform->createElement('text', 'lopmo_search', 'none',  array('size'=>'40'));
        $lopmo_search[] = &$mform->createElement('submit', 'btn_lopmo_search', 'Tìm kiếm', array('style' => 'background-color: #1177d1;color: #fff'));
        $mform->addGroup($lopmo_search, 'lopmo_search_group', ' ', ' ', false);
    }

    function validation($data, $files)
    {
        return array();
    }
}
