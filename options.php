<?

use Bitrix\Main\Localization\Loc;
use	Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);
Loc::loadMessages($context->getServer()->getDocumentRoot()."/bitrix/modules/main/options.php");

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);


$tabControl = new CAdminTabControl("tabControl", array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("MAIN_TAB_SET"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_SET"),
    ),
));

$aTabs = array(
	array(
		"DIV" 	  => "edit",
		"TAB" 	  => Loc::getMessage("REDS_OPTIONS_TAB_NAME"),
		"TITLE"   => Loc::getMessage("REDS_OPTIONS_TAB_NAME"),
		"OPTIONS" => array(
			Loc::getMessage("REDS_OPTIONS_TAB_COMMON"),
			array(
				"switch_on",
				Loc::getMessage("REDS_OPTIONS_TAB_SWITCH_ON"),
				"Y",
				array("checkbox")
			),
			Loc::getMessage("REDS_OPTIONS_TAB_APPEARANCE"),
			array(
				"width",
				Loc::getMessage("REDS_OPTIONS_TAB_WIDTH"),
				"50",
				array("text", 5)
			),
			array(
				"height",
				Loc::getMessage("REDS_OPTIONS_TAB_HEIGHT"),
				"50",
				array("text", 5)
			),
			array(
				"radius",
				Loc::getMessage("REDS_OPTIONS_TAB_RADIUS"),
				"50",
				array("text", 50)
			),
			array(
				"color",
				Loc::getMessage("REDS_OPTIONS_TAB_COLOR"),
				"#bf3030",
				array("text", 5)
			),
			Loc::getMessage("REDS_OPTIONS_TAB_POSITION_ON_PAGE"),
			array(
				"side",
				Loc::getMessage("REDS_OPTIONS_TAB_SIDE"),
				"left",
				array("selectbox", array(
					"left"  => Loc::getMessage("REDS_OPTIONS_TAB_SIDE_LEFT"),
					"right" => Loc::getMessage("REDS_OPTIONS_TAB_SIDE_RIGHT")
				))
			),
			array(
				"indent_bottom",
				Loc::getMessage("REDS_OPTIONS_TAB_INDENT_BOTTOM"),
				"10",
				array("text", 5)
			),
			array(
				"indent_side",
				Loc::getMessage("REDS_OPTIONS_TAB_INDENT_SIDE"),
				"10",
				array("text", 5)
			),
			Loc::getMessage("REDS_OPTIONS_TAB_ACTION"),
			array(
				"speed",
				Loc::getMessage("REDS_OPTIONS_TAB_SPEED"),
				"normal",
				array("selectbox", array(
					"slow"   => Loc::getMessage("REDS_OPTIONS_TAB_SPEED_SLOW"),
					"normal" => Loc::getMessage("REDS_OPTIONS_TAB_SPEED_NORMAL"),
					"fast"   => Loc::getMessage("REDS_OPTIONS_TAB_SPEED_FAST")
				))
			)
		)
	)
);

$tabControl = new CAdminTabControl(
	"tabControl",
	$aTabs
);

$tabControl->Begin();
?>
<form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>" method="post">

	<?
	foreach($aTabs as $aTab){

		if($aTab["OPTIONS"]){

			$tabControl->BeginNextTab();

			__AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
		}
	}

	$tabControl->Buttons();
	?>

	<input value="Сохранить" type="submit" name="apply" value="<? echo(Loc::GetMessage("REDS_OPTIONS_INPUT_APPLY")); ?>" class="adm-btn-save" />
	<input value="Сбросить" type="submit" name="default" value="<? echo(Loc::GetMessage("REDS_OPTIONS_INPUT_DEFAULT")); ?>" />

	<?
	echo(bitrix_sessid_post());
	?>

</form>

<?
if($request->isPost() && check_bitrix_sessid()){

	foreach($aTabs as $aTab){

		foreach($aTab["OPTIONS"] as $arOption){

			if(!is_array($arOption)){

				continue;
			}

			if($arOption["note"]){

				continue;
			}

			if($request["apply"]){

				$optionValue = $request->getPost($arOption[0]);

				if($arOption[0] == "switch_on"){

					if($optionValue == ""){

						$optionValue = "N";
					}
				}

				Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
			}elseif($request["default"]){

				Option::set($module_id, $arOption[0], $arOption[2]);
			}
		}
	}

	LocalRedirect($APPLICATION->GetCurPage()."?mid=".$module_id."&lang=".LANG);
}
