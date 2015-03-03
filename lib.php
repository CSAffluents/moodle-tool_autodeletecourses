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
 * Lib functions (cron) to automatically complete the question engine upgrade
 * if it was not done all at once during the main upgrade.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Standard cron function.
 */
function tool_oldcoursesremoval_cron() {
    $settings = tool_oldcoursesremoval_base::get_config();
    if (empty($settings->cronenabled)) {
        return;
    }

    mtrace('oldcoursesremoval: tool_oldcoursesremoval_cron() started at '. date('H:i:s'));
    try {
        tool_oldcoursesremoval_process($settings);
    } catch (Exception $e) {
        mtrace('oldcoursesremoval: tool_oldcoursesremoval_cron() failed with an exception:');
        mtrace($e->getMessage());
    }
    mtrace('oldcoursesremoval: tool_oldcoursesremoval_cron() finished at ' . date('H:i:s'));
}

/**
 * This function does the cron process within the time range according to settings.
 */
function tool_oldcoursesremoval_process($settings) {

    $hour = (int) date('H');
    if ($hour < $settings->starttime || $hour >= $settings->stoptime) {
        mtrace('oldcoursesremoval: not between starthour and stophour, so doing nothing (hour = ' . $hour . ').');
        return;
    }

    $stoptime = time() + $settings->processingtime;

    $plugin = new tool_oldcoursesremoval_courses_remover();

    mtrace('oldcoursesremoval: processing ...');
    while (time() < $stoptime) {

        $course = $plugin->get_course_to_remove();
        if (!$course) {
            mtrace('oldcoursesremoval: No more course to remove.');
            break; // No more to do;
        }

        $course = $plugin->get_course_infos($course->id);
        if ($course) {
            mtrace('  starting the remove of the course ' . $course->id);
            if ($plugin->remove_course($course)) {
                mtrace('  remove of course ' . $course->id . ' complete.');
            } else {
                mtrace('  remove of course ' . $course->id . ' incomplete.');
            }
        }
    }

    mtrace('oldcoursesremoval: Done.');
    return;
}
