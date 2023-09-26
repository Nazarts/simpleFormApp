<?php

const USER_DB = [
    ['id' => 1, 'name' => 'Nothing', 'password' => '12', 'email' => 'Test@'],
    ['id' => 2, 'name' => 'John Doe', 'password' => 'password123', 'email' => 'johndoe@example.com'],
    ['id' => 3, 'name' => 'Alice Smith', 'password' => 'secret456', 'email' => 'alice@example.com'],
    ['id' => 4, 'name' => 'Bob Johnson', 'password' => 'qwerty789', 'email' => 'bob@example.com'],
    ['id' => 5, 'name' => 'Eva Williams', 'password' => 'abcdef', 'email' => 'eva@example.com'],
    ['id' => 6, 'name' => 'Michael Brown', 'password' => 'p@ssw0rd', 'email' => 'michael@example.com'],
    ['id' => 7, 'name' => 'Olivia Davis', 'password' => 'letmein', 'email' => 'olivia@example.com'],
    ['id' => 8, 'name' => 'William Wilson', 'password' => 'hello123', 'email' => 'william@example.com'],
    ['id' => 9, 'name' => 'Sophia Harris', 'password' => 'mysecret', 'email' => 'sophia@example.com'],
    ['id' => 10, 'name' => 'James Lee', 'password' => 'password456', 'email' => 'james@example.com'],
    ['id' => 11, 'name' => 'Mia Martin', 'password' => 'letmeinagain', 'email' => 'mia@example.com'],
    ['id' => 12, 'name' => 'Benjamin White', 'password' => 'securepass', 'email' => 'benjamin@example.com'],
    ['id' => 13, 'name' => 'Emma Turner', 'password' => 'pass123', 'email' => 'emma@example.com'],
    ['id' => 14, 'name' => 'Liam Clark', 'password' => 'ilovecoding', 'email' => 'liam@example.com'],
    ['id' => 15, 'name' => 'Ava Moore', 'password' => 'testing123', 'email' => 'ava@example.com'],
    ['id' => 16, 'name' => 'Noah Lewis', 'password' => 'securepassword', 'email' => 'noah@example.com'],
    ['id' => 17, 'name' => 'Isabella Turner', 'password' => 'password789', 'email' => 'isabella@example.com'],
    ['id' => 18, 'name' => 'Lucas Smith', 'password' => 'hello1234', 'email' => 'lucas@example.com'],
    ['id' => 19, 'name' => 'Mia Davis', 'password' => 'mypass', 'email' => 'miad@example.com'],
    ['id' => 20, 'name' => 'Alexander Johnson', 'password' => 'secretcode', 'email' => 'alexander@example.com'],
];


$status = 200;

$errors = [];

function validateUser($email): bool
{
    foreach (USER_DB as $user) {
        if ($email == $user['email']) {
            return true;
        }
    }
    return false;
}

function make_response($response_body, $code) {
    file_put_contents(date('Y-m-d') . '.log', 'Error: Not found value for email');
    header("Content-Type: application/json");
    http_response_code($code);
    echo json_encode($response_body);
}

if (!isset($_POST['email'])) {
    $status = 400;
    $errors[] = ['message' => 'Email field should be present'];
}
elseif (strpos($_POST['email'], '@') === false) {
    file_put_contents(date('Y-m-d') . '.log', $_POST['email']);

    $status = 400;
    $errors[] = ['message' => 'Email field should have "@" sign'];
}

if (!isset($_POST['password']) || !isset($_POST['re_password'])) {
    $status = 400;
    $errors[] = ['message' => 'Password and repeat password fields should be present'];
}
elseif ($_POST['password'] != $_POST['re_password']) {
    $status = 400;
    $errors[] = ['message' => 'Passwords are not matching'];
}

if (sizeof($errors) > 0) {
    make_response($errors, $status);
}
else {
    make_response(['status' => true], $status);
}