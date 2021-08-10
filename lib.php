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

/**
 * Returns all fields that can be added in the registration form
 * These fields are all present in the user table
 *
 * @return array[]
 */
function local_custom_registration_get_additional_fields() {
    $translations = get_string_manager()->get_list_of_translations();

    // TODO : It would be great to get the maxlength and type directly from the database
    return [
        'custom_phone1' => [
            'element_type' => 'text',
            'type' => PARAM_TEXT,
            'maxlength' => 20,
        ],
        'custom_phone2' => [
            'element_type' => 'text',
            'type' => PARAM_TEXT,
            'maxlength' => 20,
        ],
        'custom_institution' => [
            'element_type' => 'text',
            'type' => PARAM_TEXT,
            'maxlength' => 255,
        ],
        'custom_department' => [
            'element_type' => 'text',
            'type' => PARAM_TEXT,
            'maxlength' => 255,
        ],
        'custom_address' => [
            'element_type' => 'text',
            'type' => PARAM_TEXT,
            'maxlength' => 255,
        ],
        'custom_lang' => [
            'element_type' => 'select',
            'type' => PARAM_TEXT,
            'values' => $translations
        ]
    ];
}

/**
 * Extend the signup form with additional fields selected in the plugin configuration
 *
 * @param $mform
 * @throws coding_exception
 * @throws dml_exception
 */
function local_custom_registration_extend_signup_form($mform) {

    $additional_fields = local_custom_registration_get_additional_fields();

    foreach ($additional_fields as $field_name => $field) {
        if (get_config('local_custom_registration',  'enable_' . $field_name)) {
            if (isset($field['values'])) {
                // For select inputs
                $mform->addElement($field['element_type'], $field_name, get_string($field_name, 'local_custom_registration'), $field['values']);
            } else {
                $mform->addElement($field['element_type'], $field_name, get_string($field_name, 'local_custom_registration'));
            }
            $mform->setType($field_name, PARAM_TEXT);

            if (isset($field['maxlength'])) {
                $mform->addRule($field_name, get_string('maximumchars', '', $field['maxlength']), 'maxlength', $field['maxlength'], 'client');
            }

            if (get_config('local_custom_registration', 'is_' . $field_name . '_required')) {
                $mform->addRule($field_name, null, 'required', null, 'client');
            }
        }
    }
}

/**
 * There is no data to validate.
 *
 * @param $datas
 * @return array
 */
function local_custom_registration_validate_extend_signup_form($datas) {
    return [];
}

/**
 * Handle values of our custom signup fields
 *
 * @param $datas
 */
function local_custom_registration_post_signup_requests($datas) {
    $added_fields = array_keys(local_custom_registration_get_additional_fields());

    foreach ($added_fields as $field) {
        $real_field = str_replace('custom_', '', $field);
        // Handle our added fields
        if (isset($datas->$field)) {
            $datas->$real_field = $datas->$field;
            unset($datas->$field);
        }
    }
}