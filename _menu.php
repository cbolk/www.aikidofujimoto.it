<?php

    $util = new utils();
    $currentSchedule = "_orario" . $util->getSchedule($today);
    $thismonth = Date('m');
    $nextsem = $util->getNextStageMMDD($db);

	$current = substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],"/"));
	$isorario = "inactive";
	$isfuji = "inactive";
	$isdojo = "inactive";
	$iscorsi = "inactive";
	$issem = "inactive";
	if (substr($current,1,7) == "_orario")
		$isorario = "active";
	else if (substr($current,1,6) == "_corso")
		$iscorsi = "active";
	else if (substr($current,1,5) == "_fuji" || substr($current,1,6) == "_scuola")
		$isfuji = "active";
	else if (substr($current,1,5) == "_dojo")
		$isdojo = "active";
	else if (substr($current,1,4) == "_sem")
		$issem = "active";
?>
			<ul id="menu" class="sidebar__link_list">
				<div class="mobile">
				<li onclick="location.href=&apos;./index.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name"><span class="mobile"><i class="fa fa-user fa-home"></i>&nbsp;&nbsp;</span>Home</div></li>
				</div>
				<li onclick="location.href=&apos;./_aikido.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name"><span class="mobile"><i class="fa fa-font fa-fw"></i>&nbsp;&nbsp;</span>Aikido</div></li>
				<li class="sidebar__link_item"><span class="mobile"><i class="fa fa-user fa-fw"></i>&nbsp;&nbsp;Il&nbsp;Maestro&nbsp;Fujimoto</span>
				<div onclick="location.href=&apos;./_fujimoto.php&apos;" style="cursor: pointer" class="link_is_<?php echo $isfuji; ?> sidebar__link_item__name nomobile">Il&nbsp;Maestro&nbsp;Fujimoto</div>
				<ul class="submenu fujimoto">
					<li onclick="location.href=&apos;./_fujimoto.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Il Maestro</div></li>
					<li onclick="location.href=&apos;./_scuola.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">La sua scuola</div></li>
				</ul></li>
				<!--li onclick="location.href=&apos;./insegnanti.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Insegnanti</div></li-->
				<li style="cursor: pointer" class="sidebar__link_item"><span class="mobile"><i class="fa fa-university fa-fw"></i>&nbsp;&nbsp;D&#333;j&#333;</span>
				<div onclick="location.href=&apos;./_dojo.php&apos;" style="cursor: pointer" class="link_is_<?php echo $isdojo; ?> sidebar__link_item__name nomobile">D&#333;j&#333;</div>
				<ul class="submenu dojo">
					<li onclick="location.href=&apos;./_dojo.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Luogo</div></li>
					<li onclick="location.href=&apos;./_dojoetichetta.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Etichetta</div></li>
					<li onclick="location.href=&apos;./_dojofaq.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">FAQ</div></li>
				</ul></li>
				<li style="cursor: pointer" class="sidebar__link_item"><span class="mobile"><i class="fa fa-graduation-cap fa-fw"></i>&nbsp;&nbsp;Corsi</span>
				<div onclick="location.href=&apos;./_corso.php&apos;" style="cursor: pointer" class="link_is_<?php echo $iscorsi; ?> sidebar__link_item__name nomobile">Corsi</div>
				<ul class="submenu corsi">
					<li onclick="location.href=&apos;./_corsoragazzi.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">bambini &amp; ragazzi</div></li>
					<li onclick="location.href=&apos;./_corsoprincipianti.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">principianti</div></li>
					<li onclick="location.href=&apos;./_corsoadulti.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">adulti</div></li>
				</ul></li>
				<li style="cursor: pointer" class="sidebar__link_item"><span class="mobile"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Orari</span>
				<div onclick="location.href=&apos;./<?php echo $currentSchedule; ?>.php&apos;" style="cursor: pointer" class="link_is_<?php echo $isorario; ?> sidebar__link_item__name nomobile">Orari</div>
				<ul class="submenu orari">
					<li onclick="location.href=&apos;./_day.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">oggi</div></li>
					<li onclick="location.href=&apos;./_orario09.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">settembre</div></li>
					<li onclick="location.href=&apos;./_orario10.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">ottobre - giugno</div></li>
					<li onclick="location.href=&apos;./_orario07.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">luglio</div></li>
					<li onclick="location.href=&apos;./_orario08.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">agosto</div></li>
				</ul></li>
				<li onclick="location.href=&apos;./_iscrizioni.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name"><span class="mobile"><i class="fa fa-pencil-square-o fa-fw"></i></span>&nbsp;&nbsp;Iscrizioni</div></li>
				<li style="cursor: pointer" class="sidebar__link_item"><span class="mobile"><i class="fa fa-calendar-check-o fa-fw"></i>&nbsp;&nbsp;Seminari</span>				
				<div onclick="location.href=&apos;./_semlist.php#<?php echo $nextsem;?>&apos;" style="cursor: pointer" class="link_is_<?php echo $issem; ?> sidebar__link_item__name nomobile">Seminari</div>
				<ul class="submenu seminari">
					<li onclick="location.href=&apos;./_semnext.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Prossimo seminario</div></li>
					<li onclick="location.href=&apos;./_semlist.php#<?php echo $nextsem;?>&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Calendario completo</div></li>
				</ul></li>
				<li onclick="location.href=&apos;./_info.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name"><span class="mobile"><i class="fa fa-info-circle fa-reverse fa-fw"></i></span>&nbsp;&nbsp;Info</div></li>
				<div class="nomobile fright">
				<li onclick="location.href=&apos;http://www.facebook.com/aikikaimilano/&apos;" style="cursor: pointer" class="sidebar__link_item fright nomobile"><div class="sidebar__link_item__name"><i alt='facebook' title="seguici su facebook" class="fa fa fa-facebook-official"></i></div></li>
				<li onclick="location.href=&apos;./_news.php&apos;" style="cursor: pointer" class="nomobile sidebar__link_item fright">
