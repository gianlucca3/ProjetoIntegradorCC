<?php

session_start();

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_email'])) {
    // Salva o URL atual para redirecionar após login
    $urlAtual = urlencode($_SERVER['REQUEST_URI']); // Codifica o URL atual
    header("Location: login.php?redirect=$urlAtual");
    exit();
}





?>
<html>

<head>
<title>Meus pedidos</title>
 <link rel="stylesheet" href="styles.css">

<SCRIPT TYPE=”text/javascript”>
<!–
function submitenter(cad,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
{
cad.form.submit();
return false;
}
else
return true;
}

</SCRIPT>
<link rel="stylesheet" href="styles.css">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
</head>

<body>
<SCRIPT LANGUAGE="JavaScript"  SRC="keyboard2.js"></SCRIPT>
<script language="javascript"> 
document.onkeydown = applyKey; 
</script> 




<header>
       
        <nav>
            <ul>
                <li><a href="home.php">Início</a></li>
                <li><a href="about.php">Sobre</a></li>
            </ul>
        </nav>
    </header>

<?PHP
$dia=date("d");
 $mes=date("m");
 $ano=date("y");
 $dt= "$dia/$mes/20$ano";
$config = require 'c:/conn/conn.php';

$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);


// Configurar o charset UTF-8
header('Content-Type: text/html; charset=utf-8');

// Verificar se o e-mail está vazio






	$busca = $_SESSION['cliente_email'];
	

	$sql = "SELECT * FROM meus_pedidos WHERE email_cliente LIKE '%$busca%' ORDER BY `id` DESC";
	$query = mysqli_query($conn,$sql);
	if (mysqli_num_rows($query) == 0) {
    echo "Nenhum pedido neste e-mail < $busca >
	";
	echo "<script>
            alert('Nenhum pedido neste e-mail < $busca >!');
            window.location.href = 'buscar.php';
          </script>";


	}


$i=0;
$i=0;
echo "<h3> <center>Teus pedidos";
while ($resultado = mysqli_fetch_assoc($query)) {
//$email = $resultado['email_cliente'].$resultado['data_pedido'];
$email = $resultado['email_cliente'];
$data = $resultado['email_cliente']."&data=".$resultado['data_pedido'];

$diabd=$resultado['data_pedido'];
$dia = date('d/m/Y H:i:s', strtotime($resultado['data_pedido']));
//
/*
$id = $resultado['id'];
$rg = $resultado['rg'];
$foto = $resultado['foto'];
$dat = $resultado['dat'];


email=<?php echo $email . " " . $outraVariavel; ?>

*/


//$link = 'http://www.meusite.com.br/noticia.php?id=' . $resultado['id'];
//echo "<br>";
//echo "<tr valign=center>";
echo "<b>";

//echo "<label for='io'>Nome:<input type='text' size=45  value=".$nome.">";
//echo "<td class=tabval><img src=img/blank.gif width=10 height=20></td>";
//echo "NOME: "."<font SIZE=3 color='#FF0000'>".htmlspecialchars($nome)."&nbsp;&nbsp;&nbsp;<b></FONT>";
//echo '<a href="edit.php?id='.$reg['id'].".' target="_blank">'.$nome.'</a>';
//http://191.9.119.8/log9.php?email=dio%40gmail.com&password=pit

// ok  echo "<a href='edfoto.php?id=$id' target='_blank'>dio</a></td>";
?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Botão ajustado -->

       
<input type="button" class="btn-primary"
       value="<?php echo $dia; ?>" 
       onClick='window.location.href="buscar_pedido.php?email=<?php echo $diabd; ?>"'>

 
<?PHP

$i++;


//echo "$aluno";
//echo "$pront";



//echo date('d/m/Y H:i', strtotime($resultado['cadastro']));
//echo '<p>'.$texto.'</p>';
//echo '<a href="'.$link.'" title="'.$titulo.'">'.$link.'</a>';
//echo "</li>";
}

	


?>



<!--<form name="search" method="POST" action="edfoto.php?id=<?=$reg?>" enctype="multipart/form-data">
<tr><td>nome:<td><input type=text size=50 name=nome value="<?=$nome;?>"></td></tr>
<td><input type=submit border=0 value="Editar" onKeyPress=”return submitenter(this,event)”>
<br>

<td class=tabval><a href='edfoto.php?id=<?=$reg?>' target="_blank"><?echo $nome;?></a></td>



<!-- <tr><td>data:</td><td> <input type=text size=10 name=data></td></tr> //-->



</table>

</form>
<iframe name="win" width='380' height='350' frameborder='0' src='' align="top" ></iframe>
<!--




 
&nbsp;<p>
/-->
<?PHP
 /*
 $dia=date("d");
 $mes=date("m");
 $ano=date("y");
 $data= "$dia/$mes/20$ano";
 echo $data;
 */
?>

</body>
</html>
