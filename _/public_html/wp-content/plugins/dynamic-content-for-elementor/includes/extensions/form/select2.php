<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use DynamicContentForElementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function _dce_extension_form_select2( $field ) {
	switch ( $field ) {
		case 'docs':
			return 'https://www.dynamic.ooo/widget/select2-for-elementor-pro-form/';
		case 'description':
			return __( 'Add Select2 to your select fields to gives a customizable select box with support for searching.', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_elementorpro_active() ) {

	class DCE_Extension_Form_Select2 extends DCE_Extension_Prototype {

		public $name = 'Select2 for Elementor Pro Form';
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_form_select2( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_select2( 'docs' );
		}

	}

} else {

	class DCE_Extension_Form_Select2 extends DCE_Extension_Prototype {

		public $name = 'Select2 for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		public static $docs = 'https://www.dynamic.ooo/';
		private $is_common = false;
		public $has_action = false;

		public static function get_description() {
			return _dce_extension_form_select2( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_select2( 'docs' );
		}

		public static function get_plugin_depends() {
			return self::$depended_plugins;
		}

		public static function get_satisfy_dependencies( $ret = false ) {
			return true;
		}

		public function get_name() {
			return 'dce_form_select2';
		}

		public function get_label() {
			return __( 'Select2', 'dynamic-content-for-elementor' );
		}

		protected function add_actions() {
			add_action( 'elementor/widget/render_content', array( $this, '_render_form' ), 10, 2 );

			add_action('elementor/widget/print_template', function( $template, $widget ) {
				if ( 'form' === $widget->get_name() ) {
					$template = false;
				}
				return $template;
			}, 10, 2);

			if ( ! is_admin() ) {
					wp_register_script(
					   'jquery-elementor-select2',
					   ELEMENTOR_ASSETS_URL . 'lib/e-select2/js/e-select2.full.min.js',
					   [
						   'jquery',
					   ],
					   '4.0.6-rc.1',
					   true
					 );

					wp_register_style(
					   'elementor-select2',
					   ELEMENTOR_ASSETS_URL . 'lib/e-select2/css/e-select2.min.css',
					   [],
					   '4.0.6-rc.1'
					 );

					wp_register_style(
					   'font-awesome',
					   ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/font-awesome.min.css',
					   [],
					   '4.7.0'
					 );
					wp_register_style(
					   'fontawesome',
					   ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/fontawesome.min.css',
					   [],
					   '5.9.0'
					 );
			}

		}

		public function _render_form( $content, $widget ) {
			if ( $widget->get_name() == 'form' ) {
				$settings = $widget->get_settings_for_display();

				$jkey = 'dce_' . $widget->get_type() . '_form_' . $widget->get_id() . '_select2';
				ob_start();
				?>
			  <script id="<?php echo $jkey; ?>">
				  (function ($) {
				<?php if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
						  var <?php echo $jkey; ?> = function ($scope, $) {
							  if ($scope.hasClass("elementor-element-<?php echo $widget->get_id(); ?>")) {
					<?php
				}
				$has_select2 = false;
				foreach ( $settings['form_fields'] as $key => $afield ) {
					if ( $afield['field_type'] == 'select' ) {
						if ( ! empty( $afield['field_select2'] ) ) {
							$has_select2 = true;
							?>
						if (jQuery.fn.select2) {
							var field2 = jQuery('.elementor-element-<?php echo $widget->get_id(); ?> #form-field-<?php echo $afield['custom_id']; ?>');
							var classes = field2.attr('class');
							var $select2 = field2.select2({
								//containerCssClass: classes,
							<?php if ( ! empty( $afield['field_select2_placeholder'] ) ) {
								?>placeholder: '<?php echo $afield['field_select2_placeholder']; ?>',<?php } ?>
										});
										$select2.data('select2').$container.find('.select2-selection').addClass(classes);
									}
							<?php
						}
					}
				}
				?>
					jQuery('.elementor-element-<?php echo $widget->get_id(); ?> .select2-selection__arrow').remove();
				<?php if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
					}
					};
					$(window).on("elementor/frontend/init", function () {
						elementorFrontend.hooks.addAction("frontend/element_ready/form.default", <?php echo $jkey; ?>);
					});
			  <?php } ?>
							  })(jQuery, window);
			  </script>
				<?php
				$add_js = ob_get_clean();
				if ( $has_select2 ) {

					$add_js = \DynamicContentForElementor\Assets::dce_enqueue_script( $jkey, $add_js );
					wp_enqueue_script( 'jquery-elementor-select2' );
					wp_enqueue_style( 'elementor-select2' );

					return $content . $add_js;
				}
			}
			return $content;
		}

		public static function _add_to_form( Controls_Stack $element, $control_id, $control_data, $options = [] ) {

			if ( $element->get_name() == 'form' ) {

				if ( $control_id == 'form_fields' ) {
					$control_data['fields']['field_select2'] = array(
						'name' => 'field_select2',
						'label' => __( 'Enable Select2', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::SWITCHER,
						'separator' => 'before',
						'return_value' => 'true',
						'conditions' => [
							'terms' => [
								[
									'name' => 'field_type',
									'value' => 'select',
								],
							],
						],
						'tabs_wrapper' => 'form_fields_tabs',
						'inner_tab' => 'form_fields_enchanted_tab',
						'tab' => 'enchanted',
					);
					$control_data['fields']['field_select2_placeholder'] = array(
						'name' => 'field_select2_placeholder',
						'label' => __( 'Placeholder', 'elementor' ),
						'type' => Controls_Manager::TEXT,
						'conditions' => [
							'terms' => [
								[
									'name' => 'field_type',
									'value' => 'select',
								],
								[
									'name' => 'field_select2',
									'value' => 'true',
								],
							],
						],
						'tabs_wrapper' => 'form_fields_tabs',
						'inner_tab' => 'form_fields_enchanted_tab',
						'tab' => 'enchanted',
					);
				}

				if ( $control_id == 'field_text_color' ) {
					$control_data['selectors']['{{WRAPPER}} .select2-container--default .select2-selection--single .select2-selection__rendered'] = 'color: {{VALUE}};';
					$control_data['selectors']['{{WRAPPER}} ..select2-container--default .select2-selection--multiple .select2-selection__rendered'] = 'color: {{VALUE}};';
				}
				if ( strpos( $control_id, 'field_typography' ) === 0 ) {
					if ( ! empty( $control_data['selectors'] ) ) {
						$values = reset( $control_data['selectors'] );
						$control_data['selectors']['{{WRAPPER}} .select2-container--default .select2-selection--single .select2-selection__rendered'] = $values;
						$control_data['selectors']['{{WRAPPER}} .select2-container--default .select2-selection--single .select2-selection__rendered'] = $values;
						$control_data['selectors']['{{WRAPPER}} .select2-container--default .select2-selection--single, {{WRAPPER}} .select2-container--default .select2-selection--multiple'] = 'height: auto;';
					}
				}
				if ( $control_id == 'field_background_color' ) {
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .select2'] = 'background-color: {{VALUE}};';
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .select2 .elementor-field-textual'] = 'background-color: {{VALUE}};';
					$control_data['selectors']['{{WRAPPER}} .mce-panel'] = 'background-color: {{VALUE}};';
				}
				if ( $control_id == 'field_border_color' ) {
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .select2'] = 'border-color: {{VALUE}};';
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .select2 .elementor-field-textual'] = 'border-color: {{VALUE}};';
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .mce-panel'] = 'border-color: {{VALUE}};';
				}
				if ( $control_id == 'field_border_width' ) {
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .select2'] = 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .select2 .elementor-field-textual'] = 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .mce-panel'] = 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
				}
				if ( $control_id == 'field_border_radius' ) {
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .select2'] = 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .select2 .elementor-field-textual'] = 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
					$control_data['selectors']['{{WRAPPER}} .elementor-field-group .mce-panel'] = 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};';
				}
			}

			return $control_data;
		}

	}

}
