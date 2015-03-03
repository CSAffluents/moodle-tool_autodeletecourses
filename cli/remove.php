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
 * Old courses removal plugin.
 *
 * This plugin automatically remove old courses based on some criterias.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.php');
require_once($CFG->libdir . '/clilib.php');      // CLI only functions.

// Now get cli options.
list($options, $unrecognized) = cli_get_params(array('course' => false, 'timelimit' => false, 'countlimit' => false, 'help' => false),
                                               array('c' => 'countlimit', 't' => 'timelimit', 'h' => 'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}


if ($options['help']) {
    $help =
"Old courses removal CLI tool.
Will remove all courses based on criterias in the settings if no options are specified.

Options:
-c, --countlimit=<n>    Process n number of courses then exit
-t, --timelimit=<n>     Process courses for n number of seconds, then exit.
--course=<courseid>     Process quiz quizid only
-h, --help              Print out this help

countlimit and timelimit can be used together. First one to trigger will stop execution.

Example:
\$sudo -u www-data /usr/bin/php admin/tool/oldcoursesremoval/cliupgrade.php
";

    echo $help;
    die;
}

$starttime = time();

// Setup the stop time.
if ($options['timelimit']) {
    $stoptime = time() + $options['timelimit'];
} else {
    $stoptime = false;
}

// If we are doing a course id, limit to one.
if ($options['course']) {
    $options['countlimit'] = 1;
}

$count = 0;


mtrace('oldcoursesremoval: processing ...');

$plugin = new tool_oldcoursesremoval_courses_remover();

/* This while statement does a few things
 * Basically if an option is set to false, then that subsection will return
 * true, and will short circuit the test condition for that option, and always
 * being true. Both options are handed together, so either one can trigger to stop.
 */
while ((!$stoptime || (time() < $stoptime)) && (!$options['countlimit'] || ($count < $options['countlimit']))) {
    if ($options['course']) {
        $courseid = $options['course'];
    } else {
        $course = $plugin->get_course_to_remove();
        if (!$course) {
            mtrace('oldcoursesremoval: No more course to remove.');
            break; // No more to do;
        }

        $courseid = $course->id;
    }
    $course = tool_oldcoursesremoval_get_quiz($courseid);
    if ($course) {
        mtrace('  starting the remove of the course ' . $course->id);
        if ($plugin->remove_course($course)) {
            mtrace('  remove of course ' . $course->id . ' complete.');
        } else {
            mtrace('  remove of course ' . $course->id . ' incomplete.');
        }
    } else {
        mtrace('course ' . $courseid . ' not found or already deleted.');
    }

    $count++;
}


mtrace('oldcoursesremoval: Done. Processed ' . $count . ' courses in '.(time() - $starttime).' seconds');
return;
