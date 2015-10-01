<?php
$user = new User();
if (!$user->userIsLoggedIn()) {
?>

<div class="userLogin module module-small form" id="userLogin">
    <form id="userLogin-form" novalidate="novalidate">
        <div class="row">
            <label for="userLogin-username">Username</label>
            <input id="userLogin-username" name="username" type="text" />
        </div>
        <div class="row">
            <label for="userLogin-password">Password</label>
            <input id="userLogin-password" name="password" type="password" />
        </div>
        <div class="row error-response"></div>
        <button id="userLogin-submit" disabled="false" class="button-small form-button">Login</button>
    </form>
</div>

<?php
} else {
?>

<div class="userLogout module module-small form" id="userLogout">
    <button class="button-small form-button user-logout">Logout</button>
</div>

<?php
}
?>