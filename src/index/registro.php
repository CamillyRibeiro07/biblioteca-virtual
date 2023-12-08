<?php
require_once 'C:\xampp\htdocs\biblioteca-virtual-v\src\config\config.php';
require_once 'C:\xampp\htdocs\biblioteca-virtual-v\src\index\app\Controllers\LoginController.php';

$loginController = new LoginController($pdo);
$error = '';
$successMessage = '';

if (isset($_POST['nome_u']) && isset($_POST['email']) && isset($_POST['senha'])) {
    // Verificar se já existe um usuário com as mesmas informações
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE nome_u = ? AND senha = ?');
    $stmt->execute([$_POST['nome_u'], $_POST['senha']]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error = 'Já existe um usuário com essas informações.';
    } else {
        // Se não houver erro, proceder com a criação do login
        $loginController->criarLogin($_POST['nome_u'], $_POST['email'], $_POST['senha']);
        $successMessage = 'Registro realizado com sucesso!';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Biblioteca Virtual</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="public/css/01login-registro.css">
	
</head>
<body>

	<?php
                    if(isset($_SESSION['nao_autenticado'])):
                    ?>
                      
                    <?php
                    endif;
                    unset($_SESSION['nao_autenticado']);
                    ?>
                    
                    
<div class="bg">
<div class="logo">
                </div>
<h1 class="title">Bem-vindo à<br>
    Biblioteca Virtual!<br>
    
</h1>
    
</div>
	<form  method="POST">
	<h2>Registre-se</h2>
    <h3 class="subtitle">Se identifique para continuar:</h3>
	<input type="text" name="nome_u" placeholder="Nome" required>         
	<input type="email" name="email" placeholder="E-mail" required>
	<input type="password" name="senha" placeholder="Senha" required>
	<button>			
	Registrar		
	</button>					
							
	<a href="login.php">					
	Logue na sua conta				
	</a>
    <?php
    if ($error) {
        echo '<div style="color: red;">' . $error . '</div>';
    }

    if ($successMessage) {
        echo '<div style="color: green;">' . $successMessage . '</div>';
    }
    ?>
	</form>	
	
	<a class="adm-button" id="adminButton">
        <img src="public/assets/img/adm1.png">
    </a>
	<div class="modal-background" id="modalBackground"></div>
    <div id="adminModal" class="modal">
        <button class="close-button" id="closeBtn">&times;</button>
        <p>Esta página é apenas para administradores.</p>
        <button class="understood-button" id="understoodBtn"><a href="../adm/login-adm.php">Entendi</a></button>
    </div>
    
	<script>
	 document.addEventListener('DOMContentLoaded', function() {
    var adminButton = document.getElementById('adminButton');
    var modal = document.getElementById('adminModal');
    var modalBackground = document.getElementById('modalBackground');

    adminButton.addEventListener('click', function() {
        modal.style.display = 'block';
        modalBackground.style.display = 'block';
    });

    document.getElementById('closeBtn').addEventListener('click', function() {
        modal.style.display = 'none';
        modalBackground.style.display = 'none';
    });

    document.getElementById('understoodBtn').addEventListener('click', function() {
        modal.style.display = 'none';
        modalBackground.style.display = 'none';
    });
});

</script>

</body>

</html>