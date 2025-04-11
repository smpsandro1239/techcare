Vou corrigir os erros apontados pelo `markdownlint` e melhorar ainda mais o README, garantindo que ele seja profissional, bem estruturado e compatível com as regras de formatação Markdown. Também vou ajustar a seção de imagens para lidar com o problema de "não carrega as imagens", explicando como garantir que elas sejam exibidas corretamente no GitHub.

### Problemas Identificados e Soluções

1. **Erro MD031: Fenced code blocks should be surrounded by blank lines**

    - **Descrição**: O erro ocorre na linha 301, onde o bloco de código (code fence) não está cercado por linhas em branco.
    - **Solução**: Adicionarei linhas em branco antes e depois do bloco de código.

2. **Erro MD040: Fenced code blocks should have a language specified**

    - **Descrição**: O erro ocorre na linha 311, onde o bloco de código não especifica a linguagem (ex.: `bash`, `php`, etc.).
    - **Solução**: Especificarei a linguagem do bloco de código como `bash`, já que é um comando de terminal.

3. **Imagens Não Carregam**
    - **Possível Causa**: As imagens referenciadas (ex.: `screenshots/lista-agendamentos.png`) não estão presentes na pasta `screenshots/` ou os caminhos estão incorretos no GitHub.
    - **Solução**:
        - Vou garantir que a seção de instruções para adicionar imagens seja mais clara.
        - Vou explicar como verificar se as imagens estão carregando corretamente no GitHub.
        - Vou sugerir o uso de URLs absolutas (caso as imagens sejam hospedadas em outro local) ou confirmar que os arquivos estão no repositório.

### README Melhorado

Abaixo está o README revisado e aprimorado, com os erros corrigidos, uma seção de verificação de imagens e mais detalhes para torná-lo profissional.

---

# Tech Care - Sistema de Agendamento e Administração de Serviços

![Banner do Tech Care](screenshots/banner-techcare.png)
_Sistema de agendamento e administração de serviços técnicos para simplificar sua rotina._

O **Tech Care** é uma aplicação web moderna e eficiente, desenvolvida para facilitar o agendamento e administração de serviços técnicos, como instalação de sistemas operacionais, manutenção de hardware e configuração de redes. Com uma interface intuitiva e funcionalidades robustas, o Tech Care é ideal para empresas ou profissionais que desejam organizar seus agendamentos de forma prática e confiável.

Desenvolvido com o framework **Laravel** e integrado ao **FullCalendar**, o Tech Care oferece uma experiência visual atraente e interativa, com suporte a múltiplos papéis de usuário, validação de feriados e notificações dinâmicas. Este projeto é open-source e colaborativo, convidando desenvolvedores a contribuir para seu crescimento.

---

## ✨ Funcionalidades Principais

- **Agendamento de Serviços**: Interface interativa com FullCalendar para selecionar datas e horários, com validação de feriados e horários ocupados.
- **Administração de Usuários**: Suporte a papéis (admin, vendor, customer) com autenticação e autorização via Laravel Breeze.
- **Notificações Dinâmicas**: Popups com SweetAlert2 para feedback em tempo real (ex.: erro ao agendar em feriado).
- **Catálogo de Produtos**: Seção para busca e exibição de produtos (em desenvolvimento).
- **Interface Amigável**: Design responsivo com Bootstrap 5 e FullCalendar, otimizado para desktops e dispositivos móveis.

---

## 📸 Demonstração do Sistema

Abaixo estão capturas de tela que ilustram as principais funcionalidades do Tech Care. (Certifique-se de que as imagens estão na pasta `screenshots/` no repositório.)

### 1. Página Inicial - Lista de Agendamentos

A página inicial exibe um calendário interativo com todos os agendamentos e uma tabela de agendamentos recentes.

![Página Inicial - Lista de Agendamentos](screenshots/lista-agendamentos.png)
_Visualize todos os agendamentos no calendário e na tabela de agendamentos recentes._

### 2. Criação de Agendamento

Clique em uma data no calendário para abrir o modal de agendamento, onde você pode selecionar o horário e o serviço.

![Modal de Agendamento](screenshots/modal-agendamento.png)
_Selecione a data, horário e serviço para agendar um atendimento._

### 3. Validação de Feriados

Ao tentar agendar em um feriado, um popup informativo é exibido, explicando o motivo da restrição.

