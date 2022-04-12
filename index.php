<?php include("init.php"); ?>
<?php
    $type = "page";
    $route = getRoute();
    if (str_starts_with($route, 'blog/')) {
        $type = "post";
    }
    if (str_starts_with($route, 'notes/')) {
        $type = "note";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="koyuCMS 1.0">
    <?php
    $pagetitle = getMetadata("_index")["title"];
    if ($route != "" && siteExists($route, $type)) {
        $pagetitle = getMetadata($route, $type)["title"]." – ".getMetadata("_index")["title"];
    }
    ?>
    <title><?php echo $pagetitle; ?></title>
    <link rel="stylesheet" href="/static/style.css">
    <link rel="stylesheet" href="/static/custom.css">
    <script src="https://kit.fontawesome.com/8b5d897402.js" crossorigin="anonymous"></script>
    <script src="https://twemoji.maxcdn.com/v/13.1.0/twemoji.min.js" integrity="sha384-gPMUf7aEYa6qc3MgqTrigJqf4gzeO6v11iPCKv+AP2S4iWRWCoWyiR+Z7rWHM/hU" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.6/purify.min.js" integrity="sha512-DJjvM/U3zCRpzrYboJgg23iLHapWcS2rlo7Ni18Cdv+FMs6b3gUF7hQihztj4uVkHHfUwk7dha97jVzRqUJ7hg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/static/app.js"></script>
    <?php echo getContent("_header"); ?>
    <link rel="shortcut icon" href="/static/favicon.ico">
    <link rel="alternate" href="/feed.php">
    <?php
    if ($route != "" && siteExists($route, $type)) {
    $metadata = getMetadata($route, $type);
    ?>
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $root."/".$route; ?>">
    <meta property="og:title" content="<?php echo $metadata["title"] ?>">
    <?php
    $description = explode("\n", strip_tags(getContent($route, $type)))[0];
    if (strlen($description) >= 90) {
        $description = substr($description,0,91)."...";
    }
    ?>
    <meta name="og:description" content="<?php echo $description; ?>">
    <?php
    if (isset($metadata["featured_image"])) {
    ?>
    <meta property="og:image" content="<?php echo $metadata["featured_image"]; ?>">
    <?php
    }
    }
    ?>
</head>
<body>
    <header>
        <nav>
            <ul class="menu">
                <?php echo getContent("_menu"); ?>
            </ul>
            <hr>
        </nav>
    </header>
    <?php
    $route = getRoute();
    if ($route == "") {
    echo getContent("_index");
    if (file_exists("content/posts/")) {
        echo "<h2>Articles</h2>\n<ul class=\"articles\">\n";
        foreach (getData() as $article) {
            $date = new DateTime(gmdate("Y-m-d\TH:i:s\Z", getMetadata($article, "post")["date"]));
            $title = getMetadata($article, "post")["title"];
            if (strlen($title) >= 90) {
                $title = substr($title,0,91)."...";
            }
            echo "<li><span class=\"date\">".$date->format("d.m.Y")."</span>\n";
            echo "<a href=\"/blog/".$article."\">".$title."</a></li>\n";
        }
        echo "<ul>\n";
    }
    } else if (siteExists($route, $type)) {
    ?>
    <div class="article-meta">
        <?php
        if ($type == "post") {
        ?>
        <style>.article-meta { margin-top: 0px !important; background: url(<?php echo $metadata["featured_image"]; ?>) #ccc; background-size: cover; background-position: center center; background-blend-mode: overlay; }</style>
        <?php
        }
        ?>
        <h1><span class="title"><?php echo $metadata["title"] ?></span></h1>
        <?php
        if ($type == "post") {
        ?>
        <p class="date">
            <?php
                $date = new DateTime(gmdate("Y-m-d\TH:i:s\Z", $metadata["date"]));
                echo $date->format("d.m.Y");
            ?>
        </p>
        <?php
        }
        ?>
    </div>
    <main>
        <?php echo getContent($route, $type); ?>
    </main>
    <?php
    if ($type == "post") {
        include("comments.php");
    }
    } else {
    http_response_code(404);
    ?>
    <div class="error">
        <?php echo getContent("_404"); ?>
    </div>
    <?php
    }
    ?>
    <hr>
    <footer>
    <?php echo getContent("_footer"); ?>
    </footer>
</body>
</html>