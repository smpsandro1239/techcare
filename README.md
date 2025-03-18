---

# Tech Care - Sistema de Agendamento e Gerenciamento de Serviços

Bem-vindo ao **Tech Care**, um sistema web desenvolvido para gerenciar agendamentos de serviços técnicos, como instalação de sistemas operacionais, manutenção de hardware e configuração de redes. Este projeto utiliza o framework Laravel, FullCalendar para a interface de agendamento, e oferece um ambiente colaborativo para desenvolvedores trabalharem juntos.

## Visão Geral do Projeto

O Tech Care é uma aplicação voltada para:
- **Agendamento de serviços**: Permite que clientes agendem serviços técnicos com base em horários disponíveis.
- **Gerenciamento de usuários**: Suporta múltiplos papéis (admin, vendor, customer) com autenticação e autorização.
- **Catálogo de produtos**: Inclui uma seção para procurar e exibir produtos (futuro desenvolvimento).
- **Interface amigável**: Utiliza Bootstrap e FullCalendar para uma experiência visual atraente e funcional.

### Tecnologias Utilizadas
- **Backend**: Laravel 10.x
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 4, FullCalendar 6.1.11
- **Banco de Dados**: MySQL (via Laravel migrations)
- **Outros**: Livewire (para catálogos dinâmicos), SweetAlert2 (para notificações)
- **Controle de Versão**: Git
- **Ambiente de Desenvolvimento**: Laragon (recomendado)

### Estrutura do Projeto
- `app/`: Contém os controladores, modelos e middleware.
- `resources/views/`: Templates Blade para as páginas (ex.: `agendamento/create.blade.php`, `agendamento/index.blade.php`).
- `database/migrations/`: Definições de tabelas (ex.: `agendamentos`).
- `routes/`: Definições de rotas (ex.: `web.php`).
- `public/`: Arquivos estáticos como CSS, JS e imagens.

## Como Contribuir

Para colaborar no desenvolvimento do Tech Care, siga os passos abaixo. Certifique-se de ter permissões de acesso ao repositório no GitHub.

### Pré-requisitos
- **Git**: Para clonar e gerenciar o repositório.
- **PHP 8.1 ou superior**: Versão compatível com Laravel 10.
- **Composer**: Gerenciador de dependências PHP.
- **Node.js e NPM**: Para compilar assets (opcional, se necessário).
- **Laragon** (recomendado) ou outro servidor local (ex.: XAMPP, WAMP) com MySQL.
- **Editor de Código**: VS Code, PhpStorm ou similar.

### Passo a Passo para Configuração

1. **Clone o Repositório**
   - Abra o terminal e navegue até o diretório onde deseja armazenar o projeto.
   - Execute o comando abaixo para clonar o repositório:
     ```bash
     git clone https://github.com/smpsandro1239/techcare.git
     ```
     
2. **Acesse o Diretório do Projeto**
   - Entre no diretório clonado:
     ```bash
     cd techcare
     ```

3. **Instale as Dependências**
   - Instale as dependências do PHP via Composer:
     ```bash
     composer install
     ```
   - (Opcional) Instale dependências JavaScript via NPM, se houver assets personalizados:
     ```bash
     npm install && npm run dev
     ```

4. **Configure o Ambiente**
   - Renomeie o arquivo `.env.example` para `.env`:
     ```bash
     cp .env.example .env
     ```
   - Edite o arquivo `.env` com suas configurações:
     - **DB_DATABASE**: Nome do banco de dados (ex.: `techcare_db`).
     - **DB_USERNAME**: Usuário do MySQL (ex.: `root`).
     - **DB_PASSWORD**: Senha do MySQL (deixe em branco se não houver senha no Laragon).
     - **APP_URL**: URL do projeto (ex.: `http://techcare.test`).
   - Gere a chave do aplicativo:
     ```bash
     php artisan key:generate
     ```

