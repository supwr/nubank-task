### Build

To build the application, execute under the root of the application:

```$ make build```

### Run

To run the app

```$ make run-app```

You will be prompted by the application to input an operation collection in json format:

![Image](img/run-app.png?raw=true)

```
[{"operation":"buy", "unit-cost":10, "quantity": 100},{"operation":"sell", "unit-cost":15, "quantity": 50},{"operation":"sell", "unit-cost":15, "quantity": 50}]
```

After feeding the application with as many operation collections as you want, you just need to press "ENTER", inputing one empty line. The application should output the taxes, each line for a operation collection inputed.

### Test

To run the tests

```$ make run-tests```

This project has code coverage of 100%

![Image](img/code-coverage.png?raw=true)

### Mutation tests

To run the mutation tests

```$ make run-mutation-tests```

This project uses the library `infection-php` to assess its mutation score

![Image](img/mutation-score.png?raw=true)