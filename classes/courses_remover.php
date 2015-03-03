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

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../../../config.php');

/**
 * Old courses removal remover class.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_oldcoursesremoval_courses_remover extends tool_oldcoursesremoval_courses {

    /**
     * Remove the specified course.
     *
     * @param stdClass $course The course object.
     * @return if the remove whas successful or not.
     */
    public function remove_course($course) {
        return delete_course($course);
    }

    /**
     * Get the next course from the removeable courses.
     *
     * @return string The next course to be removed.
     */
    public function get_course_to_remove() {
        global $DB;
        $sql = "SELECT DISTINCT " . self::CID . ".id FROM " . $this->get_sql_from() . " WHERE " . $this->get_sql_where();
        return $DB->get_records_sql($sql, array(), IGNORE_MULTIPLE);
    }

    /**
     * Get the course infos required for report and for the remove.
     *
     * @return string The next course to be removed.
     */
    public function get_course_infos($courseid) {
        global $DB;
        return $DB->get_record('course', array('id' => $courseid), 'id,shortname,fullname,idnumber');
    }
}
