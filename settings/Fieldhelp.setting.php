<?php
/**
 * @file
 * Settings metadata for com.aghstrategies.fieldhelp.
 * Copyright (C) 2016, AGH Strategies, LLC <info@aghstrategies.com>
 * Licensed under the GNU Affero Public License 3.0 (see LICENSE.txt)
 */
return array(
  'fieldhelp_activities' => array(
    'group_name' => 'fieldhelp',
    'group' => 'fieldhelp',
    'name' => 'fieldhelp_activities',
    'type' => 'Array',
    'default' => NULL,
    'add' => '4.7',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Associative Array of fields to add help text to for activities',
    'help_text' => 'each key in this array is a activity field name and each value is the help text to be displayed.',
  ),
  'fieldhelp_individuals' => array(
    'group_name' => 'fieldhelp',
    'group' => 'fieldhelp',
    'name' => 'fieldhelp_individuals',
    'type' => 'Array',
    'default' => NULL,
    'add' => '4.7',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Associative Array of actvity fields to add help text to for individuals',
    'help_text' => 'each key in this array is a individual field name and each value is the help text to be displayed.',
  ),
  'fieldhelp_organizations' => array(
    'group_name' => 'fieldhelp',
    'group' => 'fieldhelp',
    'name' => 'fieldhelp_organizations',
    'type' => 'Array',
    'default' => NULL,
    'add' => '4.7',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Associative Array of actvity fields to add help text to for organizations',
    'help_text' => 'each key in this array is a organization field name and each value is the help text to be displayed.',
  ),
);
