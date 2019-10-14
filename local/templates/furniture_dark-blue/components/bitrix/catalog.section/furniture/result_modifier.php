<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$arItem['PRICES']['PRICE']['PRINT_VALUE'] = number_format($arItem['PRICES']['PRICE']['PRINT_VALUE'], 0, '.', ' ');
	$arItem['PRICES']['PRICE']['PRINT_VALUE'] .= ' '.$arItem['PROPERTIES']['PRICECURRENCY']['VALUE_ENUM'];

	$arResult['ITEMS'][$key] = $arItem;
}
$PROPERTY_NAMEPLATE=array();
$arSelect = Array("ID","NAME", "PROPERTY_COLOR_TEXT", "PROPERTY_COLOR_GROUND", "PROPERTY_GROUND");
$arFilter = Array("IBLOCK_ID"=>'5', "ACTIVE"=>"Y");
$res_sh = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob_sh =  $res_sh->GetNext()) {
    $PROPERTY_NAMEPLATE[$ob_sh["ID"]]=$ob_sh;
    $PROPERTY_NAMEPLATE[$ob_sh["ID"]]['PROPERTY_GROUND_VALUE'] = CFile::GetPath($ob_sh["PROPERTY_GROUND_VALUE"]);
}


foreach ($arResult['ITEMS'] as $key => $arItem) {

    $arSelect = Array('ID', "NAME","PROPERTY_NAMEPLATE");
    $arFilter = Array("IBLOCK_ID" => $arResult['BLOCK_ID'], "ID" => $arItem["ID"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->GetNext()) {

        foreach ($ob["PROPERTY_NAMEPLATE_VALUE"] as $value)
        {
          //  echo $value;
            $arResult['ITEMS'][$key]["NAMEPLATE"][]=$PROPERTY_NAMEPLATE[$value];
        }
    }
}

//print_r($arResult);
?>