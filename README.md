### Build

To build the application, execute under the root of the application:

```$ make build-app```

### Run

To run the app

```$ make run-app```

You will be prompted by the application to input an operation collection in json format:

![Image](run-app.png?raw=true)

```
[{"operation":"buy", "unit-cost":10, "quantity": 100},{"operation":"sell", "unit-cost":15, "quantity": 50},{"operation":"sell", "unit-cost":15, "quantity": 50}]
```

After feeding the application with as many operation collections as you want, you just need to press "ENTER", inputing one empty line. The application should output the taxes, each line for a operation collection inputed.

### Test

To run the tests

```$ make test-app```