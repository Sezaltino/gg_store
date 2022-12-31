<?php
 if(session_status() == PHP_SESSION_NONE) session_start();
?>

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252"><title>Main_Menu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<link rel="stylesheet" href="./dash_files/w3.css">
<link rel="stylesheet" href="./dash_files/css">

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<style>
  html {
  background: url('./dash_files/game.jpg') no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;

  /*web app created by Gustavo Bule && Sonia Janete*/
  /*English code comments: Gustavo Bule*/
}
html,body,h1,h2,h3,h4,h5 {font-family: "Arial";font-size: 27px;}
.spc{width:16.666%;}
.sq {display: block; float: left; width: 15%; height: 15%; background-image: url("./dash_files/dash.png");background-size: cover;background-position: center;background-repeat:no-repeat;margin-right: 10px;}
.ts{padding-left:5px;padding-bottom:40px;color:red;} /*Table overlay spacing*/
.ts2{padding-left:110px;padding-bottom:35px;color:purple;} /*Table overlay 2 spacing*/
.dq {width:200px;height:250px;background-size:200px 250px;background-repeat:no-repeat;} /*Image generation*/
</style>
</head><body class="" style="opacity:0.8;">


<script>
var now = new Date().getTime();


</script>

<?php

if(isset($_POST["end"])){ //end session
  session_destroy();
}

if(isset($_POST["user"]) && isset($_POST["banco"]) && isset($_POST["id_cliente"]) && isset($_POST["id_conta"])) 
{
    //define session varables for presistence
    $_SESSION["user"] = $_POST["user"];
    $_SESSION["banco"] = $_POST["banco"];
    $_SESSION["id_cliente"]= $_POST["id_cliente"];
    $_SESSION["id_conta"]= $_POST["id_conta"];

    //get current values
    $user = $_POST["user"];
    $conta = $_POST["id_conta"];
    $banco = $_POST["banco"];
    $idc = $_POST["id_cliente"];
    echo '<script>console.log("user:'.$user.', conta: '.$conta.' , banco: '.$banco.' e cliente:'.$idc.'")</script>';
}else if(isset($_SESSION["user"]) && isset($_SESSION["banco"]) && isset($_SESSION["id_cliente"]) && isset($_SESSION["id_conta"])){
  //get current values from session
  $user = $_SESSION["user"];
  $conta = $_SESSION["id_conta"];
  $banco = $_SESSION["banco"];
  $idc = $_SESSION["id_cliente"];
  echo '<script>console.log("sesh | user:'.$user.', conta: '.$conta.' , banco: '.$banco.' e cliente:'.$idc.'")</script>';
}else{
  //force user to log in
  header("Location:Main.php");//if user is not athenticated he gets sent back to main menu
  exit();
}
?>


<!-- Top container -->
<div class="w3-container w3-top w3-large w3-padding" style="z-index:4;background-color:black;">
  <button class="BigButton w3-text-white w3-padding-2 " style="font-size:27px!important;background-color:transparent;border:2px solid black;" onclick="w3_open();"><i class="fa fa-bars"></i> &nbsp;Menu</button>
  <span class="w3-right" style="font-size:27px!important;"><i class="fa fa-chevron-left w3-hover-text-grey w3-btn" >&nbsp; <a class="terminar">Terminar sessão</a></i>&nbsp; <i class="ca fa w3-hover-text-grey w3-btn"><?php echo $user ?></i> </span>
</div>

