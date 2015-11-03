<?php
// Vars
$desktop_item_width = ($settings->desktop_item_spacing) ? $settings->desktop_item_width - $settings->desktop_item_spacing : $settings->desktop_item_width;
$desktop_item_spacing = ($settings->desktop_item_width != '100') ? $settings->desktop_item_spacing : 0;

$tablet_item_width = $desktop_item_width;
$tablet_item_spacing = $desktop_item_spacing;

$margin_left = ($settings->margin_left) ? $settings->margin_left : $global_settings->module_margins;
$margin_right = ($settings->margin_right) ? $settings->margin_right : $global_settings->module_margins;

if($settings->tablet_toggle_item_spacing || $settings->tablet_toggle_item_width) {
	if($settings->tablet_toggle_item_spacing) {
		$tablet_item_width = $desktop_item_width - $settings->tablet_item_spacing;
		$tablet_item_spacing = $settings->tablet_item_spacing;
	}

	if($settings->tablet_toggle_item_width) {
		$tablet_item_width = $settings->tablet_item_width - $desktop_item_spacing;
		$tablet_item_spacing = $desktop_item_spacing;
	}

	if($settings->tablet_toggle_item_spacing && $settings->tablet_toggle_item_width) {
		$tablet_item_width = $settings->tablet_item_width - $settings->tablet_item_spacing;
		$tablet_item_spacing = $settings->tablet_item_spacing;
	}
}


// Accordion
if($settings->accordion_width) { ?>
.fl-node-<?php echo $id; ?> .ui-accordion {
	margin-left: -<?php echo $margin_left; ?>px;
	margin-right: -<?php echo $margin_right; ?>px;
}
.fl-node-<?php echo $id; ?> .ui-accordion .ui-accordion-header,
.fl-node-<?php echo $id; ?> .ui-accordion .ui-accordion-content {
	padding-left: <?php echo $margin_left; ?>px;
	padding-right: <?php echo $margin_left; ?>px;
}
.fl-node-<?php echo $id; ?> .icon-right .ui-accordion-header .ui-accordion-header-icon {
	padding-right: <?php echo $margin_left; ?>px;
}
<?php } ?>
.fl-node-<?php echo $id; ?> .blocks-to-accordion .ui-accordion-header {
	background: <?php echo ($settings->accordion_background) ? '#'.$settings->accordion_background : 'transparent'; ?>;
	<?php if($settings->accordion_border_type) { ?>
  	border-style: <?php echo $settings->accordion_border_type; ?>;
    border-color: #<?php echo $settings->accordion_border_color; ?>;
    border-color: rgba(<?php echo implode(',', FLBuilderColor::hex_to_rgb($settings->accordion_border_color)) ?>, <?php echo $settings->accordion_border_opacity/100; ?>);
    border-top-width: <?php echo is_numeric($settings->accordion_border_top) ? $settings->accordion_border_top : '0'; ?>px;
    border-bottom-width: <?php echo is_numeric($settings->accordion_border_bottom) ? $settings->accordion_border_bottom : '0'; ?>px;
    border-left-width: <?php echo is_numeric($settings->accordion_border_left) ? $settings->accordion_border_left : '0'; ?>px;
    border-right-width: <?php echo is_numeric($settings->accordion_border_right) ? $settings->accordion_border_right : '0'; ?>px;
	<?php } ?>
	color: #<?php echo $settings->accordion_font_color; ?>;
	font-size: <?php echo $settings->accordion_heading_font_size; ?>px;
	<?php /* height: <?php echo $settings->accordion_heading_height; ?>px; */ ?>
	line-height: <?php echo $settings->accordion_heading_height; ?>px;
}
.fl-node-<?php echo $id; ?> .blocks-to-accordion .ui-accordion-header-active {
	background: #<?php echo $settings->accordion_open_background; ?>;
	<?php if($settings->accordion_border_type) { ?>
	border-color: #<?php echo $settings->accordion_open_border; ?>;
	<?php } ?>
	color: #<?php echo $settings->accordion_open_font_color; ?>;
}
.fl-node-<?php echo $id; ?> .blocks-to-accordion .ui-icon {
	color: #<?php echo $settings->accordion_icon_color; ?>;
}
.fl-node-<?php echo $id; ?> .blocks-to-accordion .ui-accordion-header-active .ui-icon {
	color: #<?php echo $settings->accordion_open_icon_color; ?>;
}

