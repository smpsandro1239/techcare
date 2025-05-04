Vou ajustar o `README.md` para incluir as três novas imagens fornecidas (lista de agendamentos, perfil do utilizador e catálogo de produtos), além de atualizar o texto para refletir o conteúdo visual dessas capturas de ecrã. Vou manter a estrutura existente, corrigir os erros `MD025` e `MD007` mencionados anteriormente, e garantir que o texto esteja em português de Portugal, com consistência e legibilidade.

---

# Tech Care - Sistema de Agendamento e Administração de Serviços

![Banner do Tech Care](screenshots/banner-techcare.png)
_Sistema de agendamento e administração de serviços técnicos para simplificar a sua rotina._

O **Tech Care** é uma aplicação web moderna e eficiente, desenvolvida para facilitar o agendamento e a administração de serviços técnicos, como a instalação de sistemas operativos, a manutenção de hardware e a configuração de redes. Com uma interface intuitiva e funcionalidades robustas, o Tech Care é ideal para empresas ou profissionais que desejam organizar os seus agendamentos de forma prática e fiável.

Desenvolvido com o _framework_ **Laravel** e integrado com o **FullCalendar**, o Tech Care oferece uma experiência visual atractiva e interactiva, com suporte para múltiplos papéis de utilizador, validação de feriados e notificações dinâmicas. Este projecto é de código aberto (_open-source_) e colaborativo, convidando programadores a contribuir para o seu desenvolvimento.

---

## ✨ Funcionalidades Principais

- Agendamento de Serviços: Interface interactiva com FullCalendar para seleccionar datas e horários, com validação de feriados e horários ocupados.
- Administração de Utilizadores: Suporte para papéis (admin, vendor, customer) com autenticação e autorização via Laravel Breeze.
- Notificações Dinâmicas: Popups com SweetAlert2 para feedback em tempo real (ex.: erro ao agendar num feriado).
- Catálogo de Produtos: Secção para pesquisa e apresentação de produtos, com detalhes como categoria e preço.
- Interface Amigável: Design responsivo com Bootstrap 5 e FullCalendar, optimizado para computadores e dispositivos móveis.

---

## 📸 Demonstração do Sistema

Abaixo estão capturas de ecrã que ilustram as principais funcionalidades do Tech Care. Certifique-se de que as imagens estão na pasta `screenshots/` no repositório.

### 1. Página de Agendamento

A página de agendamento apresenta um calendário interactivo para visualizar e gerir agendamentos, com opções para ver agendamentos existentes e escolher entre vistas mensal, semanal ou diária.

![Página de Agendamento](screenshots/lista-agendamentos.png)
_Veja todos os agendamentos no calendário interactivo e escolha a vista desejada (mensal, semanal ou diária)._

### 2. Perfil do Utilizador

A secção "O Meu Perfil" permite aos utilizadores visualizar e actualizar os seus dados pessoais, incluindo nome, e-mail, número de telemóvel e fotografia de perfil, além de alterar a senha.

![Perfil do Utilizador](screenshots/perfil-utilizador.png)
_Gerencie os seus dados pessoais e actualize a fotografia ou senha no perfil._

### 3. Catálogo de Produtos

O catálogo exibe uma lista de produtos disponíveis, com imagens, nomes, categorias, subcategorias e preços, além de uma opção para ver detalhes e navegar entre páginas.

![Catálogo de Produtos](screenshots/catalogo-produtos.png)
_Explore o catálogo de produtos e veja detalhes como preço e categoria._

### 4. Criação de Agendamento

Clique numa data no calendário para abrir o modal de agendamento, onde pode seleccionar o horário e o serviço.

![Modal de Agendamento](screenshots/modal-agendamento.png)
_Seleccione a data, o horário e o serviço para agendar um atendimento._

### 5. Validação de Feriados

Ao tentar agendar num feriado, é apresentado um popup informativo, explicando o motivo da restrição.

![Popup de Feriado](screenshots/popup-feriado.png)
_Notificação de erro ao tentar agendar num feriado (ex.: Dia do Trabalhador)._

### 6. Detalhes do Agendamento

Clique num evento no calendário para ver os detalhes, incluindo a data, o horário, o cliente e o serviço.

![Popup de Detalhes do Agendamento](screenshots/detalhes-agendamento.png)
_Veja os detalhes de um agendamento existente._

### 7. Painel de Administração

Painel de administração para gerir utilizadores, agendamentos e outras configurações (se implementado).

![Painel de Administração](screenshots/admin-dashboard.png)
_Veja o painel de administração._

---

## 🛠️ Tecnologias Utilizadas

O Tech Care utiliza tecnologias modernas para garantir desempenho, escalabilidade e uma boa experiência de programação:

- **Backend**: Laravel 10.x
- **Frontend**:
    - HTML, CSS, JavaScript
    - Bootstrap 5 (design responsivo)
    - FullCalendar 6.1.11 (calendário interactivo)
