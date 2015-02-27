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
 * Strings for component 'tool_oldcoursesremoval', language 'fr'.
 *
 * @package    tool_oldcoursesremoval
 * @copyright  2015 Gilles-Philippe Leblanc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['cronenabled'] = 'Cron activé';
$string['croninstructions'] = 'You can enable cron to automatically remove old courses based on some criterias. Cron will run between set hours on the day (according to server local time). Each time cron runs, it will process a number of removals until Time limit amount of time has been used, then it will stop and wait for the next cron run.';
$string['cronprocesingtime'] = 'Le temps de traitement de chaqu\'un es cron';
$string['cronsetup'] = 'Configurer le cron';
$string['cronsetup_desc'] = 'You can configure cron to complete the upgrade of quiz attempt data automatically.';
$string['cronstarthour'] = 'Heure de départ';
$string['cronstophour'] = 'Heure de fin';
$string['pluginname'] = 'Retrait automatique de vieux cours';
