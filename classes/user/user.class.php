<?php

class User {

    private $user;

    public function __construct($userid = false) {
        if ($userid && is_int($userid))
            $this->getUserByUserID($userid);
        else if ($userid)
            $this->getUserByLoginName($userid);
        else
            $this->user = false;

        $this->verifySessionLoggedIn();
    }

    public function userIsLoggedIn() {
        return $this->user != false;
    }

    public function registerUser($username, $password, $email, $timezone = 0) {
        $db = new Database();

        if (!$this->validateUsernameCharacters($username))
            return array(false, 'INVALID_USERNAME_CHARACTERS_OR_LENGTH');

        if (!$this->validatePasswordLength($password))
            return array(false, 'INVALID_PASSWORD_LENGTH');

        if (!$this->validateEmailAddress($email))
            return array(false, 'INVALID_EMAIL_ADDRESS');

        if ($db->query('select userID from user where loginName=:loginName', array(':loginName'=>$username)) > 0)
            return array(false, 'USERNAME_IN_USE');

        if ($db->query('select emailAddress from user where emailAddress=:emailAddress', array(':emailAddress'=>$email)) > 0)
            return array(false, 'EMAIL_ADDRESS_IN_USE');

        $params = array(
            ':loginName' => $username,
            ':emailAddress' => $email,
            ':encPassword' => $this->encryptPassword($password),
            ':signupDate' => time(),
            ':accountActivation' => $this->generateActivationCode(),
            ':timezoneOffset' => $timezone,
            ':userEnabled' => 0
        );

        if ($db->query('insert into user (loginName, emailAddress, encPassword, signupDate, accountActivation, timezoneOffset, userEnabled) values (:loginName, :emailAddress, :encPassword, :signupDate, :accountActivation, :timezoneOffset, :userEnabled)', $params) != 1)
            return array(false, 'ERROR_CREATING_USER');

        $this->sendActivationEmail($db->getLastID(), $params[':accountActivation'], $params[':loginName'], $params[':emailAddress']);

        return array(true, 'USER_CREATED');
    }

    public function activateUser($username, $activation) {
        $db = new Database();

        if ($db->query('select userID,activationCode from user where loginName=:loginname', array(":loginname" => $username)) != 1) {
            return array(false, "INVALID_CODE");
        }

        $result = $db->getArray(true);

        if (strlen($activation) < 8) {
            $this->logUserInteraction($result['userID'], 'ACTIVATION_FAIL_INVALID_FORMAT');
            return array(false, "INVALID_FORMAT");
        }

        if (trim($activation) != trim($result['activationCode'])) {
            $this->logUserInteraction($result['userID'], 'ACTIVATION_FAIL_INVALID_CODE');
            return array(false, "INVALID_CODE");
        }

        if ($db->query('update user set userActivation=:activation, userEnabled=:enabled where userID=:userid', array(":activation" => "", ":enabled" => true, ":userid" => $result['userID'])) == 0) {
            $this->logUserInteraction($result['userID'], 'ACTIVATION_FAIL_DATABASE_ERROR');
            return array(false, "DATABASE_ERROR");
        }

        $this->logUserInteraction($result['userID'], 'ACTIVATION_SUCCESS');
        return array(true, "ACTIVATION_SUCCESS");
    }

    public function loginUser($username, $password) {
        if ($this->user)
            return array(false, "USER_ALREADY_LOGGED_IN");

        $session = Session::getInstance();
        $db = new Database();

        $params = array(
            ":username" => $username
        );

        if ($db->query("select userID, loginName, emailAddress, encPassword, userEnabled, accountActivation, timezoneOffset from user where loginName=:username", $params) == 0) {
            return array(false, "INVALID_CREDENTIALS");
        }

        $result = $db->getArray(true);

        if (!$this->verifyPassword($password, $result['encPassword'])) {
            $this->logUserInteraction($result['userID'], 'LOGIN_FAIL_INVALID_CREDENTIALS');
            return array(false, "INVALID_CREDENTIALS");
        }

        if ($result['accountActivation'] != "") {
            $this->logUserInteraction($result['userID'], 'LOGIN_FAIL_ACCOUNT_INACTIVE');
            return array(false, "ACCOUNT_INACTIVE");
        }

        if (!$result['userEnabled']) {
            $this->logUserInteraction($result['userID'], 'LOGIN_FAIL_ACCOUNT_DISABLED');
            return array(false, "ACCOUNT_DISABLED");
        }

        if ($this->userIsBanned($result['userID'])) {
            $this->logUserInteraction($result['userID'], 'LOGIN_FAIL_ACCOUNT_BANNED');
            return array(false, "ACCOUNT_BANNED", $session->get('user.ban'));
        }

        if (!$this->getUserByUserID($result['userID'])) {
            $this->logUserInteraction($result['userID'], 'LOGIN_FAIL_UNKNOWN_ERROR');
            return array(false, "UNKNOWN_ERROR");
        }

        $this->user = array(
            "userID" => $result['userID'],
            "loginName" => $result['loginName'],
            "emailAddress" => $result['emailAddress'],
            "timezoneOffset" => $result['timezoneOffset']
        );

        $session->put('user', $this->user);

        $this->logUserInteraction($result['userID'], 'LOGIN_SUCCESS');
        return array(true, "LOGGED_IN");
    }

