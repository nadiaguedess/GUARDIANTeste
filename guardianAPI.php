<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//BUSCANDO JSON POST
$payload = file_get_contents('php://input');
$obj = json_decode($payload);

//REALIZANDO CONEXÃO COM O BANCO DE DADOS
require_once "banco/ConexaoVFBCompany.php";
$var = new Mysql();
$connect = $var->dbConnect();

//VALIDAR CAMPOS OBRIGATÓRIOS ANTES DE INSERIR O CLIENTE
$msg = ValidarCampos($obj->cliente->cpf, $obj->cliente->nome, $obj->cliente->data_nascimento, $obj->cliente->email, $obj->cliente->telefone);
if(!empty($msg)){
    //RETORNANDO CRITICA
    echo json_encode(
        array("message" => $msg)
    );
    exit;
}

//BUSCANDO ARRAY DE TELEFONE
$someObject = $obj->cliente->telefone; 
foreach($someObject as $value) {

    //VALIDANDO CELULAR DO CLIENTE
    if(!ValidarCelular($value)){
        echo json_encode(
            array("message" => "Celular inválido!")
        );
        exit;
    }else{
        $value.' <br/>';
    }
}

try{
    //BUSCANDO CLIENTE
    $buscarCliente = $var->freeRun("SELECT idcliente FROM CLIENTE WHERE cpf='".$obj->cliente->cpf."'");
    $numbuscarCliente = mysqli_num_rows($buscarCliente);
    
    //VERIFICANDO SE CLIENTE JÁ EXISTE
    if($numbuscarCliente == 0){
        //INSERIR CLIENTE
        $utf = $var->freeRun("SET NAMES 'utf8'");
        $inserirCliente = $var->freeRun("INSERT INTO 
                            CLIENTE 
                            (`cpf`,
                            `nome`,
                            `data_nascimento`,
                            `email`
                            ) 
                        values (
                            '".$obj->cliente->cpf."', 
                            '".$obj->cliente->nome."', 
                            '".$obj->cliente->data_nascimento."', 
                            '".$obj->cliente->email."'
                            )");
    }else{
        echo json_encode(
            array("message" => "Cliente já existe!" )
        );
        exit;
    }
    
                        
    $buscarCliente = $var->freeRun("SELECT idcliente FROM CLIENTE WHERE cpf='".$obj->cliente->cpf."'");
    $numbuscarCliente = mysqli_num_rows($buscarCliente);
    $buscarCliente = mysqli_fetch_assoc($buscarCliente);
    
    if($numbuscarCliente > 0 && $inserirCliente == true){
    
        //BUSCANDO ARRAY DE TELEFONE
        $someObject = $obj->cliente->telefone; 
        foreach($someObject as $value) {
            $utf = $var->freeRun("SET NAMES 'utf8'");
             //INSERIR TELEFONE(S) CLIENTE
            $inserirTelefone = $var->freeRun("INSERT INTO 
                                CLIENTE_TELEFONE 
                                (
                                `telefone`,
                                `cliente_idcliente`
                                ) 
                            values (
                                '$value', 
                                '".$buscarCliente['idcliente']."'
                                )");
        }
     
    }
    
    if($inserirTelefone == true && $inserirCliente == true){
        echo json_encode(
            array("message" => "Cliente ".$obj->cliente->nome." inserido(a) com sucesso!")
        );
    }
   
}catch(Exception $e){
     echo json_encode(
        array("message" => "Não foi possível inserir o cliente. Ex: ".$e)
    );
}

?>


<?php
function ValidarCampos($cpf, $nome, $data_nascimento, $email, $telefone){
    if(empty($cpf) || strlen($cpf) > 14 ){
        return 'CPF do Cliente não informado ou a quantidade de caracteres maior que 14!';
    }else if(empty($nome) || strlen($nome) > 60){
        return 'Nome do Cliente não informado ou a quantidade de caracteres maior que 60!';
    }else if(empty($data_nascimento) || checkmydate($data_nascimento) == false){
        return 'Data de Nascimento do Cliente não informado ou Data inválida!';
    }else if(empty($email) || strlen($email) > 60){
        return 'E-mail do Cliente não informado ou a quantidade de caracteres maior que 60!';
    }else if(empty($telefone) || strlen($telefone) > 15){
        return 'Telefone(s) do Cliente não informado ou a quantidade de caracteres maior que 15!';
    }else{
        return '';
    }
}

?>


<?php
function ValidarCelular($telefone){
    if(substr($telefone, 0 ,1) != "("){
         return false;
    }else if(substr($telefone, 3 ,1) != ")"){
        return false;
    }else if(substr($telefone, 10 ,1) != "-"){
        return false;
    }
    
    $telefone= trim(
                        str_replace('/', '', 
                                    str_replace(' ', '', 
                                                str_replace('-', '', 
                                                        str_replace(')', '', 
                                                            str_replace('(', '', $telefone)
                                                                    )
                                                            )
                                                )
                                    )
                    );

    $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar celular
    if (preg_match($regexCel, $telefone)) {
        return true;
    }else{
        return false;
    }
}

//VALIDAR DATA
function checkmydate($date) {
  $tempDate = explode('-', $date);
  return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
}

?>