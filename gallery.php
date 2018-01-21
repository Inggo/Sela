<div id="gallery-<?= $instance ?>" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
<?php
$i = 0;
foreach ($attachments as $id => $attachment) {
    $thumb = wp_get_attachment_image_src($id, 'thumbnail');
    $image = wp_get_attachment_image_src($id, 'large');
?>
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <a href="<?= $image[0] ?>" itemprop="contentUrl" data-size="<?= $image[1]; ?>x<?= $image[2]; ?>">
            <img src="<?= $thumb[0] ?>" itemprop="thumbnail" alt="">
        </a>
    </figure>
<?php
}
