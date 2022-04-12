<?php
require __DIR__ . '/vendor/autoload.php';

$root = "http://".$_SERVER["HTTP_HOST"];

$paths = array(
    "post"=>"posts/",
    "note"=>"notes/"
);

$uris = array(
    "post"=>"blog/",
    "note"=>"notes/"
);

function siteExists($site, $type = "page") {
    $p = "";
    if ($type == "post") {
        $p = "posts/";
    }
    if ($type == "note") {
        $p = "notes/";
    }
    return file_exists(dirname(__FILE__)."/content/".$p.basename($site).".md");
}

function getRoute() {
    if (isset($_GET["route"])) {
        return rtrim($_GET["route"], '/\\');
    } else {
        return "";
    }
}

function getArticles() {
    return str_replace(".md", "", array_slice(scandir("content/posts"), 2));
}

function getMetadata($site, $type = "page") {
    $p = "";
    if ($type == "post") {
        $p = "posts/";
    }
    if ($type == "note") {
        $p = "notes/";
    }
    $parser = new Mni\FrontYAML\Parser;
    $content = file_get_contents(dirname(__FILE__)."/content/".$p.basename($site).".md");
    $document = $parser->parse($content);
    $metadata = array_map(
        function($str) {
            return str_replace("/wp-content/", "/content/wp-content/", $str);
        },
        $document->getYAML()
    );
    return $metadata;
}

function getData() {
    $data = array();
    foreach (getArticles() as $article) {
        array_push($data, $article);
    }
    function sortFunction( $a, $b ) {
        return strtotime($a["date"]) - strtotime($b["date"]);
    }
    return array_reverse($data);
}

function getContent($site, $type = "page") {
    $p = "";
    if ($type == "post") {
        $p = "posts/";
    }
    if ($type == "note") {
        $p = "notes/";
    }
    $parser = new Mni\FrontYAML\Parser;
    $content = file_get_contents(dirname(__FILE__)."/content/".$p.basename($site).".md");
    $document = $parser->parse($content);
    $scontent = $document->getContent();
    $s = str_replace("href=\"http", "target=\"_blank\" href=\"http", $scontent);
    if ($type == "post") {
        $s = str_replace("href=\"/", "href=\"/blog/", $s);
    }
    $s = str_replace("src=\"/", "src=\"/static/", $s);
    $s = str_replace("src=\"/static/wp-content/", "src=\"/content/wp-content/", $s);
    return $s;
}

function getRaw($site, $type = "page") {
    return htmlspecialchars(getContent($site, $type));
}

function str_after($subject, $search)
{
    if ($search == '') {
        return $subject;
    }
    $pos = strpos($subject, $search);
    if ($pos === false) {
        return $subject;
    }
    return substr($subject, $pos + strlen($search));
}