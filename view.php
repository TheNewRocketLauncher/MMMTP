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

// Output custom HTML.
echo '<p> View paragraph! Course Id = </p>';
echo $COURSE->id;

// Output the page footer.
echo $OUTPUT->footer();
