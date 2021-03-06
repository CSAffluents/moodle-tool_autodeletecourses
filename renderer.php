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
 * Defines the renderer for the old courses deletion plugin.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_autodeletecourses\helper;
use tool_autodeletecourses\courses_table;
use tool_autodeletecourses\pagination_form;

defined('MOODLE_INTERNAL') || die();

/**
 * Renderer for the old courses deletion plugin.
 *
 * @package    tool_autodeletecourses
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_autodeletecourses_renderer extends plugin_renderer_base {

    /**
     * Render a page that is just a simple message.
     *
     * @param string $title The title of this page.
     * @param string $message The message to display.
     * @return string html to output.
     */
    public function simple_message_page($title, $message) {
        $output = '';
        $output .= $this->header();
        $output .= $this->heading($title);
        $output .= $message;
        $output .= $this->edit_settings();
        $output .= $this->footer();
        return $output;
    }

    /**
     * Render the list of all the eligible courses to be deleted page.
     * @param courses_table $table a list of eligible courses to be deleted.
     * @param pagination_form $paginationform Form which contains the preferences for paginating the table
     * @return string html to output.
     */
    public function course_list_page(courses_table $table, pagination_form $paginationform) {

        $output = '';
        $output .= $this->header();
        $this->page->requires->js_init_call('M.tool_autodeletecourses.init_course_table', array());

        $output .= $this->heading(helper::get_string('showelligiblecourses'));
        $output .= html_writer::tag('p', helper::get_string('showelligiblecourses_desc'));
        $output .= html_writer::tag('p', helper::get_string('matchingcourses', $table->get_count()));
        $output .= $this->output->spacer(array(), true);

        $output .= $this->container_start('tool_autodeletecourses_deletetable');

        $output .= $this->container_start('tool_autodeletecourses_paginationform');
        $output .= $this->moodleform($paginationform);
        $output .= $this->container_end();

        $output .= $this->flexible_table($table, $table->get_rows_per_page(), true);
        $output .= $this->container_end();

        $output .= $this->edit_settings();
        $output .= $this->footer();
        return $output;
    }

    /**
     * Helper method dealing with the fact we can not just fetch the output of flexible_table
     *
     * @param flexible_table $table
     * @param int $rowsperpage
     * @param bool $displaylinks Show links in the table
     * @return string HTML
     */
    protected function flexible_table(flexible_table $table, $rowsperpage, $displaylinks) {

        $o = '';
        ob_start();
        $table->out($rowsperpage, $displaylinks);
        $o = ob_get_contents();
        ob_end_clean();

        return $o;
    }

    /**
     * Helper method dealing with the fact we can not just fetch the output of moodleforms
     *
     * @param moodleform $mform
     * @return string HTML
     */
    protected function moodleform(moodleform $mform) {

        $o = '';
        ob_start();
        $mform->display();
        $o = ob_get_contents();
        ob_end_clean();

        return $o;
    }


    /**
     * Render a link in a div, such as the 'Back to plugin main page' link.
     * @param string|moodle_url $url the link URL.
     * @param string $text the link text.
     * @return string html to output.
     */
    public function end_of_page_link($url, $text) {
        return html_writer::tag('div', html_writer::link($url, $text), array('class' => 'mdl-align'));
    }

    /**
     * Output a link back to the plugin settings page.
     * @return string html to output.
     */
    public function edit_settings() {
        global $CFG;
        $url = new moodle_url($CFG->wwwroot . '/' . $CFG->admin . '/settings.php',
                array('section' => 'tool_autodeletecourses_settings'));
        return $this->end_of_page_link($url, helper::get_string('editsettings'));
    }
}
