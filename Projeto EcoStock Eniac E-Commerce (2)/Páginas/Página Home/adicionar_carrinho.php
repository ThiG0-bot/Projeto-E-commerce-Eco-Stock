<?php
include 'conexao.php';

$usuario_id = $_POST['usuario_id'];
$produto_id = $_POST['produto_id'];
$quantidade = $_POST['quantidade'];

// Verifica se o carrinho já existe
$res = $conn->query("SELECT id FROM carrinhos WHERE usuario_id = $usuario_id LIMIT 1");

if ($res->num_rows > 0) {
    $carrinho = $res->fetch_assoc();
    $carrinho_id = $carrinho['id'];
} else {
    $conn->query("INSERT INTO carrinhos (usuario_id) VALUES ($usuario_id)");
    $carrinho_id = $conn->insert_id;
}

// Adiciona o produto ao carrinho
$stmt = $conn->prepare("INSERT INTO carrinho_itens (carrinho_id, produto_id, quantidade) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $carrinho_id, $produto_id, $quantidade);

if ($stmt->execute()) {
    echo "Produto adicionado ao carrinho!";
} else {
    echo "Erro: " . $stmt->error;
}
?>
