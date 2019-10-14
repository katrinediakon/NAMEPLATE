<?
function AgentNameplate()
{
    $ID=0;
    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_TO");
    $arFilter = Array("IBLOCK_ID" => 5,  "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
    while ($ob = $res->GetNext()) {
        if(strtotime($ob['DATE_ACTIVE_TO'])<strtotime(date('Y-m-d')))
            $ID=$ob['ID'];
    }
    $product_list=array();
    $PROPERTY_NAMEPLATE_VALUE=array();
    $arSelect = Array("ID", "NAME", "PROPERTY_NAMEPLATE");
    $arFilter = Array("IBLOCK_ID" => 2, 'PROPERTY_NAMEPLATE'=>$ID, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->GetNext()) {

        $product_list[$ob["ID"]]=$ob["ID"];
        $PROPERTY_NAMEPLATE_VALUE[$ob["ID"]]=$ob["PROPERTY_NAMEPLATE_VALUE"];
    }

    foreach ($product_list as $value)
    {
        if(($key = array_search($ID,$PROPERTY_NAMEPLATE_VALUE[$value])) !== FALSE){
            unset($PROPERTY_NAMEPLATE_VALUE[$value][$key]);
        }
        $el = new CIBlockElement;
        $res = $el->SetPropertyValueCode( $value,"NAMEPLATE",$PROPERTY_NAMEPLATE_VALUE[$value]);
    }
    return "AgentNameplate();";
}
