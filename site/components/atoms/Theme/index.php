<?= css('site/components/atoms/Theme/theme.css') ?>

<div data-scroll data-reveal-image class="fixed inset__top-right grid place__start-end gap__02 z__10" style="--in-delay: 600ms; position: fixed; top: 1rem; right: 1rem; z-index: 1000;">

	<div class="flex gap__01">
		<?php if ($kirby->user()): ?>
			<a href="<?= $page->panel()->url() ?>" target="_blank" id="panel-link-btn" aria-label="Open in Kirby Panel">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
					<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
				</svg>
			</a>

			<button id="theme-toggle-btn" aria-label="Toggle Theme Settings">
				<svg class="icon-settings" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<circle cx="12" cy="12" r="3"></circle>
					<path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
				</svg>
				<svg class="icon-close" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		<?php endif; ?>
	</div>

	<div id="theme-panel-body" class="grid__2 gap__1 inner__05 color__invert bg__black/80 is-hidden" style="max-height: 85vh; overflow-y: auto; font-family: sans-serif; padding: 1rem;">
		
		<div class="theme-tab-nav span__2">
			<button class="theme-tab-btn is-active" data-tab-target="tab-headings">Headings</button>
			<button class="theme-tab-btn" data-tab-target="tab-texts">Texts</button>
			<button class="theme-tab-btn" data-tab-target="tab-spacing">Spacing</button>
			<button class="theme-tab-btn" data-tab-target="tab-animations">Animations</button>
			<button class="theme-tab-btn" data-tab-target="tab-colors">Colors & Canvas</button>
			<button class="theme-tab-btn" data-tab-target="tab-images">Images</button>
			<button class="theme-tab-btn" data-tab-target="tab-buttons">Buttons</button>
		</div>

		<!-- TAB: HEADINGS -->
		<div id="tab-headings" class="theme-tab-content grid__2 gap__1 span__2">
			<div class="typo-section-header">Heading Fluid Engine & Branding</div>
			
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Heading Family</label>
				<select name="ff-heading" data-theme-setup data-font-select></select>
			</div>

			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Default Weight</label>
					<input type="number" name="fw-heading" step="100" min="100" max="900" data-theme-setup>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Transform</label>
					<select name="tt-heading" data-theme-setup>
						<option value="none">None</option>
						<option value="uppercase">Uppercase</option>
						<option value="lowercase">Lowercase</option>
					</select>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Tracking</label>
					<input type="text" name="ls-heading" placeholder="normal" data-theme-setup>
				</div>
			</div>

			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">H-Typescale Ratio</label>
				<div class="flex" style="align-items: center; gap: 0.25rem; width: 100%;">
					<select id="ts-select" name="type-scale" data-theme-setup style="flex: 1;">
						<option value="1.618">1.618 – Golden</option>
						<option value="1.500">1.500 – Perfect 5th</option>
						<option value="1.414">1.414 – Aug 4th</option>
						<option value="1.333">1.333 – Perf 4th</option>
						<option value="1.250">1.250 – Maj 3rd</option>
						<option value="1.200">1.200 – Min 3rd</option>
						<option value="custom">Custom...</option>
					</select>
					<input type="number" id="ts-input" step="0.001" min="1" max="4" style="width: 80px;" placeholder="1.618">
				</div>
			</div>

			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">H-Start Baseline (Rem)</label>
					<input type="number" name="type-start-rem" step="0.05" min="0.5" max="4" data-theme-setup data-unit="rem">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">H-Start Fluid (Vw)</label>
					<input type="number" name="type-start-vw" step="0.05" min="0.5" max="4" data-theme-setup data-unit="vw">
				</div>
			</div>

			<div class="grid span__2" style="margin-bottom: 0.5rem;">
				<label class="ff__body op__4 font__size__small">H-Line Height Baseline</label>
				<input type="number" name="base-line-height" step="0.05" min="0.8" max="2" data-theme-setup>
			</div>

			<!-- Individual Heading Levels Overrides -->
			<div class="span__2 flex justify__space-between align__center" style="border-top: 1px solid rgba(255,255,255,0.1); border-bottom: 1px solid rgba(255,255,255,0.05); padding: 0.5rem 0 0.25rem 0; margin-top: 0.25rem;">
				<span class="font__size__small op__6 uppercase" style="font-weight:bold;">Heading Levels (Manual Overrides)</span>
				<button type="button" class="clear-section-btn" data-clear-group="headings" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; font-size: 0.65rem; padding: 0.2rem 0.5rem; border-radius: 3px; cursor: pointer;">
					⚡ Clear Headings
				</button>
			</div>

			<!-- Display / H1 -->
			<div class="typo-section-header">Display / H1</div>
			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Size</label>
					<input type="text" name="type-h1-size" data-theme-setup data-override data-override-prop="h1-size">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="type-h1-weight" step="100" min="100" max="900" data-theme-setup data-override data-override-prop="h1-weight">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Line Height</label>
					<input type="number" name="type-h1-lh" step="0.01" min="0.5" max="2.5" data-theme-setup data-override data-override-prop="h1-lh">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Letter Spacing</label>
					<input type="text" name="type-h1-ls" data-theme-setup data-override data-override-prop="h1-ls">
				</div>
			</div>

			<!-- H2 Sekce -->
			<div class="typo-section-header">H2 Sekce</div>
			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Size</label>
					<input type="text" name="type-h2-size" data-theme-setup data-override data-override-prop="h2-size">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="type-h2-weight" step="100" min="100" max="900" data-theme-setup data-override data-override-prop="h2-weight">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Line Height</label>
					<input type="number" name="type-h2-lh" step="0.01" min="0.5" max="2.5" data-theme-setup data-override data-override-prop="h2-lh">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Letter Spacing</label>
					<input type="text" name="type-h2-ls" data-theme-setup data-override data-override-prop="h2-ls">
				</div>
			</div>

			<!-- H3 Podnadpis -->
			<div class="typo-section-header">H3 Podnadpis</div>
			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Size</label>
					<input type="text" name="type-h3-size" data-theme-setup data-override data-override-prop="h3-size">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="type-h3-weight" step="100" min="100" max="900" data-theme-setup data-override data-override-prop="h3-weight">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Line Height</label>
					<input type="number" name="type-h3-lh" step="0.01" min="0.5" max="2.5" data-theme-setup data-override data-override-prop="h3-lh">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Letter Spacing</label>
					<input type="text" name="type-h3-ls" data-theme-setup data-override data-override-prop="h3-ls">
				</div>
			</div>

			<!-- H4 -->
			<div class="typo-section-header">H4 Menší podnadpis</div>
			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Size</label>
					<input type="text" name="type-h4-size" data-theme-setup data-override data-override-prop="h4-size">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="type-h4-weight" step="100" min="100" max="900" data-theme-setup data-override data-override-prop="h4-weight">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Line Height</label>
					<input type="number" name="type-h4-lh" step="0.01" min="0.5" max="2.5" data-theme-setup data-override data-override-prop="h4-lh">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Letter Spacing</label>
					<input type="text" name="type-h4-ls" data-theme-setup data-override data-override-prop="h4-ls">
				</div>
			</div>

			<!-- H5 -->
			<div class="typo-section-header">H5 Titulek</div>
			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Size</label>
					<input type="text" name="type-h5-size" data-theme-setup data-override data-override-prop="h5-size">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="type-h5-weight" step="100" min="100" max="900" data-theme-setup data-override data-override-prop="h5-weight">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Line Height</label>
					<input type="number" name="type-h5-lh" step="0.01" min="0.5" max="2.5" data-theme-setup data-override data-override-prop="h5-lh">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Letter Spacing</label>
					<input type="text" name="type-h5-ls" data-theme-setup data-override data-override-prop="h5-ls">
				</div>
			</div>
		</div>

		<!-- TAB: TEXTS -->
		<div id="tab-texts" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
			<div class="typo-section-header">Body Fluid Engine & Branding</div>
			
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Body Family</label>
				<select name="ff-body" data-theme-setup data-font-select></select>
			</div>

			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Mono Family</label>
				<select name="ff-mono" data-theme-setup data-font-select></select>
			</div>

			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Default Weight</label>
					<input type="number" name="fw-body" step="100" min="100" max="900" data-theme-setup>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Transform</label>
					<select name="tt-body" data-theme-setup>
						<option value="none">None</option>
						<option value="uppercase">Uppercase</option>
						<option value="lowercase">Lowercase</option>
					</select>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Tracking</label>
					<input type="text" name="ls-body" placeholder="normal" data-theme-setup>
				</div>
			</div>

			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Body Scale Ratio</label>
				<div class="flex" style="align-items: center; gap: 0.25rem; width: 100%;">
					<select id="bs-select" name="body-scale" data-theme-setup style="flex: 1;">
						<option value="1.400">1.400 – Default</option>
						<option value="1.300">1.300 – Medium</option>
						<option value="1.222">1.222 – Compact</option>
						<option value="1.125">1.125 – Tight</option>
						<option value="custom">Custom...</option>
					</select>
					<input type="number" id="bs-input" step="0.001" min="1" max="3" style="width: 80px;" placeholder="1.400">
				</div>
			</div>

			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">B-Start Baseline (Rem)</label>
					<input type="number" name="body-start-rem" step="0.001" min="0.1" max="3" data-theme-setup data-unit="rem">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">B-Start Fluid (Vw)</label>
					<input type="number" name="body-start-vw" step="0.001" min="0.1" max="3" data-theme-setup data-unit="vw">
				</div>
			</div>

			<div class="grid span__2" style="margin-bottom: 0.5rem;">
				<label class="ff__body op__4 font__size__small">B-Line Height Baseline</label>
				<input type="number" name="base-body-line-height" step="0.05" min="1.0" max="2.5" data-theme-setup>
			</div>

			<!-- Individual Text Variants Overrides -->
			<div class="span__2 flex justify__space-between align__center" style="border-top: 1px solid rgba(255,255,255,0.1); border-bottom: 1px solid rgba(255,255,255,0.05); padding: 0.5rem 0 0.25rem 0; margin-top: 0.25rem;">
				<span class="font__size__small op__6 uppercase" style="font-weight:bold;">Text Variants (Manual Overrides)</span>
				<button type="button" class="clear-section-btn" data-clear-group="texts" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; font-size: 0.65rem; padding: 0.2rem 0.5rem; border-radius: 3px; cursor: pointer;">
					⚡ Clear Texts
				</button>
			</div>

			<!-- Perex -->
			<div class="typo-section-header">Perex (Large)</div>
			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Size</label>
					<input type="text" name="type-perex-size" data-theme-setup data-override data-override-prop="perex-size">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="type-perex-weight" step="100" min="100" max="900" data-theme-setup data-override data-override-prop="perex-weight">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Line Height</label>
					<input type="number" name="type-perex-lh" step="0.01" min="0.5" max="2.5" data-theme-setup data-override data-override-prop="perex-lh">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Opacity</label>
					<input type="number" name="type-perex-opacity" step="0.05" min="0.1" max="1" placeholder="1" data-theme-setup data-override data-override-prop="perex-opacity">
				</div>
			</div>

			<!-- Běžný text -->
			<div class="typo-section-header">Běžný text (Body / Default)</div>
			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Size</label>
					<input type="text" name="type-body-size" data-theme-setup data-override data-override-prop="body-size">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="type-body-weight" step="100" min="100" max="900" data-theme-setup data-override data-override-prop="body-weight">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Line Height</label>
					<input type="number" name="type-body-lh" step="0.01" min="0.5" max="2.5" data-theme-setup data-override data-override-prop="body-lh">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Letter Spacing</label>
					<input type="text" name="type-body-ls" data-theme-setup data-override data-override-prop="body-ls">
				</div>
			</div>

			<!-- Nadtitulek / Popisek -->
			<div class="typo-section-header">Nadtitulek / Popisek (Caption / Small)</div>
			<div class="theme-panel-row span__2">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Size</label>
					<input type="text" name="type-caption-size" data-theme-setup data-override data-override-prop="caption-size">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Weight</label>
					<input type="number" name="type-caption-weight" step="100" min="100" max="900" data-theme-setup data-override data-override-prop="caption-weight">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Line Height</label>
					<input type="number" name="type-caption-lh" step="0.01" min="0.5" max="2.5" data-theme-setup data-override data-override-prop="caption-lh">
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Tracking (LS)</label>
					<input type="text" name="type-caption-ls" data-theme-setup data-override data-override-prop="caption-ls">
				</div>
			</div>
			<div class="theme-panel-row span__2" style="margin-bottom: 0.25rem;">
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Transform</label>
					<select name="type-caption-transform" data-theme-setup data-override data-override-prop="caption-transform">
						<option value="">Auto (none)</option>
						<option value="uppercase">Verzálky (Uppercase)</option>
						<option value="none">None</option>
						<option value="capitalize">Capitalize</option>
					</select>
				</div>
				<div class="grid">
					<label class="ff__body op__4 font__size__small">Opacity</label>
					<input type="number" name="type-caption-opacity" step="0.05" min="0.1" max="1" placeholder="1" data-theme-setup data-override data-override-prop="caption-opacity">
				</div>
			</div>
		</div>

		<div id="tab-spacing" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Min Scale</label>
				<input type="number" name="scale-min" step="0.05" min="0.2" max="3" data-theme-setup>
			</div>
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Fluid Scale</label>
				<input type="number" name="scale-fluid" step="0.1" min="0" max="10" data-theme-setup>
			</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Global Scale Modifier</label>
				<input type="number" name="scale" step="0.05" min="0.2" max="3" data-theme-setup>
			</div>
		</div>

		<div id="tab-animations" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Duration</label>
				<input type="text" name="animation-duration" placeholder="800ms" data-theme-setup>
			</div>
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Delay</label>
				<input type="text" name="animation-delay" placeholder="0ms" data-theme-setup>
			</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Stagger Interval</label>
				<input type="text" name="animation-stagger" placeholder="50ms" data-theme-setup>
			</div>
			<div class="grid span__2">
				<label class="ff__body op__4 font__size__small">Timing Curve</label>
				<select name="animation-timing" data-theme-setup>
					<option value="cubic-bezier(0.4, 0, 0.2, 1)">Material Standard (0.4, 0, 0.2, 1)</option>
					<option value="cubic-bezier(0.25, 1, 0.5, 1)">Cubic Out (Smooth)</option>
					<option value="cubic-bezier(0.16, 1, 0.3, 1)">Expo Out (Snappy)</option>
					<option value="ease">Ease</option>
					<option value="linear">Linear</option>
				</select>
			</div>
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Parallax Matrix</label>
				<select name="toggle-parallax" data-theme-setup>
					<option value="1">Enabled</option>
					<option value="0">Disabled</option>
				</select>
			</div>
			<div class="grid">
				<label class="ff__body op__4 font__size__small">Scroll Reveals</label>
				<select name="toggle-reveals" data-theme-setup>
					<option value="1">Enabled</option>
					<option value="0">Disabled</option>
				</select>
			</div>
		</div>

		<div id="tab-colors" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
			<div class="grid span__2" style="width: 100%;">
				<label class="ff__body op__4 font__size__small">Theme Canvas Mode</label>
				<select id="canvas-theme-selector">
					<option value="default">Default Root</option>
					<option value="light">Light Mode</option>
					<option value="dark">Dark Mode</option>
					<option value="invert">Inverted Mode</option>
					<option value="acc">Accent Mode</option>
				</select>
			</div>

			<div class="grid span__2" style="width: 100%; margin-top: 0.25rem;">
				<label class="ff__body op__4 font__size__small" style="margin-bottom: 0.35rem;">System Colors Palette</label>
				<div id="dynamic-color-grid" class="color-picker-grid">
					</div>
			</div>
		</div>

		<div id="tab-images" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
		    <div class="grid">
		        <label class="ff__body op__4 font__size__small">Image Radius</label>
		        <input type="number" name="img-radius" step="0.1" min="0" max="10" data-theme-setup>
		    </div>
		    <div class="grid">
		        <label class="ff__body op__4 font__size__small">Global Radius</label>
		        <input type="number" name="radius" step="0.1" min="0" max="10" data-theme-setup>
		    </div>
		</div>

		<div id="tab-buttons" class="theme-tab-content grid__2 gap__1 span__2 is-hidden">
		    <div class="grid">
		        <label class="ff__body op__4 font__size__small">Btn Padding</label>
		        <input type="text" name="btn-padding" placeholder="0.5rem 1rem" data-theme-setup>
		    </div>
		    <div class="grid">
		        <label class="ff__body op__4 font__size__small">Btn Radius</label>
		        <input type="number" name="btn-radius" step="1" min="0" max="50" data-theme-setup>
		    </div>
		    <div class="grid span__2">
		        <label class="ff__body op__4 font__size__small">Btn Border Width</label>
		        <input type="number" name="btn-border" step="1" min="0" max="10" data-theme-setup>
		    </div>
		</div>

		<div class="flex span__2" style="width: 100%; margin-top: 0.75rem; gap: 0.5rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 0.75rem; flex-wrap: wrap;">
					
			<form action="<?= $page->url() ?>" method="POST" style="width: 100%; margin: 0; padding: 0;">
				<input type="hidden" name="action" value="sync_theme_fonts">
				
				<button type="submit" style="width: 100%; background: rgba(0, 123, 255, 0.2); color: #007bff; border: 1px solid rgba(0, 123, 255, 0.4); padding: 0.5rem; border-radius: 4px; cursor: pointer; font-family: sans-serif; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; font-weight: bold; margin-bottom: 0.25rem; transition: all 0.2s;">
					🔄 Sync Fonts
				</button>
			</form>

			<form id="theme-save-form" action="<?= $page->url() ?>" method="POST" style="flex: 2; margin: 0; padding: 0;">
				<input type="hidden" name="action" value="save-theme">
				<input type="hidden" id="css-tokens-input" name="css_tokens" value="">
				
				<button type="submit" style="width: 100%; background: rgba(40, 167, 69, 0.2); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.4); padding: 0.5rem; border-radius: 4px; cursor: pointer; font-family: sans-serif; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; font-weight: bold;">
					💾 Save Config File
				</button>
			</form>

			<button id="theme-reset-btn" type="button" style="flex: 1; background: rgba(237, 19, 89, 0.2); color: #ff5487; border: 1px solid rgba(237, 19, 89, 0.4); padding: 0.5rem; border-radius: 4px; cursor: pointer; font-family: sans-serif; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; font-weight: bold;">
				Reset
			</button>
		</div>

	</div>
