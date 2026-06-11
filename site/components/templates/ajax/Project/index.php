<?php
$_this = 'templates/ajax/Project/';
if(!$page->isMobile()):
	snippet($_this.'desktop', compact('project','next'));
else:
	snippet($_this.'mobile', compact('project','next'));
endif;
?>