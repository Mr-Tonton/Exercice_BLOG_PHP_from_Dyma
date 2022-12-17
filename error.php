<?php
require __DIR__ . '/database/database.php';
$authDB = require __DIR__ . '/database/security.php';
$currentUser = $authDB->isLoggedin();
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';
$articles = $articleDB->fetchAll();
$categories = [];

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$selectedCat = $_GET['cat'] ?? '';

if (count($articles)) {
    $cattmps = array_map(fn ($a) => $a['category'], $articles);
    $categories = array_reduce($cattmps, function ($acc, $cat) {
        if (isset($acc[$cat])) {
            $acc[$cat]++;
        } else {
            $acc[$cat] = 1;
        }
        return $acc;
    }, []);
    $articlesPerCategories = array_reduce($articles, function ($acc, $article) {
        if (isset($acc[$article['category']])) {
            $acc[$article['category']] = [...$acc[$article['category']], $article];
        } else {
            $acc[$article['category']] = [$article];
        }
        return $acc;
    }, []);
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="./public/css/index.css">
    <title>Blog Tony</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <h1 style="font-size:7rem;text-align:center;">Oops une erreur est survenue</h1>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>