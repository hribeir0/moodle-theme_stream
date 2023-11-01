<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     theme_stream
 * @copyright   2022 Hugo Ribeiro <ribeiro.hugo@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

namespace theme_stream\output\core;

/**
 * The core course renderer
 *
 * Can be retrieved with the following:
 * $renderer = $PAGE->get_renderer('core','course');
 */
class course_renderer extends \core_course_renderer {

    /**
     * Renders the activity navigation.
     *
     * Defer to template.
     *
     * @param \core_course\output\activity_navigation $page
     * @return string html for the page
     */
    public function render_activity_navigation(\core_course\output\activity_navigation $page) {
        $data = $page->export_for_template($this->output);
        if (isset($data->prevlink)) {
            $data->prevlink->classes = 'btn btn-outline-primary';
            $prevoriginal = $data->prevlink->text;
            // Removes the hard coded icon.
            $prevoriginal = substr($prevoriginal, 9);
            // Replaces the activity name for the theme string.
            $prevlink = str_replace($prevoriginal, get_string('prevactivity', 'theme_stream'), $prevoriginal);
            // Adds a new icon.
            $data->prevlink->text = '<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> ' .$prevlink;
            // Tooltip data.
            $data->prevlink->attributes = [
                ['name' => 'data-toggle', 'value' => 'tooltip'],
                ['name' => 'title', 'value' => $prevoriginal],
            ];
        }

        if (isset($data->nextlink)) {
            $data->nextlink->classes = 'btn btn-outline-primary';
            $nextoriginal = $data->nextlink->text;
            // Removes the hard coded icon.
            $nextoriginal = substr($nextoriginal, 0, -9);
            // Replaces the activity name for the theme string.
            $nextlink = str_replace($nextoriginal, get_string('nextactivity', 'theme_stream'), $nextoriginal);
            // Adds a new icon.
            $data->nextlink->text = '<i class="fa fa-arrow-circle-right" aria-hidden="true"></i> ' .$nextlink;
            // Tooltip data.
            $data->nextlink->attributes = [
                ['name' => 'data-toggle', 'value' => 'tooltip'],
                ['name' => 'title', 'value' => $nextoriginal],
            ];
        }
        return $this->output->render_from_template('core_course/activity_navigation', $data);
    }
}
