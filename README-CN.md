# E-PHP
造轮子系列，实现一个自己的PHP开发框架。

<p align="center"> <a href="./README.md">英文版</a>　<p>

一个PHP框架的大致流程如下：
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

## 功能列表
- 已完成：
    - 单一入口，加载配置，自动加载，错误异常处理，路由，
    - 请求（网关：校验参数、访问权限、频率、签名）-响应，mvc，orm，视图，
    - ioc，
    - git钩子配置。
- 后续：
    - Swoole模式。命令行。

##  框架目录一览
```
app
    ├─ api                 [api模块]
        ├─ controller
        ├─ model
    ├─ framework           [默认模块]
        ├─ controller
        ├─ model
config                     [配置目录]
    ├─ common.php          [公共配置]
    ├─ swoole.php          [swoole配置]
    └─ nosql.php           [nosql配置]
docs                       [接口文档目录]
framework                  [核心框架目录]
    └─ ErrorHandle.php     [错误处理机制类]
    └─ Log.php             [log机制类]
    └─ Request.php         [请求类]
    └─ Response.php        [响应类]
    └─ Router.php          [路由策略]
    └─ run.php             [框架应用启用脚本]
    └─ View.php            [视图类]
public                     [公共资源目录，暴露到万维网]
    ├─ dist                [前端build之后的资源目录，build生成的目录，不是发布分支忽略该目录]
    └─ ...
    └─ index.html          [前端入口文件,build生成的文件，不是发布分支忽略该文件]
├─ index.php               [后端入口文件]
├─ server.php              [swoole模式后端入口文件]
runtime                    [临时目录]
    ├─ logs                [日志目录]
    ├─ build               [php打包生成phar文件目录]
tests                      [单元测试目录]
    ├─ demo                [模块名称]
        └─ DemoTest.php    [测试演示]
    ├─ TestCase.php        [测试用例]
vendor                     [composer目录]
view
.git-hooks                 [git钩子目录]
    ├─ pre-commit          [git pre-commit预commit钩子示例文件]
    ├─ commit-msg          [git commit-msg示例文件]
.gitignore                 [git忽略文件配置]
.travis.yml                [持续集成工具travis-ci配置文件]
LICENSE                    [lincese文件]
logo.png                   [框架logo图片]
composer.json              [composer配置文件]
composer.lock              [composer lock文件]
package.json               [前端依赖配置文件]
README-CN.md               [中文版readme文件]
README.md                  [readme文件]
 ```

## 框架模块说明：
###  入口文件
###  自加载模块
###  错误和异常模块
###  配置文件模块
###  输入和输出
###  路由模块
###  使用Vue作为视图
###  数据库对象关系映射
使用的 [Medoo](https://github.com/catfan/Medoo)
###  服务容器模块

服务容器的意义？

用设计模式来讲：其实不管设计模式还是实际编程的经验中，我们都是强调“高内聚，松耦合”，我们做到高内聚的结果就是每个实体的作用都是极度专一，所以就产生了各个作用不同的实体类。在组织一个逻辑功能时，这些细化的实体之间就会不同程度的产生依赖关系，对于这些依赖我们通常的做法如下：

```
class Demo
{
    public function __construct()
    {
        // 类demo直接依赖RelyClassName
        $instance = new RelyClassName();
    }
}
```

这样的写法没有什么逻辑上的问题，但是不符合设计模式的“最少知道原则”，因为之间产生了直接依赖，整个代码结构不够灵活是紧耦合的。所以我们就提供了一个第三方的实体，把直接依赖转变为依赖于第三方，我们获取依赖的实例直接通过第三方去完成以达到松耦合的目的，这里这个第三方充当的角色就类似系统架构中的“中间件”，都是协调依赖关系和去耦合的角色。最后，这里的第三方就是所谓的服务容器。

在实现了一个服务容器之后，我把Request,Config等实例都以单例的方式注入到了服务容器中，当我们需要使用的时候从容器中获取即可，十分方便。使用如下：

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

###  Nosql模块
提供对nosql的支持，提供全局单例对象，借助我们的服务容器我们在框架启动的时候，通过配置文件的配置把需要的nosql实例注入到服务容器中。目前我们支持redis/memcahed/mongodb。

如何使用？如下，

```
// 获取redis对象
App::$container->getSingle('redis');
// 获取memcahed对象
App::$container->getSingle('memcahed');
// 获取mongodb对象
App::$container->getSingle('mongodb');
```

[[file: framework/nosql/*](https://github.com/dingqing/e-php/tree/master/framework/nosql)]

###  日志模块
目前使用 [SeasLog](https://github.com/SeasX/SeasLog)
###  Swoole模式
###  Job模式
###  接口文档生成和接口模拟模块
使用 [apidoc](https://github.com/apidoc/apidoc)
文档：http://apidocjs.com/
###  单元测试模块
基于phpunit的单元测试，写单元测试是个好的习惯。

如何使用？

tests目录下编写测试文件，具体参考tests/demo目录下的DemoTest文件,然后运行：

```
 vendor/bin/phpunit
```

测试断言示例：

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

[phpunit断言文档语法参考](https://phpunit.de/manual/current/zh_cn/appendixes.assertions.html)

[[file: tests/*](https://github.com/dingqing/e-php/tree/master/tests)]
###  Git钩子配置
目的：规范化我们的项目代码和commit记录。

- 代码规范：配合使用php_codesniffer，在代码提交前对代码的编码格式进行强制验证。
- commit-msg规范：采用ruanyifeng的commit msg规范，对commit msg进行格式验证，增强git log可读性和便于后期查错和统计log等, 这里使用了[Treri](https://github.com/Treri)的commit-msg脚本，Thx~。

[[file: ./git-hooks/*](https://github.com/dingqing/e-php/tree/master/.git-hooks)]
###  辅助脚本

## 如何使用?
执行：
> composer require niumeng/e-php

**网站服务模式:**

快速开始一个demo:
```
...
```
**客户端脚本模式:**
**Swoole模式:**

## docker环境
...
## 性能-fpm
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
Document Path:          /
Document Length:        0 bytes

Concurrency Level:      1000
Time taken for tests:   0.733 seconds
Complete requests:      10000
Failed requests:        10128
   (Connect: 0, Receive: 128, Length: 9680, Exceptions: 320)
Non-2xx responses:      9179
Total transferred:      4176950 bytes
HTML transferred:       2588410 bytes
Requests per second:    13650.22 [#/sec] (mean)
Time per request:       73.259 [ms] (mean)
Time per request:       0.073 [ms] (mean, across all concurrent requests)
Transfer rate:          5568.00 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:       12   21   3.4     22      33
Processing:     9   39  38.0     33     294
Waiting:        0   32  38.5     27     285
Total:         31   61  38.1     54     317

Percentage of the requests served within a certain time (ms)
  50%     54
  66%     55
  75%     56
  80%     58
  90%     61
  95%     65
  98%    240
  99%    266
 100%    317 (longest request)
```
## 性能-Swoole
## 问题和贡献
