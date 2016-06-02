<?php include 'php/index.php'; ?>
<!DOCTYPE html>
<html>
	<?php construct_page_required($get['page'], 'head'); ?>
	<body>

	<?php construct_page_required($get['page'], 'include'); ?>


	<?php construct_page_required($get['page'], 'body_end'); ?>
	</body>
</html>
