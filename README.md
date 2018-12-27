# e-php
造轮子系列，实现自己的PHP开发框架。

### 功能列表
- 先实现基本功能：

单一入口，加载配置，
自动加载，异常处理。路由，请求（网关：校验参数、访问权限、频率、签名）-响应，
mvc，orm，视图。

- 后续：
    - 辅助功能：
文件上传，nosql，日志，消息队列。
表单助手。增删查改脚手架。
接口文档，单元测试。命令行。
git钩子配置、忽略文件。
    - 框架设计：ioc

###  框架目录一览
```
app
    ├─ api
        ├─ controller
        ├─ model
    ├─ framework
        ├─ controller
        ├─ model
config                     [配置目录]
    ├─ common.php          [公共配置]
    ├─ swoole.php          [swoole配置]
    └─ nosql.php           [nosql配置]
docs                       [接口文档目录]
framework                  [核心框架目录]
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
 
###  路由模块
 
 ```
 ├── router                      [路由策略]
 │      ├── RouterInterface.php  [路由策略接口]
 │      ├── General.php          [普通路由]
 │      ├── Pathinfo.php         [pathinfo路由]
 │      ├── Userdefined.php      [自定义路由]
 │      ├── Micromonomer.php     [微单体路由]
 │      ├── Job.php              [脚本任务路由]
 │      └── EasyRouter.php       [路由策略入口类]
 ```
 
 通过用户访问的url信息，通过路由规则执行目标控制器类的的成员方法。我在这里把路由大致分成了四类：
 
 **传统路由**
 
 ```
 domain/index.php?module=Demo&contoller=Index&action=test&username=test
 ```
 
 **pathinfo路由**
 
 ```
 domain/demo/index/modelExample
 ```
 
 **用户自定义路由**
 
 ```
 // 定义在config/moduleName/route.php文件中，这个的this指向RouterHandle实例
 $this->get('v1/user/info', function (Framework\App $app) {
     return 'Hello Get Router';
 });
 ```
 
 **微单体路由**
 
 我在这里详细说下这里所谓的微单体路由，面向SOA和微服务架构大行其道的今天，有很多的团队都在向服务化迈进，但是服务化过程中很多问题的复杂度都是指数级的增长，例如分布式的事务，服务部署，跨服务问题追踪等等。这导致对于小的团队从单体架构走向服务架构难免困难重重，所以有人提出来了微单体架构，按照我的理解就是在一个单体架构的SOA过程，我们把微服务中的的各个服务还是以模块的方式放在同一个单体中，比如：
 
 ```
 app
 ├── UserService     [用户服务模块]
 ├── ContentService  [内容服务模块]
 ├── OrderService    [订单服务模块]
 ├── CartService     [购物车服务模块]
 ├── PayService      [支付服务模块]
 ├── GoodsService    [商品服务模块]
 └── CustomService   [客服服务模块]
 ```
 
 如上，我们简单的在一个单体里构建了各个服务模块，但是这些模块怎么通信呢？如下：
 
 ```
 App::$app->get('demo/index/hello', [
     'user' => 'dingqing'
 ]);
 ```
 
 通过上面的方式我们就可以松耦合的方式进行单体下各个模块的通信和依赖了。与此同时，业务的发展是难以预估的，未来当我们向SOA的架构迁移时，很简单，我们只需要把以往的模块独立成各个项目，然后把App实例get方法的实现转变为RPC或者REST的策略即可，我们可以通过配置文件去调整对应的策略或者把自己的，第三方的实现注册进去即可。
 
 [[file: framework/hanles/RouterHandle.php](https://github.com/dingqing/e-php/blob/master/framework/handles/RouterHandle.php)]