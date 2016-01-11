<?php

if(defined('CI_OPT_IN_TO_SHARED_CUSTOMIZATION_UTILS')) {

    if(class_exists('WP_Customize_Control')) {
        /**
         * Adds a textarea control for the theme customizer
         */
        class CiCustomizeTextareaControl extends WP_Customize_Control {
            public $type = 'textarea';
            public function render_content() { ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                </label> <?php
            }
        }

        /**
         * Adds a text control with placeholder text
         */
        class CiCustomizeTextControlWithPlaceholder extends WP_Customize_Control {
            public $type = 'text';
            public $placeholder = '';
            public function render_content() { ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <?php
                    $value = esc_attr($this->value());
                    if($value) { ?>
                        <input type="text" placeholder="<?php echo $this->placeholder; ?>" <?php $this->link(); ?> value="<?php echo $value; ?>" /> <?php
                    } else { ?>
                        <input type="text" placeholder="<?php echo $this->placeholder; ?>" <?php $this->link(); ?> /> <?php
                    } ?>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                </label> <?php
            }
        }

        /**
         * Adds a control that allows you to select multiple checkboxes
         */
        class CiCustomizeMulticheckControl extends WP_Customize_Control {
            public $type = 'checkbox-multiple';
            public function render_content() { ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                    <?php $multi_values = !is_array($this->value()) ? explode(',', $this->value()) : $this->value(); ?>
                    <ul> <?php
                        foreach($this->choices as $value => $label) { ?>
                            <li>
                                <label>
                                    <input type="checkbox" value="<?php echo esc_attr($value); ?>" <?php echo checked(array_key_exists($value, $multi_values)); ?> />
                                    <?php echo esc_html($label); ?>
                                </label>
                            </li> <?php
                        } ?>
                    </ul>
                    <input type="hidden" value="<?php echo esc_attr(implode(',', $multi_values)); ?>" <?php $this->link(); ?> />
                </label> <?php
            }
        }

        class CiCustomizeHeadingControl extends WP_Customize_Control {
            public $type = "heading";
            public function render_content() { ?>
                <h2 class="customize-control-title"><?php echo esc_html($this->label); ?></h2> <?php
            }
        }

        class CiCustomizeInfoControl extends WP_Customize_Control {
            public $type = "info";
            public function render_content() { ?>
                <p><?php echo $this->description; ?></p> <?php
            }
        }

        class CiCustomizeHorizontalRuleControl extends WP_Customize_Control {
            public $type = "line";
            public function render_content() { ?>
                <hr style="border-top: solid 1px #333;"> <?php
            }
        }

        /**
         * Class to create an image version of a radio button group
         */
        class CiCustomizeImagePickerControl extends WP_Customize_Control
        {
            public $type = 'radio-images';
            public $options = array();
            public function render_content() { ?>
                <label>
                    <span class="customize-layout-control"><?php echo esc_html( $this->label ); ?></span>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                    <div class="buttonset"> <?php
                        foreach($this->options as $key => $img) {
                            $checkedStatus = "";
                            if($key === $this->value()) {
                                $checkedStatus = 'checked="checked"';
                            }
                            $inputId = $this->id . "-" . $key; ?>
                            <input type="radio" value="<?php echo $key ?>" name="_customize-<?php echo $this->type; ?>-<?php echo $this->id; ?>" id="<?php echo $inputId; ?>" <?php $this->link(); echo $checkedStatus; ?> />
                            <label for="<?php echo $inputId; ?>">
                                <img src="<?php echo $img; ?>" alt="<?php echo $key; ?>" width="50" />
                            </label> <?php
                        } ?>
                    </div>
                </label>
                <?php
            }
        }


        /**
         * Adds a TinyMCE editor for a text field
         */
        class CiCustomizeEditorControl extends WP_Customize_Control {
            public $type = 'editor';
            public function render_content() { ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                    <!--                <input type="hidden" --><?php //$this->link(); ?><!-- value="--><?php //echo esc_textarea( $this->value() ); ?><!--">-->
                    <?php
                    /**
                     * For settings options see:
                     * http://codex.wordpress.org/Function_Reference/wp_editor
                     *
                     * 'media_buttons' are not supported as there is no post to attach items to
                     * 'textarea_name' is set by the 'id' you choose
                     */
                    $settings = array('textarea_name' => $this->id, 'media_buttons' => true, 'drag_drop_upload' => true, 'textarea_rows' => 5, 'tinymce' => array('plugins' => 'wordpress'));
                    wp_editor($this->value(), $this->id, $settings);
                    if(!did_action('admin_print_footer_scripts') == 0) {
                        do_action('admin_footer');
                        do_action('admin_print_footer_scripts');
                    } ?>
                </label> <?php
            }
        }
    }

    function ciReturnIdentity($arg) { return $arg; }
    function ciSanitizeBool($bool) { if($bool === "0" || $bool === false || $bool === "false") { return false; } else { return true; } }

    function ciAddCustomizationsToSection($wp_customize, $optionsArray, $sectionSlug) {
        foreach($optionsArray as $option) {
            // Add the setting (under the hood)
            $sanitizeFunction = 'ciReturnIdentity';
            if($option['type'] == 'checkbox') {
                $sanitizeFunction = 'ciSanitizeBool';
            } elseif($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'editor' || $option['type'] == 'heading' || $option['type'] == 'info') {
                $sanitizeFunction = 'esc_textarea';
            }
            $wp_customize->add_setting($option['slug'], array('default' => $option['default'], 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => $sanitizeFunction));

            // Add the control itself to the page
            if($option['type'] == 'color') {
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $option['slug'], array('label' => $option['label'], 'section' => $sectionSlug, 'settings' => $option['slug'], 'description' => $option['description'])));
            } elseif($option['type'] == 'checkbox') {
                $wp_customize->add_control($option['slug'], array('label' => $option['label'], 'section' => $sectionSlug, 'type' => 'checkbox', 'description' => $option['description']));
            } elseif($option['type'] == 'multicheck') {
                $wp_customize->add_control(new CiCustomizeMulticheckControl(
                    $wp_customize,
                    $option['slug'],
                    array(
                        'label' => $option['label'],
                        'description' => $option['description'],
                        'section' => $sectionSlug,
                        'choices' => $option['options'],
                        'type' => 'multicheck'
                    )
                ));
            } elseif($option['type'] == 'heading') {
                $wp_customize->add_control(new CiCustomizeHeadingControl(
                    $wp_customize,
                    $option['slug'],
                    array(
                        'label' => $option['label'],
                        'section' => $sectionSlug,
                        'type' => 'heading'
                    )
                ));
            } elseif($option['type'] == 'info') {
                $wp_customize->add_control(new CiCustomizeInfoControl(
                    $wp_customize,
                    $option['slug'],
                    array(
                        'description' => $option['description'],
                        'section' => $sectionSlug,
                        'type' => 'info'
                    )
                ));
            } elseif($option['type'] == 'line') {
                $wp_customize->add_control(new CiCustomizeHorizontalRuleControl(
                    $wp_customize, $option['slug'], array('section' => $sectionSlug, 'type' => 'line')
                ));
            } elseif($option['type'] == 'text') {
                $wp_customize->add_control(
                    new CiCustomizeTextControlWithPlaceholder(
                        $wp_customize,
                        $option['slug'],
                        array(
                            'label' => $option['label'],
                            'section' => $sectionSlug,
                            'description' => $option['description'],
                            'placeholder' => $option['placeholder']
                        )
                    )
                );
            } elseif($option['type'] == 'editor') {
                $wp_customize->add_control(
                    new CiCustomizeEditorControl(
                        $wp_customize,
                        $option['slug'],
                        array(
                            'label' => $option['label'],
                            'section' => $sectionSlug,
                            'description' => $option['description']
                        )
                    )
                );
            } elseif($option['type'] == 'textarea') {
                $wp_customize->add_control(new CiCustomizeTextareaControl(
                    $wp_customize,
                    $option['slug'],
                    array(
                        'label' => $option['label'],
                        'section' => $sectionSlug,
                        'settings' => $option['slug'],
                        'description' => $option['description']
                    )
                ));
            } elseif($option['type'] == 'radio-images') {
                $wp_customize->add_control(new CiCustomizeImagePickerControl(
                    $wp_customize,
                    $option['slug'],
                    array(
                        'label' => $option['label'],
                        'section' => $sectionSlug,
                        'options' => $option['options'],
                        'description' => $option['description']
                    )
                ));
            } elseif($option['type'] == 'select') {
                $wp_customize->add_control($option['slug'], array('type' => 'select', 'label' => $option['label'], 'section' => $sectionSlug, 'description' => $option['description'], 'choices' => $option['options']));
            } elseif($option['type'] == 'radio') {
                $wp_customize->add_control($option['slug'], array('type' => 'radio', 'label' => $option['label'], 'section' => $sectionSlug, 'description' => $option['description'], 'choices' => $option['options']));
            } elseif($option['type'] == 'image') {
                $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $option['slug'], array('label' => $option['label'], 'section' => $sectionSlug, 'description' => $option['description'])));
            } else {
                die($option['type']);
            }
        }
    }
}


