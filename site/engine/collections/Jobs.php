<?php
return function () {
	$positions = page('career')->find('positions');
	if (!$positions) {
		return page('career')->children()->filterBy('template', 'job')->listed();
	}
	return $positions->children()->listed();
};
