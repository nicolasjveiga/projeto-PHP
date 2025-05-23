<?php

$users = [
    [1, "admin", "admin"],
    [2, "s", "password"],
];

function Login($users){
    echo "-----------Login-----------\n";
    $nameTry =     readline("Digite o nome:  ");
    $passwordTry = readline("Digite a senha: ");

    foreach($users as [$id, $name, $password]){
        if($nameTry == $name && $passwordTry == $password){
            return true;
        }
    }

}

if(Login($users) == true){
    echo "|+----------------Loja----------------+|\n";
    echo "|1 - Vender                            |\n";
    echo "|2 - Cadastrar                         |\n";              
    echo "|3 - Verificar Log                     |\n";
    echo "|4 - Logout                            |\n";
    echo "+--------------------------------------+ \n";
    $quest = (int) readline("Digite uma opção (1 a 4): ");
}
