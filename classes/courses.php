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
 * Automactic old courses deletion courses class.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class courses {

    /**
     * @var int The time the instance is created.
     */
    private $time = null;

    /**
     * @var string the tables prefix.
     */
    private $prefix = null;

    /**
     * @var string The course id used in the SQL queries.
     */
    const CID = 'co';

    /**
     * The constructor of the class.
     */
    public function __construct() {
        global $CFG;
        $this->time = time();
        $this->prefix = $CFG->prefix;
    }

    /**
     * Format a SQL field part helperd on an array object.
     *
     * @param array $fields The field used for the format.
     * @return string The formatted fields.
     */
    public function format_sql_fields(array $fields) {
        $output = array();
        foreach ($fields as $key => $value) {
            $output[] = self::CID . '.' . $key . ' as ' . $value;
        }
        if (empty($output)) {
            return '*';
        }
        return implode(', ', $output);
    }

    /**
     * Get the SQL from string.
     *
     * @return string The SQL from string.
     */
    public function get_sql_from() {
        return $this->prefix . 'course as ' . self::CID;
    }

    /**
     * Get the SQL where querie.
     *
     * @return string The SQL where querie.
     */
    public function get_sql_where() {

        $settings = helper::get_config();

        $where = array();

        // Keep the system course.
        $where[] = self::CID . '.id > 1';

        // Keep courses younger than.
        if (!empty($settings->keepyoungerthan)) {
            $where[] = "co.timecreated < " . ($this->time - (int)$settings->keepyoungerthan);
        }

        // Keep visible courses.
        if (!empty($settings->keepvisible)) {
            $where[] = self::CID . ".visible = 0";
        }

        // Keep courses modified.
        if (!empty($settings->keepmodified)) {
            $where[] = "(" . self::CID . ".timemodified = " . self::CID . ".timecreated OR " . self::CID . ".timemodified = 0)";
        }

        // Keep courses with action logs (only works with old log table).
        if (!empty($settings->keepwithactionlogs)) {
            $where[] = "NOT EXISTS (
                SELECT 1
                FROM " . $this->prefix . "log a
                WHERE (a.action LIKE '%add%'
                OR a.action LIKE '%update%'
                OR a.action LIKE '%delete%')
                AND a.cmid <> 0
                AND a.course = " . self::CID . ".id
            )";
        }

        // Keep courses with questions in the question bank.
        if (!empty($settings->keepwithquestions)) {
            $where[] = "NOT EXISTS (
                SELECT 2
                FROM " . $this->prefix . "question q
                JOIN " . $this->prefix . "question_categories qc ON q.category = qc.id
                JOIN " . $this->prefix . "context ctx ON ctx.id = qc.contextid
                AND ctx.contextlevel = 50
                WHERE ctx.instanceid = " . self::CID . ".id
            )";
        }

        // Keep courses with manual grading.
        if (!empty($settings->keepwithmanualgrading)) {
            $where[] = "NOT EXISTS (
                SELECT 3
                FROM " . $this->prefix . "grade_items gitm
                WHERE gitm.courseid > 1
                AND gitm.itemtype <> 'course'
                AND gitm.courseid = " . self::CID . ".id
            )";
        }

        // Keep courses used in meta course enrols.
        if (!empty($settings->keepmetacourses)) {
            $where[] = "NOT EXISTS (
                SELECT 4
                FROM " . $this->prefix . "enrol erl
                WHERE erl.enrol  = 'meta'
                AND erl.customint1 = " . self::CID . ".id
            )";
        }

        // Keep courses with modules.
        if (!empty($settings->keepwithmodules)) {
            $where[] = "NOT EXISTS (
                SELECT 5
                FROM (SELECT cmdl1.course, COUNT(cmdl1.course) nb
                    FROM " . $this->prefix . "course_modules cmdl1
                    GROUP BY course) cmdl
                WHERE cmdl.nb > 1
                AND cmdl.course = " . self::CID . ".id
            )";
        }
        return implode(' AND ', $where);
    }

    /**
     * Get the SQL count querie.
     *
     * @return string The SQL count querie.
     */
    public function get_sql_count() {
        return "SELECT count(DISTINCT " . self::CID . ".id) FROM " . $this->get_sql_from() . " WHERE " . $this->get_sql_where();
    }

    /**
     * Get the deletable course count.
     *
     * @return int The course count.
     */
    public function get_count() {
        global $DB;
        return (int)$DB->get_field_sql($this->get_sql_count());
    }

    /**
     * Check if there is any deletable courses.
     *
     * boolean If there is any deletable courses.
     */
    public function has_any() {
        $count = $this->get_count();
        return !empty($count);
    }

    /**
     * Get the time the object instance was created.
     *
     * @return int The time the object instance was created.
     */
    public function get_time() {
        return $this->time;
    }
}
