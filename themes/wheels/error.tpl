{include file='layout/header.tpl'}



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->
	<div class="container">
		<div class="sixteen columns head">
			<h1 class="remove-bottom" style="margin-top: 40px"><span class="errorCode">{$viewData->error->code}</span> <span class="errorMessage">{$viewData->error->message}</span></h1>
			<h5>Platform ver. 1.8.3</h5>
			<hr />
		</div>
		<div class="one-third column">
			<h3>Информация</h3>
			<p>

            </p>
		</div>
		<div class="one-third column">
			<h3>Контакты</h3>
			<p>Тех. поддержка:</p>
			<ul class="square">
				<li><strong>тел.:</strong>: +38 (000) 000-00-00</li>
				<li><strong>email.:</strong>: support@asd.asd</li>
				<!--<li><strong>Style Agnostic</strong>: It provides the most basic, beautiful styles, but is meant to be overwritten.</li>-->
			</ul>
		</div>
		<div class="one-third column">
			<h3>Docs &amp; Support</h3>
			<p>
                The easiest way to really get started with JE is to check out the full docs and info at <a href="http://thelaps.biz">thelaps.biz</a>. JE is also open-source and has no project on git.
            </p>
		</div>

	</div><!-- container -->


{include file='layout/footer.tpl'}