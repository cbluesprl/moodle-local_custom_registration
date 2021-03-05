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
 * @author    mgerard@cblue.be
 * @copyright CBlue SPRL, support@cblue.be
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   local_custom_registration
 */

defined('MOODLE_INTERNAL') || die;

require_once(__DIR__ . '/lib.php');

if ($hassiteconfig) {

    global $ADMIN;

    $settings = new admin_settingpage(
        'local_custom_registration_settings',
        get_string('custom_registration_form', 'local_custom_registration'),
        'moodle/site:config'
    );

    $additional_fields = local_custom_registration_get_additional_fields();

    foreach ($additional_fields as $field_name => $field) {
        $settings->add(new admin_setting_heading(
            'local_custom_registration_' . $field_name,
            get_string($field_name, 'local_custom_registration'),
            ''
        ));

        $settings->add(new admin_setting_configcheckbox(
            'local_custom_registration/enable_' . $field_name,
            get_string('enable_' . $field_name, 'local_custom_registration'),
            get_string('enable_' . $field_name . '_desc', 'local_custom_registration'),
            0
        ));

        $settings->add(new admin_setting_configcheckbox(
            'local_custom_registration/is_' . $field_name . '_required',
            get_string('is_' . $field_name . '_required', 'local_custom_registration'),
            get_string('is_' . $field_name . '_required_desc', 'local_custom_registration'),
            0
        ));
    }

    $ADMIN->add('localplugins', $settings);

}