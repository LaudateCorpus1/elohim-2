<div class="userRegister module form" id="userRegister">
    <form id="userRegister-form" novalidate="novalidate">
    <div class="form form-userRegister">
        <div class="row">
            <label for="userRegister-username">Username</label>
            <input type="text" name="username" id="userRegister-username" />
        </div>
        <div class="row">
            <label for="userRegister-password">Password</label>
            <input type="password" name="password" id="userRegister-password" />
        </div>
        <div class="row">
            <label for="userRegister-passwordConfirm">Confirm Password</label>
            <input type="password" name="passwordConfirm" id="userRegister-passwordConfirm" />
        </div>
        <div class="row spacer"><span class="info">Please enter a valid email address. You will receive an email to this address with your account activation.</span></div>
        <div class="row">
            <label for="userRegister-email">Email</label>
            <input type="text" name="email" id="userRegister-email" />
        </div>
        <div class="row">
            <label for="userRegister-emailConfirm">Confirm Email</label>
            <input type="text" name="emailConfirm" id="userRegister-emailConfirm" />
        </div>
        <div class="row spacer">
            <label for="userRegister-termsOfUse">Do you agree to the Terms of Use?</label>
            <input type="checkbox" name="termsOfUse" id="userRegister-termsOfUse" />
        </div>
        <div class="row ">
            <label for="userRegister-ageConfirm">Are you 18 years or older?</label>
            <input type="checkbox" name="ageConfirm" id="userRegister-ageConfirm" />
        </div>
        <div class="row error-response"></div>
        <button id="userRegister-submit" disabled="false" class="button-center form-button">Register Account</button>
    </div>
    </form>
</div>