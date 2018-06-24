
<div id="register-dialog" class="dialog" style="display: <?php echo $styleReg; ?>">
    <div class="dialog-content">
        <img class="exit" id="registerExit" src="Images/cancel.png" alt="Cancel">
        <p class="dialog-header">Register</p>
        <form class="horizontal-form" id="register-form" method="post">
            <div class="form-row">
                <input type="text" class="form-input" id="username-register" name="usernameReg" placeholder="Username"
                       value="<?php echo $usernameReg; ?>">
            </div>
            <div class="form-row">
                <input type="email" class="form-input" id="email" name="email" placeholder="Email"
                       value="<?php echo $email; ?>">
            </div>
            <div class="form-row">
                <input type="password" class="form-input" id="passwordRegister" name="passwordReg"
                       placeholder="Password" value="<?php echo $passwordReg; ?>">
            </div>
            <div class="form-row">
                <input type="password" class="form-input" id="confirm" name="confirm" placeholder="Confirm Password"
                       value="<?php echo $confirm; ?>">
            </div>
            <?php
            if ($registerFormSend && !$usernameRegValid) writeRegisterError("username");
            if ($registerFormSend && !$emailValid) writeRegisterError("email");
            if ($registerFormSend && !$passwordRegValid) writeRegisterError("password");
            if ($registerFormSend && !$confirmValid) writeRegisterError("confirm");
            if ($registerFormSend && !$usernameUnique) writeRegisterError("usernameUnique");
            if ($registerFormSend && !$emailUnique) writeRegisterError("emailUnique");
            if ($registerFormSend && !$registerSuccesful) writeRegisterError("register");
            if ($registerFormSend && isUserLoggedIn()) writeRegisterError("alreadyLogged");
            ?>
            <input type="submit" name="reg-sub" class="submit-btn" id="submit-button-register" value="Register">
        </form>
    </div>
</div>