<p align="center"><a href="[link para o vídeo no YouTube]" target="_blank"><img src="https://vuejs.org/images/logo.png" width="400" alt="Vue 3 Logo"></a></p>
Sobre a Agenda Telefônica
A Agenda Telefônica é uma aplicação web desenvolvida com Vue 3 e Laravel, projetada para gerenciar contatos de maneira simples e eficiente. Ela oferece todas as funcionalidades essenciais de um CRUD (Create, Read, Update, Delete), permitindo que os usuários criem, visualizem, editem e excluam seus contatos pessoais de forma segura e intuitiva.

Funcionalidades Principais
Autenticação com Laravel Sanctum: Utilize tokens seguros para autenticação de usuários, garantindo que apenas usuários autenticados possam acessar e gerenciar seus contatos.
Gerenciamento de Contatos: Crie, visualize, edite e exclua contatos facilmente.
Validação de Dados: Regras de validação robustas para garantir que os dados inseridos sejam sempre consistentes e corretos.
Interface Intuitiva: Desenvolvida com Vue 3, a interface do usuário é moderna, responsiva e fácil de usar.
Instalação
Siga os passos abaixo para instalar e configurar o projeto:

Clone o repositório:


git clone https://github.com/LimaHenriqueDev/Agenda-Telefonica
cd agenda-telefonica
Instale as dependências do PHP com o Composer:


composer install
Instale as dependências do Node.js com o npm:


npm install
Copie o arquivo .env.example para .env e configure suas variáveis de ambiente:


cp .env.example .env
Gere a chave da aplicação:


php artisan key:generate
Execute as migrações do banco de dados:


php artisan migrate
(Opcional) Popule o banco de dados com dados iniciais:


php artisan db:seed
senha para acesso de todos os usuarios seed é password
Inicie o servidor de desenvolvimento:


php artisan serve
Agora, você pode acessar a aplicação em http://localhost:8000.

Assista à Demonstração
Confira a demonstração completa da aplicação no YouTube: https://youtu.be/wMLqsHOE1VU
YouTube - Agenda Telefônica
