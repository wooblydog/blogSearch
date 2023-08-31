<?php require_once 'ParsingScript.php';
require_once 'DataControl.php';

$parsingScript = new ParsingScript();
$dataController = new DataControl();

$parsingScript->uploadData();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body class="mx-auto p-5 m-5">

<form id="searchForm" method="GET" action="" name="search-form">
    <div class="form-floating m-5  align-middle d-flex justify-content-center ">
        <input type="text" class="form-control" id="floatingInput" name="floatingInput" required
               minlength="3">
        <label for="floatingInput">Поиск по комментариям: введите ключевое слово для поиска</label>
        <button type="submit" class="ms-5 btn btn-primary pe-5 ps-5" id="submitBtn">Найти</button>
    </div>
</form>


<?php if ($dataController->getPosts() !== null) {
    foreach ($dataController->getPosts() as $row) {
        echo <<<HTML
        <article class="blog-post m-5 p-5">
            <h2 class="display-5 link-body-emphasis mb-1">{$row['title']}</h2>
            <p class="blog-post-meta">by <a href="#">{$row['name']}</a><br>{$row['email']}</p>
            <p>{$row['body']}</p>
        </article>
        HTML;
    }
}

if (!$dataController->isValidKeyword($_GET['floatingInput'])) {
    echo "Введите минимум три символа";
}
if ($dataController->getPosts() === null && $dataController->isValidKeyword($_GET['floatingInput'])) {
    echo "Записей с ключевым словом '" . $_GET['floatingInput'] . "' в комментариях не найдено";
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous">
</script>
<script>
    var postsUploaded = <?php echo $dataController->getRecordsAmount('posts');?>;
    var commentsUploaded = <?php echo $dataController->getRecordsAmount('comments');?>;
    console.log("Загружено " + postsUploaded + " записей и " + commentsUploaded + " комментариев");
</script>
</body>

</html>