<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<title>jQuery UI Button - Radios</title>
	<link rel="stylesheet" href="http://jqueryui.com/themes/base/jquery.ui.all.css">
	<script src="http://jqueryui.com/jquery-1.6.2.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.core.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.widget.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.button.js"></script>
	<link rel="stylesheet" href="http://jqueryui.com/demos/demos.css">
    
	<script>
	<?php for($i = 1 ; $i <= 2; $i ++){?>
	$(function() {
		$( "#radio<?php echo $i; ?>" ).buttonset();
	});
	 <?php } ?>
	</script>
   
</head>
<body>

<div class="demo">

<form>
<?php for($i = 1 ; $i <= 2; $i ++){?>
	<div id="radio<?php echo $i; ?>">
		<input type="radio" id="radio1<?php echo $i; ?>" name="radio-<?php echo $i; ?>"  value="1"/><label for="radio1<?php echo $i; ?>">Activo</label>
		<input type="radio" id="radio2<?php echo $i; ?>" name="radio-<?php echo $i; ?>" checked="checked"  value="0"/><label for="radio2<?php echo $i; ?>">Inactivo</label>
		
	</div>
    <?php } ?>
    <input name="" type="submit">
</form>

</div><!-- End demo -->



<div class="demo-description">
<p>A set of three radio buttons transformed into a button set.</p>
</div><!-- End demo-description -->

</body>
</html>