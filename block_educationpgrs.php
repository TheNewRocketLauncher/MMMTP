<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Block educationpgrs is defined here.
 *
 * @package     block_educationpgrs
 * @copyright   2020 Sy Pham <1612572@student.hcmus.edu.vn>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * educationpgrs block.
 *
 * @package    block_educationpgrs
 * @copyright  2020 Sy Pham <1612572@student.hcmus.edu.vn>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_educationpgrs extends block_list
{

    /**
     * Initializes class member variables.
     */
    public function init()
    {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_educationpgrs');
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content()
    {
        global $DB, $USER, $CFG, $COURSE;

        if ($this->content !== null) {
            return $this->content;
        }
        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $courseid = $COURSE->id;

        // Block content
        if (1) {
            // //Quản lý bậc đào tạo
            // $url = new \moodle_url('/blocks/educationpgrs/pages/bacdt/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_bacdt', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
            
            // //Quản lý hệ đào tạo
            // $url = new \moodle_url('/blocks/educationpgrs/pages/hedt/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_hedt', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
            
            // //Quản lý niên khoá
            // // Edit file index.php tương ứng trong thư mục page, link đến đường dẫn
            // $url = new \moodle_url('/blocks/educationpgrs/pages/nienkhoa/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_nienkhoa', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);

            // //Quản lý ngành đào tạo
            // $url = new \moodle_url('/blocks/educationpgrs/pages/nganhdt/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_nganh', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
            
            // //Quản lý chuyến ngành
            // $url = new \moodle_url('/blocks/educationpgrs/pages/chuyennganhdt/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_chuyennganh', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
                    
            // //Quản lý môn học
            // $url = new \moodle_url('/blocks/educationpgrs/pages/monhoc/danhsach_monhoc.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_monhoc', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
            
            
            // //Quản lý đề cương môn học
            // $url = new \moodle_url('/blocks/educationpgrs/pages/decuong/index.php');
            // $linktext = get_string('label_quanly_decuong', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
            
            // //Quản lớp mở
            // $url = new \moodle_url('/blocks/educationpgrs/pages/lopmo/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_lopmo', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
            
            // //Quản lý khối kiến thức
            // $url = new \moodle_url('/blocks/educationpgrs/pages/khoikienthuc/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_khoikienthuc', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
            
            // //Quản lý cây khối kiến thức kiến thức
            // $url = new \moodle_url('/blocks/educationpgrs/pages/caykkt/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('head_caykkt', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);

            // //Quản lý chương trình đào tạo
            // $url = new \moodle_url('/blocks/educationpgrs/pages/ctdt/index.php', ['courseid' => $courseid]);
            // $linktext = get_string('label_ctdt', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);
            
            // //Quản lý chuẩn đầu ra ctdt
            // $url = new \moodle_url('/blocks/educationpgrs/pages/chuandauractdt/index.php', []);
            // $linktext = get_string('label_chuandauractdt', 'block_educationpgrs');
            // $this->content->items[] = \html_writer::link($url, $linktext);

            //Quản lý chung
            $url = new \moodle_url('/blocks/educationpgrs/pages/main.php', []);
            $linktext = 'MOODLE PROJECT';
            $this->content->items[] = \html_writer::link($url, $linktext);


        }     
        return $this->content;
    }

    /**
     * Defines configuration data.
     *
     * The function is called immediatly after init().
     */
    public function specialization()
    {
        // Load user defined title and make sure it's never empty.
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_educationpgrs');
        } else {
            $this->title = $this->config->title;
        }
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    function has_config()
    {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats()
    {
        return array(
            'all' => true,
            'course-view' => true,
            'course-view-social' => true,
        );
    }
}
