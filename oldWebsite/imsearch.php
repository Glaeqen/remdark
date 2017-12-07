<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl" dir="ltr">
<head>
	<title>Szukaj</title>

	<!-- Contents -->
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
	<meta http-equiv="Content-Language" content="pl" />
	<meta http-equiv="last-modified" content="18-12-2013 20:57:22" />
	<meta http-equiv="Content-Type-Script" content="text/javascript" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<!-- imCustomHead -->
	<meta http-equiv="Expires" content="0" />
	<meta name="Resource-Type" content="document" />
	<meta name="Distribution" content="global" />
	<meta name="Robots" content="index, follow" />
	<meta name="Revisit-After" content="21 days" />
	<meta name="Rating" content="general" />
	<!-- Others -->
	<meta name="Author" content="Dariusz Górski" />
	<meta name="Generator" content="Incomedia WebSite X5 Evolution 8.0.11 - www.websitex5.com" />
	<meta http-equiv="ImageToolbar" content="False" />
	<meta name="MSSmartTagsPreventParsing" content="True" />
	
	<!-- Parent -->
	<link rel="sitemap" href="imsitemap.html" title="Ogólna mapa witryny" />
	<!-- Res -->
	<script type="text/javascript" src="res/x5engine.js"></script>
	<link rel="stylesheet" type="text/css" href="res/styles.css" media="screen, print" />
	<link rel="stylesheet" type="text/css" href="res/template.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="res/print.css" media="print" />
	<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="res/iebehavior.css" media="screen" /><![endif]-->
	
	<link rel="stylesheet" type="text/css" href="res/handheld.css" media="handheld" />
	<link rel="alternate stylesheet" title="Wysoki kontrast - Dostępność" type="text/css" href="res/accessibility.css" media="screen" />

</head>
<body>
<div id="imSite">
<div id="imHeader">
	
	<h1> Witryna "REMDARK" </h1>
</div>
<div class="imInvisible">
<hr />
<a href="#imGoToCont" title="Pomiń menu główne">Idź do treści</a>
</div>
<div id="imBody">
	<div id="imMenuMain">

<!-- Menu START -->
<a name="imGoToMenu"></a><p class="imInvisible">Menu główne:</p>
<div id="imMnMn">
<ul>
	<li><a class="imMnItm_1" href="index.html" title=""><span class="imHidden">Strona główna</span></a></li>
	<li><a class="imMnItm_2" href="oferta_firmy.html" title=""><span class="imHidden">Oferta firmy</span></a></li>
	<li><a class="imMnItm_3" href="galeria.html" title=""><span class="imHidden">Galeria</span></a></li>
	<li><a class="imMnItm_4" href="dane_kontaktowe.html" title=""><span class="imHidden">Dane Kontaktowe</span></a></li>
</ul>
</div>
<!-- Menu END -->

	</div>
<hr class="imInvisible" />
<a name="imGoToCont"></a>
	<div id="imContent">