</div>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', () => {
		const rootStyles = getComputedStyle(document.documentElement);
		const colorGridContainer = document.getElementById('dynamic-color-grid');
		
		const tsSelect = document.getElementById('ts-select');
		const tsInput = document.getElementById('ts-input');
		const bsSelect = document.getElementById('bs-select');
		const bsInput = document.getElementById('bs-input');
		
		const toggleBtn = document.getElementById('theme-toggle-btn');
		const resetBtn = document.getElementById('theme-reset-btn');
		const copyBtn = document.getElementById('theme-copy-btn');
		const panelBody = document.getElementById('theme-panel-body');
		const canvasSelector = document.getElementById('canvas-theme-selector');

		// --- 0. EXCLUSIVE DESIGN-TOKEN FONT PARSER ENGINE ---
		function discoverAndPopulateFonts() {
			const discoveredFonts = new Set();
			const bannedFonts = ['sans-serif', 'serif', 'monospace', 'inherit', 'initial', 'unset'];

			try {
				Array.from(document.styleSheets).forEach(sheet => {
					try {
						const rules = sheet.cssRules || sheet.rules;
						if (!rules) return;
						
						Array.from(rules).forEach(rule => {
							if (rule.type === CSSRule.FONT_FACE_RULE) {
								let family = rule.style.getPropertyValue('font-family') || rule.style.fontFamily;
								if (family) {
									family = family.trim().replace(/['"]/g, ''); 
									if (family && !family.startsWith('var(') && !bannedFonts.includes(family.toLowerCase())) {
										discoveredFonts.add(family);
									}
								}
							}
							
							if (rule.type === CSSRule.IMPORT_RULE && rule.href) {
								if (rule.href.includes('fonts.googleapis.com')) {
									const urlParams = new URLSearchParams(rule.href.split('?')[1]);
									const families = urlParams.getAll('family');
									families.forEach(f => {
										const name = f.split(':')[0].replace(/_/g, ' ');
										if (name && !name.startsWith('var(') && !bannedFonts.includes(name.toLowerCase())) {
											discoveredFonts.add(name);
										}
									});
								}
							}
						});
					} catch(e) {}
				});
			} catch(e) {}

			const fontDropdowns = document.querySelectorAll('[data-font-select]');
			fontDropdowns.forEach(dropdown => {
				dropdown.innerHTML = ''; 
				discoveredFonts.forEach(fontName => {
					const opt = document.createElement('option');
					opt.value = `'${fontName}'`; 
					opt.textContent = fontName;
					dropdown.appendChild(opt);
				});
			});
		}

		discoverAndPopulateFonts();

		// --- 1. TAB SELECTION CONTROL ENGINE ---
		const tabButtons = document.querySelectorAll('.theme-tab-btn');
		const tabContents = document.querySelectorAll('.theme-tab-content');

		tabButtons.forEach(btn => {
			btn.addEventListener('click', () => {
				const targetTabId = btn.dataset.tabTarget;
				tabButtons.forEach(b => b.classList.remove('is-active'));
				tabContents.forEach(c => c.classList.add('is-hidden'));
				btn.classList.add('is-active');
				document.getElementById(targetTabId).classList.remove('is-hidden');
			});
		});

		// --- 2. DYNAMIC CSS VARIABLE EXTRACTION ENGINE ---
		function getRawThemeDeclarations() {
			const declarations = {
				'spacing' : 'max(calc(var(--scale-min) * 1rem), calc(var(--scale-fluid) * 1vw * var(--scale)))',
				'type-start-rem' : '1.5rem',
				'type-start-vw' : '1.5vw',
				'body-start-rem' : '0.714rem',
				'body-start-vw' : '0.714vw',
				'animation-duration' : '800ms',
				'animation-timing' : 'cubic-bezier(0.4, 0, 0.2, 1)',
				'animation-stagger' : '50ms',
				'animation-delay' : '0ms',
				'toggle-parallax' : '1', // ADDED DEFAULT FALLBACK
				'toggle-reveals' : '1',  // ADDED DEFAULT FALLBACK
				'img-radius' : '8px',
		        'radius' : '4px',
		        'btn-padding' : '0.5rem 1rem',
		        'btn-radius' : '4px',
		        'btn-border' : '1px'
			};

			try {
				Array.from(document.styleSheets).forEach(sheet => {
					try {
						Array.from(sheet.cssRules || sheet.rules).forEach(rule => {
							if (rule.selectorText === ':root') {
								const cssText = rule.cssText;
								const matches = cssText.match(/--[\w-]+:\s*[^;]+;/g);
								if (matches) {
									matches.forEach(match => {
										const parts = match.split(':');
										const propName = parts[0].trim().replace('--', '');
										const propValue = parts[1].replace(';', '').trim();
										declarations[propName] = propValue;
									});
								}
							}
						});
					} catch(e) {}
				});
			} catch(e) {}
			return declarations;
		}

		// --- 3. DYNAMIC GENERATION OF COLOR PICKER CONTROLS ---
		const initialDeclarations = getRawThemeDeclarations();
		Object.keys(initialDeclarations).forEach(token => {
			if (token.startsWith('color-')) {
				const labelName = token.replace('color-', '');
				const stylizedLabel = labelName.charAt(0).toUpperCase() + labelName.slice(1);
				
				const itemMarkup = document.createElement('div');
				itemMarkup.className = 'color-item';
				itemMarkup.innerHTML = `
					<label class="font__size__small op__4">${stylizedLabel}</label>
					<input type="color" name="${token}" data-theme-setup data-is-color>
				`;
				colorGridContainer.appendChild(itemMarkup);
			}
		});

		const themeControls = document.querySelectorAll('[data-theme-setup]');

		// --- 4. PANEL VISIBILITY & ICON STATE ENGINE ---
		toggleBtn.addEventListener('click', () => {
			const isHidden = panelBody.classList.toggle('is-hidden');
			toggleBtn.classList.toggle('is-open', !isHidden);
		});

		// --- 5. THEME CANVAS DOM MODIFIER ---
		canvasSelector.addEventListener('change', () => {
			if (canvasSelector.value === 'default') {
				document.documentElement.removeAttribute('theme');
			} else {
				document.documentElement.setAttribute('theme', canvasSelector.value);
			}
		});

		// --- 6. RENDER SYSTEM VALUES UNTO PANEL ---
		function syncUIWithCSS() {
			const activeStyles = getComputedStyle(document.documentElement);

			themeControls.forEach(control => {
				const propertyName = control.name;
				let cssValue = activeStyles.getPropertyValue(`--${propertyName}`).trim();

				if (control.hasAttribute('data-override')) {
					const inlineVal = document.documentElement.style.getPropertyValue(`--${propertyName}`).trim();
					control.value = inlineVal || '';
					return;
				}

				if (!cssValue) return;

				if (control.hasAttribute('data-is-color') && cssValue.startsWith('var(')) {
					const nestedProp = cssValue.replace(/^var\(--/, '').replace(/\)$/, '');
					cssValue = activeStyles.getPropertyValue(`--${nestedProp}`).trim();
				}

				if (control.dataset.unit) {
					cssValue = cssValue.replace(control.dataset.unit, '');
				}

				if (control.hasAttribute('data-is-color')) {
					if (cssValue.length === 4) {
						cssValue = '#' + cssValue[1] + cssValue[1] + cssValue[2] + cssValue[2] + cssValue[3] + cssValue[3];
					}
					control.value = cssValue;
				} else if (control.type === 'number') {
					control.value = cssValue ? parseFloat(cssValue) : '';
				} else if (control.tagName === 'SELECT') {
					const options = Array.from(control.options);
					const matchingOption = options.find(opt => 
						cssValue.toLowerCase().replace(/['"]/g, '') === opt.value.toLowerCase().replace(/['"]/g, '')
					);
					if (matchingOption) {
						control.value = matchingOption.value;
					} else if (propertyName === 'type-scale' || propertyName === 'body-scale') {
						control.value = 'custom';
					}
				} else {
					control.value = cssValue; 
				}
			});

			const activeTS = activeStyles.getPropertyValue('--type-scale').trim();
			if (activeTS) tsInput.value = parseFloat(activeTS);

			const activeBS = activeStyles.getPropertyValue('--body-scale').trim();
			if (activeBS) bsInput.value = parseFloat(activeBS);

			updateDynamicPlaceholders();
		}

		// --- 6b. DYNAMIC FLUID PLACEHOLDER ENGINE ---
		function updateDynamicPlaceholders() {
			const inlineStyles = document.documentElement.style;
			const computed = getComputedStyle(document.documentElement);

			const hScale = parseFloat(inlineStyles.getPropertyValue('--type-scale') || computed.getPropertyValue('--type-scale')) || 1.618;
			const hStartRem = parseFloat((inlineStyles.getPropertyValue('--type-start-rem') || computed.getPropertyValue('--type-start-rem') || '1.5').replace('rem', '')) || 1.5;
			const hStartVw = parseFloat((inlineStyles.getPropertyValue('--type-start-vw') || computed.getPropertyValue('--type-start-vw') || '1.5').replace('vw', '')) || 1.5;
			const baseLh = parseFloat(inlineStyles.getPropertyValue('--base-line-height') || computed.getPropertyValue('--base-line-height')) || 1.2;
			const fwHeading = (inlineStyles.getPropertyValue('--fw-heading') || computed.getPropertyValue('--fw-heading') || '700').trim();
			const lsHeading = (inlineStyles.getPropertyValue('--ls-heading') || computed.getPropertyValue('--ls-heading') || 'normal').trim();

			const bScale = parseFloat(inlineStyles.getPropertyValue('--body-scale') || computed.getPropertyValue('--body-scale')) || 1.4;
			const bStartRem = parseFloat((inlineStyles.getPropertyValue('--body-start-rem') || computed.getPropertyValue('--body-start-rem') || '0.714').replace('rem', '')) || 0.714;
			const bStartVw = parseFloat((inlineStyles.getPropertyValue('--body-start-vw') || computed.getPropertyValue('--body-start-vw') || '0.714').replace('vw', '')) || 0.714;
			const baseBodyLh = parseFloat(inlineStyles.getPropertyValue('--base-body-line-height') || computed.getPropertyValue('--base-body-line-height')) || 1.6;
			const fwBody = (inlineStyles.getPropertyValue('--fw-body') || computed.getPropertyValue('--fw-body') || '400').trim();
			const lsBody = (inlineStyles.getPropertyValue('--ls-body') || computed.getPropertyValue('--ls-body') || 'normal').trim();

			const formatSize = (rem, vw) => `max(${rem.toFixed(2)}rem, ${vw.toFixed(2)}vw)`;
			const formatLh = (val) => val.toFixed(2);

			// Heading levels
			const h5Rem = hStartRem;
			const h5Vw = hStartVw;
			const h5Lh = baseLh;

			const h4Rem = hStartRem * hScale;
			const h4Vw = hStartVw * hScale;
			const h4Lh = h5Lh - (0.04 * hScale);

			const h3Rem = hStartRem * Math.pow(hScale, 2);
			const h3Vw = hStartVw * Math.pow(hScale, 2);
			const h3Lh = h4Lh - (0.04 * hScale);

			const h2Rem = hStartRem * Math.pow(hScale, 3);
			const h2Vw = hStartVw * Math.pow(hScale, 3);
			const h2Lh = h3Lh - (0.04 * hScale);

			const h1Rem = hStartRem * Math.pow(hScale, 4);
			const h1Vw = hStartVw * Math.pow(hScale, 4);
			const h1Lh = h2Lh - (0.04 * hScale);

			// Body levels
			const capRem = bStartRem;
			const capVw = bStartVw;
			const capLh = baseBodyLh;

			const bodyRem = bStartRem * bScale;
			const bodyVw = bStartVw * bScale;
			const bodyLh = baseBodyLh - (0.04 * bScale);

			const perexRem = bStartRem * Math.pow(bScale, 2);
			const perexVw = bStartVw * Math.pow(bScale, 2);
			const perexLh = bodyLh - (0.04 * bScale);

			const placeholders = {
				'type-h1-size': formatSize(h1Rem, h1Vw),
				'type-h1-weight': fwHeading || '700',
				'type-h1-lh': formatLh(h1Lh),
				'type-h1-ls': lsHeading || 'normal',

				'type-h2-size': formatSize(h2Rem, h2Vw),
				'type-h2-weight': fwHeading || '700',
				'type-h2-lh': formatLh(h2Lh),
				'type-h2-ls': lsHeading || 'normal',

				'type-h3-size': formatSize(h3Rem, h3Vw),
				'type-h3-weight': '600',
				'type-h3-lh': formatLh(h3Lh),
				'type-h3-ls': lsHeading || 'normal',

				'type-h4-size': formatSize(h4Rem, h4Vw),
				'type-h4-weight': '500',
				'type-h4-lh': formatLh(h4Lh),
				'type-h4-ls': lsHeading || 'normal',

				'type-h5-size': formatSize(h5Rem, h5Vw),
				'type-h5-weight': '500',
				'type-h5-lh': formatLh(h5Lh),
				'type-h5-ls': lsHeading || 'normal',

				'type-perex-size': formatSize(perexRem, perexVw),
				'type-perex-weight': fwBody || '400',
				'type-perex-lh': formatLh(perexLh),
				'type-perex-opacity': '1',

				'type-body-size': formatSize(bodyRem, bodyVw),
				'type-body-weight': fwBody || '400',
				'type-body-lh': formatLh(bodyLh),
				'type-body-ls': lsBody || 'normal',

				'type-caption-size': formatSize(capRem, capVw),
				'type-caption-weight': '500',
				'type-caption-lh': formatLh(capLh),
				'type-caption-ls': lsBody || 'normal',
				'type-caption-opacity': '1'
			};

			Object.entries(placeholders).forEach(([name, val]) => {
				const input = document.querySelector(`input[name="${name}"]`);
				if (input) {
					input.placeholder = val;
				}
			});
		}

		syncUIWithCSS();

		// --- 7. LIVE CHANGES MUTATOR ENGINE ---
		function handleControlInput(event) {
			const element = event.target;
			const propertyName = element.name;
			let rawValue = element.value;
			let valueToApply;

			if (element.hasAttribute('data-is-color')) {
				valueToApply = rawValue;
			} else if (element.type === 'number') {
				const numericValue = rawValue !== '' ? parseFloat(rawValue) : '';
				const unit = element.dataset.unit || '';
				valueToApply = numericValue !== '' ? `${numericValue}${unit}` : '';
			} else {
				valueToApply = rawValue ? rawValue.trim() : '';
			}

			if (element === tsSelect && valueToApply === 'custom') return;
			if (element === bsSelect && valueToApply === 'custom') return;

			if (element === tsSelect) tsInput.value = valueToApply;
			if (element === bsSelect) bsInput.value = valueToApply;

			if (valueToApply === '' && element.hasAttribute('data-override')) {
				document.documentElement.style.removeProperty(`--${propertyName}`);
			} else if (valueToApply !== '') {
				document.documentElement.style.setProperty(`--${propertyName}`, valueToApply);
			}

			updateDynamicPlaceholders();
		}

		themeControls.forEach(control => {
			control.addEventListener('input', handleControlInput);
			control.addEventListener('change', handleControlInput);
		});

		// --- 8. TYPESCALE & BODYSCALE MANAGEMENT ---
		tsSelect.addEventListener('change', () => {
			if (tsSelect.value !== 'custom') {
				document.documentElement.style.setProperty('--type-scale', tsSelect.value);
				tsInput.value = tsSelect.value;
				updateDynamicPlaceholders();
			}
		});
		tsInput.addEventListener('input', () => {
			const val = tsInput.value ? parseFloat(tsInput.value) : 1.618;
			const match = Array.from(tsSelect.options).find(opt => parseFloat(opt.value) === val);
			tsSelect.value = match ? match.value : 'custom';
			document.documentElement.style.setProperty('--type-scale', val);
			updateDynamicPlaceholders();
		});

		bsSelect.addEventListener('change', () => {
			if (bsSelect.value !== 'custom') {
				document.documentElement.style.setProperty('--body-scale', bsSelect.value);
				bsInput.value = bsSelect.value;
				updateDynamicPlaceholders();
			}
		});
		bsInput.addEventListener('input', () => {
			const val = bsInput.value ? parseFloat(bsInput.value) : 1.400;
			const match = Array.from(bsSelect.options).find(opt => parseFloat(opt.value) === val);
			bsSelect.value = match ? match.value : 'custom';
			document.documentElement.style.setProperty('--body-scale', val);
			updateDynamicPlaceholders();
		});

		// --- 8b. SECTION CLEAR OVERRIDES ACTION ---
		const clearSectionBtns = document.querySelectorAll('.clear-section-btn');
		clearSectionBtns.forEach(btn => {
			btn.addEventListener('click', () => {
				const group = btn.dataset.clearGroup;
				const parentTab = group === 'headings' ? document.getElementById('tab-headings') : document.getElementById('tab-texts');
				if (parentTab) {
					const overrides = parentTab.querySelectorAll('[data-override]');
					overrides.forEach(ctrl => {
						ctrl.value = '';
						document.documentElement.style.removeProperty(`--${ctrl.name}`);
					});
				}
				updateDynamicPlaceholders();
			});
		});

		// --- 9. GLOBAL RESET ENGINE ACTION ---
		if (resetBtn) {
			resetBtn.addEventListener('click', () => {
				const rawTokens = getRawThemeDeclarations();
				Object.keys(rawTokens).forEach(tokenName => {
					document.documentElement.style.removeProperty(`--${tokenName}`);
				});
				const overrideControls = document.querySelectorAll('[data-override]');
				overrideControls.forEach(ctrl => {
					ctrl.value = '';
					document.documentElement.style.removeProperty(`--${ctrl.name}`);
				});
				document.documentElement.style.removeProperty('--type-scale');
				document.documentElement.style.removeProperty('--body-scale');
				canvasSelector.value = 'default';
				document.documentElement.removeAttribute('theme');
				syncUIWithCSS();
			});
		}

		// --- 10. SYNCHRONOUS FORM SUBMIT ENGINE ---
		const saveForm = document.getElementById('theme-save-form');
		const tokensInput = document.getElementById('css-tokens-input');

		if (saveForm && tokensInput) {
			saveForm.addEventListener('submit', (event) => {
				const inlineStyles = document.documentElement.style;
				const rawDeclarations = getRawThemeDeclarations();
				
				const groups = {
					overrides: [
						'type-h1-size', 'type-h1-weight', 'type-h1-lh', 'type-h1-ls', 'type-h1-transform',
						'type-h2-size', 'type-h2-weight', 'type-h2-lh', 'type-h2-ls', 'type-h2-transform',
						'type-h3-size', 'type-h3-weight', 'type-h3-lh', 'type-h3-ls', 'type-h3-transform',
						'type-h4-size', 'type-h4-weight', 'type-h4-lh', 'type-h4-ls', 'type-h4-transform',
						'type-h5-size', 'type-h5-weight', 'type-h5-lh', 'type-h5-ls', 'type-h5-transform',
						'type-perex-size', 'type-perex-weight', 'type-perex-lh', 'type-perex-ls', 'type-perex-opacity',
						'type-body-size', 'type-body-weight', 'type-body-lh', 'type-body-ls',
						'type-caption-size', 'type-caption-weight', 'type-caption-lh', 'type-caption-transform', 'type-caption-ls', 'type-caption-opacity'
					],
					typography: ['ff-heading', 'fw-heading', 'tt-heading', 'ls-heading', 'ff-body', 'fw-body', 'tt-body', 'ls-body', 'ff-mono'],
					scale: ['type-scale', 'type-start-rem', 'type-start-vw', 'base-line-height', 'body-scale', 'body-start-rem', 'body-start-vw', 'base-body-line-height'],
					spacing: ['scale-min', 'scale-fluid', 'scale', 'spacing'],
					animations: ['animation-duration', 'animation-delay', 'animation-stagger', 'animation-timing', 'toggle-parallax', 'toggle-reveals'],
					images: ['img-radius', 'radius'],
					buttons: ['btn-padding', 'btn-radius', 'btn-border'],
					colors: []
				};

				Object.keys(rawDeclarations).forEach(token => {
					if (token.startsWith('color-')) groups.colors.push(token);
				});

				let cssOutputString = "/**\n * Design Tokens Live Export\n * Saved via Kirby Theme Panel Component\n */\n\n:root {\n";

				function appendGroup(title, tokensList) {
					let clusterContent = "";
					tokensList.forEach(token => {
						let finalValue = inlineStyles.getPropertyValue(`--${token}`).trim();
						if (!finalValue && !groups.overrides.includes(token)) finalValue = rawDeclarations[token];
						if (finalValue) {
							const paddedToken = `--${token}:`.padEnd(26, ' ');
							clusterContent += `    ${paddedToken} ${finalValue};\n`;
						}
					});
					if (clusterContent) {
						cssOutputString += `    /* ==========================================================================\n`;
						cssOutputString += `       ${title.toUpperCase()} TOKENS\n`;
						cssOutputString += `       ========================================================================== */\n`;
						cssOutputString += clusterContent + "\n";
					}
				}

				appendGroup("Typography Variant Manual Overrides", groups.overrides);
				appendGroup("Typography Branding Framework", groups.typography);
				appendGroup("Fluid Responsive Scale Engine", groups.scale);
				appendGroup("Layout Padding & Grid Spacing", groups.spacing);
				appendGroup("Global Interactive Animations", groups.animations);
				appendGroup("Active Theme Palette Matrix", groups.colors);
				appendGroup("Image Styling", groups.images);
				appendGroup("Button Components", groups.buttons);

				cssOutputString = cssOutputString.trimEnd() + "\n}";

				tokensInput.value = cssOutputString;
			});
		}
	});
</script>