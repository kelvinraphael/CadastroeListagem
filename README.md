Este é um projeto de exemplo em PHP e PostgreSQL que implementa um sistema simples de gestão de funcionários.

O sistema permite:

Login seguro com senhas criptografadas.
Cadastro de funcionários, incluindo nome, e-mail, cargo e situação.
Listagem com busca e paginação de funcionários.
Sessões para controlar o acesso do usuário.

O projeto foi desenvolvido usando PHP, PostgreSQL, Bootstrap 5 e PDO para acesso seguro ao banco de dados.

Estrutura do projeto
index.html → Tela de login
login.php → Processa login
conexao.php → Conexão com o banco
home.php → Cadastro e edição de funcionário
listagem.php → Listagem de funcionários
style.css → Estilos personalizados
Funcionalidade principal
O usuário faz login e é redirecionado para a listagem de funcionários.
É possível buscar, editar ou excluir funcionários.
O cadastro de novo funcionário fica na página home.php.
Futuramente, o sistema terá recuperação de senha.

O objetivo deste projeto é aprender e demonstrar conceitos de login, cadastro e listagem usando PHP com um banco PostgreSQL de forma segura e organizada.
