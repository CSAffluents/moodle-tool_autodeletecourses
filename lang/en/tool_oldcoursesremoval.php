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
 * Strings for component 'tool_oldcoursesremoval', language 'en'.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['coursesperpage'] = 'Courses per page';
$string['createdsince'] = 'Create since';
$string['cronenabled'] = 'Cron enabled';
$string['cronenabled_desc'] = 'Check this if you want to process the removal of the old courses with the system cron.';
$string['croninstructions'] = 'You can enable cron to automatically remove old courses based on some criterias. Cron will run between set hours on the day (according to server local time). Each time cron runs, it will process a number of removals until Time limit amount of time has been used, then it will stop and wait for the next cron run.';
$string['cronprocessingtime'] = 'Processing time';
$string['cronprocessingtime_desc'] = 'The processing time each cron run.';
$string['cronsetupheader'] = 'Configure cron';
$string['cronsetupheader_desc'] = 'You can configure cron to complete the upgrade of quiz attempt data automatically.';
$string['cronstarttime'] = 'Start time';
$string['cronstarttime_desc'] = 'The time in a day the cron will begin to be available for the removal.';
$string['cronstoptime'] = 'Stop time';
$string['cronstoptime_desc'] = 'The time in a day the cron will stop to be available for the removal.';
$string['description'] = 'This admin tool allow to remove the old courses based on many criterias like the course visibility, the creation date or if the course has been modified.';
$string['editsettings'] = 'Edit settings';
$string['pluginname'] = 'Auto old courses removal';
$string['removeonlyinvisible'] = 'Remove only invisible courses';
$string['removeonlyinvisible_desc'] = 'Check this to remove only invisible courses.';
$string['removeonlynotmodified'] = 'Remove only not modified courses';
$string['removeonlynotmodified_desc'] = 'Check this to remove ony not modified courses.';
$string['removeonlyolderthan'] = 'Remove courses only older that';
$string['removeonlyolderthan_desc'] = 'Only courses older than this duration will be removed.';
$string['sendemail'] = 'Send email to administrators';
$string['sendemail_desc'] = 'Check this to send an email to all administrators each time a process finnish';
$string['settings'] = 'Settings';
$string['showelligiblecourses'] = 'Show eligible courses';
$string['showelligiblecourses_desc'] = 'Affiche la liste de tous les cours qui sont admissibles à la suppression. Cela vous permet de faire une vérification avant de lancer le processus.';
$string['updatetable'] = 'Mettre à jour la table';
