<?php

$session = new Session();

class Session {

    public function __construct() {
        $this->start();
        $id = session_id();
    }

    private function start() {
        session_start();
    }

    private function regenerate() {
        session_regenerate_id();
    }

    private function destroy() {
        session_destroy();
    }
}