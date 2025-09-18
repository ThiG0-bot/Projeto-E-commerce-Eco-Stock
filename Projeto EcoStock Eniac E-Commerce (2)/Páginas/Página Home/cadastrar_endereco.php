<?php
include 'conexao.php';

$usuario_id = $_POST['usuario_id'];
$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$complemento = $_POST['complemento'];

$stmt = $conn->prepare("INSERT INTO enderecos (usuario_id, cep, rua, numero, bairro, cidade, estado, complemento)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("isssssss", $usuario_id, $cep, $rua, $numero, $bairro, $cidade, $estado, $complemento);

if ($stmt->execute()) {
    echo "Endereço cadastrado!";
} else {
    echo "Erro: " . $stmt->error;
}
$stmt->close();
?>
