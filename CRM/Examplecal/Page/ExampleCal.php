<?php
use CRM_Examplecal_ExtensionUtil as E;

class CRM_Examplecal_Page_ExampleCal extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('ExampleCal'));

    Civi::resources()->addModuleFile(E::LONG_NAME, 'js/examplecal.js');

    parent::run();
  }

}
