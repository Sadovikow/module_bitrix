<?

###########################
#						  #
# module REDS GROUP		  #
# @copyright 2019 REDSGROUP #
#						  #
###########################

AddEventHandler("main", "OnBuildGlobalMenu", "redsMenuCorporatelight");

function redsMenuCorporatelight(&$arGlobalMenu, &$arModuleMenu)
{
	IncludeModuleLangFile(__FILE__);
	$moduleName = "reds.emptyd7";

	global $APPLICATION;
	$APPLICATION->SetAdditionalCss("/bitrix/css/".$moduleName."/menu.css");


	if($APPLICATION->GetGroupRight($moduleName) > "D")
	{
		$arMenu = array(
			"menu_id" => "reds_corporatelight",
			"items_id" => "reds_corporatelight",
			"text" => 'REDS Group',
			"sort" => 900,
			"items" => array(
				array(
					"text" => 'REDS Example',
					"sort" => 10,
					"url" => "/bitrix/admin/settings.php?lang=".LANGUAGE_ID."&mid=".$moduleName."&mid_menu=1",
					"items_id" => "REDS_main",
				),
			),
		);
		$arGlobalMenu[] = $arMenu;
	}
}
//
// use Bitrix\Main\Localization\Loc;
//
// Loc::loadMessages(__FILE__);
//
// $menu = array(
//     array(
//         'parent_menu' => 'global_menu_content',
//         'sort' => 400,
//         'text' => Loc::getMessage('REDS_MENU_TITLE'),
//         'title' => Loc::getMessage('REDS_MENU_TITLE'),
//         'url' => 'd7dull_index.php',
//         'items_id' => 'menu_references',
//         'items' => array(
//             array(
//                 'text' => Loc::getMessage('REDS_SUBMENU_TITLE'),
//                 'url' => 'd7dull_index.php?param1=paramval&lang=' . LANGUAGE_ID,
//                 'more_url' => array('d7dull_index.php?param1=paramval&lang=' . LANGUAGE_ID),
//                 'title' => Loc::getMessage('REDS_SUBMENU_TITLE'),
//             ),
//         ),
//     ),
// );
//
// return $menu;
