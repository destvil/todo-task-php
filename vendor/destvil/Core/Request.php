<?php


namespace destvil\Core;


class Request {
    public function getGet(string $name) {
        return $_GET[$name];
    }

    public function getPost(string $name) {
        return $_POST[$name];
    }

    public function hasPost(string $name): bool {
        return isset($_POST[$name]);
    }

    public function generateCSRFToken(): string {
        return bin2hex(random_bytes(32));
    }

    public function getUrlWithoutQuery(): string {
        list ($url, $query) = explode('?', $_SERVER['REQUEST_URI']);
        return $url;
    }
}