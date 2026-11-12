<?php if ($page->faq()->isNotEmpty()) : ?>
<section class="faq radius" theme="light" data-scroll>
	<div class="grid__4 gap__2 inner-x__4 inner-y__5 mobile:grid__1 mobile:inner-x__1 mobile:inner-y__3">
		<div class="span__1 grid gap__1 place__start-start">
			<h2 class="font__size__2"><?= $page->faqHeading()->or('Časté otázky') ?></h2>
		</div>
		<div class="span__3 grid gap__1">
			<ol class="faq__list grid" data-scroll data-collapsibles="true">
				<?php foreach ($page->faq()->toStructure() as $item) : ?>
					<collapsible class="border__top">
						<summary class="inner-y__1 cursor__pointer flex justify__space-between align__center" collapsible-trigger>
							<h3 class="font__size__default"><?= $item->question()->inline() ?></h3>
							<span class="icon font__size__3 color__acc">+</span>
						</summary>
						<detail collapsible-detail>
							<div>
								<div class="inner-b__1 op__7">
									<p><?= $item->answer()->inline() ?></p>
								</div>
							</div>
						</detail>
					</collapsible>
				<?php endforeach ?>
				<div class="border__top"></div>
			</ol>
		</div>
	</div>
</section>
<?php endif ?>
