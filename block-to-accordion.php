<?php
/*
Plugin Name: Blocks to Accordion
Plugin URI: https://zestsms.com
Description: Add a Beaver Builder module which turns blocks into an accordion at mobile.
Version: 1.0
Author: ZestSMS
Author URI: https://zestsms.com
*/

if (!defined('ABSPATH')) {
  exit;
}

add_action( 'init', 'load_zestsms_bta_module' );
function load_zestsms_bta_module() {
  if ( class_exists( 'FLBuilder' ) ) {

    class ZestSMSBTAModule extends FLBuilderModule {
        public function __construct() {
            parent::__construct(array(
                'name'          => __('Blocks to Accordion', 'fl-builder'),
                'description'   => __('Blocks that turn to accordions for mobile', 'fl-builder'),
                'category'		=> __('Advanced Modules', 'fl-builder'),
                'dir'           => plugin_dir_path( __FILE__ ),
                'url'           => plugins_url( '/', __FILE__ )
            ));

            // Already registered
            $this->add_js('jquery-ui-accordion');

            // Register
            $this->add_js('ssm', $this->url . 'js/ssm.min.js', array(), '', true);

        }

        public function render_bta_class() {
          $bta_class = 'blocks-to-accordion icon-'. $this->settings->accordion_icon_location;
          if($this->settings->accordion_width) $bta_class .= ' accordion-full';

          echo $bta_class;
        }

        public function render_block_class( $i ) {
          $block_class = 'block';
          if($i == 0) $block_class .= ' first';
  		    if($i == (count($this->settings->blocks) - 1)) $block_class .= ' last';

  		    if($this->settings->desktop_item_width != '100') {
  		    	$desktop_counter = ceil($i * $this->settings->desktop_item_width);
  		    	$block_class .= ($desktop_counter % 100 == 0) ? ' desktop-first' : '';
  		    }

  		    if($this->settings->tablet_toggle_item_width && $this->settings->tablet_item_width != '100') {
  		    	$tablet_counter = ceil($i * $this->settings->tablet_item_width);
  		    	$block_class .= ($tablet_counter % 100 == 0) ? ' tablet-first' : '';
  		    }

          echo $block_class;
        }
    }

    FLBuilder::register_module('ZestSMSBTAModule', array(
        'content'      => array( // Tab
            'title'         => __('Content', 'fl-builder'), // Tab title
            'sections'      => array( // Tab Sections
                'general'       => array( // Section
                    'title'         => __('Content', 'fl-builder'), // Section Title
                    'fields'        => array( // Section Fields
                        'blocks'          => array(
                            'type'          => 'form',
                            'label'         => __('Block', 'fl-builder'),
                            'form'          => 'bta_content', // ID from registered form below
                            'preview_text'  => 'title', // Name of a field to use for the preview text
                            'multiple'      => true // Doesn't work with editor or photo fields
                        )
                    )
                )
            )
        ),
        'desktop'       => array( // Tab
            'title'         => __('Desktop', 'fl-builder'), // Tab title
            'sections'      => array( // Tab Sections
                'desktop_title'          => array(
                    'title'         => __('Title', 'fl-builder'),
                    'fields'        => array(
                        'desktop_title_tag'          => array(
                            'type'          => 'select',
                            'label'         => __('Title Tag', 'fl-builder'),
                            'default'       => 'h3',
                            'options'       => array(
                                'h1'            => __('H1', 'fl-builder'),
                                'h2'            => __('H2', 'fl-builder'),
                                'h3'            => __('H3', 'fl-builder'),
                                'h4'            => __('H4', 'fl-builder'),
                                'h5'            => __('H5', 'fl-builder'),
                                'h6'            => __('H6', 'fl-builder'),
                            )
                        ),
                        'desktop_show_title'         => array(
                            'type'          => 'select',
                            'label'         => __('Show Title'),
                            'default'       => '1',
                            'options'       => array(
                                '0'             => __('No', 'fl-builder'),
                                '1'             => __('Yes', 'fl-builder')
                            )
                        ),
                        'desktop_title_color'           => array(
                            'type'          => 'color',
                            'label'         => __('Title Color', 'fl-builder'),
                            'default'       => '000000',
                        )
                    )
                ),
                'desktop_column_settings'       => array( // Section
                    'title'         => __('Columns', 'fl-builder'), // Section Title
                    'fields'        => array( // Section Fields
                        'desktop_item_width'     => array(
                            'type'          => 'select',
                            'label'         => __('Item Width', 'fl-builder'),
                            'default'       => 'Full',
                            'options'       => array(
                                '100'      => __('Full', 'fl-builder'),
                                '50'      => __('1 / 2', 'fl-builder'),
                                '33.33'      => __('1 / 3', 'fl-builder'),
                                '25'      => __('1 / 4', 'fl-builder'),
                                '20'      => __('1 / 5', 'fl-builder')
                            ),
                            'toggle'        => array(
                                '100'           => array(
                                    'fields'        => array()
                                ),
                                '50'                => array(
                                    'fields'        => array('desktop_item_spacing')
                                ),
                                '33.33'                => array(
                                    'fields'        => array('desktop_item_spacing')
                                ),
                                '25'                => array(
                                    'fields'        => array('desktop_item_spacing')
                                ),
                                '20'                => array(
                                    'fields'        => array('desktop_item_spacing')
                                )
                            )
                        ),
                        'desktop_item_spacing'      => array(
                            'type'          => 'text',
                            'label'         => __('Item Spacing', 'fl-builder'),
                            'default'       => '2',
                            'description'   => '%',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        )
                    )
                ),
                'desktop_spacing'       => array(
                    'title'         => __('Padding',' fl-builder'),
                    'fields'        => array(
                        'desktop_padding_top'   => array(
                            'type'          => 'text',
                            'label'         => __('Padding Top', 'fl-builder'),
                            'placeholder'   => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'css',
                                'selector'        => '.block',
                                'property'        => 'padding-top',
                                'unit'            => 'px'
                            )
                        ),
                        'desktop_padding_bottom'   => array(
                            'type'          => 'text',
                            'label'         => __('Padding Bottom', 'fl-builder'),
                            'placeholder'   => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'css',
                                'selector'        => '.block',
                                'property'        => 'padding-bottom',
                                'unit'            => 'px'
                            )
                        ),
                        'desktop_padding_left'   => array(
                            'type'          => 'text',
                            'label'         => __('Padding Left', 'fl-builder'),
                            'placeholder'   => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'css',
                                'selector'        => '.block',
                                'property'        => 'padding-left',
                                'unit'            => 'px'
                            )
                        ),
                        'desktop_padding_right'   => array(
                            'type'          => 'text',
                            'label'         => __('Padding Right', 'fl-builder'),
                            'placeholder'   => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'css',
                                'selector'        => '.block',
                                'property'        => 'padding-right',
                                'unit'            => 'px'
                            )
                        )
                    )
                ),
                'desktop_borders'        => array(
                    'title'         => __('Border', 'fl-builder'),
                    'fields'        => array(
                        'desktop_border_type'   => array(
                            'type'          => 'select',
                            'label'         => __('Border Type', 'fl-builder'),
                            'default'       => '',
                            'help'          => __('The type of border to use. Double borders must have a width of at least 3px to render properly.', 'fl-builder'),
                            'options'       => array(
                                ''              => _x( 'None', 'Border type.', 'fl-builder' ),
                                'solid'         => _x( 'Solid', 'Border type.', 'fl-builder' ),
                                'dashed'        => _x( 'Dashed', 'Border type.', 'fl-builder' ),
                                'dotted'        => _x( 'Dotted', 'Border type.', 'fl-builder' ),
                                'double'        => _x( 'Double', 'Border type.', 'fl-builder' )
                            ),
                            'toggle'        => array(
                                ''              => array(
                                    'fields'        => array()
                                ),
                                'solid'         => array(
                                    'fields'        => array('desktop_border_color', 'desktop_border_opacity', 'desktop_border_top', 'desktop_border_bottom', 'desktop_border_left', 'desktop_border_right')
                                ),
                                'dashed'        => array(
                                    'fields'        => array('desktop_border_color', 'desktop_border_opacity', 'desktop_border_top', 'desktop_border_bottom', 'desktop_border_left', 'desktop_border_right')
                                ),
                                'dotted'        => array(
                                    'fields'        => array('desktop_border_color', 'desktop_border_opacity', 'desktop_border_top', 'desktop_border_bottom', 'desktop_border_left', 'desktop_border_right')
                                ),
                                'double'        => array(
                                    'fields'        => array('desktop_border_color', 'desktop_border_opacity', 'desktop_border_top', 'desktop_border_bottom', 'desktop_border_left', 'desktop_border_right')
                                )
                            ),
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'desktop_border_color'  => array(
                            'type'          => 'color',
                            'label'         => __('Color', 'fl-builder'),
                            'show_reset'    => true,
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'desktop_border_opacity' => array(
                            'type'          => 'text',
                            'label'         => __('Opacity', 'fl-builder'),
                            'default'       => '100',
                            'description'   => '%',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'desktop_border_top'    => array(
                            'type'          => 'text',
                            'label'         => __('Top Width', 'fl-builder'),
                            'default'       => '1',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'desktop_border_bottom' => array(
                            'type'          => 'text',
                            'label'         => __('Bottom Width', 'fl-builder'),
                            'default'       => '1',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'desktop_border_left'   => array(
                            'type'          => 'text',
                            'label'         => __('Left Width', 'fl-builder'),
                            'default'       => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'desktop_border_right'  => array(
                            'type'          => 'text',
                            'label'         => __('Right Width', 'fl-builder'),
                            'default'       => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        )
                    )
                )
            )
        ),
        'tablet'       => array( // Tab
            'title'         => __('Tablet', 'fl-builder'), // Tab title
            'sections'      => array( // Tab Sections
                'tablet_title'          => array(
                    'title'         => __('Title', 'fl-builder'),
                    'fields'        => array(
                        'tablet_show_title'         => array(
                            'type'          => 'select',
                            'label'         => __('Show Title'),
                            'default'       => '1',
                            'options'       => array(
                                '0'             => __('No', 'fl-builder'),
                                '1'             => __('Yes', 'fl-builder')
                            )
                        )
                    )
                ),
                'tablet_column_settings'       => array( // Section
                    'title'         => __('Columns', 'fl-builder'), // Section Title
                    'fields'        => array( // Section Fields
                        'tablet_toggle_item_width'      => array(
                            'type'          => 'select',
                            'label'         => __('Change Item Width', 'fl-builder'),
                            'default'       => 0,
                            'options'       => array(
                                '0' => 'No',
                                '1' => 'Yes'
                            ),
                            'toggle'        => array(
                                '1'             => array(
                                    'fields'            => array('tablet_item_width')
                                )
                            )
                        ),
                        'tablet_item_width'     => array(
                            'type'          => 'select',
                            'label'         => __('Item Width', 'fl-builder'),
                            'default'       => 'Full',
                            'options'       => array(
                                '100'      => __('Full', 'fl-builder'),
                                '50'      => __('1 / 2', 'fl-builder'),
                                '33.33'      => __('1 / 3', 'fl-builder'),
                                '25'      => __('1 / 4', 'fl-builder'),
                                '20'      => __('1 / 5', 'fl-builder')
                            )
                        ),
                        'tablet_toggle_item_spacing'      => array(
                            'type'          => 'select',
                            'label'         => __('Change Item Spacing', 'fl-builder'),
                            'default'       => 0,
                            'options'       => array(
                                '0' => 'No',
                                '1' => 'Yes'
                            ),
                            'toggle'        => array(
                                '1'             => array(
                                    'fields'            => array('tablet_item_spacing')
                                )
                            )
                        ),
                        'tablet_item_spacing'      => array(
                            'type'          => 'text',
                            'label'         => __('Item Spacing', 'fl-builder'),
                            'default'       => '2',
                            'description'   => '%',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        )
                    )
                ),
                'tablet_padding'        => array(
                    'title'         => __('Padding', 'fl-builder'),
                    'fields'        => array(
                        'tablet_toggle_padding'     => array(
                            'type'          => 'select',
                            'label'         => __('Change Padding', 'fl-builder'),
                            'default'       => 0,
                            'options'       => array(
                                '0' => __('No', 'fl-builder'),
                                '1' => __('Yes', 'fl-builder')
                            ),
                            'toggle'        => array(
                                '1'             => array(
                                    'fields'        => array('tablet_padding_top','tablet_padding_bottom','tablet_padding_left','tablet_padding_right')
                                )
                            )
                        ),
                        'tablet_padding_top'   => array(
                            'type'          => 'text',
                            'label'         => __('Padding Top', 'fl-builder'),
                            'default'       => '',
                            'placeholder'   => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_padding_bottom'   => array(
                            'type'          => 'text',
                            'label'         => __('Padding Bottom', 'fl-builder'),
                            'default'       => '',
                            'placeholder'   => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_padding_left'   => array(
                            'type'          => 'text',
                            'label'         => __('Padding Left', 'fl-builder'),
                            'default'       => '',
                            'placeholder'   => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_padding_right'   => array(
                            'type'          => 'text',
                            'label'         => __('Padding Right', 'fl-builder'),
                            'default'       => '',
                            'placeholder'   => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        )
                    )
                ),
                'tablet_borders'        => array(
                    'title'         => __('Border', 'fl-builder'),
                    'fields'        => array(
                        'tablet_toggle_border'      => array(
                            'type'          => 'select',
                            'label'         => __('Change Border', 'fl-builder'),
                            'default'       => 0,
                            'options'       => array(
                                '0' => __('No', 'fl-builder'),
                                '1' => __('Yes', 'fl-builder')
                            ),
                            'toggle'        => array(
                                '1'             => array(
                                    'fields'            => array('tablet_border_type')
                                )
                            )
                        ),
                        'tablet_border_type'       => array(
                            'type'          => 'select',
                            'label'         => __('Border Type', 'fl-builder'),
                            'default'       => '',
                            'help'          => __('The type of border to use. Double borders must have a width of at least 3px to render properly.', 'fl-builder'),
                            'options'       => array(
                                ''              => _x( 'None', 'Border type.', 'fl-builder' ),
                                'solid'         => _x( 'Solid', 'Border type.', 'fl-builder' ),
                                'dashed'        => _x( 'Dashed', 'Border type.', 'fl-builder' ),
                                'dotted'        => _x( 'Dotted', 'Border type.', 'fl-builder' ),
                                'double'        => _x( 'Double', 'Border type.', 'fl-builder' )
                            ),
                            'toggle'        => array(
                                ''              => array(
                                    'fields'        => array()
                                ),
                                'solid'         => array(
                                    'fields'        => array('tablet_border_color', 'tablet_border_opacity', 'tablet_border_top', 'tablet_border_bottom', 'tablet_border_left', 'tablet_border_right')
                                ),
                                'dashed'        => array(
                                    'fields'        => array('tablet_border_color', 'tablet_border_opacity', 'tablet_border_top', 'tablet_border_bottom', 'tablet_border_left', 'tablet_border_right')
                                ),
                                'dotted'        => array(
                                    'fields'        => array('tablet_border_color', 'tablet_border_opacity', 'tablet_border_top', 'tablet_border_bottom', 'tablet_border_left', 'tablet_border_right')
                                ),
                                'double'        => array(
                                    'fields'        => array('tablet_border_color', 'tablet_border_opacity', 'tablet_border_top', 'tablet_border_bottom', 'tablet_border_left', 'tablet_border_right')
                                )
                            ),
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_border_color'  => array(
                            'type'          => 'color',
                            'label'         => __('Color', 'fl-builder'),
                            'show_reset'    => true,
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_border_opacity' => array(
                            'type'          => 'text',
                            'label'         => __('Opacity', 'fl-builder'),
                            'default'       => '100',
                            'description'   => '%',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_border_top'    => array(
                            'type'          => 'text',
                            'label'         => __('Top Width', 'fl-builder'),
                            'default'       => '1',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_border_bottom' => array(
                            'type'          => 'text',
                            'label'         => __('Bottom Width', 'fl-builder'),
                            'default'       => '1',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_border_left'   => array(
                            'type'          => 'text',
                            'label'         => __('Left Width', 'fl-builder'),
                            'default'       => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'tablet_border_right'  => array(
                            'type'          => 'text',
                            'label'         => __('Right Width', 'fl-builder'),
                            'default'       => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        )
                    )
                )
            )
        ),
        'accordion'    => array( // Tab
            'title'         => __('Accordion', 'fl-builder'), // Tab Title
            'sections'      => array(
                'defaults'             => array(
                    'title'             => '',
                    'fields'            => array(
                        'accordion_width'           => array(
                            'type'             => 'select',
                            'label'            => __('Full Width', 'fl-builder'),
                            'default'          => 1,
                            'options'          => array(
                                '0'             => __('No', 'fl-builder'),
                                '1'             => __('Yes', 'fl-builder')
                            ),
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_heading_font_size'       => array(
                            'type'          => 'text',
                            'label'         => __('Heading Font Size', 'fl-builder'),
                            'default'       => '16',
                            'maxlength'     => '3',
                            'size'          => '4',
                            'description'   => 'px',
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_heading_height'          => array(
                            'type'          => 'text',
                            'label'         => __('Heading Height', 'fl-builder'),
                            'default'       => '22',
                            'maxlength'     => '3',
                            'size'          => '4',
                            'description'   => 'px',
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_icon_location'         => array(
                          'type'          => 'select',
                          'label'         => __('Icon Location', 'zestsms'),
                          'default'       => 'right',
                          'options'       => array(
                            'left'          => __('Left', 'zestsms'),
                            'right'          => __('Right', 'zestsms')
                          )
                        )
                    )
                ),
                'accordion_closed'          => array(
                    'title'             => __('Accordion Closed'),
                    'fields'            => array(
                        'accordion_font_color'      => array(
                            'type'             => 'color',
                            'label'            => __('Heading Text Color', 'fl-builder'),
                            'default'          => '333333',
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_icon'            => array(
                            'type'             => 'icon',
                            'label'            => __('Icon', 'fl-builder'),
                            'default'          => 'fa-angle-down',
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_icon_color'      => array(
                            'type'             => 'color',
                            'label'            => __('Icon Color'),
                            'default'          => '333333',
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_background'      => array(
                            'type'             => 'color',
                            'label'            => __('Background Color', 'fl-builder'),
                            'show_reset'       => true,
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_border_type'   => array(
                            'type'          => 'select',
                            'label'         => __('Border Type', 'fl-builder'),
                            'default'       => '',
                            'help'          => __('The type of border to use. Double borders must have a width of at least 3px to render properly.', 'fl-builder'),
                            'options'       => array(
                                ''              => _x( 'None', 'Border type.', 'fl-builder' ),
                                'solid'         => _x( 'Solid', 'Border type.', 'fl-builder' ),
                                'dashed'        => _x( 'Dashed', 'Border type.', 'fl-builder' ),
                                'dotted'        => _x( 'Dotted', 'Border type.', 'fl-builder' ),
                                'double'        => _x( 'Double', 'Border type.', 'fl-builder' )
                            ),
                            'toggle'        => array(
                                ''              => array(
                                    'fields'        => array()
                                ),
                                'solid'         => array(
                                    'fields'        => array('accordion_open_border','accordion_border_color', 'accordion_border_opacity', 'accordion_border_top', 'accordion_border_bottom', 'accordion_border_left', 'accordion_border_right')
                                ),
                                'dashed'        => array(
                                    'fields'        => array('accordion_open_border','accordion_border_color', 'accordion_border_opacity', 'accordion_border_top', 'accordion_border_bottom', 'accordion_border_left', 'accordion_border_right')
                                ),
                                'dotted'        => array(
                                    'fields'        => array('accordion_open_border','accordion_border_color', 'accordion_border_opacity', 'accordion_border_top', 'accordion_border_bottom', 'accordion_border_left', 'accordion_border_right')
                                ),
                                'double'        => array(
                                    'fields'        => array('accordion_open_border','accordion_border_color', 'accordion_border_opacity', 'accordion_border_top', 'accordion_border_bottom', 'accordion_border_left', 'accordion_border_right')
                                )
                            ),
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'accordion_border_color'  => array(
                            'type'          => 'color',
                            'label'         => __('Color', 'fl-builder'),
                            'show_reset'    => true,
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'accordion_border_opacity' => array(
                            'type'          => 'text',
                            'label'         => __('Opacity', 'fl-builder'),
                            'default'       => '100',
                            'description'   => '%',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'accordion_border_top'    => array(
                            'type'          => 'text',
                            'label'         => __('Top Width', 'fl-builder'),
                            'default'       => '1',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'accordion_border_bottom' => array(
                            'type'          => 'text',
                            'label'         => __('Bottom Width', 'fl-builder'),
                            'default'       => '1',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'accordion_border_left'   => array(
                            'type'          => 'text',
                            'label'         => __('Left Width', 'fl-builder'),
                            'default'       => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        ),
                        'accordion_border_right'  => array(
                            'type'          => 'text',
                            'label'         => __('Right Width', 'fl-builder'),
                            'default'       => '0',
                            'description'   => 'px',
                            'maxlength'     => '3',
                            'size'          => '5',
                            'placeholder'   => '0',
                            'preview'         => array(
                                'type'            => 'none'
                            )
                        )
                    )
                ),
                'accordion_open'         => array(
                    'title'         => __('Accordion Open', 'fl-builder'),
                    'fields'            => array(
                        'accordion_open_font_color'      => array(
                            'type'             => 'color',
                            'label'            => __('Heading Text Color', 'fl-builder'),
                            'default'          => '333333',
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_open_icon'           => array(
                            'type'              => 'icon',
                            'label'             => __('Icon Open'),
                            'default'           => 'fa-angle-up',
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_open_icon_color'      => array(
                            'type'             => 'color',
                            'label'            => __('Icon Color', 'fl-builder'),
                            'default'          => '333333',
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        ),
                        'accordion_open_background'       => array(
                            'type'              => 'color',
                            'label'             => __('Background Color', 'fl-builder'),
                            'default'           => '',
                            'show_reset'        => true,
                            'preview'           => array(
                                'type'              => 'none'
                            )
                        ),
                        'accordion_open_border'         => array(
                            'type'              => 'color',
                            'label'             => __('Border Color', 'fl-builder'),
                            'default'           => '',
                            'show_reset'        => true,
                            'preview'       => array(
                                'type'          => 'none'
                            )
                        )
                    )
                )
            )
        )
    ));

    /**
     * Register a settings form to use in the "form" field type above.
     */
    FLBuilder::register_settings_form('bta_content', array(
        'title' => __('Content Settings', 'fl-builder'),
        'tabs'  => array(
            'general'      => array( // Tab
                'title'         => __('General', 'fl-builder'), // Tab title
                'sections'      => array( // Tab Sections
                    'general'       => array( // Section
                        'title'         => '', // Section Title
                        'fields'        => array( // Section Fields
                            'title'       => array(
                                'type'          => 'text',
                                'label'         => __('Title', 'fl-builder'),
                                'default'       => 'Content Title'
                            ),
                            'content'       => array(
                                'type'          => 'editor',
                                'media_buttons' => true,
                                'rows'          => 16
                            )
                        )
                    )
                )
            )
        )
    ));

  }
}
