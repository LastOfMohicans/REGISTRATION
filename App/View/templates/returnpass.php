<?php include 'inc/header.php' ?>
<div id="content">
    <div id="main">
        <h1>Введите свой почтовый адрес!!!</h1>
        <?php if (!empty($_SESSION['msg'])) echo $_SESSION['msg'] ?>
        <?php unset($_SESSION['msg']) ?>

        <form action="/?ctrl=returnpass" method="post">
            <label for="mail">
                EMAIL<br>
                <input type="text" id="mail" name="email">
            </label><br>
            <input style="float: left;" type="submit" value="Вход">
        </form>
    </div>
</div>
<?php include 'inc/sidebar.php' ?>

<?php include 'inc/footer.php' ?>