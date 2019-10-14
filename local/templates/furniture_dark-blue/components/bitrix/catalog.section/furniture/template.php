<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>


<?
foreach($arResult["ITEMS"] as $cell=>$arElement):
	$width = 0;
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CATALOG_ELEMENT_DELETE_CONFIRM')));
?>
<div class="catalog-item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
<?
	if(is_array($arElement["PREVIEW_PICTURE"])):
		$width = $arElement["PREVIEW_PICTURE"]["WIDTH"];
?>
	<div style="background: url(<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>) no-repeat; width: <?=$arElement["PREVIEW_PICTURE"]["WIDTH"];?>px; height:<?=$arElement["PREVIEW_PICTURE"]["HEIGHT"];?>px;padding: 1vw;background-position: center; " class="catalog-item-image">
       <?if (isset($arElement['NAMEPLATE'])):?>
       <?foreach($arElement['NAMEPLATE'] as $value):?>
           <?if($value["PROPERTY_GROUND_VALUE"]):?>

               <img src="<?=$value["PROPERTY_GROUND_VALUE"]?>" style="margin-top: 1vw;width: 4vw;height: auto;margin-right: -11vw;margin-left: -1vw;">
            <?else:?>
        <p  style="margin: -1vw; background: <?=$value['PROPERTY_COLOR_GROUND_VALUE']?>;; color: <?=$value['PROPERTY_COLOR_TEXT_VALUE']?>; width: 4vw;height: 1vw;text-align: center;" ><?=$value['NAME']?></p>
               <?endif;?>
               <?endforeach;?>
       <?endif?>

	</div>
<?
	elseif(is_array($arElement["DETAIL_PICTURE"])):
		$width = $arElement["DETAIL_PICTURE"]["WIDTH"];
?>
	<div class="catalog-item-image">
		<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$arElement["DETAIL_PICTURE"]["SRC"]?>"width="<?=$arElement["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arElement["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a>
	</div>
<?
	endif;
?>
	<div class="catalog-item-title"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
<?
	foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):
		if ($pid != 'PRICECURRENCY'):
?>
		<?=$arProperty["NAME"]?>:&nbsp;<?
			if(is_array($arProperty["DISPLAY_VALUE"]))
				echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
			else
				echo $arProperty["DISPLAY_VALUE"];?><br />
<?
		endif;
	endforeach;
?>
	<div class="catalog-item-desc<?=$width < 300 ? '-float' : ''?>">
		<?=$arElement["PREVIEW_TEXT"]?>
	</div>

<?
	foreach($arElement["PRICES"] as $code=>$arPrice):
		if($arPrice["CAN_ACCESS"]):
?>
	<div class="catalog-item-price"><span><?=$arResult["PRICES"][$code]["TITLE"];?>:</span> <?=$arPrice["PRINT_VALUE"]?></div>
<?
		endif;
	endforeach;
?>
</div>
<?
endforeach; // foreach($arResult["ITEMS"] as $arElement):
?>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
