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

namespace theme_stream\local\hooks\navigation;

/**
 * Hook callbacks for theme_stream
 *
 * @package    theme_stream
 * @copyright  2024 Hugo Ribeiro <hugo@moodlar.pt>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class primary_extend {

    /**
     * Allows plugins to insert nodes into site primary navigation
     *
     * @param \core\hook\navigation\primary_extend $hook
     */
    public static function callback(\core\hook\navigation\primary_extend $hook): void {
        $primarynav = $hook->get_primaryview();

        // If able to create users print new node branch.
        $systemcontext = \context_system::instance();
        // Allowed to create users.
        if (has_capability('moodle/user:create', $systemcontext)) {
            $node = $primarynav->add(
                get_string('management', 'theme_stream'),
                null,
                \navigation_node::NODETYPE_BRANCH,
            );

            $node->add(
                get_string('managecourses', 'theme_stream'),
                new \moodle_url('/course/management.php'),
                \navigation_node::TYPE_ROOTNODE,
            );

            $node->add(
                get_string('manageusers', 'theme_stream'),
                new \moodle_url('/admin/user.php'),
                \navigation_node::TYPE_ROOTNODE,
            );

            $node4 = $node->add(
                get_string('themesettings', 'theme_stream'),
                new \moodle_url('/admin/settings.php', ['section' => 'themesettingstream']),
                \navigation_node::TYPE_ROOTNODE,
            );

            $node4->preceedwithhr = true;
        }
    }
}
