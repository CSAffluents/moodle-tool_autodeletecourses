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
 * Automactic old courses deletion tool cron.
 *
 * Lib functions (cron) to automatically delete the old courses.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_autodeletecourses\helper;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/statslib.php');

/**
 * Standard cron function.
 */
function tool_autodeletecourses_cron() {
    $settings = helper::get_config();
    if (empty($settings->cronenabled)) {
        return;
    }

    mtrace('autodeletecourses: tool_autodeletecourses_cron() started at '. date('H:i:s'));
    try {
        tool_autodeletecourses_process($settings);
    } catch (Exception $e) {
        mtrace('autodeletecourses: tool_autodeletecourses_cron() failed with an exception:');
        mtrace($e->getMessage());
    }
    mtrace('autodeletecourses: tool_autodeletecourses_cron() finished at ' . date('H:i:s'));
}

/**
 * This function does the cron process within the time range according to settings
 *
 * @param stdClass $settings the settings of the plugin.
 */
function tool_autodeletecourses_process($settings) {

    $hourminute = date("H:i");
    $currentime = time();
    $startime = stats_get_base_daily() + $settings->cronstarthour * 60 * 60 + $settings->cronstartminute * 60;
    $stoptime = stats_get_base_daily() + $settings->cronstophour * 60 * 60 + $settings->cronstophour * 60;

    if ($currentime < $startime || $currentime > $stoptime) {
        mtrace('autodeletecourses: not between the specified period, so doing nothing (time = ' . $hourminute . ').');
        return;
    }

    $stoptime = time() + $settings->processingtime;

    $deleter = new \tool_autodeletecourses\courses_deleter();
    $report = new \tool_autodeletecourses\report();

    mtrace('autodeletecourses: processing ...');
    while (time() < $stoptime) {

        $course = $deleter->get_course_to_delete();
        if (!$course) {
            mtrace('autodeletecourses: No more course to delete.');
            // No more to do.
            break;
        }
        $courseid = $course->id;

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
    }

    // Send email to admins if activated.
    if (!empty($settings->sendemail)) {
        $report->set_remaining_count($deleter->get_count());
        $report->send_by_email();
    }

    mtrace('autodeletecourses: Done.');
    return;
}
