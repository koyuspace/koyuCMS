<?php
if (isset($metadata["comments"]["id"])) {
?>
<div class="article-content">
  <h2>Comments</h2>
  <p>You can use your account on the fediverse to reply to this <a class="link" target="_blank" href="https://<?php echo $metadata["comments"]["host"]; ?>/@<?php echo $metadata["comments"]["username"]; ?>/<?php echo $metadata["comments"]["id"]; ?>">post</a>.</p>
  <p><a class="button" href="https://<?php echo $metadata["comments"]["host"]; ?>/interact/<?php echo $metadata["comments"]["id"] ?>?type=reply" target="_blank">Reply</a></p>
  <p id="comments-list">Loading comments...</p>
  <noscript><p>You need JavaScript to view the comments.</p></noscript>
  <script src="/assets/js/purify.min.js"></script>
  <script type="text/javascript">
    function escapeHtml(unsafe) {
      return unsafe
           .replace(/&/g, "&amp;")
           .replace(/</g, "&lt;")
           .replace(/>/g, "&gt;")
           .replace(/"/g, "&quot;")
           .replace(/'/g, "&#039;");
   }

  fetch('https://<?php echo $metadata["comments"]["host"]; ?>/api/v1/statuses/<?php echo $metadata["comments"]["id"]; ?>/context')
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      if(data['descendants'] &&
          Array.isArray(data['descendants']) && 
        data['descendants'].length > 0) {
          document.getElementById('comments-list').innerHTML = "";
          data['descendants'].forEach(function(reply) {
            reply.account.display_name = twemoji.parse(escapeHtml(reply.account.display_name));
            reply.account.emojis.forEach(emoji => {
              reply.account.display_name = reply.account.display_name.replace(`:${emoji.shortcode}:`,
                `<img src="${escapeHtml(emoji.static_url)}" class="emoji" alt="Emoji ${emoji.shortcode}" height="16" width="16" />`);
            });
            reply.content = twemoji.parse(reply.content);
            reply.emojis.forEach(emoji => {
              reply.content = reply.content.replace(`:${emoji.shortcode}:`,
                `<img src="${escapeHtml(emoji.static_url)}" class="emoji" alt="Emoji ${emoji.shortcode}" height="16" width="16" />`);
            });
            mastodonComment =
              `<hr><div class="comment">
                  <div class="avatar">
                    <img src="${escapeHtml(reply.account.avatar_static)}" height=60 width=60 alt="">
                  </div>
                  <div class="content">
                    <div class="author">
                    <span><b>${reply.account.display_name}</b></span>
                    <span>(@${escapeHtml(reply.account.acct)})</span><br>
                      <a href="${reply.uri}" rel="nofollow" target="_blank">
                        View comment
                      </a>
                    </div>
                    <div class="comment-content">${reply.content}</div> 
                  </div>
                </div><br>`;
            document.getElementById('comments-list').appendChild(DOMPurify.sanitize(mastodonComment, {'RETURN_DOM_FRAGMENT': true, ADD_ATTR: ['target']}));
          });
      } else {
        document.getElementById('comments-list').innerHTML = "<p>No comments found</p>";
      }
    });
  </script>
</div>
<?php
}
?>