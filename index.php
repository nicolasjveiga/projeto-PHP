<?php

global $users;
$users = [
    [1, "admin", "admin"],
    [2, "s", "password"],
];

$id = count($users) + 1;

function Login($users){
    echo "-----------Login-----------\n";
    $nameTry = readline("Digite o nome:  ");
    $passwordTry = readline("Digite a senha: ");

    foreach($users as [$id, $name, $password]){
        if($nameTry == $name && $passwordTry == $password){
            global $username;
            $username = $name;
            return true;
        }
    }
}

function Vender($username){
    $valor = readline("Digite o valor do produto: ");
    $produto = readline("Digite o nome do produto: ");
    $horario = date('d/m/Y H:i:s');
    global $vendas;
    $vendas[] = [$username, $valor, $produto, $horario];

}

function Cadastrar($id){
    global $users;
    $newUser = readline("Digite o nome do novo usuário: ");
    $password = readline("Digite a senha: ");

    $users[] = [$id, $newUser, $password];
    $id++;
}

function Logs($vendas){
    foreach($vendas as [$username, $valor, $produto, $horario]){
        echo "{$username} realizou uma venda do item {$produto} no valor de {$valor} às {$horario}\n";
    }
}


while(true){
    if(Login($users) == true){
        $logout = false;
        while($logout == false){
            echo "|+----------------Loja----------------+|\n";
            echo "|1 - Vender                            |\n";
            echo "|2 - Cadastrar                         |\n";              
            echo "|3 - Verificar Log                     |\n";
            echo "|4 - Logout                            |\n";
            echo "+--------------------------------------+ \n";
            $quest = (int) readline("Digite uma opção (1 a 4): ");
            
            switch($quest){
                case 1:
                    Vender($username);
                    break;
                case 2:
                    Cadastrar($id);
                    break;
                case 3: 
                    Logs($vendas);
                    break;
                case 4:
                    $logout = true;
                    break;
            }
                
        }
    }
}
