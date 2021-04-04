<?php


namespace app\Model\User\Entity;


class User {
    protected ?int $id;
    protected ?string $login;
    protected ?string $password;

    /**
     * User constructor.
     * @param ?int $id
     * @param ?string $login
     * @param ?string $password
     */
    public function __construct(?int $id, ?string $login, ?string $password) {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getPassword(): ?string {
        return $this->password;
    }
}