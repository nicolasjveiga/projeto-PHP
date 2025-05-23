<?php

$users = [
    ["user" => "admin" , "password" => "admin"]
];
$logs = [];
$vendas = [];
$totalVendas = 0.0;


function login(&$users, &$logs, &$username){
    echo "-----------Login-----------\n";
    $login = readline("Digite o nome:  ");
    $password = readline("Digite a senha: ");

    foreach($users as $user){
        if($user['user'] === $login && $user['password'] == $password){
            $username = $user['user'];
            $logs [] = "$username fez login às " . date('d/m/Y H:i:s');
            return true;
        }
    }
    echo "Usuário ou senha incorretos! \n";
    return false;
}

function vender(&$vendas, &$logs, &$totalVendas, $username){
    $valor = (float) readline("Digite o valor do produto: ");
    $produto = readline("Digite o nome do produto: ");
    $horario = date('d/m/Y H:i:s');
    $vendas[] = [
        'user' => $username,
        'produto' => $produto,
        'valor' => $valor,
        'hora' => $horario
    ];

    $logs[] = "$username realizou uma venda do item $produto no valor de R$ $valor às $horario";
    $totalVendas += $valor;

    echo "Venda registrada com sucesso!\n";
}

function cadastrar(&$users, &$logs, $username) {
    echo "------------ Cadastro ------------\n";
    $newUser = readline("Digite o nome do novo usuário: ");
    $newPassword = readline("Digite a senha: ");

    $users[] = [
        'user' => $newUser,
        'password' => $newPassword
    ];

    $logs[] = "$username cadastrou um novo usuário '$newUser' às ". date('d/m/Y H:i:s');
    echo "Usuário '$newUser' cadastrado com sucesso! \n";
}

function Logs($logs){
    echo "+--------Logs do sistema---------+\n";
    foreach($logs as $log){
        echo "$log\n";
    }
    echo "+--------------------------------+\n";
}

function Clear(){
    system('clear');
}

while(true){
    system('clear');
    $username = '';

    if(Login($users, $logs, $username)){
        $logout = false;
        while(!$logout) {
            echo "Bem-Vindo, $username! Total em vendas: R$$totalVendas\n";
            echo "+-----------------Loja-----------------+\n";
            echo "|1 - Vender                            |\n";
            echo "|2 - Cadastrar                         |\n";
            echo "|3 - Verificar Log                     |\n";
            echo "|4 - Logout                            |\n";
            echo "+--------------------------------------+ \n";

            $option = (int) readline("Digite uma opção (1 a 4): ");

            switch($option){
                case 1:
                    vender($vendas, $logs, $totalVendas, $username);
                    break;
                case 2:
                    cadastrar($users, $logs, $username);
                    break;
                case 3: 
                    logs($logs);
                    break;
                case 4:
                    $logout = true;
                    break;
                default:
                    echo "Opção inválida!\n";
            }

            echo "\nPressione ENTER para continuar...\n";
            readline();
            system('clear');
        }
    } else {
        echo "Tente novamente.\n\n";
        readline("Pressione ENTER para voltar ao login...");
        system('clear');
    }
}