<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;font-size:27px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
  <a class="w3-dark-grey" style="text-align:center;width:100%;padding:0px">GNG Store</a>
  <img src="dash_files/gamer.gif" class="" style='width:100%;height:200px'></img>
  
  </div>
  <br>
  <a href="" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu</a>
  <a class="w3-padding levantamento clk"><i class="fa fa-money fa-fw"></i>&nbsp; Levantamento</a>
  <a class="w3-padding deposito clk"><i class="fa fa-money fa-fw"></i>&nbsp; Depósitos</a>
  <a class="w3-padding transferencia clk"><i class="fa fa-exchange fa-fw"></i>&nbsp; transferências</a>
  <a class="w3-padding emprestimo clk"><i class="fa fa-bank fa-fw"></i>&nbsp; Emprestimo</a>
  <a class="w3-padding investimento clk"><i class="fa fa-bank fa-fw"></i>&nbsp; Investimento</a>
  <a class="w3-padding compras clk"><i class="fa fa-credit-card fa-fw"></i>&nbsp; Compras</a>
  <a class="w3-padding pagamentos clk"><i class="fa fa-credit-card fa-fw"></i>&nbsp; Pagamentos</a>
  <a class="w3-padding encerrar clk"><i class="fa fa-user fa-fw"></i>&nbsp; Encerrar conta</a>
  <a class="w3-padding pdf clk"><i class=" fa fa-file w3-text-gray fa-fw"></i>&nbsp; Relatório </a>
  <button class="w3-btn operacao w3-padding w3-hover-text-grey w3-hide"><i class="fa fa-bars"></i> teste</button>
  <script> //scripts for drawing modal
  $(".operacao").on("click",function(){
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<div><table class='w3-table w3-striped w3-white'><tbody><tr><td><i class='fa fa-user w3-red w3-padding-tiny'></i></td><td>Sem notificações</td></tr></tbody></table></div>");
        $(".modal_head").text("Operação 1");
        //Show the modal
        document.getElementById('id01').style.display='block';
  });
  $(".levantamento").on("click",function(){ // draws the modal
    
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<form id='levantamento' class='w3-padding-16' style='margin-top:10px' method='post'> Valor a levantar: &nbsp;<input class='valor' type='number' min=0 name='valor'/> \
          &nbsp;  <input type='hidden' name='operacao' value='Levantamento'/> \
          <input class='idco' type='hidden' name='conta' value ="+conta+" /><input type='button' class='send_l' value='confirmar'/></form>");
        $(".modal_head").text("Levantar dinheiro");
        //Show the modal
        document.getElementById('id01').style.display='block';
  });
  $(".deposito").on("click",function(){ // draws the modal
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<form id='deposito' class='w3-padding-16' style='margin-top:10px' method='post'> Valor a depositar: &nbsp;<input class='valor' type='number' min=0 name='valor'/> \
          &nbsp;  <input type='hidden' name='operacao' value='Deposito'/> \
          <input class='idco' type='hidden' name='conta' value ="+conta+" /><input type='button' class='send_d' value='confirmar'/></form>");
        $(".modal_head").text("Depositar dinheiro");
        //Show the modal
        document.getElementById('id01').style.display='block';
  });
  $(".transferencia").on("click",function(){ // draws the modal
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<form id='transferencia' class='w3-padding' style='margin-top:10px;margin-bottom:10px' method='post'> <a class='w3-half'> Valor a transferir: </a> \
          <input class='valor w3-half' type='number' min=0 name='valor' /><br><br> <a class='w3-half'> Conta a depositar: </a> \
          <input class='conta2 w3-half' type='number' min=0 name='conta_t'' /><br><br><input type='button' class='send_t' value='confirmar' style='float:right;margin-bottom:20px;margin-top:20px' /> \
          <input type='hidden' name='operacao' value='Transferencia'/><input class='idco' type='hidden' name='conta' value ="+conta+" /></form>");
        $(".modal_head").text("Transferir dinheiro");
        //Show the modal
        document.getElementById('id01').style.display='block';
  });
  $(".emprestimo").on("click",function(){ // draws the modal
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<form id='Emprestimo' class='w3-padding-16' style='margin-top:10px' method='post'><a class='w3-half'> Valor a requisitar:</a><input class='valor w3-half' type='number' min=0 name='valor' /> \
          <br><br> <a class='w3-half'> Tipo de emprestimo :</a><select class='tipo w3-half' type='number' name='tipo' form='Emprestimo' style='height:40px' > \
          <option value='Habitacao'>Habitação</option><option value='Emp auto'>Automovel</option></select><br><br> \
          <a class='w3-half'></a> <input type='hidden' name='operacao' value='Emprestimo' />  \
          <input type='hidden' name='operacao' value='Emprestimo' /> <input class='idco' type='hidden' name='conta' value ="+conta+" /> \
          <input type='button' class='send_e' value='confirmar' style='float:right;margin-bottom:20px' /></form>");
        $(".modal_head").text("Pedir Credito");
        //Show the modal
        document.getElementById('id01').style.display='block';
  });
  $(".investimento").on("click",function(){ // draws the modal
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<form id='Investimento' class='w3-padding-16' style='margin-top:10px' method='post'> Valor a investir: &nbsp;<input class='valor vi' type='number' min=0 name='valor' /> \
          &nbsp;  <input type='hidden' name='operacao' value='Investimento' /> \
          <input class='idco' type='hidden' name='conta' value ="+conta+" /><input type='button' class='send_i' value='confirmar' /></form>");
        $(".modal_head").text("Investir dinheiro");
        //Show the modal
        document.getElementById('id01').style.display='block';
  });
  $(".compras").on("click",function(){ // draws the modal
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<form id='Compra' class='w3-padding-16' style='margin-top:10px' method='post'><a class='w3-half'> Valor da compra:</a><input class='valor w3-half' type='number' min=0 name='valor' /> \
          <br><br> <a class='w3-half'> Entidade :</a> <input class='entidade w3-half' type='text' min=0 name='compra' /> <br><br> \
          <a class='w3-half'></a> <input type='hidden' name='operacao' value='Compra' />  \
          <input class='idco' type='hidden' name='conta' value ="+conta+" /> \
          <input type='button' class='send_c' value='confirmar' style='float:right;margin-bottom:20px' /></form>");
        //Show the modal
        document.getElementById('id01').style.display='block';
  });

  $(".pagamentos").on("click",function(){ // draws the modal
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<form id='Pagamento' class='w3-padding-16' style='margin-top:10px' method='post'><a class='w3-half'> Valor a pagar:</a><input class='valor w3-half' type='number' min=0 name='valor' /> \
          <br><br> <a class='w3-half'>Serviço :</a> <input class='entidade w3-half' type='text' min=0 name='pagamento' /> <br><br> \
          <a class='w3-half'></a> <input type='hidden' name='operacao' value='Pagamento' />  \
          <input class='idco' type='hidden' name='conta' value ="+conta+" /> \
          <input type='button' class='send_p' value='confirmar' style='float:right;margin-bottom:20px' /></form>");
        //Show the modal
        document.getElementById('id01').style.display='block';
  });

  $(".encerrar").on("click",function(){ // draws the modal
    $(".modal_body").empty();
        $(".modal_subtitle").empty();
        $(".modal_subtitle").append("<form id='Encerrar' class='w3-padding-16' style='margin-top:10px' method='post'><a class='w3-rest'>Tem a certeza que quer apagar a sua conta :</a> \
          <br><br><input type='hidden' name='operacao' value='Encerrar' />  \
          <input class='idco' type='hidden' name='conta' value ="+conta+" /> \
          <button class='w3-button w3-red cancel'>Cancelar</button><input type='button' class='send_rem' value='confirmar' style='float:right;margin-bottom:20px' /></form>");
        //Show the modal
        document.getElementById('id01').style.display='block';
        
  });
  $(".cancel").on("click",function(){
    $("w3-closebtn").click();
  });

  </script>
  <br><br>
