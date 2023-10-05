<?php include 'inc/header.php'; ?>


<div id="content">
    <div id="main">
        <?php foreach ($posts as $item) : ?>
            <h1 id="title"><?= $item['title']; ?></h1>
            <p><?= $item['date']; ?></p>
            <p><img align="left" src="<?= IMG_PATH . $item['img_src'] ?>"><?= $item['discription']; ?></p>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'inc/sidebar.php'; ?>

<?php include 'inc/footer.php'; ?>