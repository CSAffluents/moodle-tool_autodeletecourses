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


    private $index = null;

    private $coursesid = null;

    /**
     * The constructor of the class.
     */
    public function __construct() {
        parent::__construct();
        $this->coursesid = $this->get_coursesid();
        $this->index = 0;
    }

    /**
     * Get the id from the removeable courses.
     *
     * @return string The courses id.
     */
    private function get_coursesid() {
        global $DB;
        $coursesid = array();
        $sql = "SELECT DISTINCT " . self::CID . ".id FROM " . $this->get_sql_from() . " WHERE " . $this->get_sql_where();
        if ($courses = $DB->get_records_sql($sql)) {
            foreach($courses as $course) {
                $coursesid[] = $course->id;
            }
        }
        return $coursesid;
    }

    public function remove_course() {

    }

    public function get_course_id() {

    }
    
}
