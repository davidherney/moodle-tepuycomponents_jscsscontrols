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

namespace tepuycomponents_jscsscontrols\local\hooks\output;

/**
 * Hook callbacks for tepuycomponents_jscsscontrols
 *
 * @package    tepuycomponents_jscsscontrols
 * @copyright  2025 David Herney @ BambuCo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class before_http_headers {

    /**
     * Tweak to allow JS injection from a local plugin https://docs.moodle.org/dev/Local_plugins.
     *
     * @throws coding_exception
     * @throws dml_exception
     *
     * @param \core\hook\output\before_http_headers $hook
     */
    public static function callback(\core\hook\output\before_http_headers $hook): void {
        global $CFG;
        if (during_initial_install() || isset($CFG->upgraderunning) || !get_config('tepuycomponents_jscsscontrols', 'version')) {
            // Do nothing during installation or upgrade.
            return;
        }

        $renderer = $hook->renderer;

        global $COURSE, $PAGE;

    //    $PAGE->requires->css('/local/tepuy/components/jscsscontrols/styles.css');

        $PAGE->requires->js_call_amd('tepuycomponents_jscsscontrols/main', 'init', array($COURSE->id));

        // // TODO Using mustache template instead.
        // $PAGE->requires->strings_for_js([
        //     'js:header',
        //     'js:error_parsing',
        //     'js:command_placeholder',
        // ], 'local_commander');
    }
}
