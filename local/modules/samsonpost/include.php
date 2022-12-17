<?php
	
	use Bitrix\Main\Loader;
	use Bitrix\Main\LoaderException;
	use Bitrix\Main\Localization\Loc;
	
	try {
		
		Loader::registerAutoLoadClasses(
			'samsonpost',
			[
        Samsonpost\Main::class => "lib/Main.php",
			]
		);
		
		Loc::loadMessages(__FILE__);
		
	} catch (LoaderException $e) {
	}
	
	Loc::loadMessages(__FILE__);