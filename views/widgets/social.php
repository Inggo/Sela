<?php global $INGGO_SELA;

echo $args['before_widget'];

if (!empty( $instance['title'])) {
    echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
}

?>
<div class="social-buttons">
    <?php $this->printSocialButtons($INGGO_SELA['customizer']); ?>
</div>
<?php

echo $args['after_widget'];