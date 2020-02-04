# GUARDIANTeste
Teste Técnico GUARDIAN

API de Clientes GUARDIAN
Teste Técnico

Descrição das Funcionalidades: A API desenvolvida tem como funcionalidade inserir clientes no banco de dados através de uma requisição (POST), buscar os clientes cadastrados (GET) por Nome, CPF e Idade (Range).

Parâmetros de Entrada: 
-CPF (Tipo: String, Max 14)
-Nome (Tipo: String, Max 60)
-Data de Nascimento (Tipo: Date, Formato yyyy-MM-dd)
-E-mail (Tipo: String, Max 60)
-Idade (Tipo: Int)
-Telefone (Tipo: String, Max 15)

Formato da Resposta (GET) e Entrada (POST): JSON

Autenticação: Não possui autenticação

Requisições:

-Inserir novo cliente no banco de Dados:
Endpoint: https://trustmlm.com/GuardianTeste/guardianAPI.php
Data-raw: cliente.json (arquivo na pasta)
Parâmetros: 
- cpf (String, Max 14) Obrigatório
- nome (String, Max 60) Obrigatório
- data_nascimento (Date, yyyy-MM-dd) Obrigatório
- email (String, Max 60) Obrigatório
- idade (int) Obrigatório
- telefone (String[], Max 14) Obrigatório [1]
	
  curl --location --request POST 'https://trustmlm.com/GuardianTeste/guardianAPI.php' \
--header 'Content-Type: application/json' \
--data-raw '{
    "cliente": {
		"cpf": "02354859694",
        "nome": "Nádia Guedes de Araujo",
        "data_nascimento": "1999-05-31",
        "email": "nadiaguedees@gmail.com",
        "idade" : "1",
		"telefone": [
						"(31) 99348-0001",
						"(31) 99348-0002",
						"(31) 99348-0003",
						"(31) 99348-0004"
					]
       
    }
}'
  
-Buscar Cliente por CPF
Endpoint: https://trustmlm.com/GuardianTeste/getBuscarCliente.php
Parâmetros: CPF (String, Max 14)
curl --location --request GET 'https://trustmlm.com/GuardianTeste/getBuscarCliente.php?CPF=02354859694'

-Buscar Cliente por Nome
Endpoint: https://trustmlm.com/GuardianTeste/getBuscarCliente.php
Parâmetros: NOME (String, Max 60)

curl --location --request GET 'https://trustmlm.com/GuardianTeste/getBuscarCliente.php?NOME=N%C3%A1dia'

-Buscar Cliente por Idade
Endpoint: https://trustmlm.com/GuardianTeste/getBuscarCliente.php
Parâmetros:
- IDADE_DE (Int)
- IDADE_ATE (Int)

curl --location --request GET 'https://trustmlm.com/GuardianTeste/getBuscarCliente.php?IDADE_DE=0&IDADE_ATE=20'

Possíveis Retornos:

Caso o formato do Celular esteja inválido:
"message": "Celular inválido!" 
Caso o cliente já esteja cadastrado no bando de dados:
"message": "Cliente já existe!"
Confirmando que o cliente foi cadastrado com sucesso:
"message": "Cliente NOME inserido(a) com sucesso!! "
Caso ocorra uma exceção ao tentar inserir o cliente no banco de dados:
"message": "Não foi possível inserir o cliente. Ex:" EXCEPTION
Crítica/Validação do CPF do cliente a ser cadastrado:
"message": "CPF do Cliente não informado ou a quantidade de caracteres maior que 14! "
Crítica/Validação do Nome do cliente a ser cadastrado:
"message": "Nome do Cliente não informado ou a quantidade de caracteres maior que 60!"
Crítica/Validação da Data de Nascimento do cliente a ser cadastrado:
"message": "Data de Nascimento do Cliente não informado ou Data inválida!"
Crítica/Validação do E-mail do cliente a ser cadastrado:
"message": "E-mail do Cliente não informado ou a quantidade de caracteres maior que 60!"
Crítica/Validação do(s) Telefone(s) do cliente a ser cadastrado:
"message": "Telefone(s) do Cliente não informado ou a quantidade de caracteres maior que 15!"
Crítica a falta de parâmetros ao buscar um usuário:
"message": "Parâmetros não fornecidos!"
Mensagem para cliente não encontrado no bando de dados:
"message": "Cliente não encontrado!"


Link compartilhado para testes POSTMAN: https://www.getpostman.com/collections/a3da6e744538b7ac98f5