![Popup de Feriado](screenshots/popup-feriado.png)
_Notificação de erro ao tentar agendar em um feriado (ex.: Dia do Trabalhador)._

### 4. Detalhes do Agendamento

Clique em um evento no calendário para ver os detalhes, incluindo data, horário, cliente e serviço.

![Popup de Detalhes do Agendamento](screenshots/detalhes-agendamento.png)
_Visualize os detalhes de um agendamento existente._

### 5. Catálogo de Produtos (Em Desenvolvimento)

A seção de catálogo permite buscar e visualizar produtos disponíveis.

![Catálogo de Produtos](screenshots/catalogo-produtos.png)
_Busque e visualize produtos (funcionalidade em desenvolvimento)._

### 6. Admin Dashboard

Painel de administração para gerenciar usuários, agendamentos e outras configurações.

![Admin Dashboard](screenshots/admin-dashboard.png)
_Visualize o painel de administração._

---

## 🛠️ Tecnologias Utilizadas

O Tech Care utiliza tecnologias modernas para garantir desempenho, escalabilidade e uma boa experiência de desenvolvimento:

- **Backend**: Laravel 10.x
- **Frontend**:
    - HTML, CSS, JavaScript
    - Bootstrap 5 (design responsivo)
    - FullCalendar 6.1.11 (calendário interativo)
- **Frameworks e Bibliotecas**:
    - Livewire (componentes dinâmicos)
    - SweetAlert2 (notificações e popups)
    - Luxon (manipulação de fusos horários)
- **Base de Dados**: MySQL (gerenciado via migrations do Laravel)
- **Ambiente de Desenvolvimento**: Laragon (recomendado), compatível com XAMPP, WAMP ou Docker

---

## 📂 Estrutura do Projeto

A estrutura do projeto segue o padrão do Laravel, com pastas organizadas para facilitar a manutenção e colaboração:

- `app/`: Controladores, modelos e middlewares.
    - `app/Http/Controllers/AgendamentoController.php`: Lógica de agendamentos.
    - `app/Models/Agendamento.php`, `app/Models/Order.php`: Modelos principais.
- `resources/views/`: Templates Blade.
    - `agendamento/create.blade.php`: Criação de agendamentos.
    - `agendamento/index.blade.php`: Lista de agendamentos com calendário.
- `database/migrations/`: Definições das tabelas (`agendamentos`, `orders`).
- `routes/web.php`: Rotas da aplicação.
- `public/`: Arquivos estáticos (CSS, JS, imagens).
- `screenshots/`: Pasta para armazenar capturas de tela do README.

---

## 🚀 Como Começar

Siga os passos abaixo para configurar o Tech Care em sua máquina local.

### Pré-requisitos

- **Git**: Para clonar e gerenciar o repositório.
- **PHP 8.1 ou superior**: Compatível com Laravel 10.
- **Composer**: Gerenciador de dependências do PHP.
- **Node.js e NPM**: Para compilar assets (opcional).
- **MySQL**: Banco de dados (pode ser configurado via Laragon, XAMPP, WAMP ou Docker).
- **Editor de Código**: VS Code, PhpStorm ou similar.

### Passos para Configuração

1. **Clone o Repositório**

    ```bash
    git clone https://github.com/smpsandro1239/techcare.git
    cd techcare
    ```

2. **Instale as Dependências**

    - Dependências do PHP:

    ```bash
    composer install
    ```

    - (Opcional) Dependências JavaScript:

    ```bash
    npm install && npm run dev
    ```

3. **Configure o Ambiente**

    - Renomeie o arquivo `.env.example` para `.env`:

    ```bash
    cp .env.example .env
    ```

    - Edite o arquivo `.env` com suas configurações:

    ```env
    APP_NAME="Tech Care"
    APP_URL=http://localhost:8000
    APP_TIMEZONE=Europe/Lisbon
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=techcare_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    - Gere a chave do aplicativo:

    ```bash
    php artisan key:generate
    ```

4. **Configure a Base de Dados**

    - Crie um banco de dados MySQL chamado `techcare_db` (ou o nome definido no `.env`).
    - Execute as migrações para criar as tabelas:

    ```bash
    php artisan migrate
    ```

    - (Opcional) Popule o banco com dados de exemplo:

    ```bash
    php artisan db:seed
    ```

5. **Inicie o Servidor**

    - Use o servidor embutido do Laravel:

    ```bash
    php artisan serve
    ```

    - Ou configure um virtual host no Laragon/XAMPP/WAMP.
    - Acesse o projeto em `http://localhost:8000`.

