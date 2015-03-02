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
 * Defines the renderer for the old courses removal plugin.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2012 NetSpot
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Renderer for the old courses removal plugin.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2012 NetSpot
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_oldcoursesremoval_renderer extends plugin_renderer_base {

    /**
     * Render the list of all the eligible courses to be removed page.
     * @param tool_oldcoursesremoval_courses_table $courses a list of eligible courses to be removed.
     * @param tool_oldcoursesremoval_pagination_form $paginationform Form which contains the preferences for paginating the table
     * @return string html to output.
     */
    public function course_list_page(tool_oldcoursesremoval_courses_table $courses,
            tool_oldcoursesremoval_pagination_form $paginationform) {

        $plugin = new tool_oldcoursesremoval_base();

        $output = '';
        $output .= $this->header();
        $this->page->requires->js_init_call('M.tool_oldcoursesremoval.init_course_table', array());

        $output .= $this->heading($plugin->get_string('showelligiblecourses'));
        $output .= $this->box($plugin->get_string('showelligiblecourses'));
        $output .= $this->output->spacer(array(), true);

        $output .= $this->container_start('tool_oldcoursesremoval_removetable');

        $output .= $this->container_start('tool_oldcoursesremoval_paginationform');
        $output .= $this->moodleform($paginationform);
        $output .= $this->container_end();

        $output .= $this->flexible_table($courses, $courses->get_rows_per_page(), true);
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
        $plugin = new tool_oldcoursesremoval_base();
        $url = new moodle_url('settings.php', array('section' => 'tool_oldcoursesremoval'));
        return $this->end_of_page_link($url, $plugin->get_string('editsettings'));
    }
}
