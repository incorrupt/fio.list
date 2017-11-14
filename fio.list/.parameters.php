<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (!CModule::IncludeModule("iblock")) die();


// ������ ���������� ��� ������
$dbIBlockTypes = CIBlock::GetList(array("SORT"=>"ASC"), array("ACTIVE"=>"Y"));
while ($arIBlockTypes = $dbIBlockTypes->GetNext())
{
    $paramIBlockTypes[$arIBlockTypes["ID"]] = $arIBlockTypes["NAME"];
}

//������������ ������� ����������
$arComponentParameters = [
    "PARAMETERS" => [
        "PER_PAGE"    =>  [
            "PARENT"    =>  "BASE",
            "NAME"      =>  "��������� �� ��������",
            "TYPE"      =>  "LIST",
            "VALUES"    =>  [
                3 =>"3",
                5 =>"5",
                10 =>"10",
                12 =>"12",
                20 =>"20",
                50 =>"50"
            ],
            "MULTIPLE"  =>  "N",
        ],
        "IBLOCK_ID"   =>  [
            "PARENT"    =>  "BASE",
            "NAME"      =>  "�������� � ����������",
            "TYPE"      =>  "LIST",
            "VALUES"    =>  $paramIBlockTypes,
            "REFRESH"   =>  "Y",
            "MULTIPLE"  =>  "N",
        ]
    ],
];