<div class="one-third column">
    <h4>Интересное</h4>
    <ul class="relatedPosts">
    {foreach item=post from=$viewData.posts_widget}
        <li><a href="?view=posts&id={$post.id}"><img src="{$post.src}" title="{$post.title}">{$post.title}</a></li>
    {/foreach}
    </ul>
</div>