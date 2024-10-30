<?php
include_once "../includes/_head.php";
require_once '../tools/functions.php';
require_once '../classes/account.class.php';

session_start();

$accountObj = new Account();


$first_name = $last_name = $role = $username = $password = '';
$first_nameErr = $last_nameErr = $roleErr = $usernameErr = $passwordErr = '';
$allinputsfield = true;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $first_name = isset($_POST['first_name']) ? clean_input($_POST['first_name']) : '' ;
    $last_name = isset($_POST['last_name']) ? clean_input($_POST['last_name']) : '' ;
    $role = isset($_POST['role']) ? clean_input($_POST['role']) : '' ;
    $username = isset($_POST['username']) ? clean_input($_POST['username']) : '' ;
    $password = isset($_POST['password']) ? clean_input($_POST['password']) : '' ;

    if(empty($first_name)){
        $first_nameErr = 'First Name is required!';
        $allinputsfield = false;
    }
    if(empty($last_name)){
        $last_nameErr = 'Last Name is required!';
        $allinputsfield = false;
    }
    if(empty($role)){
        $roleErr = 'Role is required!';
        $allinputsfield = false;
    }
    if(empty($username)){
        $usernameErr = 'Username is required!';
        $allinputsfield = false;
    } else if($accountObj->usernameExist($username)){
        $usernameErr = 'Username already taken!';
        $allinputsfield = false;
    }
    if(empty($password)){
        $passwordErr = 'Password is required!';
        $allinputsfield = false;
    } 

    if($allinputsfield){
        $accountObj->first_name = $first_name;
        $accountObj->last_name = $last_name;
        $accountObj->role = $role;
        $accountObj->username = $username;
        $accountObj->password = $password;
        if($role == 'admin'){
            $accountObj->is_admin = true;
            $accountObj->is_staff = true;
        } else if ($role == 'staff'){
            $accountObj->is_admin = false;
            $accountObj->is_staff = true;
        } else {
            $accountObj->is_admin = false;
            $accountObj->is_staff = false;
        }
        $accountObj->add();

        header('Location: loginwcss.php');
    }
}

?>
<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, 0.1);
        border: solid rgba(0, 0, 0, 0.15);
        border-width: 1px 0;
        box-shadow: inset 0 0.5em 1.5em rgba(0, 0, 0, 0.1),
            inset 0 0.125em 0.5em rgba(0, 0, 0, 0.15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -0.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
        z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
    }

    html,
    body {
        height: 100%;
    }

    .form-signin {
        max-width: 330px;
        padding: 1rem;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .required {
        color: red;
    }
</style>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

    <main class="form-signin w-100 m-auto">
        <form action="signup.php" method="post">
            <img class="mb-4" src="../img/box.png" alt="" width="72" height="57">

            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating my-2">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?= $first_name?>">
                <label for="first_name">First Name</label>
            </div>
            <span class="required"><?= $first_nameErr; ?></span>

            <div class="form-floating my-2">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?= $last_name?>">
                <label for="last_name">Last Name</label>
            </div>
            <span class="required"><?= $last_nameErr; ?></span>

            <div class="form-floating my-2">
                <input type="text" class="form-control" id="role" name="role" placeholder="Role" value="<?= $role?>">
                <label for="role">Role</label>
            </div>
            <span class="required"><?= $roleErr; ?></span>

            <div class="form-floating my-2">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $username?>">
                <label for="username">Username</label>
            </div>
            <span class="required"><?= $usernameErr; ?></span>

            <div class="form-floating my-2">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?= $password?>">
                <label for="password">Password</label>
            </div>
            <span class="required"><?= $passwordErr; ?></span>

            
            <button class="btn btn-primary w-100 py-2" type="submit">Sign Up</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2024-2025</p>
        </form>
    </main>
    <?php
    require_once '../includes/_footer.php';
    ?>
</body>

</html>