
<script type="text/javascript">

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

</script>
<?php




include ('./yuimenu/dbcon.inc');
require('./yuimenu/yuimenu.php');
$newClass = new menu(); 
$newClass ->setConnect($host,$user,$pass,$bd);
?>
<DIV class="yuimenubar yuimenubarnav" id=productsandservices>
<DIV class=bd>
<UL class=first-of-type>
<?
echo $newClass->ShowTree(0,0,"ru");
?>
</UL>
</DIV>
</DIV>
