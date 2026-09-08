<?php
return function () {

	// return json_decode($json, true);
	return page('projects')->children()->listed();
};