<!--				<div id="noti_Container">
					<div class="sidebar__link_item__name"><i alt='news' title="news" class="fa fa-quote-right"></i></div>
					<div class="noti_bubble">1</div>
				</div>-->
				<div class="sidebar__link_item__name"><i alt='news' title="news" class="fa fa-quote-right"></i></div>
				</li>
				<li onclick="location.href=&apos;./_links.php&apos;" style="cursor: pointer" class="sidebar__link_item fright"><div class="sidebar__link_item__name"><i alt='links' title="links" class="fa fa-link"></i></div></li>
				</div>
			</ul>
			<div id="secondarymenu" class="sidebar__link_list">
				<ul class="<?php echo $isfuji; ?>">
					<li onclick="location.href=&apos;./_fujimoto.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Il Maestro</div></li>
					<li onclick="location.href=&apos;./_scuola.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">La sua scuola</div></li>
				</ul>
				<ul class="<?php echo $isdojo; ?>">
					<li onclick="location.href=&apos;./_dojo.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Luogo</div></li>
					<li onclick="location.href=&apos;./_dojoetichetta.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Etichetta</div></li>
					<li onclick="location.href=&apos;./_dojofaq.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">FAQ</div></li>
				</ul>
				<ul class="<?php echo $iscorsi; ?>">
					<li onclick="location.href=&apos;./_corsoragazzi.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Bambini &amp; ragazzi</div></li>
					<li onclick="location.href=&apos;./_corsoprincipianti.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Principianti</div></li>
					<li onclick="location.href=&apos;./_corsoadulti.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Adulti</div></li>
				</ul>
				<ul class="<?php echo $issem; ?>">
					<li onclick="location.href=&apos;./_semnext.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">Prossimo stage</div></li>
					<li onclick="location.href=&apos;./_semlist.php&apos;" style="cursor: pointer" class="sidebar__link_item active"><div class="sidebar__link_item__name">Calendario completo</div></li>
				</ul>
				<ul class="<?php echo $isorario; ?>">
					<li onclick="location.href=&apos;./_orario09.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">settembre</div></li>
					<li onclick="location.href=&apos;./_orario10.php&apos;" style="cursor: pointer" class="sidebar__link_item active"><div class="sidebar__link_item__name">ottobre - giugno</div></li>
					<li onclick="location.href=&apos;./_orario07.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">luglio</div></li>
					<li onclick="location.href=&apos;./_orario08.php&apos;" style="cursor: pointer" class="sidebar__link_item"><div class="sidebar__link_item__name">agosto</div></li>
				</ul>
			</div>
