# Flunt PHP implementation of Domain Notification Pattern

PHP implementation of Domain Notification Pattern based in [Flunt](https://github.com/andrebaltieri/flunt) (.NET) developed by @andrebaltieri

### Flunt
Flunt is a fluent way to use Notification Pattern with your entities, concentrating every change you made and easy accessing it when you need.

check our [Wiki](https://github.com/andrebaltieri/Flunt/wiki) for more details and samples of how to use Flunt in your applications.

### Dependencies

| Package | Version |
|---------|---------|
| `PHP`   | `>=8.1` |



### Instalation
This package is available through Packagist

**Composer**
```
composer require bloise/flunt
```

## How to use
```php
final class CPF extends Notifiable
{
  ...
}

$cpf = new CPF('012.345.678-90');
$cpf->addNotification("CPF", "Invalid document");

if($cpf->isValid())
  ...
```
## Specified contract
```php

final class CPF extends Notifiable
{
    private readonly string $document;

    public function __construct(string $document)
    {
        $this->setDocument($document);
        $this->addNotifications(
            (new CPFContract)
                ->hasMinLen($this->document, 'CPF', 'Invalid length')
                ->validFormat($this->document, 'CPF', 'Invalid format')
                ->validDocument($this->document, 'CPF', 'Invalid document')
        );
    }
}

final class CPFContract extends Contract
{
    public function hasMinLen(string $cpf, string $property, string $message): self {
        if (strlen($cpf) != 11) {
            $this->notifications[$property][] = $message;
        }
    }

    public function validFormat(string $cpf, string $property, string $message): self {...}

    public function validDocument(string $cpf, string $property, string $message): self {...}
}

```
## Fluent Methods
```php
$cpf->isValid();
$cpf->getMessages();
$cpf->filterByMessage('Invalid length');
```
### Designed for modern architectures approaches
If you are building an application with clean architecture approaches you can consider use this project, cause it's totally free of external dependencies, feel free to implement a Port/Adapter linking the dependencie with your code base, this one is for those who are more conceptual =)
