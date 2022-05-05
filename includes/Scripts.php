<?php

namespace DevTools;

class Scripts {
	public function init() {
		add_action( 'wp_body_open', [ $this, 'body_open' ], 10, 0 );
		add_action( 'in_admin_header', [ $this, 'body_open' ], 10, 0 );
	}

	public function body_open() {
		?>
		<script>
			var gdev = window.gdev || {};
			gdev.theme = {
				androidColorMeta: document.querySelector('meta[name=theme-color]'),
				osSchemeDark: window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches,
				setting: window.localStorage.getItem('gdev_theme') || 'system',
				inRange: (x, min, max) => ((x - min) * (x - max) <= 0)
			};
			if (gdev.theme.osSchemeDark && gdev.theme.setting === 'system' || gdev.theme.setting === 'dark') {
				<?php echo 'document.body.classList.add(\'gdev-dark-theme\'); gdev.theme.androidColorMeta ? gdev.theme.androidColorMeta.setAttribute(\'content\', \'#22272b\') : \'\''; ?>
			}
		</script>
		<?php
	}
}
