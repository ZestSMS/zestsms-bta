<?php 
$global_settings = FLBuilderModel::get_global_settings();
$container = '.fl-node-'.$id.' .blocks-to-accordion';
$title_tag = $settings->desktop_title_tag;
?>

(function($){
	var args = {
		header: '> .block > <?php echo $title_tag; ?>',
		heightStyle: "content",
		collapsible: true,
		active: false,
		icons: {
			activeHeader: '<?php echo $settings->accordion_open_icon; ?>',
			header: '<?php echo $settings->accordion_icon; ?>'
		}
	}

	$("<?php echo $container; ?>").accordion(args);

	ssm.addState({
		id: 'desktop',
		minWidth: <?php echo $global_settings->responsive_breakpoint + 1; ?>,
		onEnter: function(){
			$("<?php echo $container; ?>").accordion('destroy');
		},
		onLeave: function(){
			$("<?php echo $container; ?>").accordion(args);
		}
	});
	ssm.ready();

	
	$("<?php echo $container; ?>").on("accordioncreate", function(event, ui){
		if(ssm.isActive('desktop')){
			$("<?php echo $container; ?>").accordion('destroy');
		}
	});
})(jQuery);
