<?

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

class reds_emptyd7 extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID = 'reds.emptyd7';
        $this->MODULE_NAME = Loc::getMessage('REDS_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('REDS_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('REDS_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = 'https://redsgroup.ru';
    }

    public function InstallFiles(){

    	CopyDirFiles(
    		__DIR__."/assets/scripts",
    		Application::getDocumentRoot()."/bitrix/js/".$this->MODULE_ID."/",
    		true,
    		true
    	);

    	CopyDirFiles(
    		__DIR__."/assets/styles",
    		Application::getDocumentRoot()."/bitrix/css/".$this->MODULE_ID."/",
    		true,
    		true
    	);

        CopyDirFiles(
    		__DIR__."/assets/images",
    		Application::getDocumentRoot()."/bitrix/images/".$this->MODULE_ID."/",
    		true,
    		true
    	);

    	return false;
    }

    // Событие отрисовки
    public function InstallEvents(){

    	EventManager::getInstance()->registerEventHandler(
    		"main",
    		"OnBeforeEndBufferContent",
    		$this->MODULE_ID,
    		"Reds\ToTop\Main",
    		"appendScriptsToPage"
    	);

    	return false;
    }

    public function doInstall()
    {
        if(CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {

    		$this->InstallFiles();
    		$this->installDB();
    		ModuleManager::registerModule($this->MODULE_ID);
    		$this->InstallEvents();
    	}
        else {

    		$APPLICATION->ThrowException(
    			Loc::getMessage("REDS_INSTALL_ERROR_VERSION")
    		);
    	}

    }

    public function doUninstall()
    {
        $this->uninstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function installDB()
    {
        // if (Loader::includeModule($this->MODULE_ID))
        // {
        //     ExampleTable::getEntity()->createDbTable();
        //}
        return false;
    }

    public function uninstallDB()
    {
        // if (Loader::includeModule($this->MODULE_ID))
        // {
        //     $connection = Application::getInstance()->getConnection();
        //     $connection->dropTable(ExampleTable::getTableName());
        // }
        return false;
    }

    public function UnInstallFiles() {

    	Directory::deleteDirectory(
    		Application::getDocumentRoot()."/bitrix/js/".$this->MODULE_ID
    	);

    	Directory::deleteDirectory(
    		Application::getDocumentRoot()."/bitrix/css/".$this->MODULE_ID
    	);

    	return false;
    }

    public function UnInstallEvents(){

    	EventManager::getInstance()->unRegisterEventHandler(
    		"main",
    		"OnBeforeEndBufferContent",
    		$this->MODULE_ID,
    		"Reds\Exampled7\Main",
    		"appendScriptsToPage"
    	);

    	return false;
    }
}
