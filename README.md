# e-php
A Faster Lightweight Full-Stack PHP Framework.

<p align="center"> <a href="./README-CN.md">中文版</a>　<p>


### Features
- Basic：
    - Entry file, Load config file, autoload, Register error(and exception) function, Router, 
    - Request, Response, mvc, orm, View, 
    - ioc, 
    - Swoole mode
- Tools：
    - git hook configuration, travis, phpunit,
- Todos：
    - command line tool
    - docker
    - Vue integrations
### Dependencies
- [SeasLog](https://github.com/SeasX/SeasLog)
###  Project Directory Structure
```
app
    ├─ api                 [api module]
        ├─ controller
        ├─ model
    ├─ demo                [default module]
        ├─ controller
        ├─ model
config                     [config dir]
    ├─ common.php          [public configs]
    ├─ swoole.php          [swoole]
    └─ nosql.php           [nosql]
docs                       [api doc]
framework                  [framework dir]
    └─ APP.php             
    └─ Container.php       [Ioc]
    └─ ErrorHandle.php     
    └─ Log.php             
    └─ Request.php         
    └─ Response.php        
    └─ Router.php          
    └─ run.php             
    └─ View.php            
public                     
    ├─ dist                
    └─ ...
    └─ index.html          
├─ index.php               
├─ server.php              
runtime                    
    ├─ logs                
    ├─ build               
tests                      
    ├─ demo                
        └─ DemoTest.php    
    ├─ TestCase.php        
vendor                     
view
.git-hooks                 
    ├─ pre-commit          
    ├─ commit-msg          
.gitignore                 
.travis.yml                
LICENSE                    
logo.png                   
composer.json              
composer.lock              
package.json               
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