6. **Autenticação Inicial**

    - Registre um novo usuário em `http://localhost:8000/register`.
    - Ou crie um usuário admin via Artisan:

    ```bash
    php artisan tinker
    User::create(['name' => 'Admin', 'email' => 'admin@techcare.com', 'password' => bcrypt('password'), 'role' => 1])
    ```

    - Faça login com as credenciais criadas.

---

## 📖 Como Usar o Tech Care

### 1. Criar um Agendamento

1. Acesse `/agendamento`.
2. Clique em uma data no calendário para abrir o modal de agendamento.
3. Preencha os campos (nome do cliente, horário e serviço) e clique em "Agendar".
4. Um popup de sucesso será exibido, e o evento aparecerá no calendário.

### 2. Visualizar Agendamentos

- Na página inicial (`/agendamento`), o calendário exibe todos os agendamentos.
- Clique em um evento para ver os detalhes (data, horário, cliente e serviço).
- A tabela de agendamentos recentes lista os últimos agendamentos criados.

### 3. Gerenciar Usuários

- Acesse a área de administração (se implementada) para gerenciar usuários e seus papéis (admin, vendor, customer).

---

## 🤝 Como Contribuir

O Tech Care é um projeto open-source, e sua contribuição é muito bem-vinda! Siga as diretrizes abaixo para colaborar.

### Estratégia de Branches

- **Branch Principal**: `main` (versão estável).
- **Branches de Funcionalidades**: `feature/nome-da-funcionalidade` (ex.: `feature/notificacoes-email`).
- **Branches de Correções**: `fix/nome-do-problema` (ex.: `fix/erro-500-modal`).

### Passos para Contribuir

1. **Crie uma Branch**

    ```bash
    git checkout -b feature/nova-funcionalidade
    ```

2. **Faça Commit**

    ```bash
    git add .
    git commit -m "feat: adiciona nova funcionalidade"
    ```

3. **Push**

    ```bash
    git push origin feature/nova-funcionalidade
    ```

4. **Abra um Pull Request**
    - Descreva as mudanças no PR.
    - Peça revisão a pelo menos um colega.
    - Teste localmente antes de submeter.

---

## ⚠️ Problemas Conhecidos

- **Erro 500 no Modal de Agendamento**: Ocorre ao carregar horários disponíveis (em correção).
- **Catálogo Incompleto**: Integração pendente para busca e exibição de produtos.
- **Fuso Horário**: Certifique-se de que `APP_TIMEZONE=Europe/Lisbon` no `.env` e que o MySQL está configurado para o mesmo fuso horário.

---

## 🚀 Contribuições Futuras

- **Integração com Pagamentos**: Suporte a Stripe ou PayPal para pagamentos online.
- **Notificações por E-mail**: Enviar confirmações de agendamento por e-mail.
- **Melhorias Visuais**: Adicionar animações e temas personalizáveis.
- **API REST**: Criar endpoints para integração com aplicativos móveis.

---

## 📜 Guia de Estilo

### PHP

- Siga o padrão PSR-12.
- Use nomes descritivos (ex.: `$scheduledAtUtc` em vez de `$date`).
- Adicione comentários para métodos complexos.

### JavaScript

- Use camelCase para variáveis e funções.
- Adicione comentários para blocos de código complexos.

### Commits

- Formato: `tipo: descrição` (ex.: `feat: adiciona validação de feriados`).
- Tipos comuns: `feat` (nova funcionalidade), `fix` (correção), `docs` (documentação), `style` (formatação).

---

## ❓ FAQ

**1. Por que o calendário não carrega os eventos?**
Verifique se o método `getAgendamentos` está funcionando. Inspecione o console do navegador para erros e confirme se o banco de dados está populado.

**2. Como configurar o fuso horário corretamente?**
No `.env`, defina `APP_TIMEZONE=Europe/Lisbon`. No MySQL, execute:

```sql
SET GLOBAL time_zone = 'Europe/Lisbon';
```

**3. Posso usar outro banco de dados?**
Sim! O Laravel suporta PostgreSQL, SQLite, etc. Atualize o `DB_CONNECTION` no `.env` e ajuste as configurações.

---

## 📬 Contato

### Autor 1

