Installation
============

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require artox-lab/clarc-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require artox-lab/clarc-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    ArtoxLab\Bundle\ClarcBundle\ArtoxLabClarcBundle::class => ['all' => true],
];
```

### Step 3: Configuration

Configure bundle

```yaml
# config/packages/artox_lab_clarc.yaml

artox_lab_clarc:
    api:
        serializer:
            class: \ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Transformers\Serializers\NullObjectArraySerializer
```

Configure uuid generator

```yaml
# config/packages/doctrine_uuid.yaml

doctrine:
    dbal:
        types:
            uuid: Ramsey\Uuid\Doctrine\UuidType
```

```xml
<!-- src/Interfaces/Resources/config/doctrine/app/Test.Test.orm.xml -->

<id name="uuid" column="uuid" type="uuid">
    <generator strategy="CUSTOM" />
    <custom-id-generator class="ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Gateways\DoctrineUuidGenerator" />
</id>
```



