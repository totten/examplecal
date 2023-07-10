<?php

require_once 'examplecal.civix.php';
// phpcs:disable
use CRM_Examplecal_ExtensionUtil as E;
// phpcs:enable

function examplecal_civicrm_esmImportMap(\Civi\Esm\ImportMap $importMap): void {
  $npmPackages = [
    '@fullcalendar/core',
    '@fullcalendar/daygrid',
    'preact',
  ];
  foreach ($npmPackages as $package) {
    $packageJson = json_decode(file_get_contents(E::path("node_modules/{$package}/package.json")), 1);
    foreach ($packageJson['exports'] as $item => $variants) {
      // All the `$item`s and `$variant`s are expressed relative to `./`. We trim the `./` with substr().

      // No need to tell browser about CommonJS files -- browser wants ESM.
      if (str_ends_with($item, '.cjs')) {
        continue;
      }

      $logicalPath = $package . substr($item, 1);

      $physicalPath = NULL;
      if (is_string($variants)) {
        $physicalPath = "node_modules/{$package}" . substr($variants, 1);
      }
      elseif (isset($variants['browser'])) {
        $physicalPath = "node_modules/{$package}" . substr($variants['browser'], 1);
      }
      elseif (isset($variants['import'])) {
        $physicalPath = "node_modules/{$package}" . substr($variants['import'], 1);
      }

      if ($physicalPath) {
        $importMap->addPrefix($logicalPath, E::LONG_NAME, $physicalPath);

      }
    }
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function examplecal_civicrm_config(&$config): void {
  _examplecal_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function examplecal_civicrm_install(): void {
  _examplecal_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function examplecal_civicrm_enable(): void {
  _examplecal_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function examplecal_civicrm_preProcess($formName, &$form): void {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function examplecal_civicrm_navigationMenu(&$menu): void {
//  _examplecal_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _examplecal_civix_navigationMenu($menu);
//}
