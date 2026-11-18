<?php
include 'conecta.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['email_usuario'])) {
    header('Location: index.php');
    exit; // sem o exit, o resto do script continua executando
}

// Verifica se o formulário enviou algo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nova_senha = $_POST['nova_senha'];
    $email_usuario = $_SESSION['email_usuario'];

    // Query para alteração da senha do usuário
    $sql = "UPDATE usuarios SET senha = :nova_senha WHERE email = :email_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nova_senha', $nova_senha);
    $stmt->bindParam(':email_usuario', $email_usuario);

    try {
        $stmt->execute();
        header('Location: inicio.php'); // Redireciona para a página inicial após alterar a senha
        exit;
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
}
?>