<?php
require_once(__DIR__ . '/../../../../config.php');
require_once("$CFG->libdir/formslib.php");
// require_once("../../../style.css")

    class nien_khoa_form extends moodleform {
        
        public function definition()
        {
            global $CFG;
            $mform = $this->_form;
           
            $idheGroup =array();
            $idheGroup[]=& $mform->createElement('text','','','size="100"');
            $mform->addGroup($idheGroup,'',get_string('themnienkhoa_mahe','block_educationpgrs'),array(' '),false);



            $maBacGroup =array();
            $maBacGroup[]=& $mform->createElement('text','','','size="100"');
            $mform->addGroup($maBacGroup,'',get_string('themnienkhoa_mabac','block_educationpgrs'),array(' '),false);


            



            $manienkhoaGroup =array();
            $manienkhoaGroup[]=& $mform->createElement('text','','','size="100"');
            $mform->addGroup($manienkhoaGroup,'',get_string('themnienkhoa_manienkhoa','block_educationpgrs'),array(' '),false);

            $tenGroup =array();
            $tenGroup[]=& $mform->createElement('text','','','size="100"');
            $mform->addGroup($tenGroup,'',get_string('themnienkhoa_tennienkhoa','block_educationpgrs'),array(' '),false);

            $motaGroup =array();
            $motaGroup[]=& $mform->createElement('textarea','nienkhoa','','wrap="virtual" rows="10" cols="105"');
            $mform->addGroup($motaGroup,'',get_string('themnienkhoa_mota','block_educationpgrs'),array(' '),false);


            // $eGroup=array();
            // $eGroup[] =& $mform->createElement('textarea', 'mota_chuan_daura',get_string('mota_chuan_daura', 'block_educationpgrs'), 'wrap="virtual" rows="10" cols="105"');
            // $mform->addGroup($eGroup, 'thong_tin_chung_group', get_string('mota_chuan_daura', 'block_educationpgrs'), array(' '), true);

            

        }
        //Custom validation should be added here
        function validation($data, $files)
        {
            return array();
        }
    }
?>