    public function logoutUser() {
        if (!$this->user)
            return false;

        $session = Session::getInstance();

        $this->logUserInteraction($this->user['userID'], 'LOGOUT_USER_SUCCESS');
        $this->user = false;
        $session->put('user', false);
        return true;
    }

    public function editUser($password, $passwordNew, $passwordConfirm, $timezone, $email, $emailConfirm) {
        if (!$this->user)
            return array(false, "USER_NOT_LOGGED_IN");

        $db = new Database();

        if ($db->query('select encPassword from user where userID=:userid', array(':userid' => $this->user['userID'])) != 1) {
            $this->logUserInteraction($this->user['userID'], "EDIT_USER_FAILED_NO_USER_RECORD");
            return array(false, "USER_RECORD_NOT_FOUND");
        }

        if ((strlen($email) > 0 && $email == $this->user['emailAddress']) && $timezone == $this->user['timezoneOffset']) {
            return array(false, "FIELDS_UNCHANGED");
        }


        $result = $db->getArray(true);
        if (!$this->verifyPassword($password, $result['encPassword'])) {
            $this->logUserInteraction($this->user['userID'], "EDIT_USER_FAILED_PASSWORD_ERROR");
            return array(false, "PASSWORD_ERROR");
        }

        $params = array();
        $query = "update user set ";


        $passwordChange = false;
        if (strlen($passwordNew) > 0) {
            if ($passwordNew != $passwordConfirm) {
                $this->logUserInteraction($this->user['userID'], "EDIT_USER_FAILED_PASSWORD_CONFIRM_ERROR");
                return array(false, "PASSWORD_CONFIRM");
            } else if (!$this->validatePasswordLength($passwordNew)) {
                $this->logUserInteraction($this->user['userID'], "EDIT_USER_FAILED_PASSWORD_LENGTH_ERROR");
                return array(false, "PASSWORD_LENGTH");
            } else {
                $params[":password"] = $this->encryptPassword($passwordNew);
                $query .= "encPassword=:password, ";
                $passwordChange = true;
            }
        }

        $deactivateAccount = false;
        if (strlen($email) > 0) {
            if ($email != $emailConfirm) {
                $this->logUserInteraction($this->user['userID'], "EDIT_USER_FAILED_EMAIL_CONFIRM_ERROR");
                return array(false, "EMAIL_CONFIRM");
            } else if (!$this->validateEmailAddress($email)) {
                $this->logUserInteraction($this->user['userID'], "EDIT_USER_FAILED_EMAIL_INVALID_ERROR");
                return array(false, "EMAIL_INVALID");
            } else {
                $params[":email"] = $email;
                $query .= "emailAddress=:email, ";
                $deactivateAccount = true;
            }
        }

        $timezone = (int)$timezone;
        if (!is_int($timezone)) {
            echo "timezone is not int";
            $timezone = 0;
        }

        $params[":timezone"] = $timezone;
        $query .= "timezoneOffset=:timezone";

        $params[":userid"] = $this->user["userID"];
        $query .= " where userID=:userid limit 1";

        if ($db->query($query, $params) == 1) {
            $this->logUserInteraction($this->user['userID'], "EDIT_USER_COMPLETE".($deactivateAccount?"_DEACTIVATE":"").($passwordChange?"_PASSWORDCHANGE":""));
            if ($deactivateAccount) $this->deactivateAccount($email);
            else if ($passwordChange) $this->logoutUser();
            return array('true', 'USER_EDIT', array('deactivate' => $deactivateAccount, 'password' => $passwordChange));
        }

        return array(false, "SAVE_DATA_ERROR");
    }

