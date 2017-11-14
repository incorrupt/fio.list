<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule('iblock'))die();


    function updateFio(
        $blockId,
        $elementId,
        $propId,
        $value
    ) {
        print_r($value);
        CIBlockElement::SetPropertyValuesEx(
            $elementId,
            $blockId,
            [$propId =>["VALUE"=>$value]]
        );
    }

    function getPageCount(
        $iBlockId,
        $pageSize
    ) {
        if ($pageSize<1) {return 1;}
        $filter = ['IBLOCK_ID'=>$iBlockId];
        $list = CIBlockElement::GetList([],$filter,false);
        $eCount = $list->SelectedRowsCount();
        return ceil($eCount/$pageSize);
    }

    function getJsonData(
        $iBlockId,
        $pageNum,
        $pageSize
    ) {
        $result =[];
        $order = ['ID' => 'ASC'];
        $filter = ['IBLOCK_ID'=>$iBlockId];
        $pagination = ['iNumPage'=>$pageNum,'nPageSize'=>$pageSize];
        $elements = CIBlockElement::GetList($order,$filter,false,$pagination);

        while ($element = $elements->GetNextElement()) {
            $elementId = $element->GetFields()['ID'];
            $props = CIBlockElement::GetProperty($iBlockId, $elementId);

            while ($prop = $props->GetNext()) {
                $result[$elementId][$prop['ID']]['NAME'] = $prop['NAME'];
                $result[$elementId][$prop['ID']]['VALUE'] = $prop['VALUE'];
            }
        }
        return \Bitrix\Main\Web\Json::encode($result);
    }


    if ($_REQUEST["ajax_action"]) {
        $APPLICATION->RestartBuffer();
        if ($_REQUEST["ajax_action"] == "get") {
            $page = ($_REQUEST["page"]) ? (int)$_REQUEST["page"] : 1;
            header('Content-Type: application/json');
            print_r(getJsonData($arParams['IBLOCK_ID'],$page,$arParams['PER_PAGE']));
        } elseif ( $_REQUEST["ajax_action"] == "save" && $_POST['props'] ) {
            foreach ( $_POST['props'] as $index=>$prop) {
                updateFio(
                    $arParams['IBLOCK_ID'],
                    $prop['element'],
                    $prop['prop'],
                    iconv("UTF-8","WINDOWS-1251", $prop['value'])
                );
            }
        }
        die();
    } else {
        $arResult["PAGE_COUNT"]=getPageCount($arParams['IBLOCK_ID'],$arParams['PER_PAGE']);
        $this->IncludeComponentTemplate();
    }


