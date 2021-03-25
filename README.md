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

1. 方式一

    Http 请求状态 都是200 成功
    
```php
// 成功携带数据
ApiRes::success(['info' => ['name' => 'Jone', 'age' => 20]], '数据获取成功');

// 失败携带数据
// 携带自定义错误码
ApiRes::fail('数据获取失败', ['notice_type' => 1, 'notice_message' => '示例方式'], 10000);
// 不携带错误码 使用默认400错误码
ApiRes::fail('数据获取失败', ['notice_type' => 1, 'notice_message' => '示例方式'];

// 成功无数据
ApiRes::message('提交成功');

// 失败无数据
// 携带自定义错误码
ApiRes::errorMessage('提交失败', 10001);
// 使用默认400错误码
ApiRes::errorMessage('提交失败');

```

2. 方式二
```php
\Illuminate\Http\Response::success();
\Illuminate\Http\Response::fail();

参数与方式一相同

```

## 框架要求

Laravel >= 5.5

