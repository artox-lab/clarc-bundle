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
    security:
        rbac:
            permissions:
                ROLE_MAINTAINER:
                    - show
```
## Security

### How to setup ```get authenticated user permissions``` API endpoint

1. Add to your project routes file `config/routes.yaml`

```yaml
artox_lab_clarc_bundle_user_permissions:
    path: /v1/user/permissions
    controller: ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Controllers\PermissionController::permissions
    methods: GET
```

2. Setup firewall and access control in `config/packages/security.yaml`

```yaml
security:
    firewalls:
      users:
          pattern: ^/v1
          ...
    access_control:
        - { path: ^/v1/, roles: IS_AUTHENTICATED_FULLY }
```

> Note: If you have more than one authenticator - do the setup for each one

### How to use RBAC

1. Setup roles and permissions in config `config/packages/artox_lab_clarc.yaml`
2. Require `ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security\AuthorizationChecker` in your use case / controller
3. Check user permission ```$this->authorizationChecker->isGranted('permission_name')```


## Navigation

1. Setup config

```yaml
# config/packages/artox_lab_clarc.yaml

artox_lab_clarc:
    navigation:
        left_menu:
            show_orphaned_root: false
            items:
                -   icon: portfolio
                    title: Управление компаниями
                    children:
                        -   icon: something
                            link: /companies
                            title: Компании
                            permissions: company.list
                        -   link: /companies/add
                            title: Добавить компанию
                            permissions: [company.create]
```

2. Add routes

```yaml
# config/routes.yaml

artox_lab_admin_user_navigations:
    path: /user/navigations
    controller: ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Controllers\NavigationController::userNavigation
    methods: GET
```

3. Secure routes

```yaml
# config/packages/security.yaml

security:
    firewalls:
        main:
            pattern: ^/user
            ...
    access_control:
        - { path: ^/user, roles: IS_AUTHENTICATED_FULLY}
```

4. Call API  `GET /user/navigations` with authentication
