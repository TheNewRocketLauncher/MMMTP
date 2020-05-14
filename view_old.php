<?php

// Standard config file and local library.
require_once(__DIR__ . '/../../config.php');

// Setting up the page.
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_heading("GPA Transcript");
$PAGE->set_url(new moodle_url('/blocks/educationpgrs/view.php'));

// Ouput the page header.
echo $OUTPUT->header();

// Output your custom HTML.
// In the future, read about templates and renderers so you don't have to echo HTML like this.
echo '<p>Test paragraph! Coursesid=</p>';
// $id = required_param('id', PARAM_INT);
// echo $id;
echo $COURSE->id;

// Output the page footer.
echo $OUTPUT->footer();