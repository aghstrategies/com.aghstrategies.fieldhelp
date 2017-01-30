<?php

require_once 'fieldhelp.civix.php';

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function fieldhelp_civicrm_buildForm($formName, &$form) {
  // print_r($formName);
  // die();
  switch ($formName) {
    case 'CRM_Activity_Form_Activity':
    case 'CRM_Case_Form_Case':
    case 'CRM_Case_Form_Activity':
      $settingName = 'fieldhelp_activities';
      break;

    case 'CRM_Contact_Form_Contact':
      // TODO currently this breaks for inline forms
      // case 'CRM_Contact_Form_Inline_ContactInfo':
      // case 'CRM_Contact_Form_Inline_CommunicationsPreferences':
      // case 'CRM_Contact_Form_Inline_ContactName':
      // case 'CRM_Contact_Form_Inline_Email':
      // case 'CRM_Contact_Form_Inline_Phone':
      // case 'CRM_Contact_Form_Inline_Address':
      if ($form->_contactType == 'Organization') {
        $settingName = 'fieldhelp_organizations';
      }
      if ($form->_contactType == 'Individual') {
        $settingName = 'fieldhelp_individuals';
      }
      break;

    default:
      return;
  }
  try {
    $fieldsToAddHelp = civicrm_api3('Setting', 'getvalue', array(
      'name' => $settingName,
      'group' => 'fieldhelp',
    ));
  }
  catch (CiviCRM_API3_Exception $e) {
    $error = $e->getMessage();
    CRM_Core_Error::debug_log_message(ts('API Error %1', array(
      'domain' => 'com.aghstrategies.fieldhelp',
      1 => $error,
    )));
  }
  if (!empty($fieldsToAddHelp)) {
    $fields = array();
    foreach ($fieldsToAddHelp as $key => $value) {
      if ($form->elementExists($key)) {
        $fields[$key] = $value;
      }
      // weird fields that need special attention
      elseif ($key == 'Email_Block_1'|| $key == 'preferred_communication_method_1') {
        $fields[$key] = $value;
      }
    }
    CRM_Core_Resources::singleton()->addVars('fieldhelp', array('fields' => $fields));
    CRM_Core_Resources::singleton()->addScriptFile('com.aghstrategies.fieldhelp', 'js/fieldhelp.js');

  }
}
/**
 * Implements hook_civicrm_pageRun().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pageRun
 */
function fieldhelp_civicrm_pageRun(&$page) {
  if ($page->getVar('_name') == 'CRM_Contact_Page_View_Summary') {
    if (!empty($page->getVar('_contactId'))) {
      try {
        $result = civicrm_api3('Contact', 'getsingle', array(
          'id' => $page->getVar('_contactId'),
        ));
      }
      catch (CiviCRM_API3_Exception $e) {
        $error = $e->getMessage();
        CRM_Core_Error::debug_log_message(ts('API Error %1', array(
          'domain' => 'com.aghstrategies.fieldhelp',
          1 => $error,
        )));
      }
      if ($result['contact_type'] == 'Organization') {
        $settingName = 'fieldhelp_organizations';
      }
      if ($result['contact_type'] == 'Individual') {
        $settingName = 'fieldhelp_individuals';
      }
      if (!empty($settingName)) {
        try {
          $fieldsToAddHelp = civicrm_api3('Setting', 'getvalue', array(
            'name' => $settingName,
            'group' => 'fieldhelp',
          ));
        }
        catch (CiviCRM_API3_Exception $e) {
          $error = $e->getMessage();
          CRM_Core_Error::debug_log_message(ts('API Error %1', array(
            'domain' => 'com.aghstrategies.fieldhelp',
            1 => $error,
          )));
        }
        if (!empty($fieldsToAddHelp)) {
          $fields = array();
          foreach ($fieldsToAddHelp as $key => $value) {
            $fields[$key] = $value;
          }
          CRM_Core_Resources::singleton()->addVars('fieldhelp', array('fields' => $fields));
          CRM_Core_Resources::singleton()->addScriptFile('com.aghstrategies.fieldhelp', 'js/fieldhelp.js');
        }
      }
    }
  }
}
/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function fieldhelp_civicrm_config(&$config) {
  _fieldhelp_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function fieldhelp_civicrm_xmlMenu(&$files) {
  _fieldhelp_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function fieldhelp_civicrm_install() {
  _fieldhelp_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function fieldhelp_civicrm_uninstall() {
  _fieldhelp_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function fieldhelp_civicrm_enable() {
  _fieldhelp_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function fieldhelp_civicrm_disable() {
  _fieldhelp_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function fieldhelp_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _fieldhelp_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function fieldhelp_civicrm_managed(&$entities) {
  _fieldhelp_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function fieldhelp_civicrm_caseTypes(&$caseTypes) {
  _fieldhelp_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function fieldhelp_civicrm_angularModules(&$angularModules) {
_fieldhelp_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function fieldhelp_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _fieldhelp_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function fieldhelp_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function fieldhelp_civicrm_navigationMenu(&$menu) {
  _fieldhelp_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'com.aghstrategies.fieldhelp')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _fieldhelp_civix_navigationMenu($menu);
} // */
