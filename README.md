# local_custom_registration
## Introduction

This plugin has been developed to allow administrators to add user fields to the registration form.
These fields must be stored in mdl_user table.

The list of fields that can be added :

- Phone 1
- Phone 2
- Insitution
- Department
- Address
- Lang

## Procedure to follow

1) Enable "Email-based self-registration" authentication plugin. To enable potential users to register themselves and create accounts. Then set 'Admin>Manage authentication>Common settings>Self registration' to 'Email-based self-registration' and Save Changes.
2) Configure this plugin here : _<moodlepath>_/admin/settings.php?section=local_custom_registration_settings
3) The fields can simply be enabled to automaticaly appear in the registration form. They can also be switched to "required" mode if needed.

## Requirements

Make sure the "auth_email" plugin is installed and enabled.