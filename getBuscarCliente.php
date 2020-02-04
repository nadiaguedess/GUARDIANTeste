<?php

//REALIZANDO CONEXÃO COM O BANCO DE DADOS
require_once "banco/ConexaoVFBCompany.php";


//VERIFICANDO SE BUSCA É POR CPF
if(isset($_GET['CPF'])){
    $cpf = $_GET['CPF'];    
    if($cpf == ""){
        //RETORNANDO CRITICA
        echo json_encode(
            array("message" => "Parâmetros não fornecidos!")
        );
        exit;
    }
    $dados = buscarClienteCPF($cpf);
    if(empty($dados)){
         //RETORNANDO CRITICA
        echo json_encode(
            array("message" => "Cliente não encontrado!")
        );
        exit;
    }
    print_r($dados);
    exit;
}

//VERIFICANDO SE BUSCA É POR NOME
if(isset($_GET['NOME'])){
   $nome = $_GET['NOME']; 
    if($nome == ""){
        //RETORNANDO CRITICA
        echo json_encode(
            array("message" => "Parâmetros não fornecidos!")
        );
        exit;
    }
   $dados = buscarClienteNome($nome);
    if(empty($dados)){
         //RETORNANDO CRITICA
        echo json_encode(
            array("message" => "Cliente(s) não encontrado(s)!")
        );
        exit;
    }
    print_r($dados);
    exit;
}

//VERIFICANDO SE BUSCA É POR IDADE
if(isset($_GET['IDADE_DE']) && isset($_GET['IDADE_ATE'])){
    $idadeDE = $_GET['IDADE_DE'];    
    $idadeATE = $_GET['IDADE_ATE'];
    
    if($idadeDE == "" && $idadeATE == ""){
        //RETORNANDO CRITICA
        echo json_encode(
            array("message" => "Parâmetros não fornecidos!")
        );
        exit;
    }
    
    $dados = buscarClienteIdade($idadeDE, $idadeATE);
    if(empty($dados)){
         //RETORNANDO CRITICA
        echo json_encode(
            array("message" => "Cliente(s) não encontrado(s)!")
        );
        exit;
    }
    print_r($dados);
    exit;
}

function buscarClienteCPF($cpfBuscar){
    //BUSCANDO CLIENTE
    $var = new Mysql();
    $connect = $var->dbConnect();
    $utf = $var->freeRun("SET NAMES 'utf8'");
    $buscarCliente = $var->freeRun("SELECT * FROM CLIENTE WHERE cpf='$cpfBuscar'");
    $buscarCliente = mysqli_fetch_assoc($buscarCliente);    
    return $buscarCliente;
}

function buscarClienteNome($nomeBuscar){
    //BUSCANDO CLIENTE
    $var = new Mysql();
    $connect = $var->dbConnect();
    $utf = $var->freeRun("SET NAMES 'utf8'");
    $buscarCliente = $var->freeRun("SELECT * FROM CLIENTE WHERE nome like '%".$nomeBuscar."%'");
    $buscarCliente = mysqli_fetch_assoc($buscarCliente);
    return $buscarCliente;
}

function buscarClienteIdade($IdadeDEBuscar, $IdadeATEBuscar){
    //BUSCANDO CLIENTE
    $var = new Mysql();
    $connect = $var->dbConnect();
    $utf = $var->freeRun("SET NAMES 'utf8'");
    $buscarCliente = $var->freeRun("SELECT * FROM CLIENTE WHERE idade >='$IdadeDEBuscar' and idade <= '$IdadeATEBuscar'");
    $buscarCliente = mysqli_fetch_assoc($buscarCliente);
    return $buscarCliente;
}


?>