# e-php
A Faster Lightweight Full-Stack PHP Framework

<p align="center"> <a href="./README-CN.md">中文版</a>　<p>

General process as follows:
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

### Features
- Finished：

Entry file, Load config file, autoload, Register error(and exception) function, 
Router, Request, Response, Json, View.

- Later：
    - Accessibility: 
file uploader, nosql, logger, message queue.
form assistant, CURD scaffolding.
API document, unit test, command line.
git hook configuration, ignore files.
    - framework design: ioc

###  Project Directory Structure
```
app
    ├─ api                 [api module]
        ├─ controller
        ├─ model
    ├─ framework           [default module]
        ├─ controller
        ├─ model
config                     [config dir]
    ├─ common.php          [public configs]
    ├─ swoole.php          [swoole]
    └─ nosql.php           [nosql]
docs                       [api doc]
framework                  [framework dir]
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