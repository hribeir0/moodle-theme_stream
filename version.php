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

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'theme_stream';
$plugin->release = '1.5.2';
$plugin->version = 2024110704;
$plugin->requires = 2024100700;
$plugin->maturity = MATURITY_RC;
$plugin->dependencies = [
    'theme_boost' => 2024100700,
];