5. **Configure o Banco de Dados**
   - Crie um banco de dados MySQL chamado `techcare_db` (ou o nome que você definiu no `.env`).
   - Execute as migrações para criar as tabelas:
     ```bash
     php artisan migrate
     ```
   - (Opcional) Popule o banco com dados de exemplo (se houver seeders):
     ```bash
     php artisan db:seed
     ```

6. **Inicie o Servidor**
   - Se estiver usando Laragon, inicie o ambiente (Apache e MySQL) e aponte o virtual host para o diretório `techcare`.
   - Ou use o servidor embutido do Laravel:
     ```bash
     php artisan serve
     ```
   - Acesse o projeto em `http://localhost:8000` ou o URL configurado no `.env`.

7. **Autenticação Inicial**
   - Registre um novo usuário em `http://localhost:8000/register` ou use o comando Artisan para criar um admin:
     ```bash
     php artisan tinker
     User::create(['name' => 'Admin', 'email' => 'admin@techcare.com', 'password' => bcrypt('password'), 'role' => 1])
     ```
   - Faça login com as credenciais criadas.

8. **Teste o Agendamento**
   - Acesse `http://localhost:8000/agendamento` para criar um agendamento.
   - Verifique se o calendário carrega e se o modal de horários aparece corretamente.

### Estrutura de Colaboração

- **Branching Strategy**:
  - Use a branch principal `main` para a versão estável.
  - Crie branches de funcionalidades (ex.: `feature/agendamento`, `feature/catalogo`) para novos desenvolvimentos.
  - Submeta pull requests (PRs) para revisão antes de mesclar com `main`.

- **Pull Requests**:
  - Descreva as mudanças no PR.
  - Peça revisão a pelo menos um colega.
  - Teste localmente antes de submeter.

- **Comandos Úteis**:
  - Criar uma nova branch:
    ```bash
    git checkout -b feature/nova-funcionalidade
    ```
  - Enviar alterações:
    ```bash
    git add .
    git commit -m "Descrição da mudança"
    git push origin feature/nova-funcionalidade
    ```
  - Atualizar o repositório local:
    ```bash
    git pull origin main
    ```

### Funcionalidades Atuais
- **Agendamento**: Interface com FullCalendar para selecionar datas e horários, com suporte a feriados e horários ocupados.
- **Autenticação**: Login, registro e verificação de e-mail via Laravel Breeze.
- **Gerenciamento de Roles**: Admin, vendor e customer com middleware personalizado (`RoleManager`).
- **Catálogo**: Página inicial com busca de produtos (em desenvolvimento).

### Problemas Conhecidos
- Erro 500 ao carregar horários disponíveis no modal de agendamento (em processo de correção).
- Integração com catálogo de produtos ainda incompleta.

### Contribuições Futuras
- Adicionar sistema de pagamento.
- Melhorar a interface do usuário com animações.
- Implementar notificações por e-mail para agendamentos.

### Contato
- **Mantenedor**: [Seu Nome] (seu.email@example.com)
- **Repositório**: [https://github.com/smpsandro1239/techcare](https://github.com/seu-usuario/techcare)
- **Issues**: Abra uma issue no GitHub para relatar bugs ou sugerir melhorias.

### Licença
Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

---

### Personalização
- Substitua `https://github.com/User/techcare.git` pelo URL real do seu repositório.
- Adicione detalhes específicos do seu ambiente (ex.: portas do Laragon, configurações de banco de dados).
- Inclua seções adicionais, como "Guia de Estilo" ou "Documentação da API", se aplicável.

### Próximos Passos
Depois de criar o `README.md`, coloque-o na raiz do projeto e faça o commit:
```bash
echo "# Tech Care - Sistema de Agendamento e Gerenciamento de Serviços" > README.md
# Copie o conteúdo acima para README.md
git add README.md
git commit -m "Adicionado README com instruções de configuração e colaboração"
git push origin main
```
