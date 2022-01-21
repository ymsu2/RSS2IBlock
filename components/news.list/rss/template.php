<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>

	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arItem["PROPERTIES"]["ENC_URL"]["VALUE"] && is_array($arItem["PROPERTIES"])):?>
				<img
					class="preview_picture"
					border="0"
					src="<?=$arItem["PROPERTIES"]["ENC_URL"]["VALUE"]?>"
					width="<?=$arItem["PROPERTIES"]["WIDTH"]["VALUE"]?>"
					height="<?=$arItem["PROPERTIES"]["HEIGHT"]["VALUE"]?>"
					alt="<?=$arItem["NAME"]?>"
					title="<?=$arItem["NAME"]?>"
					style="float:left"
					/>
		<?endif?>

		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["ACTIVE_FROM"]):?>
			<span class="news-date-time"><?echo FormatDate('d F Yг., H:i', MakeTimeStamp($arItem["ACTIVE_FROM"]), time()+CTimeZone::GetOffset())?></span><br />
		<?endif?>

		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
				<b><?echo $arItem["NAME"]?></b><br />
		<?endif;?>

		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?echo $arItem["PREVIEW_TEXT"];?>
		<?endif;?>

		<br /><br /><i>Категория: "<?echo $arItem["PROPERTIES"]["CATEGORY"]["VALUE"]?>"</i>
		<br /><i>Ссылка на источник: <b><a target="_blank" rel="nofollow" href="<?echo $arItem["PROPERTIES"]["LINK"]["VALUE"]?>"><?echo $arItem["DISPLAY_PROPERTIES"]["FEED_URL"]["VALUE"]?></a></b></i>
		<br />  
		<div style="clear:both"></div>
		<hr>
	</p>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>