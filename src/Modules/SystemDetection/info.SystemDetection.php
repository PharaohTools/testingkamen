<?php

Namespace Info;

class SystemDetectionInfo extends Base {

    public $hidden = false;

    public $name = "System Detection - Detect the Running Operating System";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "SystemDetection" =>  array_merge(array("detect", "help") ) );
    }

    public function routeAliases() {
      return array("system-detection"=>"SystemDetection", "systemdetection"=>"SystemDetection");
    }

    public function autoPilotVariables() {
      return array(
        "SystemDetection" => array(
          "SystemDetection" => array(
            "programDataFolder" => "/etc/apache2/", // command and app dir name
            "programNameMachine" => "systemdetection", // command and app dir name
            "programNameFriendly" => "System Detect", // 12 chars
            "programNameInstaller" => "System Detection",
          )
        )
      );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This is a default Module and provides you with a method by which you can configure Application Settings.
  You can configure default application settings, ie: mysql admin user, host, pass

  SystemDetection, system-detection, systemdetection

        - detect
        Detects the Operating System
        example: ptconfigure system-detection detect

HELPDATA;
      return $help ;
    }

}