<?php

$items = explode(',', $atts['ids']);

?>
<div class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
    <?php foreach ($items as $item_id): $item = wp_get_attachment_metadata($item_id); ?>
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <a href="" itemprop="contentUrl" data-size="600x400">
            <img src="<?= $item['sizes']['thumbnail']['file']; ?>" itemprop="thumbnail" alt="Image description" />
        </a>
        <figcaption itemprop="caption description">Image caption</figcaption>
    </figure>
    <?php endforeach; ?>
</div>

<?php

$items = explode(',', $atts['ids']);

foreach ($items as $item_id) {
    $item = wp_get_attachment_metadata($item_id);

}
