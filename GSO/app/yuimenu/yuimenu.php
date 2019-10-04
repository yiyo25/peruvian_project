<?php

Class menu {
	var $link;
	var $lvl;
	var $lang;
	var	$host;  //your host
	var $user; //MySQL user
	var $pass; // MySQL password
	var $bd; //database

	function setTitle($title) 
	{
		$this->Title = $title;
	}

	function setConnect($host,$user,$pass,$bd)
	{
		$this->HOST=$host;  
		$this->USER=$user; 
		$this->PAS=$pass; 
		$this->BD=$bd;
		$link = mysql_connect($host, $user, $pass ) or die ("Could not connect to MySQL xxx");
		mysql_select_db ($bd) or die ("Could not select database");
	}

	function ShowTree($ParentID, $lvl, $lang) 
	{
		global $link;
		global $lvl;
		global $lang;
		
		if($lang=="" or $lang=='ru'){$prefix="";}else{$prefix='_en';}
		
		$table="h_menu".$prefix;
		$lvl++;
		$count=0;
		
		$sql="SELECT m.* FROM h_menug m, h_menu_usuario mu WHERE m.id= mu.IdMenu  AND m.sublevel =  ". $ParentID ."  AND mu.IdUsuario='".$_SESSION["ck_id_usuario_ini"]."' and m.estado=1 and mu.estado=1 ORDER BY orden ASC, id ASC, LEVEL ASC;;";
		$line="";
		$result = mysql_query ($sql);
		
		if(mysql_num_rows($result) > 0){
			while($line=mysql_fetch_array($result))
			{ 
				//$line['link']= "https://intranet.peruvian.pe/" . $line['link'];
				$line['link']= "https://dev.peruvian.pe/intranet/" . $line['link'];
				
				$count++;
				if ($lvl==1)
				{
					echo "<LI class=yuimenubaritem><A class=yuimenubaritemlabel href=" . $line['link']. " title=" . $line['hint'] . ">" . $line['point'] . "</a>\n" ;
				} else 	{ 
					if ($count==1)
					{
						echo"<DIV class=yuimenu id=" . $line['id'] . "><DIV class=bd><UL>\n";
					}
					echo ("<li class=yuimenuitem><A class=yuimenuitemlabel href=" . $line['link'] . ">" . $line['point'] . "</a>\n");
				}
		
				$newClass = new menu();
				$newClass->ShowTree($line['id'],$lvl,$lang);
				$lvl--;
			}
			echo "</LI></UL></DIV></DIV>\n";
		}
	}
}

?>
