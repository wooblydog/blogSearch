<?php
require_once 'DBConfiguration.php';

/**
 * Парсит данные из JSON для дальнейшего использования.
 * Устанавливает подключение к БД.
 */
 class BaseDataControl extends DBConfiguration
{

    /**
     * Хранит в себе ассоциативный массив JSON с постами.
     * @var array
     */
    protected array $aPostsData;

    /**
     * Хранит в себе ассоциативный массив JSON с комментариями.
     * @var array
     */
    protected array $aCommentsData;

    /**
     * Ссылка на API с постами.
     * Используется в дальнейшем для парсинга.
     * @var string
     */
    private string $urlPostsJson = 'https://jsonplaceholder.typicode.com/posts';

    /**
     * Ссылка на API с комментариями.
     * Используется в дальнейшем для парсинга.
     * @var string
     */
    private string $urlCommentsJson = 'https://jsonplaceholder.typicode.com/comments';

    /**
     * Подготовка объекта класса ParsingScript к выполнению задач загрузки
     * данных из JSON-источников и подключения к базе данных.
     */
    public function __construct()
    {
        $this->loadData();

        $this->connectionDB();
    }

    /**
     * Получает данные из JSON и записывает их в ассоциативный массив.
     * @return void
     */
    public function loadData(){
        $this->aPostsData = json_decode(file_get_contents($this->urlPostsJson), true);
        $this->aCommentsData = json_decode(file_get_contents($this->urlCommentsJson), true);
    }
}

?>