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
 * This file contains the definition for the courses table which subclassses table_sql
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_autodeletecourses;
use stdClass;
use html_writer;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/tablelib.php');

/**
 * Extends table_sql to provide a table of deletable courses.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class courses_table extends \table_sql implements \renderable {

    /**
     * @var int $perpage The number of courses per page.
     */
    private $perpage = 10;

    /**
     * @var int $rownum (global index of current row in table).
     */
    private $rownum = -1;

    /** @var renderer_base for getting output */
    private $output = null;

    /**
     * This table loads a list of the old assignment instances and tests them to see
     * if they can be upgraded
     *
     * @param courses $courses The courses to be deleted object.
     * @param int $perpage How many per page.
     * @param int $rowoffset The starting row for pagination.
     */
    public function __construct(courses $courses, $perpage, $rowoffset = 0) {
        global $PAGE;
        parent::__construct('tool_autodeletecourses_courses');
        $this->perpage = $perpage;
        $this->output = $PAGE->get_renderer('tool_autodeletecourses');
        $this->collapsible(false);

        $this->define_baseurl(helper::get_url('listtobedeleted'));

        // Do some business - then set the sql.
        if ($rowoffset) {
            $this->rownum = $rowoffset - 1;
        }

        $this->count = $courses->get_count();

        $fields = array(
            'id' => 'id',
            'shortname' => 'shortnamecourse',
            'fullname' => 'fullnamecourse',
            'visible' => 'visible',
            'timecreated' => 'timecreated',
        );

        $from = $courses->get_sql_from();
        $where = $courses->get_sql_where();

        $this->set_sql($courses->format_sql_fields($fields), $from, $where, array());
        $this->set_count_sql($courses->get_sql_count());

        $columns = array_values($fields);

        $headers = array();
        $headers[] = helper::get_string('courseid');
        $headers[] = get_string('shortnamecourse');
        $headers[] = get_string('fullnamecourse');
        $headers[] = get_string('visible');
        $headers[] = helper::get_string('createdsince');

        // Set the columns.
        $this->define_columns($columns);
        $this->define_headers($headers);
    }

    /**
     * Return the number of courses.
     *
     * @return int The number of courses.
     */
    public function get_count() {
        return $this->count;
    }

    /**
     * Return the number of rows to display on a single page.
     *
     * @return int The number of rows per page.
     */
    public function get_rows_per_page() {
        return $this->perpage;
    }

    /**
     * Format a link to the course page.
     *
     * @param stdClass $row The row object.
     * @return string The formatted output.
     */
    public function col_fullnamecourse(stdClass $row) {
        $url = new \moodle_url('/course/view.php', array('id' => $row->id));
        return html_writer::link($url, $row->fullnamecourse, array('title' => $row->fullnamecourse));
    }

    /**
     * Format the visible column.
     *
     * @param stdClass $row The row object.
     * @return string The formatted output.
     */
    public function col_visible(stdClass $row) {
        $output = get_string('yes');
        if (empty($row->visible)) {
            $output = get_string('no');
        }
        return $output;
    }

    /**
     * Format the visible column.
     *
     * @param stdClass $row The row object.
     * @return string The formatted output.
     */
    public function col_timecreated(stdClass $row) {
        return format_time(time() - $row->timecreated);
    }
}
