<?php require_once 'ParsingScript.php';

$parsingScript = new ParsingScript();

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

<form id="searchForm" method="post" action="" name="search-form">
    <div class="form-floating m-5  align-middle d-flex justify-content-center ">
        <input type="text" class="form-control" id="floatingInput" name="floatingInput" placeholder="-"
               minlength="3"
               value="">
        <label for="floatingInput">Поиск по комментариям: введите ключевое слово для поиска</label>
        <button type="submit" class="ms-5 btn btn-primary pe-5 ps-5" id="submitBtn">Найти</button>
    </div>
</form>

<article class="blog-post m-5 p-5">
    <h2 class="display-5 link-body-emphasis mb-1">Post title</h2>
    <p class="blog-post-meta">by <a href="#">Jacob</a><br>
        email@email.com</p>

    <p>This is some additional paragraph placeholder content. It has been written to fill the available space and show
        how a longer snippet of text affects the surrounding content. We'll repeat it often to keep the demonstration
        flowing, so be on the lookout for this exact same string of text.</p>
</article>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous">
</script>
<script>
    var postsUploaded = <?php echo $parsingScript->getRecordsAmount('posts');?>;
    var commentsUploaded = <?php echo $parsingScript->getRecordsAmount('comments');?>;
    console.log("Загружено " + postsUploaded + " записей и " + commentsUploaded + " комментариев");
</script>
</body>

</html>