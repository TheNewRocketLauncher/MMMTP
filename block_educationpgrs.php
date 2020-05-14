<!-- <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
</head>
<body>
<a href="#" onclick="openForm()">My name</a>
<h2>Popup Form</h2>
<p>Click on the button at the bottom of this page to open the login form.</p>
<p>Note that the button and the form is fixed - they will always be positioned to the bottom of the browser window.</p>

<button class="open-button" onclick="sopenForm()">Open Form</button>

<div class="form-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
    <h1>Login</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Login</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>

</body>
</html> -->
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
class block_educationpgrs extends block_list {

    /**
     * Initializes class member variables.
     */
    public function init() {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_educationpgrs');
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content() {
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
        // $this->content->footer = '';
        // $this->content->items[] = "BCZ here";


        // if (!empty($this->config->text)) {
        //     $this->content->text = $this->config->text;
        // } else {
        //     $text = '123 Please define the content text in /blocks/educationpgrs/block_educationpgrs.php.';
        //     $this->content->text = $text;
        // }
        // SSSS
        $courseid = $COURSE->id;
        
        if(1) {
            $url = new \moodle_url('/blocks/educationpgrs/view_transcript.php', ['courseid' => $courseid]);
            // $url = new \moodle_url('/blocks/educationpgrs/view.php');
            $linktext = get_string('gpatranscriptdetail', 'block_educationpgrs');
            $this->content->items[] = \html_writer::link($url, $linktext);
        }
        
        // $report['id']=2;
        // if(1) {
        //     $params = ['id' => $report['id']];
        //     $url = new \moodle_url('/blocks/educationpgrs/view_eduprogram.php',$params);
        //     $linktext = get_string('educationprogramdetail', 'block_educationpgrs');
        //     $this->content->items[] = \html_writer::link($url, $linktext);
        //     $this->content->items[] = "============";
        //     $this->content->items[] = $COURSE->id;
        //     $this->content->items[] = "============";
        // }
        
        if(1) {
            $params = ['courseid' => $courseid];
            $url = new \moodle_url('/blocks/educationpgrs/view_eduprogram.php',$params);
            $linktext = get_string('educationprogramdetail', 'block_educationpgrs');
            $this->content->items[] = \html_writer::link($url, $linktext);
            $this->content->items[] = "============";
        }

        if(1) {
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
    public function specialization() {

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
    function has_config() {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats() {
        return array(
            'all' => true,
            'course-view' => true,
            'course-view-social' => true,
        );
    }
}

///
