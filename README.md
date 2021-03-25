# laravel-api-response

> 简单封装通用前后端分离使用接口传输数据时候的数据格式定义

### 数据内容格式

```json

{
    "code": 0,
    "message": "请求成功",
    "data": {
      "user": {}
    }
}
    
```

### 用法

```php
// 示例查询语句
User::where('name', 'like', '%test%')->get();
// 完整sql获取 
User::where('name', 'like', '%test%')->select(['*'])->sql();

// 示例查询语句
DB::table('users')->where('name', 'like', '%test%')->get();
// 完整sql获取
DB::table('users')->where('name', 'like', '%test%')->select(['*'])->sql();
```

- 上述示例中直接的**get()**方法获取数据 实际上缺省了参数**['*']**

## 框架要求

Laravel >= 5.5

