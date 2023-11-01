//
// This file is part of Adaptable theme for moodle
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
//
//
// Toggle password to text in the login page.
//
// @package    theme_stream
// @copyright  2022 Hugo Ribeiro
// @copyright based on https://www.javascripttutorial.net/javascript-dom/javascript-toggle-password-visibility/
// @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.


export const init = () => {
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function() {
            // Toggle the type attribute.
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // Toggle the icon.
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
    });
};