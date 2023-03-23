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
 * Footer variables to be printed on the mustache template
 *
 * @package   theme_stream
 * @copyright 2022 Hugo Ribeiro
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$themesettings = get_config('theme_stream');

$templatecontext['year'] = date('Y');
$templatecontext['facebookurl'] = $themesettings->facebookurl;
$templatecontext['instagramurl'] = $themesettings->instagramurl;
$templatecontext['pinteresturl'] = $themesettings->pinteresturl;
$templatecontext['youtubeurl'] = $themesettings->youtubeurl;
$templatecontext['linkedinurl'] = $themesettings->linkedinurl;
$templatecontext['twitterurl'] = $themesettings->twitterurl;
$templatecontext['leftcolumn'] = format_text($themesettings->leftcolumn, FORMAT_HTML);
$templatecontext['centercolumn'] = format_text($themesettings->centercolumn, FORMAT_HTML);
