<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM corretores WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $corretor = $result->fetch_assoc();
    } else {
        echo "<script>alert('Corretor não encontrado!'); window.location.href='cadastro.php';</script>";
        exit;
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $cpf = $_POST['cpf'];
    $creci = $_POST['creci'];
    $nome = $_POST['nome'];

    if (strlen($cpf) == 11 && strlen($creci) >= 2 && strlen($nome) >= 2) {
        $stmt = $conn->prepare("UPDATE corretores SET cpf = ?, creci = ?, nome = ? WHERE id = ?");
        $stmt->bind_param("sssi", $cpf, $creci, $nome, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Cadastro atualizado com sucesso!'); window.location.href='cadastro.php';</script>";
        } else {
            echo "Erro ao atualizar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "<script>alert('Por favor, verifique os dados!');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Corretor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0);
            width: 300px;
        }

        input {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color:rgb(89, 69, 160);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color:rgb(89, 69, 160);
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Editar Corretor</h2>
    <form action="editar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $corretor['id']; ?>">
        <input type="text" name="cpf" value="<?php echo $corretor['cpf']; ?>" placeholder="CPF (11 caracteres)" required minlength="11" maxlength="11" pattern="\d{11}">
        <input type="text" name="creci" value="<?php echo $corretor['creci']; ?>" placeholder="CRECI" required minlength="2">
        <input type="text" name="nome" value="<?php echo $corretor['nome']; ?>" placeholder="Nome" required minlength="2">
        <button type="submit">Atualizar</button>
    </form>
</div>

</body>
</html>
