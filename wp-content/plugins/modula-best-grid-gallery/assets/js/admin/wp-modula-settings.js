wp.Modula = 'undefined' === typeof( wp.Modula ) ? {} : wp.Modula;

(function( $, modula ){

    var modulaSettings = Backbone.Model.extend({
    	initialize: function( args ){
            var model = this;
            $.each( args, function( att, value ){
                model.set( att, value );
            });

      		var view = new modula.settings['view']({
      			model: this,
      			el: $( '#modula-settings' )
      		});

      		this.set( 'view', view );

        },
    });

    var modulaSettingsView = Backbone.View.extend({

    	events: {
    		// Tabs specific events
    		'click .modula-tab':     'changeTab',
            'click .modula-tab > *': 'changeTabFromChild',

    		// Settings specific events
            'keyup input':         'updateModel',
            'keyup textarea':      'updateModel',
            'change input':        'updateModel',
            'change textarea':     'updateModel',
            'blur textarea':       'updateModel',
            'change select':       'updateModel',
        },

        initialize: function( args ) {
        	this.initializeLite();
        },

        initializeLite: function(){

            this.tabs          = this.$el.find( '.modula-tabs .modula-tab' );
            this.tabContainers = this.$el.find( '.modula-tabs-content > div' );
            this.sliders       = this.$el.find( '.modula-ui-slider' );
            this.colorPickers  = this.$el.find( '.modula-color' );
            this.customEditors = this.$el.find( '.modula-code-editor' );

            // initialize 3rd party scripts
            this.initSliders();
            this.initColorPickers();
            this.initCustomCSS();
            this.expandGalleryContainer();

        },

        updateModel: function( event ) {
        	var value, setting;

        	// Check if the target has a data-field. If not, it's not a model value we want to store
            if ( undefined === event.target.dataset.setting ) {
                return;
            }

            setting = event.target.dataset.setting;

            // Update the model's value, depending on the input type
            if ( event.target.type == 'checkbox' ) {
                value = ( event.target.checked ? event.target.value : 0 );
            } else {
                value = event.target.value;
            }

            // Update the model
            this.model.set( setting, value );

        },

        changeTab: function ( event ) {

        	var currentTab = jQuery( event.target ).data( 'tab' );

            if ( this.tabContainers.filter( '#' + currentTab ).length < 1 ) {
                return;
            }
    		this.tabs.removeClass( 'active-tab' );
    		this.tabContainers.removeClass( 'active-tab' );
    		jQuery( event.target ).addClass( 'active-tab' );
    		this.tabContainers.filter( '#' + currentTab ).addClass( 'active-tab' ).trigger( 'modula-current-tab' );

            window.location.hash = '#!' + currentTab;

            var postAction = $( "#post" ).attr( 'action' );
            if( postAction ) {
                postAction = postAction.split( '#' )[0];
                $( '#post' ).attr( 'action', postAction + window.location.hash );
            }

            var opts = {
                url:      modulaHelper.ajax_url,
                type:     'post',
                async:    true,
                cache:    false,
                dataType: 'json',
                data:     {
                    action: 'modula_remember_tab',
                    tab:     currentTab,
                    id: $('#post_ID').val(),
                    nonce:  modulaHelper._wpnonce,
                }
            };

            $.ajax(opts);

        },

        changeTabFromChild: function ( event ) {

            var currentTab = jQuery( event.target ).parent().data( 'tab' );

            if ( this.tabContainers.filter( '#' + currentTab ).length < 1 ) {
                return;
            }

            this.tabs.removeClass( 'active-tab' );
            this.tabContainers.removeClass( 'active-tab' );
            jQuery( event.target ).parent().addClass( 'active-tab' );
            this.tabContainers.filter( '#' + currentTab ).addClass( 'active-tab' );

        },

        initSliders: function() {

        	if ( this.sliders.length > 0 ) {
    			this.sliders.each( function( $index, $slider ) {
                    var input = jQuery( $slider ).parent().find( '.modula-ui-slider-input' ),
                        max = input.data( 'max' ),
                        min = input.data( 'min' ),
                        step = input.data( 'step' ),
                        value = parseInt( input.val(), 10 );

                    jQuery( $slider ).slider({
                        value: value,
                        min: min,
                        max: max,
                        step: step,
                        range: 'min',
                        slide: function( event, ui ) {
                            input.val( ui.value ).trigger( 'change' );
                        }
                    });


                    input.keyup(function() {
                        jQuery( $slider ).slider("value" , input.val())
                    });

                });
    		}

        },

        initColorPickers: function() {
        	if ( this.colorPickers.length > 0 ) {
                this.colorPickers.each( function( $index, colorPicker ) {
                	//@todo: we need to find a solution to trigger a change event on input.
                    jQuery( colorPicker ).wpColorPicker();
                });
            }
        },

        initCustomCSS: function() {

            // If codeEditor is undefined we should not try to recreate the Custom CSS editor
            // Will be left as a simple textarea
            if ( undefined !== wp.codeEditor ) {
                var editorSettings =  wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                if ( this.customEditors.length > 0 ) {
                    this.customEditors.each( function( $index, customEditorContainer ) {
                        var syntax          = $( customEditorContainer ).data( 'syntax' ),
                            id              = '#' + $( customEditorContainer ).find( '.modula-custom-editor-field' ).attr( 'id' ),
                            currentSettings = _.extend(
                                {},
                                editorSettings.codemirror,
                                {
                                    mode: syntax,
                                }
                            );

                        if( undefined !== wp.codeEditor ) {
                            var editor =  wp.codeEditor.initialize( $( id ), currentSettings );
                            $( customEditorContainer ).parents( '.modula-tab-content' ).on( 'modula-current-tab',function(){
                                editor.codemirror.refresh();
                            });
                        }

                    });
                }
            }
        },
        expandGalleryContainer: function () {
            $( '#modula-preview-gallery' ).removeClass( 'closed' );
        }

    });

    modula.settings = {
        'model' : modulaSettings,
        'view' : modulaSettingsView
    };

}( jQuery, wp.Modula ))

