<?php
require_once 'DBConfiguration.php';

/**
 * Манипулирует данными
 */
class DataControl extends BaseDataControl
{

    /**
     * Минимальная допустимая длина ключевого слова.
     * @var int
     */
    private int $minLength = 3;

    /**
     * Запрос для получения необходимых постов.
     * @var string
     */
    private string $getPostsQuery = "SELECT posts.title, comments.body, comments.name, comments.email
                                     FROM posts
                                     JOIN comments ON posts.id = comments.post_id
                                     WHERE comments.body LIKE ?";

    /**
     * Получает данные из БД
     * @return bool|array Dозвращает <b>массив</b> заголовков постов и авторов комментариев к ним.<br>
     * Либо <b>false</b> если ничего не найдено.
     */
    public function getPosts()
    {
        $keyWord = '%' . $_GET['floatingInput'] . '%';

        if (!$this->isValidKeyword($keyWord)) {
            return [];
        }

        $stmt = $this->pdo->prepare($this->getPostsQuery);
        $stmt->execute(['%' . $keyWord . '%']);

        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $posts;
    }

    /**
     * Выполняет валидацию введенного ключевого слова.
     * @param string $keyWord Слово для валидации.
     * @return bool Возвращает <b>true</b> или <b>false</b> в зависимости от результата валидации.
     */
    public function isValidKeyword(string $keyWord): bool
    {
        return strlen($keyWord) >= $this->minLength;
    }

    /**
     * Проверяет наличие данных в БД.
     * @return bool Возвращает <b>true</b> или <b>false</b> в зависимости от наличия данных.
     */
    public function isDataAvailable(): bool
    {
        $checkQuery = "SELECT COUNT(*) as count FROM posts WHERE id = 1";
        $stmt = $this->pdo->query($checkQuery);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    /**
     * Производит подсчёт количества записей в таблице.
     * @param string $table Таблица в которой необходимо посчитать количество записей.
     * @return int Возвращает количество записей.
     */
    public function getRecordsAmount(string $table): int // получить к-во записей
    {
        $getRecordsQuery = "SELECT COUNT(id) as count FROM $table;";
        $stmt = $this->pdo->query($getRecordsQuery);

        $recordsAmount = $stmt->fetchColumn();

        return $recordsAmount;
    }

    /**
     * Подготавливает, а затем загружает полученные данные в БД.
     * @return void
     */
    public function uploadData()
    {
        //Проверка на наличие данных в БД, для того чтобы избежать избыточности
        if (!$this->isDataAvailable()) {
            $insertPostsQuery = "INSERT INTO posts (user_id, title, body) VALUES (:userId, :title, :body)";
            $insertCommentsQuery = "INSERT INTO comments (post_id, name, email, body) VALUES (:postId, :name, :email, :body)";

            $postsStmt = $this->pdo->prepare($insertPostsQuery);
            $commentsStmt = $this->pdo->prepare($insertCommentsQuery);
            //Заполнение БД
            foreach ($this->aPostsData as $row) {
                $postsStmt->execute([
                    ':userId' => $row['userId'],
                    ':title' => $row['title'],
                    ':body' => $row['body']
                ]);
            }
            foreach ($this->aCommentsData as $row) {
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