<?php
// Tablet
if($settings->tablet_toggle_item_width || $settings->tablet_toggle_border || $settings->desktop_border_type || $settings->tablet_toggle_item_spacing || $settings->tablet_show_title == 0) { ?>

  @media only screen and (min-width: <?php echo $global_settings->responsive_breakpoint; ?>px) and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {

		.fl-node-<?php echo $id; ?> .blocks-to-accordion .block {

		  <?php if($settings->tablet_toggle_border) { ?>
	  	border-style: <?php echo $settings->tablet_border_type; ?>;
	    border-color: #<?php echo $settings->tablet_border_color; ?>;
	    border-color: rgba(<?php echo implode(',', FLBuilderColor::hex_to_rgb($settings->tablet_border_color)) ?>, <?php echo $settings->tablet_border_opacity/100; ?>);
	    border-top-width: <?php echo is_numeric($settings->tablet_border_top) ? $settings->tablet_border_top : '0'; ?>px;
	    border-bottom-width: <?php echo is_numeric($settings->tablet_border_bottom) ? $settings->tablet_border_bottom : '0'; ?>px;
	    border-left-width: <?php echo is_numeric($settings->tablet_border_left) ? $settings->tablet_border_left : '0'; ?>px;
	    border-right-width: <?php echo is_numeric($settings->tablet_border_right) ? $settings->tablet_border_right : '0'; ?>px;
			<?php }elseif($settings->desktop_border_type) { ?>
			border-style: <?php echo $settings->desktop_border_type; ?>;
		  border-color: #<?php echo $settings->desktop_border_color; ?>;
		  border-color: rgba(<?php echo implode(',', FLBuilderColor::hex_to_rgb($settings->desktop_border_color)) ?>, <?php echo $settings->desktop_border_opacity/100; ?>);
		  border-top-width: <?php echo is_numeric($settings->desktop_border_top) ? $settings->desktop_border_top : '0'; ?>px;
		  border-bottom-width: <?php echo is_numeric($settings->desktop_border_bottom) ? $settings->desktop_border_bottom : '0'; ?>px;
		  border-left-width: <?php echo is_numeric($settings->desktop_border_left) ? $settings->desktop_border_left : '0'; ?>px;
		  border-right-width: <?php echo is_numeric($settings->desktop_border_right) ? $settings->desktop_border_right : '0'; ?>px;
			<?php } ?>

			<?php if($settings->tablet_toggle_item_width || $settings->tablet_toggle_item_spacing || $settings->tablet_toggle_padding) { ?>
				margin-left: <?php echo $tablet_item_spacing; ?>%;
				padding-top: <?php echo is_numeric($settings->tablet_padding_top) ? $settings->tablet_padding_top : '0'; ?>px;
				padding-right: <?php echo is_numeric($settings->tablet_padding_right) ? $settings->tablet_padding_right : '0'; ?>px;
				padding-bottom: <?php echo is_numeric($settings->tablet_padding_bottom) ? $settings->tablet_padding_bottom : '0'; ?>px;
				padding-left: <?php echo is_numeric($settings->tablet_padding_left) ? $settings->tablet_padding_left : '0'; ?>px;
				width: <?php echo $tablet_item_width; ?>%;
			<?php } ?>
		}

		.fl-node-<?php echo $id; ?> .blocks-to-accordion .block <?php echo $settings->desktop_title_tag; ?> {
			color: #<?php echo $settings->desktop_title_color; ?>;
			<?php if($settings->tablet_show_title == 0) { ?>
			display: none;
			<?php } ?>
		}

	  .fl-node-<?php echo $id; ?> .blocks-to-accordion .desktop-first {
	   	clear: none;
	   	margin-left: <?php echo $tablet_item_spacing; ?>%;
	  }
	  .fl-node-<?php echo $id; ?> .blocks-to-accordion .tablet-first {
	  	clear: left;
	  	margin-left: 0;
	  }
	}
<?php }

// Desktop
?>
@media (min-width: <?php echo $global_settings->medium_breakpoint + 1; ?>px) {

	.fl-node-<?php echo $id; ?> .blocks-to-accordion .block {

		<?php if($desktop_item_width != '100') echo 'width: '.$desktop_item_width.'%;'; ?>

		<?php if($settings->desktop_border_type) { ?>
		border-style: <?php echo $settings->desktop_border_type; ?>;
	  border-color: #<?php echo $settings->desktop_border_color; ?>;
	  border-color: rgba(<?php echo implode(',', FLBuilderColor::hex_to_rgb($settings->desktop_border_color)) ?>, <?php echo $settings->desktop_border_opacity/100; ?>);
	  border-top-width: <?php echo is_numeric($settings->desktop_border_top) ? $settings->desktop_border_top : '0'; ?>px;
	  border-bottom-width: <?php echo is_numeric($settings->desktop_border_bottom) ? $settings->desktop_border_bottom : '0'; ?>px;
	  border-left-width: <?php echo is_numeric($settings->desktop_border_left) ? $settings->desktop_border_left : '0'; ?>px;
	  border-right-width: <?php echo is_numeric($settings->desktop_border_right) ? $settings->desktop_border_right : '0'; ?>px;
		<?php } ?>

		margin-left: <?php echo $desktop_item_spacing; ?>%;
		padding-top: <?php echo is_numeric($settings->desktop_padding_top) ? $settings->desktop_padding_top : '0'; ?>px;
		padding-right: <?php echo is_numeric($settings->desktop_padding_right) ? $settings->desktop_padding_right : '0'; ?>px;
		padding-bottom: <?php echo is_numeric($settings->desktop_padding_bottom) ? $settings->desktop_padding_bottom : '0'; ?>px;
		padding-left: <?php echo is_numeric($settings->desktop_padding_left) ? $settings->desktop_padding_left : '0'; ?>px;
	}

	.fl-node-<?php echo $id; ?> .blocks-to-accordion .block.first {
		border-top: 0;
		padding-top: 0;
	}
	.fl-node-<?php echo $id; ?> .blocks-to-accordion .block.last {
		border-bottom: 0;
		padding-bottom: 0;
	}

	.fl-node-<?php echo $id; ?> .blocks-to-accordion .block <?php echo $settings->desktop_title_tag; ?> {
		color: #<?php echo $settings->desktop_title_color; ?>;
		<?php if($settings->desktop_show_title == 0) { ?>
		display: none;
		<?php } ?>
	}

	.fl-node-<?php echo $id; ?> .blocks-to-accordion .desktop-first {
		margin-left: 0;
	}
}
