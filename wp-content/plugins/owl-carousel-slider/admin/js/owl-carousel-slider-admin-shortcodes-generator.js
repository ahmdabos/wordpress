/* 
 *  Shortcode Builder JS File
 *  v1.0.0
 */

(function ($) {
    'use strict';

    $(document).ready(function () {
        tinymce.PluginManager.add('oc_shortcodes_mce_button', function (editor, url) {
            editor.addButton('oc_shortcodes_mce_button', {
                title: 'Owl Carousel Slider',
                type: 'menubutton',
                icon: 'icon oc-icon',
                menu: [

                    /* OC Slider */
                    {
                        text: 'OC Slider',
                        onclick: function () {
                            editor.windowManager.open({
                                title: 'Insert OC Slider Shortcode',
                                body: [

                                    // Post ID                               
                                    {
                                        type:  'textbox',
                                        name:  'id',
                                        label: 'Post ID',
                                        placeholder: 'ID of OC Slider',
                                    },

                                     // Number of Items                               
                                    {
                                        type:  'textbox',
                                        name:  'items',
                                        label: 'Items',
                                        value: 3,
                                    },

                                    // Navigation                                  
                                    {
                                        type:  'listbox',
                                        name:  'navigation',
                                        label: 'Navigation',
                                        values: [
                                            {text: 'True', value: 'true'},
                                            {text: 'False', value: 'false'},
                                        ]
                                    },

                                    // Single Item                                  
                                    {
                                        type:  'listbox',
                                        name:  'single_item',
                                        label: 'Single Item',
                                        values: [
                                            {text: 'False', value: 'false'},
                                            {text: 'True', value: 'true'},

                                        ]
                                    },

                                     // Slide Speed                              
                                    {
                                        type:  'textbox',
                                        subtype: 'number',
                                        name:  'slide_speed',
                                        label: 'Slide Speed', 
                                        value: 300,
                                    },
                                    
                                    // Lazy Load                                  
                                    {
                                        type: 'listbox',
                                        name: 'lazy_load',
                                        label: 'Lazy Load',
                                        values: [
                                            {text: 'True', value: 'true'},
                                            {text: 'False', value: 'false'},
                                        ]
                                    },
                                    // Auto Height                                 
                                    {
                                        type: 'listbox',
                                        name: 'auto_height',
                                        label: 'Auto Height for Single Item',
                                        values: [
                                            {text: 'True', value: 'true'},
                                            {text: 'False', value: 'false'},
                                        ]
                                    },

                                ],
                                onsubmit: function (e) {

                                    // If user enter number less than 1
                                    if (e.data.id < 1 ) { 

                                       // Change value with null
                                        e.data.id = '';
                                    }  
                                    editor.insertContent('[oc_slider_shortcode id="' + e.data.id + '" items="' + e.data.items + '" navigation="' + e.data.navigation + '" single_item="' + e.data.single_item+ '" slide_speed="' + e.data.slide_speed+ '"lazy_load="' + e.data.lazy_load + '"auto_height="' + e.data.auto_height + '"]');
                                }
                            });
                        }
                    }, // End oc shortcode generator
                ]
            });
        });
    });
})(jQuery);