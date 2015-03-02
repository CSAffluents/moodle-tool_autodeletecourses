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
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/tablelib.php');
require_once($CFG->libdir.'/gradelib.php');
require_once($CFG->dirroot.'/mod/assign/locallib.php');

/**
 * Extends table_sql to provide a table of removeable courses.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_oldcoursesremoval_courses_table extends table_sql implements renderable {

    /**
     * @var int $perpage
     */
    private $perpage = 10;

    /**
     * @var int $rownum (global index of current row in table)
     */
    private $rownum = -1;

    /** @var renderer_base for getting output */
    private $output = null;

    /**
     * This table loads a list of the old assignment instances and tests them to see
     * if they can be upgraded
     *
     * @param int $perpage How many per page
     * @param int $rowoffset The starting row for pagination
     */
    public function __construct($perpage, $rowoffset = 0) {
        global $PAGE;
        parent::__construct('tool_oldcoursesremoval_courses');
        $this->perpage = $perpage;
        $this->output = $PAGE->get_renderer('tool_oldcoursesremoval');

        $plugin = new tool_oldcoursesremoval_base();

        $this->define_baseurl($plugin->get_url('listtoberemoved'));

        // Do some business - then set the sql.
        if ($rowoffset) {
            $this->rownum = $rowoffset - 1;
        }

        $fields = 'c.id as id, c.shortname as shortnamecourse, c.fullname as fullnamecourse';
        $from = 'mdl_course c';
        $where = 'c.visible = 0';

        $this->set_sql($fields, $from, $where, array());

        $columns = array();
        $headers = array();

        
        $columns[] = 'id';
        $headers[] = get_string('course');
        $columns[] = 'shortnamecourse';
        $headers[] = get_string('shortnamecourse');
        $columns[] = 'fullnamecourse';
        $headers[] = get_string('fullnamecourse');

        // Set the columns.
        $this->define_columns($columns);
        $this->define_headers($headers);
    }

    /**
     * Return the number of rows to display on a single page
     *
     * @return int The number of rows per page
     */
    public function get_rows_per_page() {
        return $this->perpage;
    }

    /**
     * Format a link to the course page.
     *
     * @param stdClass $row
     * @return string
     */
    public function col_fullnamecourse(stdClass $row) {
        $url = new moodle_url('/course/view.php', array('id' => $row->id));
        return html_writer::link($url, $row->fullnamecourse, array('title' => $row->fullnamecourse));
    }
}
