<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("RSS - агрегатор");
?>
<?
global $arrFilter; // указываем что переменная глобальная
// Дата создания новости в БД хранится с учетом часового пояса первоисточника (UTC +3:00) "Europe/Moscow"
// Локальное время сервера Битрикс по умолчанию находится в часовом поясе (UTC 0:00)
// в фильтре это надо учитывать
$disp = 1; // берем новости за последние 2 часа (от UTC +3:00 отнимаем 2 часа, в итоге получаем смешение + 1 час от UTC 0:00)
$now  = date('d.m.Y H:i:s', time() + 3600 * $disp); // расчет производится от локального времени на сервере
$arFilter = array(">DATE_CREATE" => $now); // фильтр выбирает новости из ИБ, созданные за последние 2 часа. 
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"rss", 
	array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "7200",
		"CACHE_TYPE" => "Y",
		"CHECK_DATES" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "19",
		"IBLOCK_TYPE" => "rss_aggregator",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "round",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "CATEGORY",
			1 => "ENC_HEIGHT",
			2 => "ENC_URL",
			3 => "ENC_WIDTH",
			4 => "FEED_URL",
			5 => "LINK",
			6 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "rss"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>