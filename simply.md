command+ctrl+G:批量替换
##PHP
###phpunit
setEquals() 测试是否相等  
setCount()  自动增加count函数  
setUp()相当于构造函数  
###ini
short_open_tag开启短标签  
is_type() and gettype()   diffent
### 函数的函数
1、有条件的函数，首先要求判断语句能够运行，否则函数不存在  
2、函数中的函数，首先调用父函数，然后子函数才能被调用  
3、递归函数，函数内部调用的函数  
4、可变函数，函数名通过赋值得到 调用  
####数组函数
1、array_combine($arr_key,$arr_val);生成新的array($key1=>$val1,$key2=>$val2)的新数组，类比arrya_values(),array_keys();  
2、  
3、  
###常见函数 
1、`get_load_extensions()`获得`php`加载项   php -m  
2、`is_upload_file`  和 `move_uploaded_file()`  
3、`yield`：    
4、`$sql = sprintf("SELECT * FROM (SELECT * FROM chat WHERE id > '%d' ORDER BY id DESC LIMIT 100) t ORDER BY id ASC", $begin)`;  
5、`set_time_limit(0)` ;   
6、`basename（‘文件名’，'后缀'）`，如果1个参数直接输出，2个参数取出后缀之后的文件名  ;
类比trim和ltrim的第二个参数 ;   
7、`htmlentities()` 函数把字符转换为 HTML 实体; 
`html_entity_decode()` 函数把 HTML 实体转换为字符;   
8、`mysql_data_seek（$resource,int）`；将指针指到int位，只能和mysql\_query的结果一起使用  
9、`replace into tbname (columns) values(values)`先插入，如果有唯一索引或者主键冲突那么更新，如果没有主键，那么直接插入   
10、`preg_match_all()   
11、执行顺序 select * from liv_column where id in (35,23,37);
12、```curl -v ```取出请求头 的相关信息
###oop 
1、注册自动加载函数 spl\_autoload\_register("类名");  
2、trait 声明类 然后可以在类里use调用类 类俗于继承 减少代码量  
3、__callStatic 和 __call区别   
4、对象类型约束：function add（OtherClass）{}或者 array Traverable  callable 等等约束参数  
5、后期静态绑定：  
6、命名空间 后期看  
7、$GLOBALS 存储全局变量的地方是个数 
8、$_ENV 
###正则
1、```\d:数字```  
2、*```linux下换行是\n,window下换行是\r\n```*  
3、```\s 空白（一个字符，空格，tab均可） \S取反\s```  
4、```/i  不区分大小写```   
5、
6、

##linux指令
1、ls -ah 查看隐藏文件 		
2、sed 指令  
3、
1️⃣：ctrl+v 进入列编辑模式,向下或向上移动光标,把需要注释的行的开头标记起来,然后按大写的I(shift+i),再插入注释符,比如"//",再按Esc,就会全部注释了
批量去掉注释
2️⃣：ctrl+v,进入列编辑模式,横向选中列的个数(如"//"注释符号,需要选中两列),然后按d, 就会删除注释符号  
4、SCP命令类似cp，区别是可以在linux之间通过ssh进行互相传递，  ``` scp [可选参数] file_source file_target ```


##install config
mysql :mysql.server start mysql.server restart  
php: sudo /usr/local/Cellar/php/php5.6/sbin/php5.6-fpm start  or restart or stop  
conf : /usr/local/etc/php/5.3/php-fpm.conf   
nginx : sudo nginx -s reload 重启  
        本地配置文件:usr/local/etc/nginx/servers  
   		 sudo /usr/local/opt/nginx/bin/nginx   
  lsof -i:80 查看80端口是否被占用  
##mysql语法
```
  并发控制：
```
|锁类型|用途||
| --- |---|---|
|表锁|进行写操作时会阻塞其他读写操作|写锁优先级比读锁高，读锁之间不会相互阻塞|
|行级锁||
###事务的隔离级别
```
read uncommited 未提交读：几乎不用    
```
死锁：当2个事务同时需求对方的资源时，等待释放资源 导致的冲突
###错误日志  
`/usr/local/etc ->php.ini`  `display_error` 和error_logs=‘地址’   logs_error  
nginx conf中添加  access_log地址access error_log +地址 main错误类型  
/etc/hosts修改host

###nginx
###phpstorm
com + shift + o  查找文件  
com + shift + a  查找方法  php artisan app:name 
com + e          查找最近的文件  
com + shift + a  查找配置项  
com + ctrl  + g  查找所有  
com + shft  + g  一个一个查找

###GIT
1、git init 初始化 git库  
2、git add filename   
3、git commit  -m filename  
4、git status  
5、git diff   
6、git reset --hard HEAD~number 
  或者是 git resrt --hard version-number  
7、git reflog 和 git log  
8、git checkout --filename撤销修改     
9、git reset HEAD filename 暂缓区的文件撤销掉 add后    
10、git checkout -- filename   
11 `git branch` 查看分支// `git checkout <name>`切换分支 // git branch \<name> 创建分支 //git branch -D \<name> 删除分支 // git merge \<name> // git checkout -b \<name> 创建并且切换分支  //删除远程分支 ：git push origin:name