    public function userHasGroupPermission($groupID, $permission) {

    }

    public function getEmailAddress() {
        return (!$this->user)?false:$this->user['emailAddress'];
    }

    public function getTimezoneOffset() {
        return (!$this->user)?false:$this->user['timezoneOffset'];
    }

    private function deactivateAccount($email) {
        if (!$this->user)
            return false;

        $db = new Database();

        $params = array(
            ":activation" => $this->generateActivationCode(),
            ":enabled" => 0,
            ":userid" => $this->user["userID"]
        );

        if ($db->query('update user set accountActivation=:activation, userEnabled=:enabled where userID=:userid', $params) == 1) {
            if ($this->sendActivationEmail($this->user["userID"], $params[":activation"], $this->user["loginName"], $email)) {
                $this->logoutUser();
                return true;
            }
        }

        return false;
    }

    private function logUserInteraction($userid, $type = 'USER_REQUEST_FAILURE_UNKNOWN') {
        $params = array(
            ":userid" => $userid,
            ":accessdate" => mktime(),
            ":ipaddress" => $_SERVER["REMOTE_ADDR"],
            ":lognote" => $type
        );

        $db = new Database();
        $db->query('insert into user_access_log (userID, accessDate, ipAddress, logNote) values (:userid, :accessdate, :ipaddress, :lognote)', $params);
    }

    private function userIsBanned($userid) {
        $query = "select banReason, startDate, endDate from user_ban where bannedUserID=:userid and startDate < :now and endDate > :now and (revocationDate is null or revocationDate > :now)";
        $params = array(
            ":userid" => $userid,
            ":now" => mktime()
        );

        $session = Session::getInstance();
        $db = new Database();

        if ($db->query($query, $params) == 0) {
            $session->put('user.ban', false);
            return false;
        }

        $session->put('user.ban', $db->getArray(true));

        return true;
    }

    private function verifySessionLoggedIn() {
        $session = Session::getInstance();
        $this->getUserByUserID($session->get('user.userID'));
    }

    private function getUserByUserID($userid) {
        if (!$userid) {
            return false;
        }

        $db = new Database();
        $session = Session::getInstance();

        if ($db->query("select userID, loginName, timezoneOffset, signupDate, emailAddress from user where userID=:userid", array(':userid' => $userid)) != 1) {
            return false;
        }

        $result = $db->getArray(true);

        $this->user = $result;

        $session->put('user.id', $result['userID']);
        $session->put('user.login', $result['loginName']);
        $session->put('user.timezone', (int)$result['timezoneOffset']);

        return true;
    }

    private function getUserByLoginName($username) {
        $db = new Database();

        if ($db->query('select userID from user where loginName=:username', array(':username' => $username) != 1))
            return false;

        $result = $db->getArray(true);

        return $this->getUserByUserID($result['userID']);
    }

    private function encryptPassword($password) {
        $_seed = $this->generatePasswordSeed();
        return hash('SHA256', $password.$_seed).":".$_seed;
    }

    private function verifyPassword($password, $_enc) {
        $parts = explode(':', $_enc);
        return hash('SHA256', $password.$parts[1]) == $parts[0];
    }

    private function generatePasswordSeed() {
        return md5($_SERVER['HTTP_USER_AGENT'].":".time().":".mt_rand(1,100000));
    }

    private function generateActivationCode() {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $str = "";
        for ($i = 0; $i < 8; $i++)
            $str .= $chars[mt_rand(0,strlen($chars) - 1)];
        return $str;
    }

    private function sendActivationEmail($userid, $activation, $username, $email) {
        $template = new MailTemplates();
        $tpl = $template->mergeTemplate('activateAccount', array('username' => $username, 'code' => $activation));
        if (!$tpl)
            return false;

        $this->logUserInteraction($userid, "ACCOUNT_ACTIVATION_EMAIL_SENT");

        return Sendmail::sendHTMLMail($email, array(
            'subject' => "Manifest Destiny Account Activation",
            'text_message' => $tpl['text'],
            'html_message' => $tpl['html']
        ));
    }

    function validatePasswordLength($password) {
        return strlen($password) >= 8;
    }

    function validateEmailAddress($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validateUsernameCharacters($username) {
        return preg_match('/^[a-z0-9 ._-]{3,}$/i', $username);
    }
}