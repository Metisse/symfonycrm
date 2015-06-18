# Symfony CRM Application  
  
Welcome to the Symfony CRM - a simple CRM using Symfony2 Framework.  
  
## Requirements  
  
This repository includes the source code of the application and the development environment based in Vagrant.  
  
It uses VirtualBox as provider and Ansible as provisioner.  
  
- [Vagrant](https://www.vagrantup.com/ "Vagrant")  
- [VirtualBox](https://www.virtualbox.org/ "VirtualBox")  
- [Ansible](http://www.ansible.com/home "Ansible"). If you don't have it installed in your host machine it will install and execute it automatically in the virtual server.  
  
## How to launch the server for development  
  
1. To launch it you just need to execute:  
  
    $ vagrant up  
  
2. For see the SymfonyCRM in your web browser, add this line in your C:\Windows\System32\drivers\etc\hosts (for Windows users) or /etc/hosts (for Linux users) file:  
  
    192.168.56.182	symfonycrm.com.dev  
  
3. You need to execute "composer" to obtain an executable project. Just do:  
  
    $ cd /var/www/workspace/symfonycrm/  
  
    $ composer install  
  
4. Create database  
  
	$ php app/console doctrine:schema:create

5. Add some dummy data

	$ mysql -uroot symfonycrm < fixtures/dummy-data.sql
  
Just go to the address in your browser: [http://symfonycrm.com.dev/](http://symfonycrm.com.dev/ "Symfony CRM")

  * LOGIN: admin
  * PASSWORD: admin
  
## What's inside?  
  
The Symfony CRM is configured with the following defaults:  
  
  * Twig as the only configured template engine
  
  * Doctrine ORM/DBAL
  
  * Swiftmailer
  
The following bundles:
  
  * **FrameworkBundle** - The core Symfony framework bundle  
  
  * [**SensioFrameworkExtraBundle**][1] - Adds several enhancements, including  
    template and routing annotation capability  
  
  * [**DoctrineBundle**][2] - Adds support for the Doctrine ORM  
  
  * [**TwigBundle**][3] - Adds support for the Twig templating engine  
  
  * [**SecurityBundle**][4] - Adds security by integrating Symfony's security  
    component  
  
  * [**SwiftmailerBundle**][5] - Adds support for Swiftmailer, a library for  
    sending emails  
  
  * [**MonologBundle**][6] - Adds support for Monolog, a logging library  
  
  * [**AsseticBundle**][7] - Adds support for Assetic, an asset processing  
    library

  * [**KnpSnappyBundle**][9] HTML to PDF converter
  
  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and  
    the web debug toolbar  
  
  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for  
    configuring and working with Symfony distributions  
  
  * [**SensioGeneratorBundle**][8] (in dev/test env) - Adds code generation
    capabilities

And requieres the next libraries:

  * [**wkhtmltox**][10] wkhtmltopdf and wkhtmltoimage are
    open source (LGPLv3) command line tools to render HTML into PDF and various
    image formats using the QT Webkit rendering engine.

[1]:  http://symfony.com/doc/2.6/bundles/SensioFrameworkExtraBundle/index.html
[2]:  http://symfony.com/doc/master/bundles/DoctrineBundle/index.html
[3]:  http://symfony.com/doc/2.6/book/templating.html
[4]:  http://symfony.com/doc/2.6/book/security.html
[5]: http://symfony.com/doc/2.6/cookbook/email.html
[6]: http://symfony.com/doc/2.6/cookbook/logging/monolog.html
[7]: http://symfony.com/doc/2.6/cookbook/assetic/asset_management.html
[8]: http://symfony.com/doc/2.6/bundles/SensioGeneratorBundle/index.html
[9]: https://github.com/KnpLabs/KnpSnappyBundle
[10]: http://wkhtmltopdf.org/