### Build

Para funcionamento da aplicação, é necessário a execução do `build`, antes de qualquer coisa. Durante o build o container será criado e todos os pacotes necessários serão instalados.

Para buildar a aplicação, execute na raiz do projeto:

```$ make build```

### Execução

Para executar a aplicação

```$ make run-app```

A aplicação espera como input uma coleção de operações, no formato json:

![Image](img/run-app.png?raw=true)

![Image](img/run-app.gif?raw=true)

```
[{"operation":"buy", "unit-cost":10, "quantity": 100},{"operation":"sell", "unit-cost":15, "quantity": 50},{"operation":"sell", "unit-cost":15, "quantity": 50}]
```
Após inserir na aplicação quantas coleções de operações for desejado, basta pressionar "ENTER", inserindo uma linha em branco pra indicar que a fase de inserção de dados foi finalizada. A aplicação deverá retornar as taxas calculadas, cada linha para uma coleção de operações inserida.


### Teste

Para executar os testes

```$ make run-tests```

Este projeto de cobertura de testes de 100% =)

![Image](img/code-coverage.png?raw=true)

### Testes de mutação

Para executar os testes de mutação

```$ make run-mutation-tests```

Este projeto usa o pacote `infection-php` para avaliar o MSI(Mutation Score Indicator)

![Image](img/mutation-score.png?raw=true)

### Considereções finais

Foi decidido criar um sistema separado em camadas de aplicação, domínio e infraestrutura, para melhor manutenção, extensibilidade e consumo por diferentes meios. Com o uso de injeção de dependências e interfaces, a substituição de componentes ficou extremamente possibilitada.

Visando garantir a efetividade dos testes, foi buscado não apenas a cobertura de 100%, mas também a implementação de testes de mutação no código.

Para garantia de tipos foram utilizados Value Objects e DTOs. Foram criados validadores, tanto para atestar que o input é um json valido, quanto para garantir o json tem o formato esperado para o funcionamento da aplicação.

