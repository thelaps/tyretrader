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
		<div class="two-thirds column">
			<h4>About JE?</h4>
			<p>
                <center><img width="148" src="{$src}/images/jumper.png"></center>
            </p>
		</div>
		<!--<div class="one-third column">
			<h3>Three Core Principles</h3>
			<p>JE is built on three core principles:</p>
			<ul class="square">
				<li><strong>A Responsive Grid Down To Mobile</strong>: Elegant scaling from a browser to tablets to mobile.</li>
				<li><strong>Fast to Start</strong>: It's a tool for rapid development with best practices</li>
				<li><strong>Style Agnostic</strong>: It provides the most basic, beautiful styles, but is meant to be overwritten.</li>
			</ul>
		</div>-->
        {include file='widget/random_posts.tpl'}

	</div><!-- container -->


{include file='layout/footer.tpl'}