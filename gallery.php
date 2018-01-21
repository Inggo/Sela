<div id="gallery-<?= $instance ?>" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
<?php
$i = 0;
foreach ($attachments as $id => attachment) {
    $thumbnail = wp_get_attachment_image($id, 'thumbnail');
    $image = wp_get_attachment_image($id, 'large');
    $image_meta = wp_get_attachment_metadata($id);
?>
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <pre>
        <?php var_dump($thumbnail); ?>
        <?php var_dump($image); ?>
        <?php var_dump($image_meta); ?>
        </pre>
    </figure>
<?php
}
