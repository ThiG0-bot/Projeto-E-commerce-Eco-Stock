<?php
include 'conexao.php';

$usuario_id = $_POST['usuario_id'];
$endereco_id = $_POST['endereco_id'];

// Obtem carrinho
$res = $conn->query("SELECT id FROM carrinhos WHERE usuario_id = $usuario_id LIMIT 1");
if ($res->num_rows === 0) {
    exit("Carrinho não encontrado.");
}
$carrinho_id = $res->fetch_assoc()['id'];

// Itens do carrinho
$itens = $conn->query("SELECT * FROM carrinho_itens WHERE carrinho_id = $carrinho_id");
if ($itens->num_rows === 0) {
    exit("Carrinho vazio.");
}

// Cria pedido
$total = 0;
$pedido_itens = [];
while ($item = $itens->fetch_assoc()) {
    $produto_id = $item['produto_id'];
    $quantidade = $item['quantidade'];
    $res_prod = $conn->query("SELECT preco FROM produtos WHERE id = $produto_id")->fetch_assoc();
    $preco = $res_prod['preco'];
    $subtotal = $preco * $quantidade;
    $total += $subtotal;

    $pedido_itens[] = ['produto_id' => $produto_id, 'quantidade' => $quantidade, 'preco' => $preco];
}

// Insere pedido
$conn->query("INSERT INTO pedidos (usuario_id, endereco_id, total) VALUES ($usuario_id, $endereco_id, $total)");
$pedido_id = $conn->insert_id;

// Insere itens do pedido
foreach ($pedido_itens as $item) {
    $conn->query("INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unitario)
        VALUES ($pedido_id, {$item['produto_id']}, {$item['quantidade']}, {$item['preco']})");
}

// Limpa carrinho
$conn->query("DELETE FROM carrinho_itens WHERE carrinho_id = $carrinho_id");

echo "Pedido realizado com sucesso!";
?>