- **Frameworks e Bibliotecas**:
    - Livewire (componentes dinâmicos)
    - SweetAlert2 (notificações e popups)
    - Luxon (manipulação de fusos horários)
- **Base de Dados**: MySQL (gerido via migrações do Laravel)
- **Ambiente de Desenvolvimento**: Laragon (recomendado), compatível com XAMPP, WAMP ou Docker

---

## 📂 Estrutura do Projecto

A estrutura do projecto segue o padrão do Laravel, com pastas organizadas para facilitar a manutenção e a colaboração:

- `app/`: Controladores, modelos e _middlewares_.
    - `app/Http/Controllers/AgendamentoController.php`: Lógica de agendamentos.
    - `app/Models/Agendamento.php`, `app/Models/Order.php`: Modelos principais.
- `resources/views/`: Modelos Blade.
    - `agendamento/create.blade.php`: Criação de agendamentos.
    - `agendamento/index.blade.php`: Lista de agendamentos com calendário.
- `database/migrations/`: Definições das tabelas (`agendamentos`, `orders`).
- `routes/web.php`: Rotas da aplicação.
- `public/`: Ficheiros estáticos (CSS, JS, imagens).
- `screenshots/`: Pasta para armazenar capturas de ecrã do README.

---

## 🚀 Como Começar

Siga os passos abaixo para configurar o Tech Care na sua máquina local.

### Pré-requisitos

- Git: Para clonar e gerir o repositório.
- PHP 8.1 ou superior: Compatível com Laravel 10.
- Composer: Gestor de dependências do PHP.
- Node.js e NPM: Para compilar _assets_ (opcional).
- MySQL: Base de dados (pode ser configurada via Laragon, XAMPP, WAMP ou Docker).
- Editor de Código: VS Code, PhpStorm ou similar.

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

    - Renomeie o ficheiro `.env.example` para `.env`:

        ```bash
        cp .env.example .env
        ```

    - Edite o ficheiro `.env` com as suas configurações:

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

    - Gere a chave da aplicação:

        ```bash
        php artisan key:generate
        ```

4. **Configure a Base de Dados**

    - Crie uma base de dados MySQL chamada `techcare_db` (ou o nome definido no `.env`).
    - Execute as migrações para criar as tabelas:

        ```bash
        php artisan migrate
        ```

    - (Opcional) Preencha a base de dados com dados de exemplo:

        ```bash
        php artisan db:seed
        ```

5. **Inicie o Servidor**

    - Use o servidor embutido do Laravel:

        ```bash
        php artisan serve
        ```

    - Ou configure um _virtual host_ no Laragon/XAMPP/WAMP.
    - Acesse o projecto em `http://localhost:8000`.

6. **Autenticação Inicial**

    - Registe um novo utilizador em `http://localhost:8000/register`.
    - Ou crie um utilizador admin via Artisan:

        ```bash
        php artisan tinker
        User::create(['name' => 'Admin', 'email' => 'admin@techcare.com', 'password' => bcrypt('password'), 'role' => 1])
        ```

    - Faça login com as credenciais criadas.

---

## 📖 Como Utilizar o Tech Care

### 1. Criar um Agendamento

1. Acesse `/agendamento`.
2. Clique numa data no calendário para abrir o modal de agendamento.
3. Preencha os campos (nome do cliente, horário e serviço) e clique em "Agendar".
4. Um popup de sucesso será apresentado, e o evento aparecerá no calendário.

### 2. Ver Agendamentos

- Na página inicial (`/agendamento`), o calendário apresenta todos os agendamentos.
- Clique num evento para ver os detalhes (data, horário, cliente e serviço).
- A tabela de agendamentos recentes lista os últimos agendamentos criados.

### 3. Gerir Utilizadores

- Acesse a área "O Meu Perfil" para actualizar os seus dados pessoais ou senha.
- A área de administração (se implementada) permite gerir utilizadores e os seus papéis (admin, vendor, customer).

### 4. Explorar o Catálogo

- Acesse o catálogo para pesquisar produtos por nome, categoria ou subcategoria.
- Clique em "Ver Detalhes" para mais informações sobre um produto específico.

---

## 🤝 Como Contribuir

O Tech Care é um projecto de código aberto, e a sua contribuição é muito bem-vinda! Siga as directrizes abaixo para colaborar.

### Estratégia de _Branches_

- _Branch_ Principal: `main` (versão estável).
- _Branches_ de Funcionalidades: `feature/nome-da-funcionalidade` (ex.: `feature/notificacoes-email`).
- _Branches_ de Correcções: `fix/nome-do-problema` (ex.: `fix/erro-500-modal`).

### Passos para Contribuir

1. **Crie uma _Branch_**

    ```bash
    git checkout -b feature/nova-funcionalidade
    ```