</nav>

<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<div id="ajub" class="w3-row-padding w3-margin-bottom" >
</div>

<div class="w3-row-padding " style="margin-top:32px!important;">
    <div class="w3-quarter">
    <!--ao clicar vai mostrar balanco dos ultimos dias-->
      <div class="w3-container bigButton w3-black w3-text-white w3-padding-16 w3-border-black" style="border: 7px solid;">
        <div class="w3-left"><i class="fas fa-wallet w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3 id=saldo>0</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Saldo Disponivel</h4>
      </div>
    </div>
    <div class="w3-quarter">
    <!--Credito inicial/Valor mensal/Valor mes atual/Valor restante-->
      <div class="w3-container w3-black w3-padding-16 w3-border-black" style="border: 7px solid;">
        <div class="w3-left"><i class="fa fa-coins w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3 id=casa>0</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Valor gasto</h4>
      </div>
    </div>
    <div class="w3-quarter">
    <!--Valor atual de ação/Numero de ações/Empresa/detalhes-->
      <div class="w3-container w3-black w3-padding-16 w3-border-black" style="border: 7px solid;">
        <div class="w3-left"><i class="fas fa-gamepad w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3 id=investimento>0</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Jogos Comprados</h4>
      </div>
    </div>
    <div class="w3-quarter">
    <!--Credito inicial/Valor mensal/Valor mes atual/Valor restante/Tipo de credito-->
      <div class="w3-container w3-black w3-padding-16 w3-border-black" style="border: 7px solid;">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3 id=emprestimo>0</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Avaliações feitas</h4>
      </div>
    </div>
  </div>


