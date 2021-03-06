<?php

Namespace Model;

class BaseComposerApp extends BasePHPApp {

  protected $fileSources;

  public function __construct($params) {
    parent::__construct($params);
  }

  public function install($autoPilot = null) {
    if (isset($this->params["hide-title"])) { $this->populateTinyTitle() ; }
    $this->showTitle();
    $this->programDataFolder = ($autoPilot)
      ? $autoPilot->{$this->autopilotDefiner."InstallDirectory"}
      : $this->askForProgramDataFolder();
    $this->programExecutorFolder = ($autoPilot)
      ? $autoPilot->{$this->autopilotDefiner."ExecutorDirectory"}
      : $this->askForProgramExecutorFolder();
    $this->deleteProgramDataFolderAsRootIfExists();
    $this->makeProgramDataFolderIfNeeded();
    $this->copyComposerJsonToProgramDataFolder();
    $this->doComposerCommand();
    $this->deleteExecutorIfExists();
    $this->populateExecutorFile();
    $this->saveExecutorFile();
    $this->deleteInstallationFiles();
    $this->changePermissions();
    $this->setInstallFlagStatus(true) ;
    if (isset($this->params["hide-completion"])) { $this->populateTinyCompletion(); }
    $this->showCompletion();
  }

  public function unInstall($autoPilot = null) {
    $this->showTitle();
    $this->programDataFolder = ($autoPilot)
      ? $autoPilot->{$this->autopilotDefiner}
      : $this->askForProgramDataFolder();
    $this->programExecutorFolder = $this->askForProgramExecutorFolder();
    $this->deleteProgramDataFolderAsRootIfExists();
    $this->deleteExecutorIfExists();
    $this->setInstallFlagStatus(false) ;
    $this->showCompletion();
  }

  // @todo removed hardcoded composer path
  protected function copyComposerJsonToProgramDataFolder() {
      $templatorFactory = new \Model\Templating();
      $templator = $templatorFactory->getModel($this->params);
      $original = "/opt/ptconfigure/ptconfigure/src/Modules/".$this->getModuleName()."/Templates/composer.json" ;
      $targetLocation = $this->programDataFolder.DIRECTORY_SEPARATOR.$this->programNameMachine.DIRECTORY_SEPARATOR."composer.json" ;
      $templator->template(
          $original,
          array(),
          $targetLocation );
  }

  protected function doComposerCommand(){
      $command = array(
          "cd $this->programDataFolder".DIRECTORY_SEPARATOR.$this->programNameMachine ,
          "wget https://getcomposer.org/installer",
          "php installer",
          "php composer.phar install"
      );
      self::executeAsShell($command);
    return true;
  }

}