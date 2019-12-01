<p align="center"><img width="50%" src="./logo.png"><p>
造轮子系列，实现一个PHP轻量、全栈开发框架。
_DIY is so funny!_
<p align="center"><a href="./README-EN.md">English version</a><p>

>如果对您有帮助，欢迎 "Star" 支持一下！

>您也可以 "follow" 一下，该项目将持续更新，不断完善。

>如有问题或者好的建议可以在 `Issues` 中提。

### 1.快速开始
- 安装依赖
    [SeasLog](https://github.com/SeasX/SeasLog)
    ```
    composer install
    cp .env.example .env
    ```
- Nginx配置
    ```
    server{
        ......
        root path-to-e-php/public;
        
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
        ......
    }
    ```
### 2.介绍
    ```
    框架初始化：
    初始化 ---> 单一入口。初始化应用（，实现自动加载）、服务容器
    注册服务 ---> 注册服务（错误异常处理、框架配置、业务配置、日志、数据库服务、用户自定义启动时操作、路由）并分别初始化，启动应用

    处理请求：
    输入输出 ---> 获取变量、检查变量，返回前数据格式
    路由转发
    mvc实现 ---> MCL（数据模型 -- 控制器 -- 业务逻辑）---> json／视图
    ```
- 开发工具

    Docker，Git钩子配置，PHPUnit单元测试，
    apiDoc接口文档，命令行工具
- 目录结构
    ```
    .git-hooks               [git钩子目录]
        └─ pre-commit            [预commit钩子示例]
        └─ commit-msg            [commit-msg示例]
    app                      [应用目录]
        ├─ api               [api模块]
            ├─ controller
            ├─ model
        ├─ demo              [默认模块]
            ├─ controller
            ├─ model
    config                   [配置目录]
        ├─ common.php          
    docs                     [接口文档目录]
    framework                [框架目录]
        ├─ exceptions
        ├─ handles           [处理机制目录]
            └─ ConfigHandle.php  [框架配置]
            └─ EnvHandle.php     [业务配置]
            └─ ErrorHandle.php   [错误、异常处理]
            └─ Handle.php        [处理接口]
            └─ Log.php           
            └─ Nosql.php         
            └─ Router.php        [路由]
        ├─ storage           [nosql、消息队列等处理目录]
        └─ App.php           [框架类]
        └─ Container.php     [Ioc容器]
        └─ Load.php          [自动加载]
        └─ Request.php       
        └─ Response.php      
        └─ run.php           [fpm应用启用脚本]
        └─ swoole.php        [swoole应用启用脚本]
        └─ View.php          [视图类]
    jobs                     [任务脚本目录]
    public                   [公共资源目录，暴露到万维网]
        └─ index.php             [fpm应用入口]
        └─ server.php            [swoole应用入口]
    runtime                  [临时目录]
        ├─ logs                  [日志目录]
        ├─ build                 [php打包生成phar文件目录]
    tests                    [单元测试目录]
        ├─ demo                  [模块名称]
            └─ DemoTest.php         [测试演示]
        ├─ TestCase.php          [测试用例]
    vendor                   [composer目录]
    view
    .env.example             [具体配置示例]  
    .gitignore                 
    .travis.yml              [travis-ci配置]
    composer.json            [composer配置]
    composer.lock              
    phpunit.xml              [PHPUnit配置]
    README-CN.md               
    README.md             
    ```
### 3.模块说明
- 入口文件

    [[file: public/index.php](public/index.php)]
- 自动加载
- 错误和异常处理
    
    捕获异常：set_exception_handler()
    捕获所有错误：set_error_handler() + register_shutdown_function()
- 配置文件
- 服务容器

    原理：把直接依赖转变为依赖于第三方，获取依赖的实例直接通过第三方去完成以达到松耦合的目的。
    实现：加载并调用各服务的register()方法注册入服务容器，需要时从中获取。
    ```
    // 注入单例
    App::$container->setSingle('别名，方便获取', '对象/闭包/类名');
    
    // 例，注入Request实例
    App::$container->setSingle('request', function () {
        // 匿名函数懒加载
        return new Request();
    });
    // 获取Request对象
    App::$container->get('request');
    ```
    [[file: framework/Container](https://github.com/dingqing/e-php/blob/master/framework/Container.php)]
- Nosql模块

    提供全局单例对象，在框架启动时，读取配置把需要的nosql实例注入到服务容器中。目前支持redis，可实现更多如memcahed/mongodb。
    ```
    // 获取redis对象
    App::$container->getSingle('redis');
    ```
    [[file: framework/storage/*](https://github.com/dingqing/e-php/tree/master/framework/storage)]
- 日志模块

    目前使用 [SeasLog](https://github.com/SeasX/SeasLog)
- 输入和输出
- 路由模块
    
    任务模式、普通url模式、pathinfo模式
- 从MVC到MCL

    V：视图交给前端，后端只提供数据，
    L：将业务逻辑代码提出到logic层，为多出的L层，利于代码维护和扩展。
- 数据库对象关系映射ORM

    使用的 [Medoo](https://github.com/catfan/Medoo)
- 使用Vue作为视图
- Swoole模式
    ```
    cd public && php server.php
    ```
    然后访问[http://localhost:8888/](http://localhost:8888/)
- Job模式

    可以在jobs目录编写任务脚本
- 接口文档生成和接口模拟

    使用 [apidoc](https://github.com/apidoc/apidoc)
    [使用示例](https://github.com/dingqing/apidoc-demo)
- 单元测试

    使用：tests目录下编写测试文件，具体参考tests/demo目录下的DemoTest文件,然后运行：
    ```
     vendor/bin/phpunit
    ```
    示例：
    ```
    /**
     *　演示测试
     */
    public function testDemo()
    {
        $this->assertEquals(
            'Hello E- PHP',
            // 执行demo模块index控制器index操作，断言结果是不是等于'Hello E- PHP'　
            App::$app->get('api/index/index')
        );
    }
    ```
    [[file: tests/*](https://github.com/dingqing/e-php/tree/master/tests)]
    [phpunit断言文档语法参考](https://phpunit.de/manual/current/zh_cn/appendixes.assertions.html)
- Git钩子配置

    目的：规范化我们的项目代码和commit记录。
    代码规范：配合使用php_codesniffer，在代码提交前对代码的编码格式进行强制验证。
    commit-msg规范：采用ruanyifeng的commit msg规范，对commit msg进行格式验证，增强git log可读性和便于后期查错和统计log等, 这里使用了[Treri](https://github.com/Treri)的commit-msg脚本，Thx~。
    [[file: ./git-hooks/*](https://github.com/dingqing/e-php/tree/master/.git-hooks)]
- 辅助脚本

    如何使用?
    ```
    composer create-project dingqing/e-php
    ```
    Swoole模式:
    ```
    cd public && php server.php
    ```
- docker环境

    ...
- 性能
    - fpm
    ```
    8核8G
    fpm配置：
    pm = dynamic
    pm.max_children = 5
    pm.start_servers = 2
    pm.min_spare_servers = 1
    pm.max_spare_servers = 3
    ```
    ab -c 1000 -n 10000 -r http://localhost:84/
    ```
    Server Software:        
    Server Hostname:        localhost
    Server Port:            84
    
    Document Path:          /
    Document Length:        0 bytes
    
    Concurrency Level:      1000
    Time taken for tests:   0.708 seconds
    Complete requests:      10000
    Failed requests:        10128
       (Connect: 0, Receive: 128, Length: 9680, Exceptions: 320)
    Non-2xx responses:      8856
    Total transferred:      4576840 bytes
    HTML transferred:       3030720 bytes
    Requests per second:    14115.22 [#/sec] (mean)
    Time per request:       70.845 [ms] (mean)
    Time per request:       0.071 [ms] (mean, across all concurrent requests)
    Transfer rate:          6308.90 [Kbytes/sec] received
    
    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        9   23   4.5     23      35
    Processing:    10   41  29.4     35     209
    Waiting:        0   34  29.7     28     203
    Total:         27   64  29.9     57     228
    
    Percentage of the requests served within a certain time (ms)
      50%     57
      66%     60
      75%     62
      80%     62
      90%     68
      95%    153
      98%    181
      99%    187
     100%    228 (longest request)
    ```
    - Swoole
    ab -c 1000 -n 10000 -r http://localhost:8888/
    ```
    Server Software:        swoole-http-server
    Server Hostname:        localhost
    Server Port:            8888
    
    Document Path:          /
    Document Length:        13 bytes
    
    Concurrency Level:      1000
    Time taken for tests:   0.631 seconds
    Complete requests:      10000
    Failed requests:        0
    Total transferred:      1840000 bytes
    HTML transferred:       130000 bytes
    Requests per second:    15840.05 [#/sec] (mean)
    Time per request:       63.131 [ms] (mean)
    Time per request:       0.063 [ms] (mean, across all concurrent requests)
    Transfer rate:          2846.26 [Kbytes/sec] received
    
    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        5   12   3.7     12      22
    Processing:     2   13   3.6     13      27
    Waiting:        1    7   2.3      7      20
    Total:         17   25   3.1     24      43
    
    Percentage of the requests served within a certain time (ms)
      50%     24
      66%     25
      75%     25
      80%     25
      90%     27
      95%     33
      98%     35
      99%     41
     100%     43 (longest request)
    ```
### 4.问题和贡献
……