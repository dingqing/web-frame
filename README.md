# web-frame
> 手动实现Web开发框架（PHP）

**目录**

[文件目录说明](#文件目录说明)
类别 | 页内目录
--- | ---
初始化 |[框架入口](#框架入口)，[自动加载](#自动加载)，[错误与异常处理](#错误与异常处理)，[配置加载](#配置加载)，[服务容器](#服务容器)
转发请求-处理-返回 |[路由](#路由)，MVC，[ORM](#对象关系映射)，视图

测试与使用：[单元测试](#单元测试)，[Git钩子](#钩子)，[运行使用](#运行使用)

***

### 文件目录说明
主要文件目录|说明
---|---
app |应用目录
.git-hooks |git钩子
framework |框架
public |公共资源目录，暴露到万维网
tests |单元测试
.env.example |[业务配置示例]

***

### 框架入口
[public/index.php](public/index.php) -> [framework/start.php](framework/start.php)
### 自动加载
类别|说明|对应文件
---|---|---
使用 |`use 命名空间类名`
实现 |调用spl_autoload_register()注册自加载函数到__autoload队列中 |[framework/Load.php](framework/Load.php)

### 错误与异常处理
方案|作用
---|---
通过set_error_handler()注册错误处理方法 |处理常规错误
register_shutdown_function() + error_get_last() |在脚本终止执行时，处理set_error_handler()不能处理的错误，包括：E_ERROR、 E_PARSE、 E_CORE_ERROR、 E_CORE_WARNING、 E_COMPILE_ERROR、 E_COMPILE_WARNING，以及在调用set_error_handler()所在文件中产生的大多数E_STRICT
通过set_exception_handler()注册异常处理方法

[framework/hanles/ErrorHandle.php](framework/handles/ErrorHandle.php)
### 配置加载
[framework/hanles/ConfigHandle.php](framework/handles/ConfigHandle.php)
### 服务容器
> 一开始的买菜：去农户家购买，可能遇到农户没法提供，总之出现各种问题，

> 改进版：去菜市场，比如想要买土豆，市场里面有很多农户提供服务。

> 即，增加中间层，将服务方与调用方解耦，农户专注为集市提供服务，买方只去集市。

[framework/Container.php](framework/Container.php)

### 路由
```
├─ router
  ├─ RouterInterface.php
  ├─ General.php      [普通路由]
  ├─ Pathinfo.php     [pathinfo路由]
  ├─ Userdefined.php  [自定义路由]
  ├─ Job.php          [脚本任务路由]
  └─ RouterStart.php  [路由策略入口类]
```
[framework/hanles/RouterHandle.php](framework/handles/RouterHandle.php)
### 对象关系映射
> 把对象的链式操作解析成具体的sql语句。
```
├─ orm
  ├─ Interpreter.php    [sql解析器]
  ├─ DB.php             [数据库操作类]
  ├─ Model.php          [数据模型基类]
  └─ db                 [数据库类目录]
    └─ Mysql.php        [mysql实体类]
```
**DB类使用示例**
```
/**
 * DB操作示例
 *
 * findAll
 *
 * @return void
 */
public function dbFindAllDemo()
{
    $where = [
        'id'   => ['>=', 2],
    ];
    $instance = DB::table('user');
    $res      = $instance->where($where)
                         ->orderBy('id asc')
                         ->limit(5)
                         ->findAll(['id','create_at']);
    $sql      = $instance->sql;

    return $res;
}
```

**Model类使用示例**

```
// controller 代码
/**
 * model example
 *
 * @return mixed
 */
public function modelExample()
{
    try {

        DB::beginTransaction();
        $testTableModel = new TestTable();

        // find one data
        $testTableModel->modelFindOneDemo();
        // find all data
        $testTableModel->modelFindAllDemo();
        // save data
        $testTableModel->modelSaveDemo();
        // delete data
        $testTableModel->modelDeleteDemo();
        // update data
        $testTableModel->modelUpdateDemo([
               'nickname' => 'web-frame'
            ]);
        // count data
        $testTableModel->modelCountDemo();

        DB::commit();
        return 'success';

    } catch (Exception $e) {
        DB::rollBack();
        return 'fail';
    }
}

//TestTable model
/**
 * Model操作示例
 *
 * findAll
 *
 * @return void
 */
public function modelFindAllDemo()
{
    $where = [
        'id'   => ['>=', 2],
    ];
    $res = $this->where($where)
                ->orderBy('id asc')
                ->limit(5)
                ->findAll(['id','create_at']);
    $sql = $this->sql;

    return $res;
}
```

[framework/orm/](framework/orm)
**build步骤**
```
yarn install

DOMAIN=http://你的域名 npm run dev
```
**编译后**

build成功之后会生成dist目录和入口文件index.html在public目录中。非发布分支.gitignore文件会忽略这些文件，发布分支去除忽略即可。

```
public               [暴露到万维网]
├─ dist              [前端build之后的资源目录，不是发布分支忽略该目录]
  └─ ...
├─ index.html        [前端入口文件,build生成的文件，不是发布分支忽略该文件]
```
[[frontend/*](frontend)]

### 单元测试
> 基于phpunit的单元测试。

**如何使用？**

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
        'Hello web-frame',
        // 执行demo模块index控制器hello操作，断言结果是不是等于'Hello web-frame'　
        App::$app->get('demo/index/hello')
    );
}
```

[phpunit断言文档语法参考](https://phpunit.de/manual/current/zh_cn/appendixes.assertions.html)

[tests/*](tests)
### 钩子
目的：规范化项目代码和commit记录。
- 代码规范：配合使用php_codesniffer，在代码提交前对代码的编码格式进行强制验证。
- commit-msg规范：采用ruanyifeng的commit msg规范，对commit msg进行格式验证，增强git log可读性和便于后期查错和统计log等, 这里使用了[Treri](https://github.com/Treri)的commit-msg脚本。

[./git-hooks/](./git-hooks)

***

## 运行使用
> nginx配置虚拟主机根目录设置为项目中的public，然后访问虚拟主机地址。