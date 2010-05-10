<?php

class PmsInstallShell extends Shell
{
	var $uses = array('Resolution');

	function main()
	{
		$this->Resolution->makeInitialRecord();
		echo "done!!!";
	}
}
?>
