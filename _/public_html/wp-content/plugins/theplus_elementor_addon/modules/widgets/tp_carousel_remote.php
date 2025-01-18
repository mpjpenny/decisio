<?php 
/*
Widget Name: Carousel Remote
Description: Carousel/Switcher remote button.
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class ThePlus_Carousel_Remote extends Widget_Base {
		
	public function get_name() {
		return 'tp-carousel-remote';
	}

    public function get_title() {
        return esc_html__('Carousel Remote', 'theplus');
    }

    public function get_icon() {
        return 'fa fa-bluetooth-b theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'theplus' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'carousel_unique_id',
			[
				'label' => esc_html__( 'Unique Connection ID', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'separator' => 'after',
				'description' => esc_html__('Enter the value of ID of carousel/Switcher, which you want to remotely connect with this.','theplus'),
			]
		);
		$this->add_control(
			'remote_type',
			[
				'label' => esc_html__( 'Remote Type', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => [
					'carousel'  => esc_html__( 'Carousel', 'theplus' ),
					'switcher' => esc_html__( 'Switcher', 'theplus' ),					
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
			'nxtprvbtn',[
				'label'   => esc_html__( 'Next/Prev Button', 'theplus' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),	
			]
		);
		$this->add_control(
			'nav_next_slide',
			[
				'label' => esc_html__( 'Button 1 Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Next', 'theplus' ),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_prev_slide',
			[
				'label' => esc_html__( 'Button 2 Text', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Prev', 'theplus' ),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'content_align',
			[
				'label' => esc_html__( 'Alignment', 'theplus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
				'default' => 'left',
				'prefix_class' => 'text-%s',
			]
		);
		$this->add_control(
			'nav_icon_style',
			[
				'label'   => esc_html__( 'Icon Style', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
					'custom' => esc_html__( 'Custom', 'theplus' ),
				],
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_prev_icon',
			[
				'label' => esc_html__( 'Custom Icon 1', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'nav_icon_style' => 'custom',
				],
			]
		);
		$this->add_control(
			'nav_next_icon',
			[
				'label' => esc_html__( 'Custom Icon 2', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'nav_icon_style' => 'custom',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'nav_icon_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'before',
				'condition' => [
					'nav_icon_style' => 'custom',
				],
			]
		);
		$this->end_controls_section();
		/*icon style*/
		$this->start_controls_section(
            'section_icon_styling',
            [
                'label' => esc_html__('Icon Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nxtprvbtn' => 'yes',
					'nav_icon_style!' => 'none',
				],
            ]
        );
		$this->add_responsive_control(
            'icon_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote > span.nav-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote > span.nav-icon img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'icon_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Space', 'theplus'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 40,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote.nav-prev-slide > span.nav-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote.nav-next-slide > span.nav-icon' => 'margin-left: {{SIZE}}{{UNIT}};',					
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_icon_style' );
		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote > span.nav-icon' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover/Active', 'theplus' ),
			]
		);
		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover > span.nav-icon,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active  > span.nav-icon' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		
		/*Dots Start*/
		$this->start_controls_section(
            'section_dot',
            [
                'label' => esc_html__('Dots', 'theplus'),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'remote_type' => 'carousel',
				],
            ]
        );
		$this->add_control(
			'dotList',
			[
				'label' => esc_html__( 'Dots', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'theplus' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Label', 'theplus' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$repeater->add_control(
			'iconFonts',
			[
				'label' => esc_html__( 'Select Icon', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'none'  => esc_html__( 'None', 'theplus' ),
					'font_awesome' => esc_html__( 'Font Awesome', 'theplus' ),
					'image' => esc_html__( 'Image', 'theplus' ),
				],				
			]
		);
		$repeater->add_control(
			'iconName',
			[
				'label' => esc_html__( 'Icon Library', 'theplus' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'solid',
				],
				'condition' => [
					'iconFonts' => 'font_awesome',
				],
			]
		);
		$repeater->add_control(
			'iconImage',
			[
				'label' => esc_html__( 'Use Image As icon', 'theplus' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'media_type' => 'image',
				'dynamic' => ['active'   => true,],
				'condition' => [
					'iconFonts' => 'image',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'iconimageSize',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
				'condition' => [
					'iconFonts' => 'image',
				],
			]
		);
		$repeater->start_controls_tabs( 'tabs_dot' );
		$repeater->start_controls_tab(
			'tab_dot_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->add_control(
			'doticonColor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .tp-carodots-item{{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				],
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'dotBgtype',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'render_type' => 'ui',
				'selector' => '{{WRAPPER}} .theplus-carousel-remote .tp-carodots-item{{CURRENT_ITEM}}',
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'tab_dot_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->add_control(
			'acticonColor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .tp-carodots-item{{CURRENT_ITEM}}.active' => 'color: {{VALUE}}',
				],
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'actdotBgtype',
				'label' => esc_html__( 'Background', 'theplus' ),
				'types' => [ 'classic', 'gradient'],
				'render_type' => 'ui',
				'selector' => '{{WRAPPER}} .theplus-carousel-remote .tp-carodots-item{{CURRENT_ITEM}}.active',
				'condition' => [
					'iconFonts!' => 'none',
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();
		$this->add_control(
			'dots_coll',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'label' => esc_html__( 'Dot 1', 'theplus' ),
						'iconName' => 'fas fa-plus',
					],
					[
						'label' => esc_html__( 'Dot 2', 'theplus' ),
						'iconName' => 'fas fa-plus',
					],
					[
						'label' => esc_html__( 'Dot 3', 'theplus' ),
						'iconName' => 'fas fa-plus',
					],
				],
				'title_field' => '{{{ label }}}',
				'condition' => [
					'dotList' => 'yes',
				],
			]
		);
		$this->add_control(
			'dotLayout',
			[
				'label' => esc_html__( 'Layout', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal'  => esc_html__( 'Horizontal', 'theplus' ),
					'vertical'  => esc_html__( 'Vertical', 'theplus' ),
				],
				'condition' => [
					'dotList' => 'yes',
				],
			]
		);
		$this->add_control(
			'dotstyle',
			[
				'label' => esc_html__( 'Active Dot Style', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'theplus' ),
					'style-2'  => esc_html__( 'Style 2', 'theplus' ),
				],
				'condition' => [
					'dotList' => 'yes',
				],
			]
		);
		$this->add_control(
			'AniDuration',
			[
				'label' => esc_html__( 'Duration (milliseconds)', 'theplus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 10000,
				'step' => 100,
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-1',
				],
			]
		);
		$this->add_control(
			'AborderColor',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-1',
				],
			]
		);
		$this->add_control(
			'tooltipDir',
			[
				'label' => esc_html__( 'Tooltip Direction', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top'  => esc_html__( 'Top', 'theplus' ),
					'bottom'  => esc_html__( 'Bottom', 'theplus' ),
				],
				'condition' => [
					'dotList' => 'yes',
					'dotLayout' => 'horizontal',
					'dotstyle' => 'style-2',
				],
			]
		);
		$this->add_control(
			'vtooltipDir',
			[
				'label' => esc_html__( 'Tooltip Direction', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'theplus' ),
					'right'  => esc_html__( 'Right', 'theplus' ),
				],
				'condition' => [
					'dotList' => 'yes',
					'dotLayout' => 'vertical',
					'dotstyle' => 'style-2',
				],
			]
		);
		$this->end_controls_section();	
		/*Dots End*/
		
		/*Pagination Start*/
		$this->start_controls_section(
            'section_pagination',
            [
                'label' => esc_html__('Pagination', 'theplus'),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'remote_type' => 'carousel',
				],
            ]
        );
		$this->add_control(
			'showpagi',
			[
				'label' => esc_html__( 'Pagination', 'theplus' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'sliderInd',
			[
				'label' => esc_html__( 'Total Slides', 'theplus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1'  => esc_html__( '1', 'theplus' ),
					'2'  => esc_html__( '2', 'theplus' ),
					'3'  => esc_html__( '3', 'theplus' ),
					'4'  => esc_html__( '4', 'theplus' ),
					'5'  => esc_html__( '5', 'theplus' ),
					'6'  => esc_html__( '6', 'theplus' ),
					'7'  => esc_html__( '7', 'theplus' ),
					'8'  => esc_html__( '8', 'theplus' ),
					'9'  => esc_html__( '9', 'theplus' ),
					'10'  => esc_html__( '10', 'theplus' ),
					'11'  => esc_html__( '11', 'theplus' ),
					'12'  => esc_html__( '12', 'theplus' ),
					'13'  => esc_html__( '13', 'theplus' ),
					'14'  => esc_html__( '14', 'theplus' ),
					'15'  => esc_html__( '15', 'theplus' ),
				],
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_pagination' );
		$this->start_controls_tab(
			'tab_pagination_total',
			[
				'label' => esc_html__( 'Total', 'theplus' ),
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'noTypo',
                'label' => esc_html__('Typography', 'theplus'),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.total,
				{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.separator',
				'condition' => [
					'showpagi' => 'yes',
				],
            ]
        );
		$this->add_control(
			'noColor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.total,
				{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.separator' => 'color: {{VALUE}}',
				],
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_pagination_active',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ActnoTypo',
                'label' => esc_html__('Typography', 'theplus'),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.active',
				'condition' => [
					'showpagi' => 'yes',
				],
            ]
        );
		$this->add_control(
			'ActnoColor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.active' => 'color: {{VALUE}}',
				],
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'sepColor',
			[
				'label' => esc_html__( 'Seprator Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .carousel-pagination li.pagination-list-in.separator' => 'color: {{VALUE}}',
				],
				'condition' => [
					'showpagi' => 'yes',
				],
			]
		);
		$this->end_controls_section();	
		/*Pagination Start*/		
		
		/*icon style*/
		$this->start_controls_section(
            'section_styling',
            [
                'label' => esc_html__('Button Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nxtprvbtn' => 'yes',
				],
            ]
        );
		$this->add_responsive_control(
			'button_between_space',
			[
				'label' => esc_html__( 'Button Gap/Space', 'theplus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote.nav-prev-slide' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev a.custom-nav-remote.nav-next-slide' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'nav_inner_padding',
			[
				'label' => esc_html__( 'Padding', 'theplus' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default' =>[
					'top' => '10',
					'right' => '20',
					'bottom' => '10',
					'left' => '20',
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'theplus'),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote',
            ]
        );
		$this->start_controls_tabs( 'tabs_nav_style' );
		$this->start_controls_tab(
			'tab_nav_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'nav_color',
			[
				'label' => esc_html__( 'Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_nav_hover',
			[
				'label' => esc_html__( 'Hover/Active', 'theplus' ),
			]
		);
		$this->add_control(
			'nav_hover_color',
			[
				'label' => esc_html__( 'Hover Text Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'box_border',
			[
				'label' => esc_html__( 'Box Border', 'theplus' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'button_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'theplus' ),
					'solid'  => esc_html__( 'Solid', 'theplus' ),
					'dotted' => esc_html__( 'Dotted', 'theplus' ),
					'dashed' => esc_html__( 'Dashed', 'theplus' ),
					'groove' => esc_html__( 'Groove', 'theplus' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_border_style' );
		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'box_border_width',
			[
				'label' => esc_html__( 'Border Width', 'theplus' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Hover/Active', 'theplus' ),
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'background_options',
			[
				'label' => esc_html__( 'Background Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_background_style' );
		$this->start_controls_tab(
			'tab_background_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_background_hover',
			[
				'label' => esc_html__( 'Hover/Active', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'box_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'theplus' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_shadow_style' );
		$this->start_controls_tab(
			'tab_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_shadow_hover',
			[
				'label' => esc_html__( 'Hover/Active', 'theplus' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_hover_shadow',
				'selector' => '{{WRAPPER}} .theplus-carousel-remote .slider-nav-next-prev .custom-nav-remote:hover,{{WRAPPER}} .theplus-carousel-remote.remote-switcher .slider-nav-next-prev .custom-nav-remote.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		
		/*dots style*/
		$this->start_controls_section(
            'section_dots_styling',
            [
                'label' => esc_html__('Dots Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'dotList' => 'yes',
				],
            ]
        );
		$this->add_responsive_control(
            'dotsSize',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Dots Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots .tp-carodots-item' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'dotsGap',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Dots Gap', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots.dot-vertical .tp-carodots-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-carousel-dots.dot-horizontal .tp-carodots-item' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'dotsIconSize',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tp-dots i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_responsive_control(
            'dotsImageSize',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Size', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tp-dots img' => 'width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_dotsb_style' );
		$this->start_controls_tab(
			'tab_dotsb_normal',
			[
				'label' => esc_html__( 'Normal', 'theplus' ),
			]
		);
		$this->add_responsive_control(
            'dotsbr',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Radius', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots .tp-carodots-item' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_dotsb_hover',
			[
				'label' => esc_html__( 'Active', 'theplus' ),
			]
		);
		$this->add_responsive_control(
            'dotsbra',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Radius', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carousel-dots .tp-carodots-item.active' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();	
		$this->end_controls_section();
		/*dots end*/
		
		/*tooltip style*/
		$this->start_controls_section(
            'section_tooltip_styling',
            [
                'label' => esc_html__('Tooltip Style', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'dotList' => 'yes',
					'dotstyle' => 'style-2',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tttypography',
				'selector' => '{{WRAPPER}} .tp-carodots-item .tooltip-txt',
			]
		);
		$this->add_control(
			'ttcolor',
			[
				'label' => esc_html__( 'Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tooltip-txt' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'ttbgcolor',
			[
				'label' => esc_html__( 'Background Color', 'theplus' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tooltip-txt' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tp-carodots-item .tooltip-txt:after' => 'border-right-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
            'ttwidth',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'theplus'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-carodots-item .tooltip-txt' => 'width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->end_controls_section();
		/*tooltip end*/
		
		/*Adv tab*/
		$this->start_controls_section(
            'section_plus_extra_adv',
            [
                'label' => esc_html__('Plus Extras', 'theplus'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );
		$this->end_controls_section();
		/*Adv tab*/
		$this->start_controls_section(
            'section_animation_styling',
            [
                'label' => esc_html__('On Scroll View Animation', 'theplus'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'animation_effects',
			[
				'label'   => esc_html__( 'Choose Animation Effect', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no-animation',
				'options' => theplus_get_animation_options(),
			]
		);
		$this->add_control(
            'animation_delay',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Animation Delay', 'theplus'),
				'default' => [
					'unit' => '',
					'size' => 50,
				],
				'range' => [
					'' => [
						'min'	=> 0,
						'max'	=> 4000,
						'step' => 15,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
            ]
        );
		$this->add_control(
            'animation_duration_default',
            [
				'label'   => esc_html__( 'Animation Duration', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animate_duration',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Duration Speed', 'theplus'),
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'	=> 100,
						'max'	=> 10000,
						'step' => 100,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_duration_default' => 'yes',
				],
            ]
        );
		$this->add_control(
			'animation_out_effects',
			[
				'label'   => esc_html__( 'Out Animation Effect', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no-animation',
				'options' => theplus_get_out_animation_options(),
				'separator' => 'before',
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animation_out_delay',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Out Animation Delay', 'theplus'),
				'default' => [
					'unit' => '',
					'size' => 50,
				],
				'range' => [
					'' => [
						'min'	=> 0,
						'max'	=> 4000,
						'step' => 15,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
				],
            ]
        );
		$this->add_control(
            'animation_out_duration_default',
            [
				'label'   => esc_html__( 'Out Animation Duration', 'theplus' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animation_out_duration',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Duration Speed', 'theplus'),
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'	=> 100,
						'max'	=> 10000,
						'step' => 100,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
					'animation_out_duration_default' => 'yes',
				],
            ]
        );
		$this->end_controls_section();
	}
	
	 protected function render() {

        $settings = $this->get_settings_for_display();
		$remote_type = $settings["remote_type"];
		
			$animation_effects=$settings["animation_effects"];
			$animation_delay= (!empty($settings["animation_delay"]["size"])) ? $settings["animation_delay"]["size"] : 50;
			if($animation_effects=='no-animation'){
				$animated_class = '';
				$animation_attr = '';
			}else{
				$animate_offset = theplus_scroll_animation();
				$animated_class = 'animate-general';
				$animation_attr = ' data-animate-type="'.esc_attr($animation_effects).'" data-animate-delay="'.esc_attr($animation_delay).'"';
				$animation_attr .= ' data-animate-offset="'.esc_attr($animate_offset).'"';
				if($settings["animation_duration_default"]=='yes'){
					$animate_duration=$settings["animate_duration"]["size"];
					$animation_attr .= ' data-animate-duration="'.esc_attr($animate_duration).'"';
				}
				if(!empty($settings["animation_out_effects"]) && $settings["animation_out_effects"]!='no-animation'){
					$animation_attr .= ' data-animate-out-type="'.esc_attr($settings["animation_out_effects"]).'" data-animate-out-delay="'.esc_attr($settings["animation_out_delay"]["size"]).'"';					
					if($settings["animation_out_duration_default"]=='yes'){						
						$animation_attr .= ' data-animate-out-duration="'.esc_attr($settings["animation_out_duration"]["size"]).'"';
					}
				}
			}
			/*--Plus Extra ---*/
			$magic_class = $magic_attr = $parallax_scroll = '';
			if (!empty($settings['magic_scroll']) && $settings['magic_scroll'] == 'yes') {
				
				$scroll_offset=($settings['scroll_option_scroll_offset']!='') ? $settings['scroll_option_scroll_offset'] : 0;
				$scroll_duration=($settings['scroll_option_scroll_duration']!='') ? $settings['scroll_option_scroll_duration'] : 300;
				
				$scroll_x_from=($settings['scroll_from_scroll_x_from']!='') ? $settings['scroll_from_scroll_x_from'] : 0;
				$scroll_y_from=($settings['scroll_from_scroll_y_from']!='') ? $settings['scroll_from_scroll_y_from'] : 0;
				$scroll_opacity_from=($settings['scroll_from_scroll_opacity_from']!='') ? $settings['scroll_from_scroll_opacity_from'] : 1;
				$scroll_scale_from=($settings['scroll_from_scroll_scale_from']!='') ? $settings['scroll_from_scroll_scale_from'] : 1;
				$scroll_rotate_from=($settings['scroll_from_scroll_rotate_from']!='') ? $settings['scroll_from_scroll_rotate_from'] : 0;
				
				$scroll_x_to=($settings['scroll_to_scroll_x_to']!='') ? $settings['scroll_to_scroll_x_to'] : 0;
				$scroll_y_to=($settings['scroll_to_scroll_y_to']!='') ? $settings['scroll_to_scroll_y_to'] : -50;
				$scroll_opacity_to=($settings['scroll_to_scroll_opacity_to']!='') ? $settings['scroll_to_scroll_opacity_to'] : 1;
				$scroll_scale_to=($settings['scroll_to_scroll_scale_to']!='') ? $settings['scroll_to_scroll_scale_to'] : 1;
				$scroll_rotate_to=($settings['scroll_to_scroll_rotate_to']!='') ? $settings['scroll_to_scroll_rotate_to'] : 0;
				
				$magic_attr .= ' data-scroll_type="position" ';
				$magic_attr .= ' data-scroll_offset="' . esc_attr($scroll_offset) . '" ';
				$magic_attr .= ' data-scroll_duration="' . esc_attr($scroll_duration) . '" ';
				
				$magic_attr .= ' data-scroll_x_from="' . esc_attr($scroll_x_from) . '" ';
				$magic_attr .= ' data-scroll_x_to="' . esc_attr($scroll_x_to) . '" ';
				$magic_attr .= ' data-scroll_y_from="' . esc_attr($scroll_y_from) . '" ';
				$magic_attr .= ' data-scroll_y_to="' . esc_attr($scroll_y_to) . '" ';
				$magic_attr .= ' data-scroll_opacity_from="' . esc_attr($scroll_opacity_from) . '" ';
				$magic_attr .= ' data-scroll_opacity_to="' . esc_attr($scroll_opacity_to) . '" ';
				$magic_attr .= ' data-scroll_scale_from="' . esc_attr($scroll_scale_from) . '" ';
				$magic_attr .= ' data-scroll_scale_to="' . esc_attr($scroll_scale_to) . '" ';
				$magic_attr .= ' data-scroll_rotate_from="' . esc_attr($scroll_rotate_from) . '" ';
				$magic_attr .= ' data-scroll_rotate_to="' . esc_attr($scroll_rotate_to) . '" ';
				
				$parallax_scroll .= ' parallax-scroll ';
				
				$magic_class .= ' magic-scroll ';
			}
			if( $settings['plus_tooltip'] == 'yes' ) {
				
				$this->add_render_attribute( '_tooltip', 'data-tippy', '', true );

				if (!empty($settings['plus_tooltip_content_type']) && $settings['plus_tooltip_content_type']=='normal_desc') {
					$this->add_render_attribute( '_tooltip', 'title', $settings['plus_tooltip_content_desc'], true );
				}else if (!empty($settings['plus_tooltip_content_type']) && $settings['plus_tooltip_content_type']=='content_wysiwyg') {
					$tooltip_content=$settings['plus_tooltip_content_wysiwyg'];
					$this->add_render_attribute( '_tooltip', 'title', $tooltip_content, true );
				}
				$plus_tooltip_position=($settings["tooltip_opt_plus_tooltip_position"]!='') ? $settings["tooltip_opt_plus_tooltip_position"] : 'top';
				$this->add_render_attribute( '_tooltip', 'data-tippy-placement', $plus_tooltip_position, true );
				
				$tooltip_interactive =($settings["tooltip_opt_plus_tooltip_interactive"]=='' || $settings["tooltip_opt_plus_tooltip_interactive"]=='yes') ? 'true' : 'false';
				$this->add_render_attribute( '_tooltip', 'data-tippy-interactive', $tooltip_interactive, true );
				
				$plus_tooltip_theme=($settings["tooltip_opt_plus_tooltip_theme"]!='') ? $settings["tooltip_opt_plus_tooltip_theme"] : 'dark';
				$this->add_render_attribute( '_tooltip', 'data-tippy-theme', $plus_tooltip_theme, true );
				
				
				$tooltip_arrow =($settings["tooltip_opt_plus_tooltip_arrow"]!='none' || $settings["tooltip_opt_plus_tooltip_arrow"]=='') ? 'true' : 'false';
				$this->add_render_attribute( '_tooltip', 'data-tippy-arrow', $tooltip_arrow , true );
				
				$plus_tooltip_arrow=($settings["tooltip_opt_plus_tooltip_arrow"]!='') ? $settings["tooltip_opt_plus_tooltip_arrow"] : 'sharp';
				$this->add_render_attribute( '_tooltip', 'data-tippy-arrowtype', $plus_tooltip_arrow, true );
				
				$plus_tooltip_animation=($settings["tooltip_opt_plus_tooltip_animation"]!='') ? $settings["tooltip_opt_plus_tooltip_animation"] : 'shift-toward';
				$this->add_render_attribute( '_tooltip', 'data-tippy-animation', $plus_tooltip_animation, true );
				
				$plus_tooltip_x_offset=($settings["tooltip_opt_plus_tooltip_x_offset"]!='') ? $settings["tooltip_opt_plus_tooltip_x_offset"] : 0;
				$plus_tooltip_y_offset=($settings["tooltip_opt_plus_tooltip_y_offset"]!='') ? $settings["tooltip_opt_plus_tooltip_y_offset"] : 0;
				$this->add_render_attribute( '_tooltip', 'data-tippy-offset', $plus_tooltip_x_offset .','. $plus_tooltip_y_offset, true );
				
				$tooltip_duration_in =($settings["tooltip_opt_plus_tooltip_duration_in"]!='') ? $settings["tooltip_opt_plus_tooltip_duration_in"] : 250;
				$tooltip_duration_out =($settings["tooltip_opt_plus_tooltip_duration_out"]!='') ? $settings["tooltip_opt_plus_tooltip_duration_out"] : 200;
				$tooltip_trigger =($settings["tooltip_opt_plus_tooltip_triggger"]!='') ? $settings["tooltip_opt_plus_tooltip_triggger"] : 'mouseenter';
				$tooltip_arrowtype =($settings["tooltip_opt_plus_tooltip_arrow"]!='') ? $settings["tooltip_opt_plus_tooltip_arrow"] : 'sharp';
			}
			
			$move_parallax=$move_parallax_attr=$parallax_move='';
			if(!empty($settings['plus_mouse_move_parallax']) && $settings['plus_mouse_move_parallax']=='yes'){
				$move_parallax='pt-plus-move-parallax';
				$parallax_move='parallax-move';
				$parallax_speed_x=($settings["plus_mouse_parallax_speed_x"]["size"]!='') ? $settings["plus_mouse_parallax_speed_x"]["size"] : 30;
				$parallax_speed_y=($settings["plus_mouse_parallax_speed_y"]["size"]!='') ? $settings["plus_mouse_parallax_speed_y"]["size"] : 30;
				$move_parallax_attr .= ' data-move_speed_x="' . esc_attr($parallax_speed_x) . '" ';
				$move_parallax_attr .= ' data-move_speed_y="' . esc_attr($parallax_speed_y) . '" ';
			}
			$tilt_attr='';
			if(!empty($settings['plus_tilt_parallax']) && $settings['plus_tilt_parallax']=='yes'){
				$tilt_scale=($settings["plus_tilt_opt_tilt_scale"]["size"]!='') ? $settings["plus_tilt_opt_tilt_scale"]["size"] : 1.1;
				$tilt_max=($settings["plus_tilt_opt_tilt_max"]["size"]!='') ? $settings["plus_tilt_opt_tilt_max"]["size"] : 20;
				$tilt_perspective=($settings["plus_tilt_opt_tilt_perspective"]["size"]!='') ? $settings["plus_tilt_opt_tilt_perspective"]["size"] : 400;
				$tilt_speed=($settings["plus_tilt_opt_tilt_speed"]["size"]!='') ? $settings["plus_tilt_opt_tilt_speed"]["size"] : 400;
				
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt', '' , true );
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-scale', $tilt_scale , true );
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-max', $tilt_max , true );
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-perspective', $tilt_perspective , true );
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-speed', $tilt_speed , true );
				
				if($settings["plus_tilt_opt_tilt_easing"] !='custom'){
					$easing_tilt=$settings["plus_tilt_opt_tilt_easing"];					
				}else if($settings["plus_tilt_opt_tilt_easing"] =='custom'){
					$easing_tilt=$settings["plus_tilt_opt_tilt_easing_custom"];
				}else{
					$easing_tilt='cubic-bezier(.03,.98,.52,.99)';
				}
				$this->add_render_attribute( '_tilt_parallax', 'data-tilt-easing', $easing_tilt , true );
				
			}
			$reveal_effects=$effect_attr='';
			if(!empty($settings["plus_overlay_effect"]) && $settings["plus_overlay_effect"]=='yes'){
				$effect_rand_no =uniqid('reveal');
				$color_1=($settings["plus_overlay_spcial_effect_color_1"]!='') ? $settings["plus_overlay_spcial_effect_color_1"] : '#313131';
				$color_2=($settings["plus_overlay_spcial_effect_color_2"]!='') ? $settings["plus_overlay_spcial_effect_color_2"] : '#ff214f';
				$effect_attr .=' data-reveal-id="'.esc_attr($effect_rand_no).'" ';
				$effect_attr .=' data-effect-color-1="'.esc_attr($color_1).'" ';
				$effect_attr .=' data-effect-color-2="'.esc_attr($color_2).'" ';
				$reveal_effects=' pt-plus-reveal '.esc_attr($effect_rand_no).' ';
			}
			$continuous_animation='';
			if(!empty($settings["plus_continuous_animation"]) && $settings["plus_continuous_animation"]=='yes'){
				if($settings["plus_animation_hover"]=='yes'){
					$animation_class='hover_';
				}else{
					$animation_class='image-';
				}
				$continuous_animation=$animation_class.$settings["plus_animation_effect"];
			}
			
			$before_content =$after_content ='';
			$uid_widget=uniqid("plus");
			if($settings['magic_scroll'] == 'yes' || $settings['plus_tooltip'] == 'yes' || $settings['plus_mouse_move_parallax']=='yes' || $settings['plus_tilt_parallax']=='yes' || $settings["plus_overlay_effect"]=='yes' || $settings["plus_continuous_animation"]=='yes'){
				$before_content .='<div id="'.esc_attr($uid_widget).'" class="plus-widget-wrapper '.esc_attr($magic_class).' '.esc_attr($move_parallax).' '.esc_attr($reveal_effects).' '.esc_attr($continuous_animation).'" '.$effect_attr.' '.$this->get_render_attribute_string( '_tooltip' ).'>';
				$before_content .='<div class="plus-widget-inner-wrap '.esc_attr($parallax_scroll).' " '.$magic_attr.'>';
				if($settings['plus_mouse_move_parallax']=='yes'){
					$before_content .='<div class="plus-widget-inner-parallax '.esc_attr($parallax_move).'" '.$move_parallax_attr.'>';
				}
				if($settings['plus_tilt_parallax']=='yes'){
					$before_content .='<div class="plus-widget-inner-tilt js-tilt" '.$this->get_render_attribute_string( '_tilt_parallax' ).'>';
				}
			}
			if($settings['magic_scroll'] == 'yes' || $settings['plus_tooltip'] == 'yes' || $settings['plus_mouse_move_parallax']=='yes' || $settings['plus_tilt_parallax']=='yes' || $settings["plus_overlay_effect"]=='yes' || $settings["plus_continuous_animation"]=='yes'){
				$after_content .='</div>';
				$after_content .='</div>';
				if($settings['plus_mouse_move_parallax']=='yes'){
					$after_content .='</div>';
				}
				if($settings['plus_tilt_parallax']=='yes'){
					$after_content .='</div>';
				}
				if($settings['plus_tooltip'] == 'yes'){
					$after_content .='<script>
					(function($){
						"use strict";
						$( document ).ready(function() {
							tippy( "#'.esc_attr($uid_widget).'" , {
								arrowType : "'.$tooltip_arrowtype.'",
								duration : ['.esc_attr($tooltip_duration_in).','.esc_attr($tooltip_duration_out).'],
								trigger : "'.esc_attr($tooltip_trigger).'",
								appendTo: document.querySelector("#'.esc_attr($uid_widget).'")
							});
						});
					})(jQuery);
					</script>';
				}
			}
			/*--Plus Extra ---*/
			$nav_next =$nav_prev = '';
			$carousel_unique_id=$settings["carousel_unique_id"];
			$nav_next_slide = $settings['nav_next_slide'];
			$nav_prev_slide = $settings['nav_prev_slide'];
			
			$nav_next_text=$nav_prev_text ='';
			if($nav_next_slide!=''){
				$nav_next_text ='<span>'.esc_html($nav_next_slide).'</span>';
			}
			if($nav_prev_slide!=''){
				$nav_prev_text ='<span>'.esc_html($nav_prev_slide).'</span>';
			}
			
			if($settings["nav_icon_style"]=='none'){
				$nav_prev = $nav_prev_text;
				$nav_next = $nav_next_text;
			}else if($settings["nav_icon_style"]=='style-1'){
				$nav_prev = '<span class="nav-icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>'.$nav_prev_text;
				$nav_next = $nav_next_text.'<span class="nav-icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>';
			}else if($settings["nav_icon_style"]=='custom'){				
				$nav_prev_icon=$settings['nav_prev_icon']['id'];
				$img = wp_get_attachment_image_src($nav_prev_icon,$settings['nav_icon_thumbnail_size']);
				$nav_prev_icon = $img[0];
								
				$nav_next_icon=$settings['nav_next_icon']['id'];
				$img = wp_get_attachment_image_src($nav_next_icon,$settings['nav_icon_thumbnail_size']);
				$nav_next_icon = $img[0];
				
				if(!empty($nav_prev_icon)){
					$nav_prev_icon ='<img src="'.esc_url($nav_prev_icon).'" />';
				}
				if(!empty($nav_next_icon)){
					$nav_next_icon ='<img src="'.esc_url($nav_next_icon).'" />';
				}
				$nav_prev = '<span class="nav-icon">'.$nav_prev_icon.'</span>'.$nav_prev_text;
				$nav_next = $nav_next_text.'<span class="nav-icon">'.$nav_next_icon.'</span>';
			}
			
			$active_class='';
			if($remote_type=='switcher'){
				$active_class="active";
			}
			
			$uid=uniqid("remote");
			$da=$daid='';
			if(!empty($settings['dotList']) && $settings['dotList']=='yes'){
				$da='data-connection="tpca_'.esc_attr($carousel_unique_id).'" data-tab-id="tptab_'.esc_attr($carousel_unique_id).'" data-extra-conn="tpex-'.esc_attr($carousel_unique_id).'"';
				$daid='id="tptab_'.esc_attr($carousel_unique_id).'"';
			}
			$carousel_remote ='<div '.$daid.' class="theplus-carousel-remote remote-'.esc_attr($remote_type).' '.$animated_class.' '.esc_attr($uid).'" data-id="'.esc_attr($uid).'" data-remote="'.esc_attr($remote_type).'"  '.$da.' '.$animation_attr.'>';
			
				if(empty($settings['nxtprvbtn']) && $settings['nxtprvbtn'] != 'yes'){
					$carousel_remote .='';
				}else{
					$carousel_remote .='<div class="slider-nav-next-prev">';				
					$carousel_remote .='<a href="#" class="custom-nav-remote nav-prev-slide '.esc_attr($active_class).'" data-id="tpca_'.esc_attr($carousel_unique_id).'" data-nav="'.esc_attr("prev","theplus").'">'.$nav_prev.'</a>';
					$carousel_remote .='<a href="#" class="custom-nav-remote nav-next-slide" data-id="tpca_'.esc_attr($carousel_unique_id).'" data-nav="'.esc_attr("next","theplus").'">'.$nav_next.'</a>';					
					$carousel_remote .='</div>';
				}
				
				if(!empty($settings['dotList']) && $settings['dotList']=='yes'){
					if(!empty($settings["dots_coll"])) {
						$index=0;	
						$carousel_remote .='<div class="tp-carousel-dots dot-'.$settings['dotLayout'].'">';
						foreach($settings["dots_coll"] as $index => $item) {
							$ps_count = $index;
							$ttpos='';
							if(!empty($settings['dotLayout']) && $settings['dotLayout']=='horizontal'){
								$ttpos = $settings['tooltipDir'];
							}else if(!empty($settings['dotLayout']) && $settings['dotLayout']=='vertical'){
								$ttpos = $settings['vtooltipDir'];
							}
								$ia ='inactive';
								if($index==0){
									$ia ='active';
								}
								$carousel_remote .='<div class="tp-carodots-item elementor-repeater-item-'.$item['_id'].' '.$settings['dotstyle'].' '.$ia.'" data-tab="'.$ps_count.'">';
									$carousel_remote .='<div class="tp-dots tooltip-'.$ttpos.'">';
										$icons='';
										if($item['iconFonts'] && $item['iconFonts']=='font_awesome' && !empty($item['iconName'])){
											ob_start();
											\Elementor\Icons_Manager::render_icon( $item['iconName'], [ 'aria-hidden' => 'true' ]);
											$faicon = ob_get_contents();
											ob_end_clean();
											
											$icons = $faicon;											
										}else if($item['iconFonts'] && $item['iconFonts']=='image' && !empty($item['iconImage'])){
											$iconImage=$item['iconImage']['id'];											
											$img = wp_get_attachment_image_src($iconImage,$item['iconimageSize_size']);
											$imgsrc	= $img[0];											
											$icons= '<img src="'.$imgsrc.'" />';
										}											
										$carousel_remote .=$icons;
										
										if(!empty($item['label'])){
											$carousel_remote .='<span class="tooltip-txt">'.$item['label'].'</span>';
											$carousel_remote .='<svg height="32" data-v-d3e9c2e8="" width="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" svg-inline="" role="presentation" focusable="false" tabindex="-1" class="active-border">
											 <path data-v-d3e9c2e8="" d="M14.7974701,0 C16.6202545,0 19.3544312,0 23,0 C26.8659932,0 30,3.13400675 30,7 L30,23 C30,26.8659932 26.8659932,30 23,30 L7,30 C3.13400675,30 0,26.8659932 0,23 L0,7 C0,3.13400675 3.13400675,0 7,0 L14.7602345,0" transform="translate(1.000000, 1.000000)" fill="none" stroke="'.$settings["AborderColor"].'" stroke-width="2" class="border"></path>
											</svg>';
										}
									$carousel_remote .='</div>';
								$carousel_remote .='</div>';							
						}			
						$carousel_remote .='</div>';
					}					
				}
				
				if(!empty($settings['showpagi']) && $settings['showpagi']=='yes'){
					$carousel_remote .='<div class="carousel-pagination">';
							$carousel_remote .='<ul class="pagination-list">';
								$carousel_remote .='<li class="pagination-list-in active"> 01 </li>';
								$carousel_remote .='<li class="pagination-list-in separator"> / </li>';
								$carousel_remote .='<li class="pagination-list-in total"> 0'.$settings['sliderInd'].' </li>';
							$carousel_remote .='</ul>';
					$carousel_remote .='</div>';
				}
				
			$carousel_remote .='</div>';
			
		echo $before_content.$carousel_remote.$after_content;
	}
	
    protected function content_template() {
	
    }

}