<!--user account module-->
  <div id="ajin" class="w3-half w3-padding">
        
    <h5 class="w3-black w3-padding-left">Informações de conta</h5>
    <table id="us_conta" class="w3-table w3-black "> 
          <tbody>
          <tr>
          <td><i class="fa fa-user"></i> &emsp; Nome:</td><td><a class="info-n">Default</a></td>
          </tr>
          <tr>
          <td><i class="fa fa-money"></i>&emsp; Saldo:</td><td><a class="info-m">Default</a></td>
          </tr>
          <tr>
          <td><i class="fa fa-calendar"></i> &emsp; Data:</td><td><a class="info-d">Default</a></td>
          </tr>

        <script>
          
        </script>
        </tbody>
    </table>
        
  </div><!--end of container-->
<!--end of charts module-->

<!--user recent actions-->

      <div id="ajun" class="w3-half w3-padding">
        <h5 class="big w3-black w3-padding-left">Area cliente  </h5>
        <table id="operacoes" class="w3-table w3-black "> 
          <tbody><tr>
          <td><i class="fa fa-user w3-green w3-padding-tiny"></i></td><td>Sem notificações</td>
          </tr></tbody>
        </table>
      </div> <!--end of AJN (ajun) module-->
    </div><!--end of row padding-->
  </div><!--end of container-->


<!--Multi purpose modal-->

  <div id="id01" class="w3-modal" style="padding-top:10%!important;opacity:1!important;">
    <div class="w3-modal-content w3-card-8" >
      <header class="w3-container w3-black" style="position:center">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn">&times;</span>
        <h2 class="modal_head"></h2>
      </header>
      <div class="w3-container modal_subtitle" style="border-bottom:1px solid;">
        
      </div>
        
      <div class="w3-container w3-white modal_body">

      </div>
    </div>
  </div>

  <!--footer
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-half w3-hoverable">
        <h5 class="w3-bottombar w3-border-green">exit</h5>
      </div>
      <div class="w3-container w3-half">
        <h5 class="w3-bottombar w3-border-red ">settings</h5>

      </div>
    </div>
  </div>
<br>
-->
<script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}

//varaible declaration
var selection = "1";
var sensor_selector="1";
var ct = [];
var saldo;
var casa;
var investimento;
var emprestimo;
var conta = 0;
var cliente = 0;
var banco = 0;
var user = 0;

function loadsaldo(conta){
    //security layer test vs sql injections
    conta = parseInt(conta);

    //get all saldos
    $.post("http://localhost:8080/Banco_simples/Banco_Servlet",{operacao:'consultar_saldo',conta:conta},function(postresult){
      $(".modal_body").html(postresult);
      //get all classes
      classes = $("#dados").attr('class');
      //split classes
      st = classes.split(' ');
      saldo = st[0].replace( /[^\d.]/g, '' );
      saldo = parseInt(saldo,10); //select saldo
      saldo = saldo.toFixed(2);
      casa = st[1].replace( /[^\d.]/g, '' );
      casa = parseInt(casa,10); //select casa
      casa = casa.toFixed(2);
      investimento = st[2].replace( /[^\d.]/g, '' );
      investimento = parseInt(investimento,10); //select inv
      investimento = investimento.toFixed(2);
      emprestimo = st[3].replace( /[^\d.]/g, '' );
      emprestimo = parseInt(emprestimo,10); //select emp
      emprestimo = emprestimo.toFixed(2);
      $("#saldo").text(saldo);
      $("#casa").text(casa);
      $("#investimento").text(investimento);
      $("#emprestimo").text(emprestimo);
      $(".modal_body").empty();//cleanup

      //user info
      var currentdate2 = new Date(); 
      var datenow = currentdate2.getDate() + "/" +  (currentdate2.getMonth()+1) + "/" + currentdate2.getFullYear();
      $(".info-n").text(user);
      $(".info-m").text(saldo);
      $(".info-d").text(datenow);
    });
}

