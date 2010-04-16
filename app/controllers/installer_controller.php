<?php
// app/controllers/
uses('model' . DS . 'connection_manager');

class InstallerController extends AppController {
	var $name = 'Installer';
	var $uses = array();
	var $helpers = array('Html');

	function beforeFilter() {		 
		if (!file_exists(TMP.'not_installed.txt')) {
			echo('Application is already installed. Create app/config/not_installed.txt to reinstall the application.');
			exit();
		}
	}

	function index() {
		// show how to install
	}

	function database() {		 
		$db = ConnectionManager::getDataSource('default');

		if(!$db->isConnected()) {
			echo 'Could not connect to database. Please check the settings in app/config/database.php and try again';
		}
        $this->__executeSQLScript($db, CONFIGS.'sql'.DS.'tables.sql');
        $this->redirect('/installer/thanks');
	}

	function thanks() {
		if (unlink(TMP.'not_installed.txt')) {
			$this->set('message', 'Installation is complete');
		} else {
			$this->set('message', 'The final step of the installation failed because ' . TMP.'not_installed.txt' . ' could not be deleted.');
		}
	}

	private function __executeSQLScript($db, $fileName) {
		//echo "__executeSQLScript()<br>";
		
		$statements = file_get_contents($fileName);
		$statements = explode(';', $statements);

		foreach ($statements as $statement) {
			if (trim($statement) != '') {
				$db->query($statement);
			}
		}
	}
}
?>