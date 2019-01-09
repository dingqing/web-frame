# e-php
A Faster Lightweight Full-Stack PHP Framework

<p align="center"> <a href="./README-CN.md">中文版</a>　<p>

> If it's helpful for you, welcome to "Star" to support, Thanks!
  
> You can also "follow", the project will be continuously updated and continuously improved.
  
> If you have questions or good suggestions, you can mention them in `Issues`.

### Features
- Basic：
    - Entry file, Load config file, autoload, Register error and exception functions, Router, 
    - Request, Response, MVC, ORM, View, 
    - Ioc, 
    - Swoole mode
- Tools：
    - Git hook configuration, Travis, apiDoc,
- Todos：
    - PHPUnit, command line tool
    - Docker
    - Vue integrations
### Dependencies
- [SeasLog](https://github.com/SeasX/SeasLog)
###  Project Directory Structure
```
.git-hooks               
    └─ pre-commit         
    └─ commit-msg        
app                      [application dir]
    ├─ api               [api module]
        ├─ controller
        ├─ model
    ├─ demo              [default module]
        ├─ controller
        ├─ model
config                   [config dir]
    ├─ common.php          
docs                     [api doc]
framework                [framework dir]
    ├─ exceptions
    ├─ handles           
        └─ ConfigHandle.php  [framework configs]
        └─ EnvHandle.php     [business configs]
        └─ ErrorHandle.php   [error and exceptions handle、异常处理]
        └─ Handle.php        [Handle interface]
        └─ Log.php           
        └─ Nosql.php         
        └─ Router.php
    ├─ storage           [nosql、mq handles dir]
    └─ App.php           [framework class]
    └─ Container.php     [Ioc container]
    └─ Load.php          [autoloader]
    └─ Request.php       
    └─ Response.php      
    └─ run.php           [fpm application start file]
    └─ swoole.php        [swoole application start file]
    └─ View.php          [view class]
public                   
    └─ index.php             [fpm application entry]
    └─ server.php            [swoole application entry]
runtime                  
    ├─ logs                  
    ├─ build                 [phar files dir]
tests                    [phpunit dir]
    ├─ demo                  [module dir]
        └─ DemoTest.php         
    ├─ TestCase.php          
vendor                   [composer dir]
view
.env.example             [business configs example]  
.gitignore                 
.travis.yml              [travis-ci config]
composer.json            [composer config]
composer.lock              
phpunit.xml              [PHPUnit config]
README-CN.md               
README.md              
 ```

## Develop
### Framework design
- For a PHP framework. General process as follows:
    ```
    Entry file ----> Register autoload function
               ----> Register error(and exception) function
               ----> Load config file
               ----> Request
               ----> Router
               ----> (Controller <----> Model)
               ----> Response
               ----> Json
               ----> View
    ```

## Modules Description:
...

## How to use ?
Run：
> composer require dingqing/e-php

**Web Server Mode:**

## Quick Start:
```

```
**Cli Mode:**
**Swoole Mode:**

## Docker env
## Performance with php-fpm
## Performance with Swoole
## Question&Contribution