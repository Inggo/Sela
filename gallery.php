<?php

$items = $atts['ids'];

foreach ($items as $item_id) {
    $item = get_post($item_id);

    var_dump($item);
}
