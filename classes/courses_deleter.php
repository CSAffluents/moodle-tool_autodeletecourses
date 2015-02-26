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

namespace tool_autodeletecourses;

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../../../config.php');

/**
 * Automactic old courses deletion deleter class.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class courses_deleter extends courses {

    /**
     * Delete the specified course.
     *
     * @param stdClass $course The course object.
     * @return if the delete whas successful or not.
     */
    public function delete_course($course) {
        return delete_course($course, false);
    }

    /**
     * Get the next course from the deletable courses.
     *
     * @return string The next course to be deleted.
     */
    public function get_course_to_delete() {
        global $DB;
        $sql = "SELECT DISTINCT " . self::CID . ".id FROM " . $this->get_sql_from() . " WHERE " . $this->get_sql_where();
        return $DB->get_record_sql($sql, array(), IGNORE_MULTIPLE);
    }

    /**
     * Get the course infos required for report and for the delete.
     *
     * @param int $courseid The course id.
     * @return string The next course to be deleted.
     */
    public function get_course_infos($courseid) {
        global $DB;
        return $DB->get_record('course', array('id' => $courseid), 'id,shortname,fullname,idnumber');
    }
}
