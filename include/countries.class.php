﻿<?php
class countries {
	var $matches = Array();
	var $countries = Array(
	"ua" => "Україна",
	"us" => "USA",
	"au" => "Австралия",
	"at" => "Австрия",
	"az" => "Азербайджан",
	"al" => "Албания",
	"dz" => "Алжир",
	"as" => "Американское Самоа",
	"ai" => "Ангилья",
	"ao" => "Ангола",
	"ad" => "Андорра",
	"aq" => "Антарктида",
	"ag" => "Антигуа и Барбуда",
	"ar" => "Аргентина",
	"am" => "Армения",
	"aw" => "Аруба",
	"af" => "Афганистан",
	"bs" => "Багамы",
	"bd" => "Бангладеш",
	"bb" => "Барбадос",
	"bh" => "Бахрейн",
	"by" => "Беларусь",
	"bz" => "Белиз",
	"be" => "Бельгия",
	"bj" => "Бенин",
	"bm" => "Бермуды",
	"bg" => "Болгария",
	"bo" => "Боливия",
	"ba" => "Босния и Герцеговина",
	"bw" => "Ботсвана",
	"br" => "Бразилия",
	"io" => "Британская территория в Индийском океане",
	"bn" => "Бруней-Даруссалам",
	"bf" => "Буркина-Фасо",
	"bi" => "Бурунди",
	"bt" => "Бутан",
	"vu" => "Вануату",
	"hu" => "Венгрия",
	"ve" => "Венесуэла",
	"vg" => "Виргинские острова, Британские",
	"vi" => "Виргинские острова, США",
	"vn" => "Вьетнам",
	"ga" => "Габон",
	"ht" => "Гаити",
	"gy" => "Гайана",
	"gm" => "Гамбия",
	"gh" => "Гана",
	"gp" => "Гваделупа",
	"gt" => "Гватемала",
	"gn" => "Гвинея",
	"gw" => "Гвинея-Бисау",
	"de" => "Германия",
	"gg" => "Гернси",
	"gi" => "Гибралтар",
	"hn" => "Гондурас",
	"hk" => "Гонконг",
	"gd" => "Гренада",
	"gl" => "Гренландия",
	"gr" => "Греция",
	"ge" => "Грузия",
	"gu" => "Гуам",
	"dk" => "Дания",
	"je" => "Джерси",
	"dj" => "Джибути",
	"dm" => "Доминика",
	"do" => "Доминиканская Республика",
	"eg" => "Египет",
	"zm" => "Замбия",
	"eh" => "Западная Сахара",
	"zw" => "Зимбабве",
	"il" => "Израиль",
	"in" => "Индия",
	"id" => "Индонезия",
	"jo" => "Иордания",
	"iq" => "Ирак",
	"ir" => "Иран, Исламская Республика",
	"ie" => "Ирландия",
	"is" => "Исландия",
	"es" => "Испания",
	"it" => "Италия",
	"ye" => "Йемен",
	"cv" => "Кабо-Верде",
	"kz" => "Казахстан",
	"kh" => "Камбоджа",
	"cm" => "Камерун",
	"ca" => "Канада",
	"qa" => "Катар",
	"ke" => "Кения",
	"cy" => "Кипр",
	"kg" => "Киргизия",
	"ki" => "Кирибати",
	"cn" => "Китай",
	"cc" => "Кокосовые (Килинг) острова",
	"co" => "Колумбия",
	"km" => "Коморы",
	"cg" => "Конго",
	"cd" => "Конго, Демократическая Республика",
	"cr" => "Коста-Рика",
	"ci" => "Кот д'Ивуар",
	"cu" => "Куба",
	"kw" => "Кувейт",
	"la" => "Лаос",
	"lv" => "Латвия",
	"ls" => "Лесото",
	"lb" => "Ливан",
	"ly" => "Ливийская Арабская Джамахирия",
	"lr" => "Либерия",
	"li" => "Лихтенштейн",
	"lt" => "Литва",
	"lu" => "Люксембург",
	"mu" => "Маврикий",
	"mr" => "Мавритания",
	"mg" => "Мадагаскар",
	"yt" => "Майотта",
	"mo" => "Макао",
	"mw" => "Малави",
	"my" => "Малайзия",
	"ml" => "Мали",
	"um" => "Малые Тихоокеанские отдаленные острова Соединенных Штатов",
	"mv" => "Мальдивы",
	"mt" => "Мальта",
	"ma" => "Марокко",
	"mq" => "Мартиника",
	"mh" => "Маршалловы острова",
	"mx" => "Мексика",
	"fm" => "Микронезия, Федеративные Штаты",
	"mz" => "Мозамбик",
	"md" => "Молдова",
	"mc" => "Монако",
	"mn" => "Монголия",
	"ms" => "Монтсеррат",
	"mm" => "Мьянма",
	"na" => "Намибия",
	"nr" => "Науру",
	"np" => "Непал",
	"ne" => "Нигер",
	"ng" => "Нигерия",
	"an" => "Нидерландские Антилы",
	"nl" => "Нидерланды",
	"ni" => "Никарагуа",
	"nu" => "Ниуэ",
	"nz" => "Новая Зеландия",
	"nc" => "Новая Каледония",
	"no" => "Норвегия",
	"ae" => "Объединенные Арабские Эмираты",
	"om" => "Оман",
	"bv" => "Остров Буве",
	"cp" => "Остров Клиппертон",
	"im" => "Остров Мэн",
	"nf" => "Остров Норфолк",
	"cx" => "Остров Рождества",
	"mf" => "Остров Святого Мартина",
	"hm" => "Остров Херд и острова Макдональд",
	"ky" => "Острова Кайман",
	"ck" => "Острова Кука",
	"tc" => "Острова Теркс и Кайкос",
	"pk" => "Пакистан",
	"pw" => "Палау",
	"ps" => "Палестинская территория, оккупированная",
	"pa" => "Панама",
	"va" => "Папский Престол (Государство &mdash; город Ватикан)",
	"pg" => "Папуа-Новая Гвинея",
	"py" => "Парагвай",
	"pe" => "Перу",
	"pn" => "Питкерн",
	"pl" => "Польша",
	"pt" => "Португалия",
	"pr" => "Пуэрто-Рико",
	"mk" => "Республика Македония",
	"re" => "Реюньон",
	"ru" => "Россия",
	"rw" => "Руанда",
	"ro" => "Румыния",
	"ws" => "Самоа",
	"sm" => "Сан-Марино",
	"st" => "Сан-Томе и Принсипи",
	"sa" => "Саудовская Аравия",
	"sz" => "Свазиленд",
	"sh" => "Святая Елена",
	"kp" => "Северная Корея",
	"mp" => "Северные Марианские острова",
	"bl" => "Сен-Бартельми",
	"pm" => "Сен-Пьер и Микелон",
	"sn" => "Сенегал",
	"vc" => "Сент-Винсент и Гренадины",
	"lc" => "Сент-Люсия",
	"kn" => "Сент-Китс и Невис",
	"rs" => "Сербия",
	"sc" => "Сейшелы",
	"sg" => "Сингапур",
	"sy" => "Сирийская Арабская Республика",
	"sk" => "Словакия",
	"si" => "Словения",
	"gb" => "Великобритания",
	"us" => "Соединенные Штаты",
	"sb" => "Соломоновы острова",
	"so" => "Сомали",
	"sd" => "Судан",
	"sr" => "Суринам",
	"sl" => "Сьерра-Леоне",
	"tj" => "Таджикистан",
	"th" => "Таиланд",
	"tz" => "Танзания, Объединенная Республика",
	"tw" => "Тайвань (Китай)",
	"tl" => "Тимор-Лесте",
	"tg" => "Того",
	"tk" => "Токелау",
	"to" => "Тонга",
	"tt" => "Тринидад и Тобаго",
	"tv" => "Тувалу",
	"tn" => "Тунис",
	"tm" => "Туркмения",
	"tr" => "Турция",
	"ug" => "Уганда",
	"uz" => "Узбекистан",
	"ua" => "Украина",
	"wf" => "Уоллис и Футуна",
	"uy" => "Уругвай",
	"fo" => "Фарерские острова",
	"fj" => "Фиджи",
	"ph" => "Филиппины",
	"fi" => "Финляндия",
	"fk" => "Фолклендские острова (Мальвинские)",
	"fr" => "Франция",
	"gf" => "Французская Гвиана",
	"pf" => "Французская Полинезия",
	"tf" => "Французские Южные территории",
	"hr" => "Хорватия",
	"cf" => "Центрально-Африканская Республика",
	"td" => "Чад",
	"me" => "Черногория",
	"cz" => "Чешская Республика",
	"cl" => "Чили",
	"ch" => "Швейцария",
	"se" => "Швеция",
	"sj" => "Шпицберген и Ян Майен",
	"lk" => "Шри-Ланка",
	"ec" => "Эквадор",
	"gq" => "Экваториальная Гвинея",
	"ax" => "Эландские острова",
	"sv" => "Эль-Сальвадор",
	"er" => "Эритрея",
	"ee" => "Эстония",
	"et" => "Эфиопия",
	"za" => "Южная Африка",
	"gs" => "Южная Джорджия и Южные Сандвичевы острова",
	"kr" => "Южная Корея",
	"jm" => "Ямайка",
	"jp" => "Япония",
	"ru" => "Россия",
	);
		
	function makeSelect($qresult, $total_option = true) {
		$this->getMatches($qresult);
		global $servers_total;
		$result = "<select name='country'>";
		if($total_option) $result .= "<option value='all' selected>Все страны </option>";
		foreach($this->countries as $key => $name) {
			if(isset($this->matches[$key])) {
				$cur_matches = $this->matches[$key];
			} else {
				$cur_matches = 0;
			}
			
			if($cur_matches != 0) $result .= "<option value='$key'>$name </option>\n";
		}
		$result .= "</select>";
		echo $result;
	}
	
	
	function getMatches($qresult) {
		while($server = dbarray_fetch($qresult)) {
				if(empty($matches[$server['server_location']])) {
					$this->matches[strtolower($server['server_location'])] = 1;
				} else {
					$this->matches[strtolower($server['server_location'])]++;
				}
		}
	}

}
?>