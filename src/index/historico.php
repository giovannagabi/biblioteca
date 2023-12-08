<?php
include_once 'verifica_login.php';
require_once 'C:\xampp\htdocs\biblioteca-virtual-g\src\config\config.php';
require_once 'app/Controllers/LivroController.php';
require_once 'app/Controllers/EmprestimoController.php';



?>

<?php
if (!isset($_SESSION['nome_u'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->query('SELECT * FROM livros');
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

$livroController = new LivroController($pdo);
$emprestimoController = new EmprestimoController($pdo);

$livros = $livroController->listarLivros();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['emprestar'])) {
    $livroID = $_POST['id_livro'];
    $livroNome = $_POST['nome'];
    $usuarioNome = $_SESSION['nome_u'];

    $emprestimoController->emprestarLivro($livroID, $livroNome, $usuarioNome);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $livroID = $_POST['id_livro'];

    $emprestimoController->devolverLivro($livroID);
}

$historico = $emprestimoController->listarHistorico($_SESSION['nome_u']);
?>	
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="public/css/02index-biblio.css">
    <link rel="stylesheet" href="public/css/03tables-style.css">
    <link rel="shortcut icon" href="public/assets/img/letter-b.png" type="image/x-icon">
    <script src="public/assets/js/script.js"></script>
</head>
<body>
   




</style>
    <header>
        <div class="esq">
        <div class="text-logo">
        <h1 class="text">Biblioteca Virtual</h1>
</div>
</div>
    </header>

    <div class="container">
        <nav style="height:100vh">
            <div class="user-container">
            <div class="user-icon" id="user-icon" onclick="showUserInfo()">
            <div class="user-ico">
            <img src="public/assets/img/user-ico.png">
</div>
            <div class="user-info" id="user-info">
            <button class= "exitbutton" onclick="logout()">
                    <div class="login-button"><h6 class="flex">Sair<img width="5" height="5" src="https://img.icons8.com/ios/50/FFFFFF/exit--v1.png" alt="exit"/></h6></div></button>
                    
                
                </div>
            <div class="user-title">
            <h1>
                <?php echo "Olá, " . $_SESSION['nome_u'] . ""; ?>
            <span class="user-level">Usuário</span>
            </h1>
            
             
            </div>
            </div>
            </div>

            <script>
function menuShow() {
    let menuMobile = document.querySelector('.mobile-menu');
    if (menuMobile.classList.contains('open')) {
        menuMobile.classList.remove('open');
        document.querySelector('.icon').src = "public/assets/menu_white_36dp.svg";
    } else {
        menuMobile.classList.add('open');
        document.querySelector('.icon').src = "public/assets/close_white_36dp.svg";
    }
}

// ICON INTERATIVO
function showUserInfo() {
    const userInfo = document.getElementById('user-info');
    
    // Verifique se o elemento está visível ou oculto
    if (userInfo.style.display === 'block') {
        // Se estiver visível, oculte-o
        userInfo.style.display = 'none';
    } else {
        // Se estiver oculto, mostre-o
        userInfo.style.display = 'block';
    }
}

function logout() {
    alert('Você foi desconectado.');
    window.location.href = "logout.php";
}
</script>
            <aside class="list">
            <ul>
                
                
                <li><a href="index.php"><span class="images"><img width="20" height="20" src="https://img.icons8.com/ios-filled/50/FFFFFF/book.png" alt="book"/></span>Livros</a></li>
                <li><a href="emprestados.php"><span class="images"><img  width="20" height="20" src="https://img.icons8.com/external-itim2101-fill-itim2101/64/FFFFFF/external-book-back-to-school-itim2101-fill-itim2101.png" alt="external-book-back-to-school-itim2101-fill-itim2101"/></span>Empréstimos</a></li>
                <li><a href="historico.php"><span class="images"><img width="20" height="20" src="https://img.icons8.com/ios-filled/20/FFFFFF/historical.png" alt="historical"/></span>Histórico</a></li>
            </ul>
                
</aside>
        </nav>

    <div class="emprestados"> 
    
    <?php foreach ($historico as $registro): ?>
        <div class="item-1">
            <li>
                <?php echo "ID do Livro: " . $registro['livro_id']; ?> <br>
                <?php echo "Ação: " . $registro['acao']; ?> <br>
                <?php echo "Data: " . $registro['data']; ?>
            </li>
        </div>
    <?php endforeach; ?>
</div>
        
        </section>
    </div>
        </div>


     

   

    <footer>
        <p>&copy; 2023 Biblioteca Virtual. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
