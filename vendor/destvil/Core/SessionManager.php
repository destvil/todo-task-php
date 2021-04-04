<?php


namespace destvil\Core;


class SessionManager {
    public function start(): void {
        session_start();
    }

    public function has(string $name): bool {
        return isset($_SESSION[$name]);
    }

    public function get(string $name) {
        return $_SESSION[$name];
    }

    public function set(string $name, $val): void {
        $_SESSION[$name] = $val;
    }

    public function delete(string $name): void {
        unset($_SESSION[$name]);
    }

    public function getToken(): string {
        return $_SESSION['token'];
    }

    public function verifyToken(string $token): bool {
        return hash_equals($_SESSION['token'], $token);
    }
}