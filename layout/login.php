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
 * A login page based on Boost.
 *
 * @package   theme_stream
 * @copyright 2022 Hugo Ribeiro ribeiro.hugo@gmail.com
 * @copyright based on 2016 Damyon Wiese
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes();
// Loads theme settings.
$theme = theme_config::load('stream');

// Sets a default login image if none exists on the theme settings.
$loginimage = $OUTPUT->image_url('default/loginimage', 'theme');
// Reads image from the theme settings.
if ($theme->setting_file_url('loginimg', 'loginimg')) {
    $loginimage = $theme->setting_file_url('loginimg', 'loginimg');
}

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'loginimg' => $loginimage,
];

echo $OUTPUT->render_from_template('theme_stream/login', $templatecontext);

