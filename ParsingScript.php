<?php

class ParsingScript
{
    public $postsAData;
    public $commentsAData;
    public $pdo;
    /**
     *
     * Подготовка объекта класса ParsingScript к выполнению задач загрузки
     * данных из JSON-источников и подключения к базе данных
     *
     */
    public function __construct()
    {
        $this->postsAData = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
        $this->commentsAData = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);

        $dsn = 'mysql:host=localhost;dbname=blog';
        $username = 'mysql';
        $password = '';

        //Подключение к БД
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     *
     * Подготавливает, а затем загружает полученные данные в БД
     *
     * @return void
     */
    public function uploadData()
    {
        $dataController = new DataControl();
        //Проверка на наличие данных в БД, для того чтобы избежать избыточности
        if (!$dataController->isDataAvailable()) {
            $insertPostsQuery = "INSERT INTO posts (user_id, title, body) VALUES (:userId, :title, :body)";
            $insertCommentsQuery = "INSERT INTO comments (post_id, name, email, body) VALUES (:postId, :name, :email, :body)";

            $postsStmt = $this->pdo->prepare($insertPostsQuery);
            $commentsStmt = $this->pdo->prepare($insertCommentsQuery);
        //Заполнение БД
            foreach ($this->postsAData as $row) {
                $postsStmt->execute([
                    ':userId' => $row['userId'],
                    ':title' => $row['title'],
                    ':body' => $row['body']
                ]);
            }
            foreach ($this->commentsAData as $row) {
                $commentsStmt->execute([
                    ':postId' => $row['postId'],
                    ':name' => $row['name'],
                    ':email' => $row['email'],
                    ':body' => $row['body']
                ]);
            }
        }
    }
}

?>