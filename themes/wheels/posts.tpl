{include file='layout/header.tpl'}
{include file='layout/menu.tpl'}



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->

	<div class="container">
		<div class="sixteen columns head">
			<h1 class="remove-bottom" style="margin-top: 40px">Jumper Engine (basic theme)</h1>
			<h5>Version --</h5>
			<hr />
		</div>
        <div class="sixteen columns">
            <ul class="allPosts">
            {foreach item=post from=$viewData.posts}
                <li><img src="{$post->src}" title="{$post->title}"><a href="?view=posts&id={$post->id}">{$post->title}</a></li>
            {/foreach}
            </ul>
            <hr />
        </div>

	</div><!-- container -->


{include file='layout/footer.tpl'}