- **Nome**: Sandro Pereira
- **E-mail**: [smpsandro1239@gmail.com](mailto:smpsandro1239@gmail.com)
- **GitHub**: [https://github.com/smpsandro1239](https://github.com/smpsandro1239)
- **LinkedIn**: [https://www.linkedin.com/in/sandro-pereira-1239/](https://www.linkedin.com/in/sandro-pereira-1239/)

### Autor 2

- **Nome**: Santiago Rodriguez
- **E-mail**: [Santiagob3rnal@gmail.com](mailto:Santiagob3rnal@gmail.com)
- **GitHub**: [https://github.com/santiagob3rnal](https://github.com/santiagob3rnal)
- **LinkedIn**: [https://www.linkedin.com/in/santiago-bernal/](https://www.linkedin.com/in/santiago-bernal/)

### Repositório

- **GitHub**: [https://github.com/smpsandro1239/techcare](https://github.com/smpsandro1239/techcare)
- **Issues**: Abra uma issue no GitHub para relatar bugs ou sugerir melhorias.

---

## 📄 Licença

Este projeto está licenciado sob a [Licença MIT](LICENSE). Veja o arquivo `LICENSE` para mais detalhes.

---

## 📸 Instruções para Adicionar e Verificar Imagens

Se as imagens não estão carregando no GitHub, siga estas instruções para corrigir o problema.

### 1. Crie a Pasta `screenshots/`

Na raiz do projeto, crie uma pasta chamada `screenshots/`:

```bash
mkdir screenshots
```

### 2. Adicione as Imagens

Tire capturas de tela das seguintes telas e salve-as na pasta `screenshots/` com os nomes indicados:

- `lista-agendamentos.png`: Página inicial (`/agendamento`) com o calendário e a tabela de agendamentos recentes.
- `modal-agendamento.png`: Modal de agendamento ao clicar em uma data no calendário.
- `popup-feriado.png`: Popup de erro ao tentar agendar em um feriado (ex.: 01/05/2025).
- `detalhes-agendamento.png`: Popup de detalhes ao clicar em um evento no calendário.
- `catalogo-produtos.png`: Página do catálogo (se disponível; caso contrário, use um placeholder).
- `admin-dashboard.png`: Painel de administração (se disponível).
- `banner-techcare.png`: Banner simples com o nome "Tech Care" (crie em ferramentas como Canva ou Figma).

### 3. Faça Commit das Imagens

Adicione as imagens ao repositório:

```bash
git add screenshots/*
git commit -m "docs: adiciona capturas de tela ao README"
git push origin main
```

### 4. Verifique se as Imagens Carregam no GitHub

- Acesse o repositório no GitHub (`https://github.com/smpsandro1239/techcare`).
- Abra o arquivo `README.md` e confirme se as imagens estão sendo exibidas.
- Se as imagens não carregarem, verifique:
    - **Caminho Correto**: O caminho no README deve ser relativo à raiz do repositório (ex.: `screenshots/lista-agendamentos.png`).
    - **Nome do Arquivo**: Certifique-se de que os nomes dos arquivos correspondem exatamente (incluindo maiúsculas/minúsculas, ex.: `Admin-dashboard.png` é diferente de `admin-dashboard.png`).
    - **Imagens no Repositório**: Confirme que as imagens foram enviadas ao repositório (use `git status` para verificar antes do commit).

### 5. Alternativa: Hospede as Imagens Externamente

Se as imagens ainda não carregarem, você pode hospedá-las em um serviço externo (ex.: ImgBB, GitHub Issues) e usar URLs absolutas no README. Exemplo:

```markdown
![Página Inicial - Lista de Agendamentos](https://i.ibb.co/abc123/lista-agendamentos.png)
```

---

## 📚 Referências

- [Laravel](https://laravel.com/docs/9.x/database)
- [FullCalendar](https://fullcalendar.io/)
- [Bootstrap](https://getbootstrap.com/)
- [Font Awesome](https://fontawesome.com/)
- [Materialize](https://materializecss.com/)
- [MySQL](https://www.mysql.com/)
- [PhpMyAdmin](https://www.phpmyadmin.net/)
- [XAMPP](https://www.apachefriends.org/pt_br/index.html)
- [Git](https://git-scm.com/)
- [GitHub](https://github.com/)
- [Visual Studio Code](https://code.visualstudio.com/)
- [IntelliJ IDEA](https://www.jetbrains.com/idea/)
- [Postman](https://www.postman.com/)
- [Laragon](https://laragon.org/)

---

Aproveite o **Tech Care**! 🚀
