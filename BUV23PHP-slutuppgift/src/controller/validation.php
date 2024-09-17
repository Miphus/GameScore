<?php

function validateUsername($username) {
    return !empty($username);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password) {
    $length = strlen($password) >= 8;
    $letter = preg_match("/[a-z]/i", $password);
    $number = preg_match("/[0-9]/", $password);
    return $length && $letter && $number;
}

function passwordsMatch($password, $confirmation) {
    return $password === $confirmation;
}