function getop(conta){
  //security layer test vs sql injections
  conta = parseInt(conta);

  //get all operacoes
  $.post("http://localhost:8080/Banco_simples/Banco_Servlet",{operacao:'consultar_operacoes',conta:conta},function(postresult){
    $("#operacoes").html(postresult);
  });
}

//jquery & ajax
  //Loaded at the beginning
  $( document ).ready(function() {
    <?php echo 'loadsaldo('.$conta.');'; ?>//inline php to solve sync issues
    //show table modal
    $(document).on("click",".clickable",function(){
      $(".modal_body").empty();
      $(".modal_subtitle").empty();
      $(".modal_head").text("");
    //Show the modal
    document.getElementById('id01').style.display='block';
    });

    //save all values as local variables
    <?php echo 'conta ='.$conta.';' ?>
    <?php echo 'cliente='.$idc.';'; ?>
    <?php echo 'banco='.$banco.';'; ?>
    <?php echo 'user="'.$user.'";'; ?>

    <?php echo 'getop('.$conta.');'; ?>//inline php to solve sync issues

    //print reports of any part of the web page
    $(document).on("click",".pdf",function(){
      createPDF("ajun");
    });

    $(".terminar").on("click",function(){
      $.post("dash.php",{end:'1'},function(postresult){
        window.location.href = "Main.php";
      });
    });
  });

  

