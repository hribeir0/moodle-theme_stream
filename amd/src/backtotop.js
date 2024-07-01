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
 * Theme Stream - JS code back to top button
 *
 * @module     theme_stream/backtotop
 * @copyright  Based on Theme Boost Union
 * @copyright  2022 Moodle an Hochschulen e.V. <kontakt@moodle-an-hochschulen.de>
 * @copyright  based on code from theme_boost_campus by Kathrin Osswald.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

const Selectors = {
    actions: {
        backToTop: '[data-action="theme_stream/top"]',
    },
};

// Get the button because the data-action doesn't work to add classes.
let backToTop = document.getElementById("back-to-top");

 /**
 * Show or hide back to top button.
 *
 */
function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTop.style.display = "inline-block";
  } else {
        backToTop.style.display = "none";
    }
}

export const init = () => {
    // When there's scrolling we fire the function.
    window.onscroll = function() {
        scrollFunction();
    };
    document.addEventListener('click', e => {
        if (e.target.closest(Selectors.actions.backToTop)) {
            document.body.scrollTo({top: 0, behavior: 'smooth'});
            document.documentElement.scrollTo({top: 0, behavior: 'smooth'});
        }
    });
};