2. **Faça _Commit_**

    ```bash
    git add .
    git commit -m "feat: adiciona nova funcionalidade"
    ```

3. **Push**

    ```bash
    git push origin feature/nova-funcionalidade
    ```

4. **Abra um Pull Request**

    - Descreva as alterações no PR.
    - Peça revisão a pelo menos um colega.
    - Teste localmente antes de submeter.

---

## ⚠️ Problemas Conhecidos

- Erro 500 no Modal de Agendamento: Ocorre ao carregar horários disponíveis (em correcção).
- Catálogo Incompleto: Integração pendente para pesquisa e apresentação de produtos.
- Fuso Horário: Certifique-se de que `APP_TIMEZONE=Europe/Lisbon` no `.env` e que o MySQL está configurado para o mesmo fuso horário.

---

## 🚀 Contribuições Futuras

- Integração com Pagamentos: Suporte a Stripe ou PayPal para pagamentos online.
- Notificações por E-mail: Enviar confirmações de agendamento por e-mail.
- Melhorias Visuais: Adicionar animações e temas personalizáveis.
- API REST: Criar _endpoints_ para integração com aplicações móveis.

---

## 📜 Guia de Estilo

### PHP

- Siga o padrão PSR-12.
- Use nomes descritivos (ex.: `$scheduledAtUtc` em vez de `$date`).
- Adicione comentários para métodos complexos.

### JavaScript

- Use camelCase para variáveis e funções.
- Adicione comentários para blocos de código complexos.

### _Commits_

- Formato: `tipo: descrição` (ex.: `feat: adiciona validação de feriados`).
- Tipos comuns: `feat` (nova funcionalidade), `fix` (correcção), `docs` (documentação), `style` (formatação).

---

## ❓ Perguntas Frequentes

**1. Por que o calendário não carrega os eventos?**
Verifique se o método `getAgendamentos` está a funcionar. Inspecione o console do navegador para erros e confirme se a base de dados está preenchida.

**2. Como configurar o fuso horário correctamente?**
No `.env`, defina `APP_TIMEZONE=Europe/Lisbon`. No MySQL, execute:

```sql
SET GLOBAL time_zone = 'Europe/Lisbon';
```

**3. Posso usar outra base de dados?**
Sim! O Laravel suporta PostgreSQL, SQLite, entre outros. Actualize o `DB_CONNECTION` no `.env` e ajuste as configurações.

---

## 📬 Contacto

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
- **Issues**: Abra uma _issue_ no GitHub para relatar erros ou sugerir melhorias.

---

## 📄 Licença

Este projecto está licenciado sob a [Licença MIT](LICENSE). Veja o ficheiro `LICENSE` para mais detalhes.

---

## 📸 Instruções para Adicionar e Verificar Imagens

Se as imagens não estão a carregar no GitHub, siga estas instruções para corrigir o problema.

### 1. Crie a Pasta `screenshots/`

Na raiz do projecto, crie uma pasta chamada `screenshots/`:

```bash
mkdir screenshots
```

### 2. Adicione as Imagens

Tire capturas de ecrã das seguintes telas e guarde-as na pasta `screenshots/` com os nomes indicados:

- `lista-agendamentos.png`: Página de agendamento com o calendário interactivo.
- `perfil-utilizador.png`: Secção "O Meu Perfil" para gerir dados pessoais.
- `catalogo-produtos.png`: Página do catálogo com lista de produtos.
- `modal-agendamento.png`: Modal de agendamento ao clicar numa data no calendário.
- `popup-feriado.png`: Popup de erro ao tentar agendar num feriado.
- `detalhes-agendamento.png`: Popup de detalhes ao clicar num evento no calendário.
- `admin-dashboard.png`: Painel de administração.
- `banner-techcare.png`: _Banner_ simples com o nome "Tech Care".

### 3. Faça _Commit_ das Imagens

Adicione as imagens ao repositório:

```bash
git add screenshots/*
git commit -m "docs: adiciona capturas de ecrã ao README"
git push origin main
```

### 4. Verifique se as Imagens Carregam no GitHub

- Acesse o repositório no GitHub (`https://github.com/smpsandro1239/techcare`).
- Abra o ficheiro `README.md` e confirme se as imagens estão a ser apresentadas.
- Se as imagens não carregarem, verifique:
    - **Caminho Correcto**: O caminho no README deve ser relativo à raiz do repositório (ex.: `screenshots/lista-agendamentos.png`).
    - **Nome do Ficheiro**: Certifique-se de que os nomes dos ficheiros correspondem exactamente.
    - **Imagens no Repositório**: Confirme que as imagens foram enviadas.

### 5. Alternativa: Aloje as Imagens Externamente

Se as imagens ainda não carregarem, aloje-as num serviço externo (ex.: ImgBB) e use URLs absolutas no README.

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
