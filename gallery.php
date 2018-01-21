<div id="gallery-<?= $instance ?>" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
<?php
$i = 0;
foreach ($attachments as $id => $attachment) {
    $thumb = wp_get_attachment_image_src($id, 'thumbnail');
    $image = wp_get_attachment_image_src($id, 'large');
?>
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <a href="<?= $image['url'] ?>" itemprop="contentUrl" data-size="<?= $image['width']; ?>x<?= $image['height']; ?>">
            <img src="<?= $thumb['url'] ?>" itemprop="thumbnail" alt="">
        </a>
    </figure>
<?php
}
