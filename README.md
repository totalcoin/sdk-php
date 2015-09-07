#Métodos

1. get_access_token: Retorna este atributo:

```
TokenId: "asg8agsc8at6s7216t121"
```

2. perform_checkout: Recibe un Array con estos atributos:

```
"Amount" : 10,
"Quantity" : 1,
"Country" : "ARG",
"Currency" : "ARS",
"Description" : "Zapatillas",
"PaymentMethods" : "CREDITCARD|CASH|TOTALCOIN",
"Reference" : "1-04557898",
"Site": "My Site",
"MerchantId": "abcde-abcde-abcde-abcde"
```

Retorna un Array con estos atributos:
```
Message: "",
IsOk: true o false,
Response : [ URL: "https://..." ]
```
3. get_merchants:

Retorna un Array con estos atributos:
```
Message: "",
IsOk: true o false,
Response : [[ Id: "", Name: "" ], [ Id: "", Name: "" ]]
```
4. get_ipn_info:
Recibe como parámetro el id de referencia

```
$reference_id
```
Retorna un Array con estos atributos:
```
Message: "",
IsOk: true o false,
Response : [
  "Reference":"",
  "MerchantReference":"",
  "TransactionType":"Sale",
  "Reason":"",
  "Currency":"ARS",
  "PaidAmount":0.00,
  "NetAmount":0.00,
  "FinancingCost":0.00,
  "TotalAmount":0.00,
  "TransactionHistories":[
     [
        "Date":"2015-07-22T18:08:12.503",
        "TransactionState":"InProccess"
     ]
  ],
  "Merchant":[
     "Id":"",
     "Name":"Comercio Predefinido"
  ],
  "FromUser":[
     "Phone":"",
     "FullName":"",
     "Email":""
  ],
  "ToUser":[
     "Phone":"",
     "FullName":"",
     "Email":""
  ],
  "Provider":[
     "Name":"TOTAL COIN",
     "PaymentMethod":"TotalCoin"
  ]
]
```

#Ejemplos de uso

Dado que esto es un modulo de Composer, se debe instalar con este comando:

```
composer install
```

1. Creación del objeto API:

```
require_once __DIR__ . '/vendor/autoload.php';

use TotalCoin\Api;
use TotalCoin\Client;

$api = new Api("email@domain.com", "aisb8as7sd7aasda7sd");
```

2. Checkout:

```
$data = Array();
$data['Amount'] = 100;
$data['Quantity'] = 1;
$data['Country'] = "ARG";
$data['Currency'] = "ARS";
$data['Description'] = "Zapatillas adidas";
$data['PaymentMethods'] = "CREDITCARD|CASH|TOTALCOIN";
$data['Reference'] = "004557898";
$data['Site'] = "WordPress";
$data['MerchantId'] = "123-132-123-123";

$results = $api->perform_checkout($data);

echo $results['Response']['URL'];
```

En test/TotalCoinTest.php se encuentran mas ejemplos de estos servicios.

#Como correr los Tests

Dentro de la suite se encuentran los tests de los métodos mencionados anteriormente.

1. Configuración

En el archivo phpunit.xml se deben configurar con los valores correspondientes, las variables:

- PHPUNIT_TESTSUITE_EMAIL_LOGIN
- PHPUNIT_TESTSUITE_APIKEY

2. Luego se debe instalar las dependencias via composer para poder ejecutar la Suite

```
composer install
vendor/bin/phpunit --verbose --testsuite "TotalCoin PHP SDK Test Suite"

```
