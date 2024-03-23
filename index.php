<?php 
session_start();
$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include ("assets/conexao.php");
    var_dump($_POST);
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' ";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        var_dump($row);
        //if (password_verify($senha, $row["senha"])) {
        if ($senha == $row['senha']){
            // Login ok
            $msg = "Login bem-sucedido! Bem-vindo, " . $row["nome"];
            $_SESSION['nome'] = $row["nome"];
            header("Location: logado.php");
            // redirect aqui
        } else {
            $msg = "Senha incorreta!";
        }
    } else {
        $msg = "Usuário não encontrado!";
    }
}

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="assets/style.css">

<!------ Include the above in your HEAD tag ---------->

<div class="sidenav">
         <div class="login-main-text">
            <h2>Sistema<br> Página de Login</h2>
            <p>Faça o login para acessar.</p>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
               <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                  <?php echo $msg ?>
                  <div class="form-group">
                     <label>Email</label>
                     <input type="email" name="email" class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group">
                     <label>Senha</label>
                     <input type="password" name="senha" class="form-control" placeholder="Password">
                  </div>
                  <button type="submit" class="btn btn-black">Login</button>
                  <!-- <button type="submit" class="btn btn-secondary">Register</button> -->
               </form>
            </div>
         </div>
      </div>