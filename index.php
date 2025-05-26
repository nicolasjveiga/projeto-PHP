<?php

$users = [
    ["user" => "admin", "password" => "admin", "totalVendas" => 0.0]
];
$logs = [];
$firsTime = true;

function login(&$users, &$logs, &$username, &$currentUserIndex) {
    echo "-----------Login-----------\n";
    $login = readline("Digite o nome:  ");
    $password = readline("Digite a senha: ");

    foreach ($users as $index => $user) {
        if ($user['user'] === $login && $user['password'] === $password) {
            $username = $user['user'];
            $currentUserIndex = $index;
            $logs[] = "$username fez login às " . date('d/m/Y H:i:s');
            return true;
        }
    }
    echo "Usuário ou senha incorretos! \n";
    return false;
}

function vender(&$logs, &$users, &$caixa , $currentUserIndex, $username) {
    $produto = readline("Digite o nome do produto: ");
    $valor = (float) readline("Digite o valor do produto: ");
    $valorPago = readline("Digite o valor que foi pago: ");
    $horario = date('d/m/Y H:i:s');

    if($caixa >= ($valorPago - $valor)){
        $logs[] = "$username realizou uma venda do item $produto no valor de R$ $valor às $horario";
        $users[$currentUserIndex]['totalVendas'] += $valor;
        $caixa += $valor;

        echo "Venda registrada com sucesso!\n";
    } else {
        echo "Venda cancelada por falta de troco!\n";
    }
}
function cadastrar(&$users, &$logs, $username) {
    echo "------------ Cadastro ------------\n";
    $newUser = readline("Digite o nome do novo usuário: ");
    $newPassword = readline("Digite a senha: ");

    $users[] = [
        'user' => $newUser,
        'password' => $newPassword,
        'totalVendas' => 0.0
    ];

    $logs[] = "$username cadastrou um novo usuário '$newUser' às " . date('d/m/Y H:i:s');
    echo "Usuário '$newUser' cadastrado com sucesso! \n";
}

function logs($logs) {
    $arquivo = fopen("arquivo.txt", "w");
    echo "+--------Logs do sistema---------+\n";
    foreach ($logs as $log) {
        fwrite($arquivo, $log . "\n");
        echo "$log\n";
    }
    echo "+--------------------------------+\n";
    fclose($arquivo);
}

function clear() {
    system('clear');
}
while (true) {
    clear();
    $username = '';
    $currentUserIndex = -1;

    if (login($users, $logs, $username, $currentUserIndex)) {
        $logout = false;
        if($firsTime == true){
            $caixa = readline("Digite quanto dinheiro tem no caixa: ");
            $firsTime = false;
        }
        while (!$logout) {
            $totalVendasUser = $users[$currentUserIndex]['totalVendas'];
            echo "Bem-Vindo, $username! Total em vendas: R$ $totalVendasUser\n";
            echo "Dinheiro em caixa: R$ $caixa\n";
            echo "+-----------------Loja-----------------+\n";
            echo "|1 - Vender                            |\n";
            echo "|2 - Cadastrar                         |\n";
            echo "|3 - Verificar Log                     |\n";
            echo "|4 - Logout                            |\n";
            echo "+--------------------------------------+ \n";

            $option = (int) readline("Digite uma opção (1 a 4): ");

            switch ($option) {
                case 1:
                    vender($logs, $users, $caixa,  $currentUserIndex, $username);
                    break;
                case 2:
                    cadastrar($users, $logs, $username);
                    break;
                case 3:
                    logs($logs);
                    break;
                case 4:
                    $logs[] = "$username fez logout às " . date('d/m/Y H:i:s');
                    $logout = true;
                    break;
                default:
                    echo "Opção inválida!\n";
            }

            echo "\nPressione ENTER para continuar\n";
            readline();
            clear();
        }
    } else {
        echo "Tente novamente.\n\n";
        readline("Pressione ENTER para voltar ao login");
        clear();
    }
}
