<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> 
-->
<script src="../jquery/jquery-1.7.1.min.js"></script>
<script language="javascript" src="../js/jquery.cookie.js"></script>
<script language="javascript" src="../js/jquery.treeview.js"></script>
<script language="javascript" src="../js/arbol.js"></script>
<script language="javascript" src="../SpryAssets/SpryValidationSelect.js"></script>
<script language="javascript" src="../js/jquery-ui-1.8.16.custom.min.js"></script>
<script language="javascript" src="../js/jquery-ui-1.8.5.custom.min.js"></script>
<script language="javascript" src="../js/jquery.ui.datepicker-es.js"></script>
<script language="javascript" src="../js/jquery.ui.datepicker.js"></script>
<script language="javascript" src="../SpryAssets/SpryMenuBar.js"></script>
<script language="javascript" src="../SpryAssets/SpryValidationTextField.js"></script>
<script language="javascript" src="../SpryAssets/SpryValidationTextarea.js"></script>

<link href="../css/jquery.treeview.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<link href="../js/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="../js/jquery.autocomplete.css" rel="stylesheet" type="text/css"/> 
<link href="../css/encabezados.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<!--	<link rel="stylesheet" href="http://jqueryui.com/themes/base/jquery.ui.all.css">
--><!--	<script src="http://jqueryui.com/jquery-1.6.2.js"></script>
--><!--	<script src="http://jqueryui.com/ui/jquery.ui.core.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.widget.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.button.js"></script>-->
<!--	<link href="http://jqueryui.com/demos/demos.css" rel="stylesheet" type="text/css">
-->

<script >
$(function() {
        var xOffset = 10;
        var yOffset = 20;

        $("input").focus(function(e) {
            this.t = this.title;
            this.title = "";
            $("#texto").append("<span id='tooltip'>" + this.t + "</span>");
            $("#tooltip").css("top", (e.pageY - xOffset) + "px").css("left", (e.pageX + yOffset) + "px").fadeIn("fast");
        });

        $("input").blur(function(e) {
            this.title = this.t;
            $("#tooltip").remove();

           // $("#tooltip").css("top", (e.pageY - xOffset) + "px").css("left", (e.pageX + yOffset) + "px");   
        });   
    });
	</script>