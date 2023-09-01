<?php

/**
 * Хранит в себе конфигурации для подключения к БД.
 */
class DBConfiguration
{
    /**
     * Используется для установки соединения между PHP и сервером базы данных.
     * @var PDO
     */
    protected PDO $pdo;

    /**
     * Хранит в себе конфигурации для подключения к БД.
     * @var string
     */
    private string $dsn = 'mysql:host=localhost;dbname=blog';

    /**
     * Хранит в себе логин пользователя для подключения к БД.
     * @var string
     */
    private string $username = 'mysql';

    /**
     * Хранит в себе пароль пользователя для подключения к БД
     * @var string
     */
    private string $password = '';

    /**
     * Выполняет установку соединения с базой данных с использованием <b>PDO</b>.
     * @return void
     */
    public function connectionDB()
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}