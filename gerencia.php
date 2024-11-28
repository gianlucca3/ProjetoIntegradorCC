<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['ger_email']) && $_SESSION['ger_email'] != null) {
    // Pega o nome do usuário da sessão
    $nomeUsuario = $_SESSION['ger_email']; // Aqui você pode ter o nome do usuário armazenado
    // Extrai a primeira letra do nome
    $primeiraLetra = strtoupper($nomeUsuario[0]);
} else {
    // Usuário não logado
    $primeiraLetra = '?'; // Ícone genérico para usuários não logados
}



// Captura a URL da página de onde o login foi solicitado
$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home.php';
/*<?php echo $dt.date("H:i");?>
 Gerência</h2>
*/
// Salva a URL para redirecionar após o login
//$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
?>

<html>

<head>
<title>Gerência</title>
<link rel="stylesheet" href="f.css">
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>

<body>
<SCRIPT LANGUAGE="JavaScript"  SRC="keyboard2.js"></SCRIPT>
<script language="javascript"> 
document.onkeydown = applyKey; 
<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['ger_email']) && $_SESSION['ger_email'] != null) {
    // Pega o nome do usuário da sessão
    $nomeUsuario = $_SESSION['ger_email']; // Aqui você pode ter o nome do usuário armazenado
    // Extrai a primeira letra do nome
    $primeiraLetra = strtoupper($nomeUsuario[0]);
} else {
    // Usuário não logado
    $primeiraLetra = '?'; // Ícone genérico para usuários não logados
}



// Captura a URL da página de onde o login foi solicitado
$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home.php';


// Salva a URL para redirecionar após o login
//$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
?>





</script> 
<?php

	//$conn = new mysqli("localhost", "root", "", "pit");


$dia=date("d");
 $mes=date("m");
 $ano=date("y");
 $dt= "$dia/$mes/20$ano";
 //echo $dt;
 
// echo " Hora: ";



//echo date("H:i"); //exibe a hora no formato HH:MM

	

?>
<link href="padrao.css" rel="stylesheet" type="text/css">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerência</title>
    <link rel="stylesheet" href="styles.css">
<script>
        function validarFormulario(email) {
		
		
            var email = document.forms["meuFormulario"]["email"].value;
            if (email == "") {
                alert("O campo de email não pode estar vazio!");
                return false;  // Impede o envio do formulário
            }
            return true;  // Permite o envio do formulário
        }
    </script>
	
	
	
	
	
	
<header>
     <h2>Gerência</h2>
      
  </header>
 
<form  name="search" method="POST" action="geren.php"  enctype="multipart/form-data">
	
           <br><br><BR><TABLE CLASS="tabelaLogin" cellpadding="1"  cellspacing="1" ALIGN="center" BORDER="1" width="500"  style="border-collapse:collapse;">
		<TR>  <TD><TABLE CLASS="tabelaLogin" BORDER="0" ALIGN="CENTER" cellpadding="1"  cellspacing="5" width="100%">
		
         <TR>   <TD Colspan="2" CLASS="linhaloginTitulo" Align="Center" height="35">    <CENTER>Estoque</CENTER>
              </TD>            </TR></h2>
			  

<TABLE border="0" CLASS="tabelaLogin" ALIGN="center" cellpadding="1" cellspacing="2" width="100%">
<tr><TD CLASS="linhalogin"> Gerente:<TD CLASS="linhalogin" align="left"><INPUT  type=text size=25 id=email name=email  required placeholder="Digite seu e-mail" style="height: 33px">
	<tr><TD CLASS="linhalogin"> Senha:<TD CLASS="linhalogin" align="left"><INPUT  type=password size=25 id=senha name=senha 	required placeholder="senha" style="height: 33px">
													
<!-- <tr><td>data:</td><td> <input type=text size=10 name=data></td></tr> //-->
</TABLE></TD></TR>         <TR><TD><TABLE border="0" CLASS="tabelaLogin" ALIGN="center" cellpadding="1" cellspacing="2" width="100%">               <TR><TD><TABLE CLASS="tabelaLogin" BORDER="0" ALIGN="CENTER" cellpadding="1"  cellspacing="5" >
<TD ALIGN="center" height="25" colspan="2"><INPUT TYPE="reset" CLASS="botao"  VALUE="Limpar">   &nbsp;<input id="ok" type="submit" CLASS="botao" value=" BUSCAR ">  </td></tr>




<!--

<TD ALIGN="center" height="35" colspan="2"><Input id="ok"  Type=""  value="Confirmar" >                 <Input  Type="Reset" id="sair" value="Fechar" onClick='self.location="fim.htm"'>

<input type="submit" value=" ficha2 ">
     

-->


</td>

<!--
<input type="button" value=" BUSCAR " onClick='window.location.href="ficha2.php?nome=" + document.search.nome.value' >

--></tr>
         </TABLE>
       </TD>
      </TR>
    </TABLE>
   </TD>
  </TR>
</TABLE>
</br>
</table>

</form>
<iframe name="win" width='380' height='350' frameborder='0' src='' align="top" ></iframe>
<!--




</body>
</html>
