<?php include "inc/header.php"; ?>
<div id="content">
    <div id="main">
        <h1>Регистрация</h1>
        <?php if (!empty($_SESSION['msg'])) echo $_SESSION['msg'] ?>
        <?php unset($_SESSION['msg']) ?>
        <form action="/?ctrl=registration" method="post">
            Логин<br>
            <input type="text" name="reg_login" value="<?php if (!empty($_SESSION['reg']['login'])) echo $_SESSION['reg']['login'] ?>">
            <br>
            Пароль<br>
            <input type="password" name="reg_password">
            <br>
            Подтвердите пароль<br>
            <input type="password" name="reg_password_confirm">
            <br>
            Почта<br>
            <input type="email" name="reg_email" value="<?php if (!empty($_SESSION['reg']['email'])) echo $_SESSION['reg']['email'] ?>">
            <br>
            Имя<br>
            <input type="text" name="reg_name" value="<?php if (!empty($_SESSION['reg']['name'])) echo $_SESSION['reg']['name'] ?>">
            <br>
            <button type="submit" name="reg" style="float:left;cursor:pointer;">Регистрация</button>
        </form>
    </div>
</div>
<?php include "inc/sidebar.php"; ?>

<?php include "inc/footer.php"; ?>

<?php unset($_SESSION['reg']); ?>