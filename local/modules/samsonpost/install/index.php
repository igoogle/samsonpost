<?php

	use Bitrix\Main\Localization\Loc;

	IncludeModuleLangFile(__FILE__);

	class samsonpost extends CModule {

		var $MODULE_ID = "samsonpost";
		var $MODULE_VERSION;
		var $MODULE_VERSION_DATE;
		var $MODULE_NAME;
		var $MODULE_DESCRIPTION;

    var $errors;

		function samsonpost() {

			$arModuleVersion = [];

			$path = str_replace("\\", "/", __FILE__);
			$path = substr($path, 0, strlen($path) - strlen("/index.php"));
			include($path . "/version.php");

			if(\is_array($arModuleVersion) && \array_key_exists("VERSION", $arModuleVersion))
			{

				$this->MODULE_VERSION = $arModuleVersion["VERSION"];
				$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
			}

			$this->MODULE_NAME = Loc::getMessage('MODULE_NAME');
			$this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_DESCRIPTION');

		}

		function InstallDB()
		{
			return true;
		}

		function UnInstallDB($arParams = [])
		{
			return true;
		}

		function InstallEvents()
		{
			return true;
		}

		function UnInstallEvents()
		{
			return true;
		}

		function InstallFiles()
		{
			return true;
		}

		function UnInstallFiles()
		{
			return true;
		}

		function DoInstall()
		{
			RegisterModule('samsonpost');
			return true;
		}

		function DoUninstall()
		{
			UnRegisterModule('samsonpost');
			return true;
		}

	}