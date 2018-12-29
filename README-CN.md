# e-php
造轮子系列，实现自己的PHP开发框架。

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

### 功能列表
- 已完成：
    - 单一入口，加载配置，自动加载，错误异常处理，路由，
    - 请求（网关：校验参数、访问权限、频率、签名）-响应，mvc，orm，视图。
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
