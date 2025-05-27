<?php

$users = [
    ["user" => "admin", "password" => "admin", "totalVendas" => 0.0]
];
$logs = [];
$itens = [];
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

function vender(&$logs, &$users, &$caixa , &$itens, $currentUserIndex, $username) {
    if(empty($itens)) {
        echo "Nenhum item cadastrado para venda.\n";
        return;
    }

    listarItens($itens);

    $index = (int) readline("Digite o número do item que deseja vender: ");

    if(!isset($itens[$index])){
        echo "Índice inválido! Por favor, escolha um item válido.\n";
        return;
    }

    $produto = $itens [$index]['produto'];
    $valor = $itens [$index]['valor'];
    $estoque = $itens [$index]['estoque'];

     if($estoque <= 0){
        echo "Indisponivel em estoque!";
        return;
    }

    echo "Você escolheu vender: $produto por R$ $valor\n";
    $valorPago = (float) readline("Digite o valor pago pelo cliente: ");

    $horario = date('d/m/Y H:i:s');

    if($valorPago >= $valor){
        $troco = $valorPago - $valor;
        $logs[] = "$username vendeu o item '$produto' por R$ $valor, recebeu R$ $valorPago e deu R$ $troco de troco às $horario";
        $users[$currentUserIndex]['totalVendas'] += $valor;
        $itens [$index] ['estoque']--;
        $caixa += $valor;

        echo "Venda realizada com sucesso! Troco: R$ $troco\n";
    } else {
        echo "Valor pago insuficiente! A venda foi cancelada!\n";
    }
}

function listarItens($itens) {
    echo "+-----------------Itens Disponiveis-----------------+\n"; 
    foreach ($itens as $index => $item) {
        echo "[$index] - {$item['produto']} - R$ {$item['valor']} - Estoque: {$item['estoque']}\n";
    }
    echo "+----------------------------------------------------+\n";
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

function cadastrarItens(&$logs, &$itens, $username) {
    echo "------------ Cadastro de Itens ------------\n";
    $produto = readline("Digite o nome do produto: ");
    $valor = (float) readline("Digite o preço do produto: ");
    $estoque = (int) readline("Digite quantos tem em estoque: ");

    $itens[] = [
        'produto' => $produto,
        'valor' => $valor,
        'estoque' => $estoque
    ];
    
    $logs[] = "$username cadastrou um novo item '$produto' com preço R$ $valor às " . date('d/m/Y H:i:s');
    echo "Item '$produto' cadastrado com sucesso! \n";
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
            echo "|2 - Cadastrar Usuário                 |\n";
            echo "|3 - Cadastrar Itens                   |\n";
            echo "|4 - Verificar Log                     |\n";
            echo "|5 - Logout                            |\n";
            echo "+--------------------------------------+ \n";

            $option = (int) readline("Digite uma opção (1 a 5): ");

            switch ($option) {
                case 1:
                    vender($logs, $users, $caixa, $itens, $currentUserIndex, $username);
                    break;
                case 2:
                    cadastrar($users, $logs, $username);
                    break;
                case 3:
                    cadastrarItens($logs, $itens, $username);
                    break;
                 case 4:
                    logs($logs);
                    break;
                case 5:
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