//functions
  //operations
  $(document).on("click",".send_l",function(){ //levantar
    //get value user wants and check if its valid
    var val = parseInt($(".valor").val(),10);
    console.log(val);
    console.log(saldo);
    (val <= saldo) ? retirar(val) : console.log("saldo insuficiente") ; 
    function retirar()
    {
      $.ajax({
        url: 'http://localhost:8080/Banco_simples/Banco_Servlet',
        type: 'post',
        data: $('#levantamento').serialize(),
        success:function(postresult){
          cdata = postresult.includes("A sua operação foi efectuada...");

          if (cdata == true){
              //fazer levantamento
              console.log("levantamento efectuado");
              //reload values
              loadsaldo(conta);
              getop(conta);
              $(".w3-closebtn").click();//close modal
          }
        }
      });
    }
  });
  $(document).on("click",".send_d",function(){ //depositar
    //get value user wants and check if its valid
    var val = parseInt($(".valor").val(),10);
    $.ajax({
      url: 'http://localhost:8080/Banco_simples/Banco_Servlet',
      type: 'post',
      data: $('#deposito').serialize(),
      success:function(postresult){
        cdata = postresult.includes("A sua operação foi efectuada...");
        if (cdata == true){
            //fazer deposito
            console.log("deposito efectuado");
            //reload values
            loadsaldo(conta);
            getop(conta);
            $(".w3-closebtn").click();//close modal
        }
      }
    });
  });
  $(document).on("click",".send_t",function(){ //transferir
    //get value user wants and check if its valid
    var val = parseInt($(".valor").val(),10);
    console.log(val);
    console.log(saldo);
    (val <= saldo) ? passar(val) : console.log("saldo insuficiente") ; 
    function passar()
    {
      $.ajax({
        url: 'http://localhost:8080/Banco_simples/Banco_Servlet',
        type: 'post',
        data: $('#transferencia').serialize(),
        success:function(postresult){
          cdata = postresult.includes("A sua operação foi efectuada...");

          if (cdata == true){
              //fazer transferencia
              console.log("transferencia efectuada");
              //reload values
              loadsaldo(conta);
              getop(conta);
              $(".w3-closebtn").click();//close modal
          }
        }
      });
    }
  });
  $(document).on("click",".send_e",function(){ //depositar
    //get value user wants and check if its valid
    var val = parseInt($(".valor").val(),10);
    $.ajax({
      url: 'http://localhost:8080/Banco_simples/Banco_Servlet',
      type: 'post',
      data: $('#Emprestimo').serialize(),
      success:function(postresult){
        cdata = postresult.includes("A sua operação foi efectuada...");
        if (cdata == true){
            //fazer emprestimo
            console.log("Emprestimo efectuado");
            //reload values
            loadsaldo(conta);
            getop(conta);
            $(".w3-closebtn").click();//close modal
        }
      }
    });
  });

  $(document).on("click",".send_i",function(){
    //calculate profit
    var val = parseInt($(".vi").val(),10);
    var win = Math.floor(Math.random() * 101)/100;//random profit from investment
    var profit = val+(val*win);
    $(".vi").val(profit);//append profit to the form
    send_i();
  });

  function send_i(){
    $.ajax({
    url: 'http://localhost:8080/Banco_simples/Banco_Servlet',
    type: 'post',
    data: $('#Investimento').serialize(),
    success:function(postresult){
      cdata = postresult.includes("A sua operação foi efectuada...");
      if (cdata == true){
          //fazer investimento
          console.log("Investimento efectuado");
          //reload values
          loadsaldo(conta);
          getop(conta);
          $(".w3-closebtn").click();//close modal
      }
    }
    });
  }

  $(document).on("click",".send_c",function(){ //levantar
    //get value user wants and check if its valid
    var val = parseInt($(".valor").val(),10);
    console.log(val);
    console.log(saldo);
    (val <= saldo) ? comprar(val) : console.log("saldo insuficiente") ; 
    function comprar()
    {
      $.ajax({
        url: 'http://localhost:8080/Banco_simples/Banco_Servlet',
        type: 'post',
        data: $('#Compra').serialize(),
        success:function(postresult){
          cdata = postresult.includes("A sua operação foi efectuada...");

          if (cdata == true){
              //fazer levantamento
              console.log("compra efectuada");
              //reload values
              loadsaldo(conta);
              getop(conta);
              $(".w3-closebtn").click();//close modal
          }
        }
      });
    }
  });

  $(document).on("click",".send_p",function(){ //levantar
    //get value user wants and check if its valid
    var val = parseInt($(".valor").val(),10);
    console.log(val);
    console.log(saldo);
    (val <= saldo) ? pagar(val) : console.log("saldo insuficiente") ; 
    function pagar()
    {
      $.ajax({
        url: 'http://localhost:8080/Banco_simples/Banco_Servlet',
        type: 'post',
        data: $('#Pagamento').serialize(),
        success:function(postresult){
          cdata = postresult.includes("A sua operação foi efectuada...");

          if (cdata == true){
              //fazer levantamento
              console.log("compra efectuada");
              //reload values
              loadsaldo(conta);
              getop(conta);
              $(".w3-closebtn").click();//close modal
          }
        }
      });
    }
  });
  
  $(document).on("click",".send_rem",function(){ //levantar
    //get value user wants and check if its valid
    saldo_a = parseInt(saldo,10);
    console.log(saldo_a);
    (saldo_a == 0) ? apagar() : console.log("ainda existe saldo") ; 
    function apagar()
    {
      $.ajax({
        url: 'http://localhost:8080/Banco_simples/Banco_Servlet',
        type: 'post',
        data: $('#Encerrar').serialize(),
        success:function(postresult){
          cdata = postresult.includes("A sua operação foi efectuada...");

          if (cdata == true){
              //fazer levantamento
              console.log("conta apagada");
              $.post("dash.php",{end:'1'},function(postresult){
                window.location.href = "Main.php"; // close session
              });
          }
        }
      });
    }
  });

  //impressao
  function createPDF(valor) { //print any 
        var sTable = document.getElementById(valor).innerHTML;
        var currentdate = new Date(); 
        var datetime = "Impresso dia: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " as  "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds()+ " horas ";
        var style = "<style>";
        style = style + "table {width: 100%;font: 17px Calibri;}";
        style = style + "table, th, td {border: solid 1px #fff; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: left;}";
        style = style + ".big{font: 24px Calibri;}";
        style = style + "</style>";

        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');

        win.document.write('<html><head>');
        win.document.write('<title>Profile</title>');   // <title> FOR PDF HEADER.
        win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('<br><br>');
        win.document.write(datetime); //get current time
        win.document.write('</body></html>');

        win.document.close(); 	// CLOSE THE CURRENT WINDOW.

        win.print();    // PRINT THE CONTENTS.
    }

</script>
</body></html>