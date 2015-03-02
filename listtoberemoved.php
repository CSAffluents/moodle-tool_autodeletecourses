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
 * Script to show all the eligible courses to be removed.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$plugin = new tool_oldcoursesremoval_base();

// This calls require_login and checks moodle/site:config.
admin_externalpage_setup('tool_oldcoursesremoval_list');

$renderer = $PAGE->get_renderer('tool_oldcoursesremoval');

$perpage = optional_param('perpage', 0, PARAM_INT);
if (!$perpage) {
    $perpage = get_user_preferences('tool_oldcoursesremoval_perpage', 100);
} else {
    set_user_preference('tool_oldcoursesremoval_perpage', $perpage);
}
$courses = new tool_oldcoursesremoval_courses_table($perpage);
$paginationform = new tool_oldcoursesremoval_pagination_form();
$pagedata = new stdClass();
$pagedata->perpage = $perpage;
$paginationform->set_data($pagedata);
echo $renderer->course_list_page($courses, $paginationform);
