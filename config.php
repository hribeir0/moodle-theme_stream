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
 * The configuration for theme_stream is defined here.
 *
 * @package     theme_stream
 * @copyright   2021 Hugo Ribeiro <ribeiro.hugo@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'stream';

$THEME->doctype = 'html5';

$THEME->parents = [
    'boost',
];

$THEME->sheets = [
    'sheet',
];

// Disables navigation and admin blocks.
$THEME->requiredblocks = '';

// Most themes will use this rendererfactory as this is the one that allows the theme to override any other renderer.
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Loads the main SCSS file and starting point. Defined in lib.php.
$THEME->scss = function($theme) {
    return theme_stream_get_main_scss_content($theme);
};

$THEME->haseditswitch = true;

// Ability to add block on the new region and on top of existing blocks.
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

// Support for the extra SCSS read read from theme settings.
$THEME->prescsscallback = 'theme_stream_get_pre_scss';

// Extra SCSS.
$THEME->extrascsscallback = 'theme_stream_get_extra_scss';

// On M4.0 sets if should repeat MODs title.
$THEME->activityheaderconfig = [
    'notitle' => true,
];

// Remove main menu nodes given the theme settings.
$THEME->removedprimarynavitems = explode("," , get_config('theme_stream', 'hideprimarynodes'));

// Used layouts.
$THEME->layouts = [
    // Main course page.
    'course' => [
        'file' => 'course.php',
        'regions' => ['side-pre', 'topblock'],
        'defaultregion' => 'side-pre',
        'options' => ['langmenu' => true],
    ],
    // Login page.
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'defaultregion' => [],
        'options' => ['langmenu' => true],
    ],
    // Front page.
    'frontpage' => [
        'file' => 'frontpage.php',
        'regions' => ['topblock'],
        'defaultregion' => 'topblock',
        'options' => ['langmenu' => true],
    ],
    // Standard layout with blocks.
    'standard' => [
        'file' => 'drawers.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
];
