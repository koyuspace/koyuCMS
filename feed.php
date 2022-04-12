<?php
header("Content-type: text/xml");
include("init.php");
?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<rss version="2.0">
  <channel>

    <title><?php echo getMetadata("_index")["title"]; ?></title>
    <description><?php echo strip_tags(str_after(getContent("_index"), "<!-- content -->")); ?></description>
    <language>en</language>
    <link><?php echo $root; ?></link>
    <lastBuildDate><?php echo date("r"); ?></lastBuildDate>

    <?php
    if (file_exists("content/posts/")) {
        foreach (getData() as $article) {
            echo "<item>\n";
            $date = new DateTime(gmdate("Y-m-d\TH:i:s\Z", getMetadata($article, "post")["date"]));
            echo "<title>".getMetadata($article, "post")["title"]."</title>\n";
            echo "<description>".html_entity_decode(nl2br(strip_tags(getContent("blog/".$article, "post"))))."</description>";
            echo "<link>".$root."/blog/".$article."</link>\n";
            echo "<pubDate>".$date->format("r")."</pubDate>\n";
            echo "<guid>".$root."/blog/".$article."</guid>\n";
            echo "</item>\n";
        }
    }
    ?>

  </channel>
</rss>
