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

$string['courseid'] = 'ID du cours';
$string['coursesperpage'] = 'Cours par page';
$string['createdsince'] = 'Créé depuis';
$string['cronenabled'] = 'Cron activé';
$string['cronenabled_desc'] = 'Cochez cette case si vous souhaitez traiter la suppression des anciens cours avec le cron du système.';
$string['croninstructions'] = 'Vous pouvez activer le cron pour supprimer de vieux espaces cours basé sur certains critères. Le cron va fonctionner durant une plage horaire définie (en phase avec le réglage local du serveur). Chaque fois que le cron fonctionne, il va traiter la suppression des cours jusqu\'à ce que le temps limite soit épuisé, puis stoppera et attendra la prochaine exécution.';
$string['cronprocessingtime'] = 'Temps de fonctionnement';
$string['cronprocessingtime_desc'] = 'Le temps de fonctionnement à chaque lancement de cron..';
$string['cronsetupheader'] = 'Configurer le cron';
$string['cronsetupheader_desc'] = 'Vous pouvez configurer le cron pour supprimer de vieux espaces cours basé sur certains critères.';
$string['cronstarttime'] = 'Temps de démarrage';
$string['cronstarttime_desc'] = 'Le temps de la journée où le cron commencera à être disponible pour la suppression.';
$string['cronstoptime'] = 'Temps de fin';
$string['cronstoptime_desc'] = 'Le temps de la journée où le cron arrêtera d\'être disponible pour la suppression.';
$string['description'] = 'Cet outil d\'administration permet de supprimer les anciens cours en fonction de nombreux critères comme la visibilité de cours, la date de création ou si le cours a été modifié.';
$string['editsettings'] = 'Modifier les réglages';
$string['filterrules'] = 'Règles de filtrage';
$string['filterrules_desc'] = 'Ces réglages contrôlent les cours qui seront supprimés et ceux qui seront conservés.';
$string['keepmetacourses'] = 'Conserver les méta-cours';
$string['keepmetacourses_desc'] = 'Cochez cette case si vous souhaitez seulement supprimer les cours n\'étant pas utilisés dans une inscription méta-cours.';
$string['keepmodified'] = 'Conserver les cours modifiés';
$string['keepmodified_desc'] = 'Cochez cette case si vous souhaitez seulement supprimer les cours non modifiés.';
$string['keepvisible'] = 'Conserver les cours visibles';
$string['keepvisible_desc'] = 'Cochez cette case si vous souhaitez seulement supprimer les cours non visibles.';
$string['keepyoungerthan'] = 'Conserver les cours plus jeunes que';
$string['keepyoungerthan_desc'] = 'Cochez cette case si vous souhaitez seulement supprimer les cours plus vieux que cette durée.';
$string['keepwithactionlogs'] = 'Conserver les cours avec des historiques de modification';
$string['keepwithactionlogs_desc'] = 'Cochez cette case si vous souhaitez seulement supprimer les cours n\'ayant pas d\'historiques d\'ajouts, de suppressions ou de mises à jour.';
$string['keepwithmanualgrading'] = 'Conserver les cours avec des éléments d\'évaluation manuelle';
$string['keepwithmanualgrading_desc'] = 'Cochez cette case si vous souhaitez seulement supprimer les cours n\'ayant pas d\'éléments d\'évaluation manuelle.';
$string['keepwithmodules'] = 'Conserver les cours avec modules';
$string['keepwithmodules_desc'] = 'Cochez cette case si vous souhaitez seulement supprimer les cours n\'ayant pas de modules d\'activité ou de ressources.';
$string['keepwithquestions'] = 'Conserver les cours avec questions';
$string['keepwithquestions_desc'] = 'Cochez cette case si vous souhaitez seulement supprimer les cours n\'ayant pas de questions dans la banque de question.';
$string['nocoursetoremove'] = 'Il n\'y a actuellement aucun cours à supprimer. Vous pouvez modifier au besoin les règles de filtrage dans les réglages du plugin.';
$string['matchingcourses'] = 'Il y a actuellement {$a} cours qui correspondent aux règles de filtrage actuelles.';
$string['pluginname'] = 'Suppression automatique de vieux cours';
$string['sendemail'] = 'Envoyer un courriel aux administrateurs';
$string['sendemail_desc'] = 'Cochez cette case pour envoyer un courriel à tous les administrateurs chaque fois qu\'un traitement se termine.';
$string['settings'] = 'Réglages';
$string['showelligiblecourses'] = 'Afficher les cours admissibles';
$string['showelligiblecourses_desc'] = 'Affiche la liste de tous les cours qui sont admissibles à la suppression. Cela vous permet de faire une vérification avant de lancer le processus.';
$string['updatetable'] = 'Update table';

