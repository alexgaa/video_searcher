<?php
namespace brands\app\controller;

class ExitController {
    public function __construct() {
        session_unset();
	session_destroy();
        header ("Location: ".MAIN_SITE);
    }
}
