# web-frame
> 手动实现web框架（PHP）


目录 | 二级目录
--- | ---
理解 |[框架的工作](#框架的工作)
实现 |[文件目录](#文件目录)
&nbsp;|初始化：[框架入口](#框架入口)，[自动加载](#自动加载)，[错误与异常处理](#错误与异常处理)，[配置加载](#配置加载)，[服务容器](#服务容器)
&nbsp;|处理请求：[路由](#路由)，MVC，[ORM](#对象关系映射)，视图
&nbsp;|测试与工具：[单元测试](#单元测试)，[Git钩子](#钩子)
[使用](#使用)

***
## 理解
### 框架的工作
>完成“基础设施”建设：方便的路由定义、错误处理、配置管理、服务管理、ORM等等，使得业务开发更加简洁、方便。
***

## 实现
### 文件目录
目录|说明
---|---
app |应用目录
.git-hooks |git钩子
framework |框架
public |公共资源目录，暴露到万维网
tests |单元测试
.env.example |业务配置示例

***

### 框架入口
[public/index.php](public/index.php) -> [framework/start.php](framework/start.php)
### 自动加载
[framework/Load.php](framework/Load.php)
类别|说明
---|---
使用 |`use 命名空间类名`
实现 |调用spl_autoload_register()注册自加载函数到__autoload队列中

### 错误与异常处理
[framework/hanles/ErrorHandle.php](framework/handles/ErrorHandle.php)
方案|作用
---|---
通过set_error_handler()注册错误处理方法 |处理常规错误
register_shutdown_function() + error_get_last() |在脚本终止执行时，处理set_error_handler()不能处理的错误，包括：E_ERROR、 E_PARSE、 E_CORE_ERROR、 E_CORE_WARNING、 E_COMPILE_ERROR、 E_COMPILE_WARNING，以及在调用set_error_handler()所在文件中产生的大多数E_STRICT
通过set_exception_handler()注册异常处理方法

### 配置加载
[framework/hanles/ConfigHandle.php](framework/handles/ConfigHandle.php)
### 服务容器
[framework/Container.php](framework/Container.php)
> 初级版买菜：直接去农户家购买，可能遇到农户没法提供想要的菜，总之出现各种问题，

> 改进版：去菜市场，比如想要买土豆，市场里面有很多农户提供服务。

> 即，增加中间层，将服务方与调用方解耦，农户专注为提供服务，买方去集市获取服务、不用关心服务的实现。

### 路由
[framework/hanles/RouterHandle.php](framework/handles/RouterHandle.php)
```
├─ router
  ├─ RouterInterface.php
  ├─ General.php      [普通路由]
  ├─ Pathinfo.php     [pathinfo路由]
  ├─ Userdefined.php  [自定义路由]
  ├─ Job.php          [脚本任务路由]
  └─ RouterStart.php  [路由策略入口类]
```
### 对象关系映射
[framework/orm/](framework/orm)
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

### 单元测试
[phpunit断言文档语法参考](https://phpunit.de/manual/current/zh_cn/appendixes.assertions.html)
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

### 钩子
目的：规范化项目代码和commit记录。
- 代码规范：配合使用php_codesniffer，在代码提交前对代码的编码格式进行强制验证。
- commit-msg规范：采用ruanyifeng的commit msg规范，对commit msg进行格式验证，增强git log可读性和便于后期查错和统计log等, 这里使用了[Treri](https://github.com/Treri)的commit-msg脚本。

***

## 使用
    nginx配置虚拟主机根目录设置为项目中的public，然后访问虚拟主机地址。