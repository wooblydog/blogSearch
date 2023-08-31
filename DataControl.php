<?php

class DataControl extends ParsingScript
{
    /**
     * Получает данные из БД
     *
     * @return bool|array Dозвращает <b>массив</b> заголовков постов и авторов комментариев к ним.<br>
     * Либо <b>false</b> если ничего не найдено
     */
    public function getPosts()
    {
        $keyWord = '%' . $_GET['floatingInput'] . '%';

        if ($this->isValidKeyword($keyWord)) {
            $getPostsQuery = "SELECT posts.title, comments.body, comments.name, comments.email
            FROM posts
            JOIN comments ON posts.id = comments.post_id
            WHERE comments.body LIKE ?";

            $stmt = $this->pdo->prepare($getPostsQuery);
            $stmt->execute(['%' . $keyWord . '%']);

            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $posts;
        }
        return [];
    }

    /**
     *
     * Выполняет валидацию введенного ключевого слова
     *
     * @param string $keyWord Слово для валидации
     * @return bool Возвращает <b>true</b> или <b>false</b> в зависимости от результата валидации
     */
    public function isValidKeyword(string $keyWord): bool
    {
        return strlen($keyWord) >= 3;
    }

    /**
     *
     * Проверяет наличие данных в БД
     *
     * @return bool Возвращает <b>true</b> или <b>false</b> в зависимости от наличия данных
     */
    public function isDataAvailable(): bool
    {
        $checkQuery = "SELECT COUNT(*) as count FROM posts WHERE id = 1";
        $stmt = $this->pdo->query($checkQuery);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    /**
     *
     * Производит подсчёт количества записей в таблице
     *
     * @param string $table Таблица в которой необходимо посчитать количество записей
     * @return int Возвращает количество записей
     */
    public function getRecordsAmount(string $table): int // получить к-во записей
    {
        $getRecordsQuery = "SELECT COUNT(id) as count FROM $table;";
        $stmt = $this->pdo->query($getRecordsQuery);

        $recordsAmount = $stmt->fetchColumn();

        return $recordsAmount;
    }
}