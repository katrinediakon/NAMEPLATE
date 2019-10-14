<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/iblock/prolog.php");


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
$arResult=array();
$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID" => 5, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
while ($ob = $res->GetNext()) {
    $arResult[$ob["ID"]]['ID']=$ob["ID"];
    $arResult[$ob["ID"]]['NAME']=$ob["NAME"];
}
?>
<style>
    .form-input-select {
        width: 90%;
    }

</style>
    <form method="post" action="http://bx/local/menu/custom_item.php">

    <div include="form-input-select">
        <select name="select" required style="padding-right: 3vw;">
        <?foreach ($arResult as $Item):?>
        <option value="<?=$Item["ID"]?>"><?=$Item["NAME"]?></option>
    <?endforeach?>
         </select>
        <p>Артикул:
        <input type="text" id="articul" name="articul" value="96395Т">
        </p>
        <select name="act" required style="padding-right: 3vw;">
            <option value="add">Добавить</option>
            <option value="del">Удалить</option>
        </select>
        <input type="submit" id="submit" name="submit" value="Применить">
     </div>
    </form>

<?
if($_POST["select"] && $_POST["articul"])
{
    $ID="";
//array_unique

    $arSelect = Array("ID", "NAME", "PROPERTY_NAMEPLATE");
    $arFilter = Array("IBLOCK_ID" => 2, "PROPERTY_ARTNUMBER"=>$_POST["articul"],"ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->GetNext()) {
        $ID=$ob["ID"];

        $PROPERTY_NAMEPLATE=$ob["PROPERTY_NAMEPLATE_VALUE"];
    }


    if ($_POST["act"]=="add")
    {
        $PROPERTY_NAMEPLATE[]=$_POST["select"];
        $PROPERTY_NAMEPLATE = array_unique($PROPERTY_NAMEPLATE);
        $el = new CIBlockElement;
        $res = $el->SetPropertyValueCode( $ID,"NAMEPLATE",$PROPERTY_NAMEPLATE);
    }
    else if($_POST["act"]=="del")
    {
        if(($key = array_search($_POST["select"],$PROPERTY_NAMEPLATE)) !== FALSE){
	     unset($PROPERTY_NAMEPLATE[$key]);
	        }
        $el = new CIBlockElement;
        $res = $el->SetPropertyValueCode( $ID,"NAMEPLATE",$PROPERTY_NAMEPLATE);
    }
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");