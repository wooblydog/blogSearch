<?php

class ParsingScript
{
    public $postsAData;
    public $commentsAData;
    private $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=blog';
        $username = 'mysql';
        $password = '';
        $this->postsAData = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
        $this->commentsAData = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);


        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function uploadData() //загрузка данных в бд
    {
        if (!$this->checkData()) {
            $insertPostsQuery = "INSERT INTO posts (user_id, title, body) VALUES (:userId, :title, :body)";
            $insertCommentsQuery = "INSERT INTO comments (post_id, name, email, body) VALUES (:postId, :name, :email, :body)";

            $postsStmt = $this->pdo->prepare($insertPostsQuery);
            $commentsStmt = $this->pdo->prepare($insertCommentsQuery);

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

    public function checkData() //проверить наличие данных
    {
        $checkQuery = "SELECT COUNT(*) as count FROM posts WHERE id = 1";
        $stmt = $this->pdo->query($checkQuery);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    public function getRecordsAmount(string $table) // получить к-во записей
    {
        $getRecordsQuery = "SELECT COUNT(id) as count FROM $table;";
        $stmt = $this->pdo->query($getRecordsQuery);

        $recordsAmount = $stmt->fetchColumn();

        return $recordsAmount;
    }
}

?>