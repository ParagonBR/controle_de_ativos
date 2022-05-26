<?php


require_once 'FactoryConnection.php';
require_once('wp-load.php');
require_once(ABSPATH.'wp-includes/pluggable.php');
function getUser(){
    // retorna os dados do usuário logado
    $current_user = wp_get_current_user();
    $user_info = get_userdata($current_user->ID);
    return $user_info->user_login;
}
function getNome(){
   //global $current_user;
    // retorna os dados do usuário logado
    $current_user = wp_get_current_user();
    $user_info = get_userdata($current_user->ID);
    return $user_info->display_name;
}
function getEmail(){
    $current_user = wp_get_current_user();
    // retorna os dados do usuário logado
    $user_info = get_userdata($current_user->ID);
    return $user_info->user_email;
}
