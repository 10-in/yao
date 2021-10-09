# 实仁-六爻

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
  \Shiren\Yao\Visible::instance($eye)->show();

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
  // 戊戌自己转换参数
  $eye = \Shiren\Yao\Eye::create([1, 2, 0, 0, 0, 3], [6, 10], [2, 2])->look();
  $data = \Shiren\Yao\Visible::instance($eye)->show(true);
  ```

## 参考demo

[demo](demo/foo.php)

## LICENSE

  MIT