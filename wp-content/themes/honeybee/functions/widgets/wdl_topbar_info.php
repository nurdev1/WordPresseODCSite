<?php

// Register and load the widget
function honeybee_header_topbar_info_widget() {
    register_widget('honeybee_header_topbar_info_widget');
}

add_action('widgets_init', 'honeybee_header_topbar_info_widget');

// Creating the widget
class honeybee_header_topbar_info_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'honeybee_header_topbar_info_widget', // Base ID
                esc_html__('HoneyBee: Header info widget', 'honeybee'), // Widget Name
                array(
                    'classname' => 'honeybee_header_topbar_info_widget',
                    'description' => esc_html__('Topbar header info widget.', 'honeybee'),
                ),
                array(
                    'width' => 600,
                )
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        ?>
        <ul class="head-contact-info">
            <li>
                <?php if (!empty($instance['fa_icon'])) { ?>
                    <i class="fa <?php echo esc_attr($instance['fa_icon']); ?>"></i>
                <?php } else { ?>
                    <i class="fa fa-phone"></i>
                <?php } ?>
                <?php
                if (!empty($instance['description'])) {
                    echo esc_html($instance['description']);
                } else {
                    echo esc_html__('+99 999-999-9999', 'honeybee');
                }
                ?></li>
            <li>
                <?php if (!empty($instance['honeybee_email'])) { ?>
                    <i class="fa <?php echo esc_attr($instance['honeybee_email']); ?>"></i>
                <?php } else { ?>
                    <i class="fa fa-envelope-o"></i>
                <?php } ?>
                <?php
                if (!empty($instance['honeybee_email_id'])) {
                    echo '<a href="mailto:' . esc_attr($instance['honeybee_email_id']) . '">';

                    echo esc_html($instance['honeybee_email_id']);
                    echo '</a>';
                } else {
                    echo '<a href="mailto:abc@example.com">';

                    echo esc_html__('abc@example.com', 'honeybee');
                    echo '</a>';
                }
                ?></li>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance) {

        if (isset($instance['fa_icon'])) {
            $fa_icon = $instance['fa_icon'];
        } else {
            $fa_icon = 'fa fa-phone';
        }

        if (isset($instance['description'])) {
            $description = $instance['description'];
        } else {
            $description = esc_html__('+99 999-999-9999', 'honeybee');
        }

        if (isset($instance['honeybee_email'])) {
            $honeybee_email = $instance['honeybee_email'];
        } else {
            $honeybee_email = 'fa fa-envelope-o';
        }

        if (isset($instance['honeybee_email_id'])) {
            $honeybee_email_id = $instance['honeybee_email_id'];
        } else {
            $honeybee_email_id = esc_html__('abc@example.com', 'honeybee');
        }

        // Widget admin form
        ?>

        <label for="<?php echo esc_attr($this->get_field_id('fa_icon')); ?>"><?php esc_html_e('Font Awesome icon', 'honeybee'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('fa_icon')); ?>" name="<?php echo esc_attr($this->get_field_name('fa_icon')); ?>" type="text" value="<?php
        if ($fa_icon)
            echo esc_attr($fa_icon);
        else
            esc_attr_e('fa-icon', 'honeybee');
        ?>" />
        <span><?php esc_html_e('Link to get Font Awesome icons', 'honeybee'); ?><a href="<?php echo esc_url('http://fortawesome.github.io/Font-Awesome/icons/', 'honeybee'); ?>" target="_blank" ><?php esc_html_e('fa-icon', 'honeybee'); ?></a></span>
        <br><br>

        <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Phone', 'honeybee'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>" type="text" value="<?php
        if ($description)
            echo esc_attr(htmlspecialchars_decode($description));
        else
            esc_attr_e('Phone: +99 999-999-9999', 'honeybee');
        ?>" /><br><br>

        <label for="<?php echo esc_attr($this->get_field_id('honeybee_email')); ?>"><?php esc_html_e('Font Awesome icon', 'honeybee'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('honeybee_email')); ?>" name="<?php echo esc_attr($this->get_field_name('honeybee_email')); ?>" type="text" value="<?php
        if ($honeybee_email)
            echo esc_attr($honeybee_email);
        else
            esc_attr_e('fa fa-phone', 'honeybee');
        ?>" />
        <span><?php esc_html_e('Link to get Font Awesome icons', 'honeybee'); ?><a href="<?php echo esc_url('http://fortawesome.github.io/Font-Awesome/icons/', 'honeybee'); ?>" target="_blank" ><?php esc_html_e('fa-icon', 'honeybee'); ?></a></span><br><br>

        <label for="<?php echo esc_attr($this->get_field_id('honeybee_email_id')); ?>"><?php esc_html_e('Email', 'honeybee'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('honeybee_email_id')); ?>" name="<?php echo esc_attr($this->get_field_name('honeybee_email_id')); ?>" type="text" value="<?php
               if ($honeybee_email_id)
                   echo esc_attr(htmlspecialchars_decode($honeybee_email_id));
               else
                   esc_attr_e('Email: abc@example.com', 'honeybee');
               ?>" /><br><br>

        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {

        $instance = array();
        $instance['fa_icon'] = (!empty($new_instance['fa_icon']) ) ? honeybee_sanitize_text($new_instance['fa_icon']) : '';
        $instance['description'] = (!empty($new_instance['description']) ) ? honeybee_sanitize_text($new_instance['description']) : '';
        $instance['honeybee_email'] = (!empty($new_instance['honeybee_email']) ) ? honeybee_sanitize_text($new_instance['honeybee_email']) : '';
        $instance['honeybee_email_id'] = (!empty($new_instance['honeybee_email_id']) ) ? honeybee_sanitize_text($new_instance['honeybee_email_id']) : '';

        return $instance;
    }

}
