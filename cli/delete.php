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
 * Automactic old courses deletion plugin.
 *
 * This plugin automatically delete old courses based on some criterias.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_autodeletecourses\helper;

define('CLI_SCRIPT', true);

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.php');
require_once($CFG->libdir . '/clilib.php');      // CLI only functions.

// Now get cli options.
list($options, $unrecognized) = cli_get_params(array('course' => false, 'timelimit' => false, 'countlimit' => false,
    'help' => false), array('c' => 'countlimit', 't' => 'timelimit', 'h' => 'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}


if ($options['help']) {
    $help =
    "Automatic old courses deletion CLI tool.
    Will delete all courses based on criterias in the settings if no options are specified.

    Options:
    -c, --countlimit=<n>    Process n number of courses then exit
    -t, --timelimit=<n>     Process courses for n number of seconds, then exit.
    --course=<courseid>     Process course courseid only
    -h, --help              Print out this help

    countlimit and timelimit can be used together. First one to trigger will stop execution.

    Example:
    \$sudo -u www-data /usr/bin/php admin/tool/autodeletecourses/cliupgrade.php
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


mtrace('autodeletecourses: processing ...');

$deleter = new \tool_autodeletecourses\courses_deleter();
$report = new \tool_autodeletecourses\report();

/* This while statement does a few things
 * Basically if an option is set to false, then that subsection will return
 * true, and will short circuit the test condition for that option, and always
 * being true. Both options are handed together, so either one can trigger to stop.
 */
while ((!$stoptime || (time() < $stoptime)) && (!$options['countlimit'] || ($count < $options['countlimit']))) {
    if ($options['course']) {
        $courseid = $options['course'];
    } else {
        $course = $deleter->get_course_to_delete();
        if (!$course) {
            mtrace('autodeletecourses: No more course to delete.');
            // No more to do.
            break;
        }

        $courseid = $course->id;
    }
    $course = $deleter->get_course_infos($courseid);
    if ($course) {
        mtrace('  starting the delete of the course ' . $courseid);
        if ($deleter->delete_course($course)) {
            mtrace('  delete of course ' . $courseid . ' complete.');
            $report->add_status(new \tool_autodeletecourses\status_ok($course));
        } else {
            mtrace('  delete of course ' . $courseid . ' incomplete.');
            $report->add_status(new \tool_autodeletecourses\status_incomplete($course));
        }
    } else {
        mtrace('course ' . $courseid . ' not found or already deleted.');
        $report->add_status(new \tool_autodeletecourses\status_missing($course));
    }

    $count++;
}

// Send email to admins if activated.
$sendbymail = helper::get_config('sendemail');
if (!empty($sendbymail)) {
    $report->set_remaining_count($deleter->get_count());
    $report->send_by_email();
}

mtrace('autodeletecourses: Done. Processed ' . $count . ' courses in ' . (time() - $starttime) . ' seconds');
return;
