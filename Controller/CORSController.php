<?php

namespace Controller;

use Application\CORS;

class CORSController {
	public function options() {
		CORS::headers();
		die();
	}
}
