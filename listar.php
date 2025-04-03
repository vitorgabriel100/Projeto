<?php
include 'conexao.php';

$sql = "SELECT * FROM corretores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corretores Cadastrados</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 20px; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color:rgb(89, 69, 160); color: white; }
        .actions button { margin: 2px; }
    </style>
</head>
<body>

    <h2>Corretores Cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>CPF</th>
            <th>CRECI</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['cpf']) . "</td>
                        <td>" . htmlspecialchars($row['creci']) . "</td>
                        <td>" . htmlspecialchars($row['nome']) . "</td>
                        <td>
                            <a href='editar.php?id=" . $row['id'] . "'><button>Editar</button></a>
                            <a href='excluir.php?id=" . $row['id'] . "'><button>Excluir</button></a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum corretor cadastrado.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="index.html"><button>Voltar ao Cadastro</button></a>

</body>
</html>

<?php
$conn->close();
?>
