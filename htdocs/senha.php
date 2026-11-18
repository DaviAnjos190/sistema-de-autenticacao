<?php
require 'conecta.php';

// Só acessa quem está logado
if (!isset($_SESSION['email_usuario'])) {
    header('Location: index.php');
    exit;
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_usuario = $_SESSION['email_usuario'];
    $nova_senha    = $_POST['nova_senha'] ?? '';
    $confirmar     = $_POST['confirmar_senha'] ?? '';

    if ($nova_senha === '' || $nova_senha !== $confirmar) {
        $mensagem = 'As senhas não coincidem.';
    } else {
        $nova_senha = password_hash($nova_senha, PASSWORD_DEFAULT);

        $sql  = "UPDATE usuarios SET senha = :nova_senha WHERE email = :email_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nova_senha', $nova_senha);
        $stmt->bindParam(':email_usuario', $email_usuario);
        $stmt->execute();

        $mensagem = 'Senha alterada com sucesso.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar senha</title>
</head>
<body>
    <h1>Alterar senha</h1>

    <?php if ($mensagem): ?>
        <p><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="password" name="nova_senha" placeholder="Nova senha" required>
        <input type="password" name="confirmar_senha" placeholder="Confirmar nova senha" required>
        <button type="submit">Salvar</button>
    </form>

    <a href="inicio.php">Voltar</a>
</body>
</html>