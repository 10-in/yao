# 实仁-六爻

# 当前项目废弃
  
  这个过程本就不应该在服务端实现，意义不大。现在已经改写为js版本，在前端实现，请参考 [seerlegend/six](https://github.com/seerlegend/six)

## 安装

  ```shell
  composer require shiren/yao
  ```

## 使用

- 爻值对应
  - No　 名称　　符号
  - 0　　阴爻　　[ - - ] 
  - 1　　阳爻　　[ --- ] 
  - 2　　动阴爻　[ -x- ] 
  - 3　　动阳爻　[ -0- ]

- 命令行查看结果
  ```php
  $eye = \Shiren\Yao\Eye::create([1, 2, 0, 0, 0, 3], [6, 10], [2, 2])->look();
  \Shiren\Yao\Visible::instance($eye)->show(true);

  //庚戌月丙寅日  
  //山雷颐之地泽临 木  
  //6 　 青 兄 -0- 寅[　 　 　　　] 酉 官  
  //5 　 玄 父 - - 子[　 　 伏巳子] 　 　  
  //4 世 白 才 - - 戌[空 建 　　　] 　 　  
  //3 　 蛇 才 - - 辰[　 破 　　　] 　 　  
  //2 　 勾 兄 -x- 寅[　 　 　　　] 卯 兄  
  //1 应 朱 父 --- 子[　 　 　　　] 　 
  ```
　  
- 接口调用
  ```php
  // 需要自己转换参数
  $data = \Shiren\Yao\Eye::create([1, 2, 0, 0, 0, 3], [6, 10], [2, 2])->look()->toArray();
  // 以下无需自己转换参数
  $eye = \Shiren\Yao\Eye::create([1, 2, 0, 0, 0, 3], [6, 10], [2, 2])->look();
  $data = \Shiren\Yao\Visible::instance($eye)->show();
  ```
  - ->show()结果
  ```json
  {
    "name": [ "山雷颐", "地泽临"],
    "element": "木",
    "times": [
      {
        "no": 0, "type": 1, "sy": "应", "animal": "朱", "peace": "", "z": "子", "relation": "父", "empty": "", "m": "破", "d": "",
        "change": null
      },
      {
        "no": 1, "type": 2, "sy": "", "animal": "勾", "peace": "", "z": "寅", "relation": "兄", "empty": "", "m": "", "d": "",
        "change": { "z": "卯", "relation": "兄", "empty": "", "m": "", "d": "" }
      },
      {
        "no": 2, "type": 0, "sy": "", "animal": "蛇", "peace": "", "z": "辰", "relation": "才", "empty": "", "m": "", "d": "",
        "change": null
      },
      {
        "no": 3, "type": 0, "sy": "世", "animal": "白", "peace": "", "z": "戌", "relation": "才", "empty": "空", "m": "", "d": "",
        "change": null
      },
      {
        "no": 4, "type": 0, "sy": "", "animal": "玄", "peace": "巳子", "z": "子", "relation": "父", "empty": "", "m": "破", "d": "",
        "change": null
      },
      {
        "no": 5, "type": 3, "sy": "", "animal": "青", "peace": "", "z": "寅", "relation": "兄", "empty": "", "m": "", "d": "",
        "change": { "z": "酉", "relation": "官", "empty": "", "m": "", "d": ""}
      }
    ],
    "dayCol": [2, 2],
    "monthCol": [6, 6],
    "front": 33,
    "back": 3
  }
  ```

## 参考demo

[demo](demo/foo.php)

## LICENSE

  MIT
