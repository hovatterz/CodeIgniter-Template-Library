<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8" />
		<?php echo $meta_tags; ?>
		
		<title><?php echo $title; ?></title>
		
		<?php echo $stylesheets; ?>
	</head>
	
	<body>
		<div class="container">
			<?php echo $content; ?>
		</div>
		
		<?php echo $javascripts; ?>
	</body>
</html>