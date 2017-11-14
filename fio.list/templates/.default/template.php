<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

    CJSCore::Init(["jquery"]);
    $this->addExternalCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
//    $this->addExternalCss($templateFolder."/style.css");

?>

<div class="container">
    <div id="list" class="row"></div>
    <div id="pagination" class="column">
        <?for ($i = 1; $i <= $arResult["PAGE_COUNT"]; $i++):?>
            <button class="btn-page " data-page=<?=$i?>><?=$i?></button>
            <br><br>
        <?endfor;?>
    </div>
</div>

