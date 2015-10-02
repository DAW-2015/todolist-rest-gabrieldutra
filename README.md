#Propriedades do Sistema
##Usuários
1. `GET /usuarios`
	* Descrição: Visualizar usuários;
	* Retorna: 
		
	```
	[
  		{
    	"id": "1",
    	"name": "teste22",
    	"email": "teste@teste",
    	"login": "teste",
    	"password": "teste"
  		},
  		{
    	"id": "3",
    	"name": "absabs",
    	"email": "nesk@abs",
    	"login": "absabs",
    	"password": "absabs"
  		}		
	]
	```		
2. `GET /usuarios/:id`
	* Descrição: Visualizar usuário com determinado id;
	* Parâmetro `:id`: Id do usuário a ser localizado;
	* Retorna: 
	
	```
	{
    "id": "3",
    "name": "absabs",
    "email": "nesk@abs",
    "login": "absabs",
    "password": "absabs"
  	}
	```
3. `POST /usuarios`
	* Descrição: Insere um novo usuário;
	* Exemplo de corpo: 
	
	```
	{
    "id": "0",
    "name": "absabs",
    "email": "nesk@abs",
    "login": "absabs",
    "password": "absabs"
  	} 
	```
	* Retorno: JSON do usuário inserido;
4. `PUT /usuarios/:id`
	* Descrição: Altera um usuário;
	* Parâmetro `:id`: Id do usuário a ser alterado;
	* Exemplo de corpo: 
	
	```
	{
    "id": "0",
    "name": "Novo nome",
    "password": "novasenha"
  	}
	```
	* Retorno: 
		
	```
	{
	"success": true 
	}
	```				
5. `DELETE /usuarios/:id`
	* Descrição: Deleta um usuário;
	* Parâmetro `:id`: Id do usuário a ser deletado;
	* Retorno: 
	
	```
	{
	"success": true 
	}
	```	
	
##Categorias
1. `GET /categorias`
	* Descrição: Visualizar categorias;
	* Retorna: 
		
	```
	[
  		{
    	"id": "8",
    	"category": "Categoria1"
  		},
  		{
    	"id": "5",
    	"category": "Categoria2"
  		}
	]
	```		
2. `GET /categorias/:cat`
	* Descrição: Retorna o id da categoria solicitada, cria a categoria se ela não existir;
	* Parâmetro `:cat`: Categoria desejada;
	* Retorna: 
	
	```
	{
	"id": 3 
	}
	```	
3. `POST /categorias`
	* Descrição: Insere uma nova categoria;
	* Exemplo de corpo: 
	
	```
	{
    "id": "0",
    "category": "NovaCategoria"
  	} 
	```
	* Retorno: 
	
	```
	{
	"success": true 
	}
	```
4. `PUT /categorias/:id`
	* Descrição: Altera uma categoria;
	* Parâmetro `:id`: Id da categoria a ser alterada;
	* Exemplo de corpo: 
	
	```
	{
    "id": "0",
    "category": "MudaCategoria"
  	} 
	```
	* Retorno: 
		
	```
	{
	"success": true 
	}
	```				
5. `DELETE /categorias/:id`
	* Descrição: Deleta uma categoria;
	* Parâmetro `:id`: Id da categoria a ser deletada;
	* Retorno: 
	
	```
	{
	"success": true 
	}
	```	
	
##Tarefas
1. `GET /tarefas`
	* Descrição: Visualizar tarefas;
	* Retorna: 
		
	```
	[
  		{
    	"id": "1",
    	"user": {
      		"id": "1",
      		"name": "teste22",
      		"email": "teste@teste",
      		"login": "teste",
     		"password": "teste"
    	  },
    	"description": "teste",
    	"category": "Pessoal"
  		},
  		{
    	"id": "2",
    	"user": {
      		"id": "1",
      		"name": "teste22",
      		"email": "teste@teste",
      		"login": "teste",
      		"password": "teste"
    	  },
    	"description": "teste3",
    	"category": "Trabalho"
  		}
  	]
	```		
2. `GET /tarefas/:id`
	* Descrição: Visualizar tarefa com determinado id;
	* Parâmetro `:id`: Id da tarefa a ser localizada;
	* Retorna: 
	
	```
	{
    "id": "2",
    "user": {
      	"id": "1",
      	"name": "teste22",
      	"email": "teste@teste",
      	"login": "teste",
      	"password": "teste"
      },
    "description": "teste3",
    "category": "Trabalho"
  	}
	```	
3. `POST /tarefas`
	* Descrição: Insere uma nova tarefa;
	* Exemplo de corpo: 
	
	```
	{
    "id": "0",
    "user": {
      	"id": "1",
      	"name": "teste22",
      	"email": "teste@teste",
      	"login": "teste",
      	"password": "teste"
      },
    "description": "Nova Tarefa",
    "category": "Trabalho"
  	}
	```
	* Retorno: 
	
	```
	{
	"success": true 
	}
	```
4. `PUT /tarefas/:id`
	* Descrição: Altera uma tarefa;
	* Parâmetro `:id`: Id da tarefa a ser alterada;
	* Exemplo de corpo: 
	
	```
	{
    "id": "0",
    "user": {
      	"id": "1",
      	"name": "teste22",
      	"email": "teste@teste",
      	"login": "teste",
      	"password": "teste"
      },
    "description": "Tarefa alterada",
    "category": "Trabalho"
  	}
	```
	* Retorno: 
		
	```
	{
	"success": true 
	}
	```				
5. `DELETE /tarefas/:id`
	* Descrição: Deleta uma tarefa;
	* Parâmetro `:id`: Id da tarefa a ser deletada;
	* Retorno: 
	
	```
	{
	"success": true 
	}
	```	