<?php 
$files = array("index.html","galeria.html","dane_kontaktowe.html","oferta_firmy.html");
?>
<div id="imSText">
<?php
	$domain = "";
	$search = trim($_GET['search']);
	$page = $_GET['page'];
	if($page == "")
		$page = 0;
	else
		$page--;
	if($search != "") {
		$queries = explode(" ",$search);
		foreach($files as $filename) {
			$count = 0;
			$weight = 0;
			$file_content = implode("\n",file($filename));
			$starttitle = strpos($file_content,"<title>") + 7;
			$endtitle = strpos($file_content,"</title>");
			if(($starttitle != false) && ($endtitle != false)) {
				foreach($queries as $query) {
					$title = substr($file_content,$starttitle,$endtitle-$starttitle);
					while (($title = stristr($title, $query)) !== false) {
						$weight += 4;
						$title = substr($title,strlen($query));
					}
				}
			}
			$page_pos = strpos($file_content,"<!-- Page START -->")+19;
			$page_end = strpos($file_content,"<!-- Page END -->");
			if($page_pos != false && $page_end != false)
				$file_content = substr($file_content,$page_pos, $page_end-$page_pos);
			$file_content = strip_tags($file_content);
			foreach($queries as $query) {
				$file = $file_content;
				while (($file = stristr($file, $query)) !== false) {
					$count++;
					$weight++;
					$file = substr($file,strlen($query));
				}
			}
			if($count > 0) {
				$found_count[$filename] = $count;
				$found_weight[$filename] = $weight;
			}
		}
		
		if($found_count != null) {
			arsort($found_weight);
			$i = 0;
			$pagine = ceil(count($found_count)/10);
			if(($page >= $pagine) || ($page < 0))
				$page = 0;
			echo "		<div class=\"imSLabel\"><div id=\"imSPageTitle\"><strong>Wyniki wyszukiwania</strong> dla <i>". $search ."</i></div><strong>" . ($page*10+1) . "-" . (count($found_count)<($page+1)*10? count($found_count):($page+1)*10) . "</strong> z <strong>"  . count($found_count) . "</strong></div>\n";
			foreach($found_weight as $name => $weight) {
				$count = $found_count[$name];
				$i++;
				if(($i > $page*10) && ($i <= ($page+1)*10)) {
					$file = implode(" ",file($name));
					$starttitle = strpos($file,"<title>") + 7;
					$endtitle = strpos($file,"</title>");
					if(($starttitle != false) && ($endtitle != false))
						$title = substr($file,$starttitle,$endtitle-$starttitle);
					else
						$title = $name;
					$page_pos = strpos($file,"<!-- Page START -->")+19;
					$page_end = strpos($file,"<!-- Page END -->");
					if($page_pos != false && $page_end != false)
						$file = substr($file,$page_pos, $page_end-$page_pos);
					$file = strip_tags($file);
					$ap = 0;
					$filelen = strlen($file);
					$text = "";
					for($j=0;$j<($count > 6 ? 6 : $count);$j++) {
						$minpos = $filelen;
						foreach($queries as $query) {
							if(($pos = strpos(strtoupper($file),strtoupper($query),$ap)) !== false) {
								if($pos < $minpos) {
									$minpos = $pos;
									$word = $query;
								}
							}
						}
						$prev = explode(" ",substr($file,$ap,$minpos-$ap));
						if(count($prev) > ($ap > 0 ? 9 : 8))
							$prev = ($ap > 0 ? implode(" ",array_slice($prev,0,8)) : "") . " ... " . implode(" ",array_slice($prev,-8));
						else
							$prev = implode(" ",$prev);
						$text .= $prev . "<strong>" . substr($file,$minpos,strlen($word)) . "</strong> ";
						$ap = $minpos + strlen($word);
					}
					$next = explode(" ",substr($file,$ap));
					if(count($next) > 9)
						$text .= implode(" ",array_slice($next,0,8)) . "...";
					else
						$text .= implode(" ",$next);
					echo "			<div class=\"imSTitle\"><a href=\"" . $name . "\">" . $title . "</a> <span class=\"imSCount\">(" . $count . " " . ($count > 1 ? "Wyniki" : "Wynik") . ")</span></div>" . $text . "<div class=\"imSLink\"><a href=\"" . $name . "\">" . $domain . $name . "</a></div>\n";
				}
			}
			echo "  <div class=\"imSLabel\">&nbsp;</div>\n";
			if ($pagine > 1) {
				echo "			Strona ";
				for($i = 1; $i <= $pagine; $i++)
					if($i != $page+1)
						echo "<a href=\"imsearch.php?search=" . $search . "&page=" . $i . "\">" . $i . "</a> ";
					else
						echo "<strong>" . $i . "</strong> ";
				echo "\n";
			}
		}
		else
			echo "  <div style=\"text-align: center; font-weight: bold; \"><strong>Nie znaleziono żadnych elementów</strong></div>\n";
	}
?>
</div>
<div id="imSBox">
<form action="imsearch.php" method="get"><fieldset>
	<input type="text" name="search" value="<?php echo $_GET['search']; ?>"/> <input id="imSButton" type="submit" value="Szukaj" />
</fieldset></form>
</div>
<br />

	</div>
	<div id="imFooter">
	</div>
</div>
</div>
<div class="imInvisible">
<hr />
<a href="#imGoToCont" title="Przeczytaj ta stronę ponownie">Powrót do treści</a> | <a href="#imGoToMenu" title="Przeczytaj ta stronę ponownie">Wróć do menu głównego</a>
</div>


<div id="imShowBoxBG" style="display: none;" onclick="imShowBoxHide()"></div>
<div id="imShowBoxContainer" style="display: none;" onclick="imShowBoxHide()"><div id="imShowBox" style="height: 200px; width: 200px;"></div></div>
<div id="imBGSound"></div>
<div id="imToolTip"><script type="text/javascript">var imt = new IMTip;</script></div>
<script type="text/javascript">imPreloadImages('res/immnu_01b.gif,res/immnu_02b.gif,res/immnu_03b.gif,res/immnu_04b.gif,res/immnlv_a.gif,res/immnlv_b.gif')</script>
</body>
</html>
