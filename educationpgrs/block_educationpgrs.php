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
            $url = new \moodle_url('/blocks/educationpgrs/view_transcript.php', ['courseid' => $courseid]);
            $linktext = get_string('gpatranscriptdetail', 'block_educationpgrs');
            $this->content->items[] = \html_writer::link($url, $linktext);
        }
        if (1) {
            $params = ['courseid' => $courseid];
            $url = new \moodle_url('/blocks/educationpgrs/view_eduprogram.php', $params);
            $linktext = get_string('educationprogramdetail', 'block_educationpgrs');
            $this->content->items[] = \html_writer::link($url, $linktext);
            $this->content->items[] = "============";
        }
        if (1) {
            $url = new \moodle_url('/blocks/educationpgrs/managereport.php', ['courseid' => $courseid]);
            $linktext = get_string('manageeducationprograms', 'block_educationpgrs');
            $this->content->footer = \html_writer::link($url, $linktext);
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