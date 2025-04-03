<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "corretores_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $creci = $_POST['creci'];
    $nome = $_POST['nome'];

    if (strlen($cpf) == 11 && strlen($creci) >= 2 && strlen($nome) >= 2) {
        $stmt = $conn->prepare("INSERT INTO corretores (cpf, creci, nome) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $cpf, $creci, $nome);

        if ($stmt->execute()) {
            echo "<script>alert('Cadastro realizado!'); window.location.href='cadastro.php';</script>";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "<script>alert('Por favor, verifique os dados.');</script>";
    }
}

$sql = "SELECT * FROM corretores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Corretores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0);
            text-align: center;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color:rgb(89, 69, 160);
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color:rgb(89, 69, 160);
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .actions button {
            margin: 0 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Cadastro de Corretores</h2>
    <form id="corretorForm" action="cadastro.php" method="POST">
        <input type="text" name="cpf" id="cpf" placeholder="CPF (11 caracteres)" required minlength="11" maxlength="11" pattern="\d{11}">
        <input type="text" name="creci" id="creci" placeholder="CRECI" required minlength="2">
        <input type="text" name="nome" id="nome" placeholder="Nome" required minlength="2">
        <button type="submit">Cadastrar</button>
    </form>

    <h2>Corretores Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>CPF</th>
                <th>Creci</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['cpf'] . "</td>
                            <td>" . $row['creci'] . "</td>
                            <td>" . $row['nome'] . "</td>
                            <td class='actions'>
                                <a href='editar.php?id=" . $row['id'] . "'><button>Editar</button></a>
                                <a href='excluir.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir?\")'><button>Excluir</button></a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum corretor cadastrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById("corretorForm").addEventListener("submit", function(event) {
    let cpf = document.getElementById("cpf").value.trim();
    let creci = document.getElementById("creci").value.trim();
    let nome = document.getElementById("nome").value.trim();

    if (cpf.length !== 11 || isNaN(cpf)) {
        alert("O CPF deve conter exatamente 11 números.");
        event.preventDefault();
        return;
    }

    if (creci.length < 2) {
        alert("O CRECI deve conter pelo menos 2 caracteres.");
        event.preventDefault();
        return;
    }

    if (nome.length < 2) {
        alert("O Nome deve conter pelo menos 2 caracteres.");
        event.preventDefault();
        return;
    }
});
</script>

</body>
</html>

<?php
$conn->close();
?>
