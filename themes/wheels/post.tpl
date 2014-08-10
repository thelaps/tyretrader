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
        <div class="columns">
            <h3 class="remove-bottom" style="margin-top: 40px">{$viewData.post->title}</h3>
            <div class="columns">
                <img src="{$viewData.post->src}">
            </div>
            <p>
                {$viewData.post->text}
            </p>
            <del>{$viewData.post->date}</del>
            <hr />
        </div>

	</div><!-- container -->


{include file='layout/footer.tpl'}