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
 * Old courses removal plugin tests.
 *
 * @package    tool_oldcoursesremoval
 * @category   test
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Old courses removal test class.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_oldcoursesremoval_testcase extends advanced_testcase {

    /**
     * @var The name of the remote table containing the grade items.
     */
    const GRADE_ITEMS_TABLE = 'tool_oldcoursesremoval_test_gi';

    /**
     * @var The name of the remote table containing the user grades.
     */
    const GRADES_TABLE = 'tool_oldcoursesremoval_test_gg';

    /**
     * @var array The courses used in this test.
     */
    protected static $courses = array();

    /**
     * @var array The users used in this test.
     */
    protected static $users = array();

    /** @var string Original error log */
    protected $oldlog;

    /**
     * Initialization of the tables and variables required for the tests.
     *
     * @throws exception Unknown database driver.
     */
    protected function init_tool_oldcoursesremoval() {
        global $DB, $CFG;

        $plugin = new tool_oldcoursesremoval_base();

        $plugin->set_config('remotegradestable', $CFG->prefix . self::GRADES_TABLE);
        $plugin->set_config('remotegradescoursefield', 'courseid');
        $plugin->set_config('remotegradesfield', 'gradeitemid');
        $plugin->set_config('remotegradesuserfield', 'userid');
        $plugin->set_config('remotegradesvaluefield', 'value');

        // Create some test users and courses and enrol them in course 1.
        $studentrole = $DB->get_record('role', array('shortname' => 'student'));
        for ($i = 1; $i <= 4; $i++) {
            self::$courses[$i] = $this->getDataGenerator()->create_course(array('fullname' => 'Test course '.$i,
                'shortname' => 'tc'.$i, 'idnumber' => 'courseid'.$i));
            self::$users[$i] = $this->getDataGenerator()->create_user(array('username' => 'username'.$i,
                'idnumber' => 'userid' . $i, 'email' => 'user'.$i.'@example.com'));
            $this->getDataGenerator()->enrol_user(self::$users[$i]->id, self::$courses[1]->id, $studentrole->id);
        }
    }

    /**
     * Clean up of the tables and variables required for the tests.
     */
    protected function cleanup_tool_oldcoursesremoval() {
        self::$courses = null;
        self::$users = null;
    }

    /**
     * Reset the records used in this test.
     */
    protected function reset_tool_oldcoursesremoval() {

    }

    /**
     * Assert that a specified course is removed.
     *
     * @param int $courseid The course id containing the grade item.
     */
    public function assert_course_is_removed($courseid) {
        
    }

    /**
     * Assert that a specified course is not removed.
     *
     * @param int $courseid The course id containing the grade item.
     */
    public function assert_course_is_not_removed($courseid) {

    }


    /**
     * Test for the create_grade_items method.
     */
    public function test_remove_courses() {

        $this->init_tool_oldcoursesremoval();

        $this->resetAfterTest(true);
        $this->preventResetByRollback();

        $plugin = new tool_oldcoursesremoval_remover();

        // Set differents grade items values for the test.
        //$this->insert_remote_grade_item();
        
        // Hide the course 3.
        course_change_visibility(self::$courses[3]->id, false);

        $plugin->remove_old_courses();

        $this->reset_tool_oldcoursesremoval();
        $this->cleanup_tool_oldcoursesremoval();
    }
}
