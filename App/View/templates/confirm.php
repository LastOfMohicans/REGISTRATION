<?php include 'inc/header.php'; ?>
<div id="content">
    <div id="main">
        <?php if (!empty($error)) echo $error; ?>
        <?php if (!empty($confirm)) echo $confirm; ?>
    </div>
</div>

<?php include 'inc/sidebar.php'; ?>

<?php include 'inc/footer.php'; ?>