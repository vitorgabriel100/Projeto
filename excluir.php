<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM corretores WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Corretor excluído com sucesso!'); window.location.href='cadastro.php';</script>";
    } else {
        echo "Erro ao excluir: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "<script>alert('ID inválido!'); window.location.href='cadastro.php';</script>";
}

$conn->close();
?>
