<p align="center"><img width="50%" src="./logo.png"><p>

造轮子系列，实现一个PHP轻量、全栈开发框架

<p align="center"> <a href="./README-EN.md">English version</a>　<p>

> 如果对您有帮助，欢迎 "Star" 支持一下！

> 您也可以 "follow" 一下，该项目将持续更新，不断完善。

> 如有问题或者好的建议可以在 `Issues` 中提。

### 说明
- 基本功能：
    - 单一入口，加载配置，自动加载，错误、异常处理，路由，
    - 请求，响应，MVC，ORM，视图，
    - Ioc，
    - Swoole模式
- 工具
    - Git钩子配置，Travis，apiDoc
- Todos：
    - PHPUnit，命令行工具，
    - Docker
    - Vue
### 依赖
- [SeasLog](https://github.com/SeasX/SeasLog)
### 目录一览
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
config                   [框架配置目录]
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
.env.example             [业务配置示例]  
.gitignore                 
.travis.yml              [travis-ci配置]
composer.json            [composer配置]
composer.lock              
phpunit.xml              [PHPUnit配置]
README-CN.md               
README.md             
 ```


## 开发
### 框架设计
- 一个PHP框架的大致流程如下：
    ```
    入口文件　----> 注册自加载函数
            ----> 注册错误(和异常)处理函数
            ----> 加载配置文件
            ----> 请求
            ----> 路由　
            ---->（控制器 <----> 数据模型）
            ----> 响应
            ----> json
            ----> 视图渲染数据
    ```
    
###  模块说明：
1. 入口文件
2. 自加载模块
3. 错误和异常模块
4. 配置文件模块
5. 输入和输出
6. 路由模块
7. 使用Vue作为视图
8. 数据库对象关系映射
    - 使用的 [Medoo](https://github.com/catfan/Medoo)
9. 服务容器模块
    - 服务容器的意义？
    提供了一个第三方的实体，把直接依赖转变为依赖于第三方，我们获取依赖的实例直接通过第三方去完成以达到松耦合的目的，这里这个第三方充当的角色就类似系统架构中的“中间件”，都是协调依赖关系和去耦合的角色。最后，这里的第三方就是所谓的服务容器。
    - 在实现了一个服务容器之后，我把Request,Config等实例都以单例的方式注入到了服务容器中，当我们需要使用的时候从容器中获取即可，十分方便。使用如下：
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
    - [[file: framework/Container](https://github.com/dingqing/e-php/blob/master/framework/Container.php)]

10. Nosql模块
    - 提供对nosql的支持，提供全局单例对象，借助我们的服务容器我们在框架启动的时候，通过配置文件的配置把需要的nosql实例注入到服务容器中。目前我们支持redis/memcahed/mongodb。

    - 如何使用？如下，
    ```
    // 获取redis对象
    App::$container->getSingle('redis');
    // 获取memcahed对象
    App::$container->getSingle('memcahed');
    // 获取mongodb对象
    App::$container->getSingle('mongodb');
    ```
    - [[file: framework/nosql/*](https://github.com/dingqing/e-php/tree/master/framework/nosql)]

11. 日志模块
    - 目前使用 [SeasLog](https://github.com/SeasX/SeasLog)
12. Swoole模式
    ```
    cd public && php server.php
    ```
    然后访问[http://localhost:8888/](http://localhost:8888/)
13. Job模式
14. 接口文档生成和接口模拟模块
    - 使用 [apidoc](https://github.com/apidoc/apidoc)
15. 单元测试模块
    - 如何使用？
    tests目录下编写测试文件，具体参考tests/demo目录下的DemoTest文件,然后运行：

    ```
     vendor/bin/phpunit
    ```
    - 测试断言示例：
    ```
    /**
     *　演示测试
     */
    public function testDemo()
    {
        $this->assertEquals(
            'Hello E- PHP',
            // 执行demo模块index控制器hello操作，断言结果是不是等于'Hello E- PHP'　
            App::$app->get('api/index/hello')
        );
    }
    ```
    - [phpunit断言文档语法参考](https://phpunit.de/manual/current/zh_cn/appendixes.assertions.html)
    - [[file: tests/*](https://github.com/dingqing/e-php/tree/master/tests)]
16. Git钩子配置
    - 目的：规范化我们的项目代码和commit记录。
    - 代码规范：配合使用php_codesniffer，在代码提交前对代码的编码格式进行强制验证。
    - commit-msg规范：采用ruanyifeng的commit msg规范，对commit msg进行格式验证，增强git log可读性和便于后期查错和统计log等, 这里使用了[Treri](https://github.com/Treri)的commit-msg脚本，Thx~。

    - [[file: ./git-hooks/*](https://github.com/dingqing/e-php/tree/master/.git-hooks)]
17. 辅助脚本
    - 如何使用?
    ```
    composer create-project dingqing/e-php
    ```
    - Swoole模式:
    ```
    cd public && php server.php
    ```
18. docker环境
    - ...

19. 性能
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
### 问题和贡献
