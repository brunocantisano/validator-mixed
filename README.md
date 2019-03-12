# Laravel 5 - Validações em Português

Esta é uma biblioteca com validações brasileiras:
PIS,PASEP,celular,celular_com_ddd,cnh,cnpj,cpf,cpf_cnpj,nis,data,formato_cnpj,formato_cpf,formato_cpf_cnpj,formato_nis,telefone,telefone_com_ddd,formato_cep,formato_placa_de_veiculo,titulo_eleitor

[![Build Status](https://travis-ci.org/brunocantisano/validator-mixed.svg?branch=master)](https://travis-ci.org/brunocantisano/validator-mixed)

## Instalação

Navegue até a pasta do seu projeto, por exemplo:

```
cd /etc/www/projeto
```

E então execute:

```
composer require brunocantisano\validator-mixed:1.0.* --no-scripts
```

Ou então adicione no arquivo `composer.json`, adicione no seu `"require":`, exemplo:

```json
{
    "require": {
        "brunocantisano/validator-mixed": "1.0.*"
    }
}
```

Rode o comando `composer update --no-scripts`.

Após a instalação, adicione no arquivo `config/app.php` a seguinte linha:

```php

brunocantisano\validator-mixed\ValidatorProvider::class

```

Agora, para utilizar a validação, basta fazer o procedimento padrão do `Laravel`.

A diferença é que será possível usar os seguintes métodos de validação:

* **`celular`** - Valida se o campo está no formato (**`99999-9999`** ou **`9999-9999`**)

*  **`celular_com_ddd`** - Valida se o campo está no formato (**`(99)99999-9999`** ou **`(99)9999-9999`** ou **`(99) 99999-9999`** ou **`(99) 9999-9999`**)

* **`cnpj`** - Valida se o campo é um CNPJ válido. É possível gerar um CNPJ válido para seus testes utilizando o site [geradorcnpj.com](http://www.geradorcnpj.com/)

* **`cpf`** - Valida se o campo é um CPF válido. É possível gerar um CPF válido para seus testes utilizando o site [geradordecpf.org](http://geradordecpf.org) 

* **cpf_cnpj** - Verifica se é um CPF ou CNPJ valido. Para testar, basta utilizar um dos sites acima (quando salvos no mesmo atributo)
* **nis** - Verifica se o PIS/PASEP/NIT/NIS é valido. Para testar, basta utilizar o site https://www.4devs.com.br/gerador_de_pis_pasep

* **titulo_eleitor** - Verifica se um Título de Eleitor é valido. Para testar, basta utilizar o site http://4devs.com.br/gerador_de_titulo_de_eleitor

* **`data`** - Valida se o campo é uma data no formato `DD/MM/YYYY`<sup>*</sup>. Por exemplo: `31/12/1969`.

* **`formato_cnpj`** - Valida se o campo tem uma máscara de CNPJ correta (**`99.999.999/9999-99`**).

* **`formato_cpf`** - Valida se o campo tem uma máscara de CPF correta (**`999.999.999-99`**).

* **formato_cpf_cnpj** - Verifica se a mascara do CPF ou CNPJ é válida. ( 999.999.999-99 ) ou ( 99.999.999/9999-99 )
* **formato_nis** - Verifica se a mascara do PIS/PASEP/NIT/NIS é válida. ( 999.99999-99.9 )

* **`formato_cep`** - Valida se o campo tem uma máscara de correta (**`99999-999`** ou **`99.999-999`**).

* **`telefone`** - Valida se o campo tem umas máscara de telefone (**`9999-9999`**).

* **`telefone_com_ddd`** - Valida se o campo tem umas máscara de telefone com DDD (**`(99)9999-9999`** ou **`(99) 9999-9999`**).

* **`formato_placa_de_veiculo`** - Valida se o campo tem o formato válido de uma placa de veículo.

### Testando

Com isso, é possível fazer um teste simples


```php
$validator = Validator::make(
    ['telefone' => '(77)9999-3333'],
    ['telefone' => 'required|telefone_com_ddd']
);

dd($validator->fails());

```

No exemplo abaixo, fazemos um teste onde validamos a formatação e a validade de um CPF ou CNPJ, para os casos onde a informação deva ser salva em um mesmo atributo:

```php
$this->validate($request, [
          'cpf_or_cnpj' => 'formato_cpf_cnpj|cpf_cnpj',
      ]);
```

### Customizando as mensagens

Todas as validações citadas acima já contam mensagens padrões de validação, porém, é possível alterar isto usando o terceiro parâmetro de `Validator::make`. Este parâmetro deve ser um array onde os índices sejam os nomes das validações e os valores devem ser as respectivas mensagens.

Por exemplo:


```php
Validator::make($valor, $regras, ['celular_com_ddd' => 'O campo :attribute não é um celular'])
```

