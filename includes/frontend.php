<div class="<?php $module->render_bta_class(); ?>">
	<?php

  for($i = 0; $i < count($settings->blocks); $i++) :

      if(!is_object($settings->blocks[$i])) {
          continue;
      }
      else {
          $block = $settings->blocks[$i];
      }

  ?>
	<div class="<?php $module->render_block_class( $i ); ?>">
		<<?php echo $settings->desktop_title_tag; ?>><span class="block-title"><?php echo $block->title; ?></span></<?php echo $settings->desktop_title_tag; ?>>
		<div class="block-content">
			<?php echo $block->content; ?>
		</div>
	</div>
	<?php endfor; ?>
	<div class="fl-clear"></div>
</div>
