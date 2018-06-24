
<div id="login-dialog" class="dialog" style="display: <?php echo $styleLog; ?>">
    <div class="dialog-content">
        <img class="exit" id="loginExit" src="Images/cancel.png" alt="Cancel">
        <p class="dialog-header">Login</p>
        <form class="horizontal-form" id="login-form" method="post">
            <div class="form-row">
                <input type="text" class="form-input" id="username" name="username" placeholder="Username"
                       value="<?php echo $username; ?>">
            </div>
            <div class="form-row">
                <input type="password" class="form-input" id="password" name="password" placeholder="Password"
                       value="<?php echo $password; ?>">
            </div>
            <?php
            if ($loginFormSend && (!$usernameValid || !$passwordValid || !$userRegistered)) writeLoginError();
            if ($loginFormSend && isUserLoggedIn()) writeRegisterError("alreadyLogged");
            ?>
            <input type="submit" name="login-sub" class="submit-btn" id="submit-button-login" value="Login">
        </form>
    </div>
</div>