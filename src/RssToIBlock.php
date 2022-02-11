<?
	class RssToIBlock
	{
		private $_feedUrl;
		private $_iblockId;
		private $_feedPort;
		private $_feedPath;
		private $_feedQuery;
		private $_timePeriod;

		public function __construct($feedUrl, $feedPort, $feedPath, $feedQuery, $iblockId, $timePeriod)
		{
			$this->_feedUrl = $feedUrl;
			$this->_iblockId = $iblockId;
			$this->_feedPort = $feedPort;
			$this->_feedPath = $feedPath;
			$this->_feeQuery = $feedQuery;
			$this->_timePeriod = $timePeriod;
		}

		public function fetch()
		{		 
			CModule::IncludeModule("iblock");
			$arRes = CIBlockRSS::GetNewsEx($this->_feedUrl, $this->_feedPort, $this->_feedPath, $this->_feedQuery);
			$arRes = CIBlockRSS::FormatArray($arRes);
			$d2 = strtotime('now');
			$arFeed = array();

			for ($i = 0; $i < count($arRes["item"]); $i++):
				$d1 = strtotime($arRes["item"][$i]["pubDate"]);

				if (($d2-$d1)/3600 >= $this->_timePeriod) break;
				$date = new \DateTime($arRes["item"][$i]["pubDate"]);
				$arFeed[$i]["pubDate"] 			= $date->format('d.m.Y H:i:s');
				$arFeed[$i]["title"]			= $arRes["item"][$i]["title"];
				$arFeed[$i]["description"]		= $arRes["item"][$i]["description"];
				$arFeed[$i]["link"] 			= $arRes["item"][$i]["link"];
				$arFeed[$i]["enclosure"]["url"]		= $arRes["item"][$i]["enclosure"]["url"];
				$arFeed[$i]["enclosure"]["width"]	= $arRes["item"][$i]["enclosure"]["width"];
				$arFeed[$i]["enclosure"]["height"]	= $arRes["item"][$i]["enclosure"]["height"];
				$arFeed[$i]["description"]		= $arRes["item"][$i]["description"];
				$arFeed[$i]["category"] 		= $arRes["item"][$i]["category"];
			endfor;

			$arFilter = array(
				"IBLOCK_ID" => $this->_iblockId,
				"FEED_URL" => $this->_feedUrl
			);
			$arSelectedFields = array("PROPERTY_LINK");
			$dbRecords = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelectedFields);

			$params = Array(
	 			"max_len" => "100", // обрезает символьный код до 100 символов
				"change_case" => "L", // буквы преобразуются к нижнему регистру
				"replace_space" => "_", // меняем пробелы на нижнее подчеркивание
				"replace_other" => "_", // меняем левые символы на нижнее подчеркивание
				"delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
				"use_google" => "false", // отключаем использование google
			); 

			$arLinks = array();

			while ($arRecord = $dbRecords->GetNext()):
				$arLinks[] = $arRecord["PROPERTY_LINK_VALUE"];
				for ($i = 0; $i < count($arFeed); $i++):
					if(in_array($arFeed[$i]["link"], $arLinks)) // если аналогичная запись уже имеется в БД, то новую не создаем во избежание дублирования записей
						continue;
						$arProperties = array (
						"FEED_URL" => $this->_feedUrl,
						"LINK" => $arFeed[$i]["link"],
						"ENC_URL" => $arFeed[$i]["enclosure"]["url"],
						"ENC_WIDTH" => $arFeed[$i]["enclosure"]["width"],
						"ENC_HEIGHT" => $arFeed[$i]["enclosure"]["height"],
						"CATEGORY" => $arFeed[$i]["category"]
					);
					$arFields = array(
						"IBLOCK_ID" => $this->_iblockId,
						"NAME" => $arFeed[$i]["title"],
						"CODE" => CUtil::translit($arFeed[$i]["title"], "ru" , $params),
						"PREVIEW_TEXT" => $arFeed[$i]["description"],
						"DETAIL_TEXT" => $arFeed[$i]["description"],
						"DATE_CREATE" => $arFeed[$i]["pubDate"], 
						"ACTIVE_FROM" => $arFeed[$i]["pubDate"],
						"PROPERTY_VALUES" => $arProperties
					);
					$iblockElement = new CIBlockElement;
					$iblockElement->Add($arFields, false, false, true); // добавляем новую запись в БД
				endfor;
			endwhile;
		} // end function fetch()
	}; // end class RssToIBlock
?>