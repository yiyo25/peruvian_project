<HTML>
      <HEAD>
            <TITLE>Website Top Nav With Submenus Built From Markup (YUI Library) from MySQL base</TITLE>
<LINK href="./reset-fonts-grids.css" type=text/css rel=stylesheet>
<LINK href="./menu.css" type=text/css rel=stylesheet>
<SCRIPT src="./yahoo-dom-event.js" type=text/javascript></SCRIPT>
<SCRIPT src="./container_core.js" type=text/javascript></SCRIPT>
<SCRIPT src="./menu.js" type=text/javascript></SCRIPT>
<SCRIPT type=text/javascript>

            // Initialize and render the menu bar when it is available in the DOM

            YAHOO.util.Event.onContentReady("productsandservices", function () {

                // Instantiate and render the menu bar

                var oMenuBar = new YAHOO.widget.MenuBar("productsandservices", { autosubmenudisplay: true, hidedelay: 750, lazyload: true });

                /*
                     Call the "render" method with no arguments since the markup for
                     this menu already exists in the DOM.
                */

                oMenuBar.render();

            });

        </SCRIPT>
</HEAD>
<BODY>
<?php
include ('dbcon.inc');
require('yuimenu.php');
$newClass = new menu(); // Создаем экземпляр класса 
$newClass ->setConnect($host,$user,$pass,$bd);
?>
<DIV class="yuimenubar yuimenubarnav" id=productsandservices>
<DIV class=bd>
<UL class=first-of-type>
<?
echo $newClass->ShowTree(0,0,ru);
?>
</UL>
</DIV>
</DIV>
</body>
</html>
