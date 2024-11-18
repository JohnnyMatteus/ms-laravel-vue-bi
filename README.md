# Dashboard de Análise de Dados 

## Visão Geral

Este projeto consiste em um painel de análise de dados. Ele foi implementado utilizando **Clean Architecture**, princípios **SOLID** e tecnologias modernas para garantir escalabilidade, manutenibilidade e eficiência.

A aplicação oferece:
- Gráficos dinâmicos com filtros avançados, paginação e detalhamento;
- Controle de autenticação e segurança;
- Configuração simplificada e automatizada por meio de Docker.

---

## Tecnologias Utilizadas

### **Frontend**
- **Vue.js 3:** Framework progressivo para construção de interfaces interativas;
- **TailwindCSS:** Biblioteca de utilitários CSS;
- **Chart.js:** Biblioteca para renderização de gráficos;
- **Vue Router:** Gerenciamento de rotas no frontend;
- **Pinia:** Gerenciamento de estado global;
- **Axios:** Consumo de APIs.

### **Backend**
- **Laravel 11:** Framework PHP robusto e escalável;
- **MySQL:** Banco de dados relacional;
- **Laravel Sanctum:** Gerenciamento de autenticação baseada em tokens;
- **Redis:** Cache para otimização de consultas;
- **Docker:** Gerenciamento de containers para configuração do ambiente.

---

## Organização do Projeto

### Estrutura de Pastas

O projeto segue os padrões da **Clean Architecture**, organizando as responsabilidades em camadas distintas para facilitar a manutenção e evolução:

```plaintext
app/
├── Core/
│   ├── Domain/           # Lógica de negócio central
│   │   ├── Entities/     # Entidades do sistema
│   │   ├── Exceptions/   # Exceções de domínio
│   │   ├── Repositories/ # Interfaces para acesso a dados
│   │   ├── Services/     # Regras de negócios
│   │   └── UseCases/     # Casos de uso isolados
│   ├── DTOs/             # Objetos de transferência de dados
│   │   └── Auth/         # DTOs relacionados à autenticação
│   │       ├── DashboardDataDTO.php
│   │       └── ErrorResponse.php
│   └── Infrastructure/   # Implementações específicas do framework
│       ├── Framework/
│       │   └── Laravel/
│       │       ├── Controllers/  # Controladores HTTP
│       │       ├── Exceptions/   # Exceções específicas
│       │       ├── Middleware/   # Middlewares personalizados
│       │       ├── Providers/    # Provedores de serviços
│       │       └── Requests/     # Validações de entrada
│       ├── Repositories/         # Implementações de Repositórios
│       └── Services/             # Serviços de integração
```

---

## Instalação e Execução

### Pré-requisitos

- **Docker** (incluindo Docker Compose).

### Passos para Configuração

1. **Apos realizar downalod do projeto acesse a pasta do projeto**:
   ```bash
   cd ms-laravel-vue-bi
   ```

2. **Inicie o ambiente com Docker**:
   ```bash
   docker-compose up --build
   ```

3. **Acesse a aplicação**:
    - Frontend: [http://localhost:8000](http://localhost:8000)
    - API: [http://localhost:8000/api](http://localhost:8000/api)

4. **Dados para Login**:
    - **Email:** `test@example.com`
    - **Senha:** `password`

---

## Testes Automatizados

### Cobertura de Testes

Os testes foram implementados para cobrir as principais funcionalidades da aplicação, garantindo qualidade e confiabilidade do código.

#### Testes Unitários
- **UseCases\LoginUseCaseTest**:
    - **login success:** Garante que usuários com credenciais válidas possam se autenticar.
    - **invalid credentials:** Valida que o sistema bloqueia credenciais incorretas.
    - **user not found:** Testa que um usuário inexistente não pode acessar.

- **UseCases\RegisterUseCaseTest**:
    - **user registration success:** Testa o registro de usuários válidos.
    - **email already in use:** Impede registros duplicados com o mesmo e-mail.

#### Testes de Integração (Feature Tests)
- **DashboardTest**:
    - **dashboard returns correct data:** Valida o retorno correto dos dados do dashboard.
    - **dashboard filters:** Testa filtros por tipo de investimento e intervalo de datas.
    - **details endpoint:** Verifica os dados retornados no detalhamento.

- **LoginApiTest e RegisterApiTest**:
    - **login success:** Testa autenticação via API com sucesso.
    - **register validation fails:** Valida erros durante tentativas de registro.

### Execução dos Testes

Para rodar os testes automatizados:
1. **Entre no container do Laravel**:
   ```bash
   docker exec -it app bash
   ```

2. **Execute o comando de testes**:
   ```bash
   php artisan test
   ```

### Resultados dos Testes
- **Total de Testes:** 19
- **Total de Assertivas:** 8045
- **Duração Total:** 83.99s

Os testes garantem a funcionalidade das principais features, como login, filtros e validação de dados.

