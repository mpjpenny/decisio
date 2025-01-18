jQuery( window ).on( 'elementor:init', function() {

	// Query Control

	var PlusQuery = elementor.modules.controls.Select2.extend( {

		cache: null,
		isTitlesReceived: false,

		getSelect2Placeholder: function getSelect2Placeholder() {
			var self = this;
			
			return {
				id: '',
				text: self.model.get('placeholder') || 'All',
			};
		},

		getSelect2DefaultOptions: function getSelect2DefaultOptions() {
			var self = this;

			return jQuery.extend( elementor.modules.controls.Select2.prototype.getSelect2DefaultOptions.apply( this, arguments ), {
				ajax: {
					transport: function transport( params, success, failure ) {
						var data = {
							q 			: params.data.q,
							query_type 	: self.model.get('query_type'),
							object_type : self.model.get('object_type'),
							query_options 	: self.model.get('query_options'),
						};

						return elementorCommon.ajax.addRequest('plus_query_control_filter_autocomplete', {
							data 	: data,
							success : success,
							error 	: failure,
						});
					},
					data: function data( params ) {
						return {
							q 	 : params.term,
							page : params.page,
						};
					},
					cache: true
				},
				escapeMarkup: function escapeMarkup(markup) {
					return markup;
				},
				minimumInputLength: 2
			});
		},

		get_value_titles: function get_value_titles() {
			var self 		= this,
			    valueIds 		= this.getControlValue(),
			    queryTypeOpt 	= this.model.get('query_type'),
			    objectTypeOpt 	= this.model.get('object_type'),
				queryOptionsOpt = this.model.get('query_options');

			if ( ! valueIds || ! queryTypeOpt ) return;

			if ( ! _.isArray( valueIds ) ) {
				valueIds = [ valueIds ];
			}

			elementorCommon.ajax.loadObjects({
				action 	: 'plus_query_control_value_titles',
				ids 	: valueIds,
				data 	: {
					query_type 	: queryTypeOpt,
					object_type : objectTypeOpt,
					query_options 	: queryOptionsOpt,
					unique_id 	: '' + self.cid + queryTypeOpt,
				},
				success: function success(data) {
					self.isTitlesReceived = true;
					self.model.set('options', data);
					self.render();
				},
				before: function before() {
					self.add_spinner();
				},
			});
		},

		add_spinner: function add_spinner() {
			this.ui.select.prop('disabled', true);
			this.$el.find('.elementor-control-title').after('<span class="elementor-control-spinner">&nbsp;<i class="fas fa-spinner fa-spin"></i>&nbsp;</span>');
		},

		onReady: function onReady() {
			setTimeout( elementor.modules.controls.Select2.prototype.onReady.bind(this) );

			if ( ! this.isTitlesReceived ) {
				this.get_value_titles();
			}
		},
		
		onBeforeDestroy: function onBeforeDestroy() {
			if (this.ui.select.data('select2')) {
				this.ui.select.select2('destroy');
			}

			this.$el.remove();
		},

	} );

	elementor.addControlView( 'plus-query', PlusQuery );
} );