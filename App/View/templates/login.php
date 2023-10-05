<?php include "inc/header.php"; ?>
<div id="content">
    <div id="main">
        <h1>Авторизуйтесь</h1>
        <?php if (!empty($_SESSION['msg'])) echo $_SESSION['msg'] ?>
        <?php unset($_SESSION['msg']) ?>

        <form action="/?ctrl=login" method="post">
            <label>
                login<br>
                <input type="text" name="login">
            </label><br>
            Password<br>
            <label>
                <input type="password" name="password">
            </label><br>
            <label>Member
                <input type="checkbox" name="member" value="1">
            </label><br>
            <button type="submit" style="float: left">Вход</button>
        </form>

        <form action="/?ctrl=logout" method="post">
            <input type="submit" style="margin-top: -16px" name="logout" value="Выход">
        </form>
        <p><a href="/?ctrl=registration">Регистрация</a> | <a href="/?ctrl=Returnpass">Забыли пароль?</a></p>
    </div>
</div>
<?php include "inc/sidebar.php"; ?>

<?php include "inc/footer.php"; ?>