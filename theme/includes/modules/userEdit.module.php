<?php
$user = new User();
if ($user->userIsLoggedIn()) {
?>

<div class="userEdit module form" id="userEdit">
    <form id="userEdit-form" novalidate="novalidate">
        <h1>Edit User</h1>
        <div class="row">
            <label for="userEdit-password">Current Password</label>
            <input id="userEdit-password" name="password" type="password" />
        </div>
        <div class="row">
            <label for="userEdit-passwordNew">New Password</label>
            <input id="userEdit-passwordNew" name="passwordNew" type="password" />
        </div>
        <div class="row">
            <label for="userEdit-passwordConfirm">Confirm Password</label>
            <input id="userEdit-passwordConfirm" name="passwordConfirm" type="password" />
        </div>
        <div class="row">
            <?php
            echo $user->getTimezoneOffset();
            ?>
            <label for="userEdit-timezone">Timezone</label>
            <select id="userEdit-timezone" name="timezone">
                <?php
                for ($i = 12; $i > -13; $i--) {
                    echo '<option value="'.$i.'" '.($user->getTimezoneOffset() == $i?"selected":"").'>GMT '.$i.'</option>';
                }
                ?>
            </select>
        </div>
        <div class="row">
            <label for="userEdit-email">Email</label>
            <input id="userEdit-email" name="email" type="text" />
        </div>
        <div class="row">
            <label for="userEdit-emailConfirm">Confirm email</label>
            <input id="userEdit-emailConfirm" name="emailConfirm" type="text" />
        </div>
        <div class="row helptext">
            <p>Changing your email address will send a confirmation email to the new address. You will need to activate this email address again to login. Please enter a valid email address.</p>
        </div>
        <div class="row error-response"></div>
        <button id="userEdit-submit" disabled="false" class="button-small">Edit User</button>
    </form>
</div>

<?php
}
?>