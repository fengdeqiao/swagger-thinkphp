# Swagger-ThinkPHP
平时写app接口的时候，都是先写接口再去写接口文档，有时候想测试接口都是一件很复杂的事情，忙的时候都找不到接口文档在什么地方。有了这个组件你就不用担心文档找不到、接口不好测试。它可以帮你边写接口的同时边写接口文档并且可以在线调试接口，就是这么安逸。
## swagger-ui
这东西咋用呢? 说白了就是安装Swagger套件, 然后php文件代码里写注释, 用Swagger后端程序跑来php文件中提取注释, 生成一个json文件, 再通过Swagger前端来美化，达到展示JSON数据的效果。

前提：thinkphp3.2必须支持composer安装组件，且你的电脑上已经安装了composer，具体怎么安装composer这里就不详细介绍了，自行百度安装composer，最好把镜像换成国内的，如果你有很好的vpn等于我没说哈，这些方法百度上都有。

## 第一步：安装swagger-ui前端
下载thinkphp3.2框架解压后放到网站根目录中改名tp

```
git clone https://github.com/swagger-api/swagger-ui.git
```

下载完成之后，将文件夹放到你的网站根目录上面，例如我是放在我wamp下面的www目录。

接着找到dist目录, 打开index.html把其中的那一串url改成自己的 比如`http://localhost/tp/swagger-docs/swagger.json`

如果你想支持中文在index.html中加上
```javascript
<script src='lang/translator.js' type='text/javascript'>

</script><script src='lang/zh-cn.js' type='text/javascript'></script>
```
然后打开URL输入`http://localhost/swagger-ui/dist/index.html`就可以看到前端界面了, 应该是没内容的, 因为还没生成swagger.json, 生成好之后你设置的URL就起了作用。swagger.json我是放在tp框架下的swagger-docs目录中的，具体路径看你自己，具体下面会提到，不要慌O(∩_∩)O~。

## 第二步：安装swagger-php后端

进入你的tp框架中，找到与index.php同级目录的composer.json文件，打开文件在require下面加上"zircote/swagger-php": "*"一行，然后在当前目录下按住 shift + 右键 选择 ‘在此处打开命令窗口’ ，执行 composer update 等待安装完成 或者 直接在当前目录中按住 shift + 右键 选择 ‘在此处打开命令窗口’ 运行`composer require zircote/swagger-php`安装swagger-php。详情安装步骤见https://github.com/zircote/swagger-php。

提示安装完成后执行` composer global require zircote/swagger-php`会在你tp项目的vendor中生成一个zircote的组件文件夹，说明已经安装插件成功了。

## 第三步：生成swagger.json文件

直接在命令行中输入
```
php E:/wamp64/www/tp/vendor/zircote/swagger-php/bin/swagger E:/wamp64/www/tp/vendor/zircote/swagger-php/Examples -o E:/wamp64/www/tp/swagger-docs
```
生成swagger.json文件。

### 注意：第一个路径是你安装成功后组件的路径；第二个路径是你想要生成这个目录下所有用swagger方式注释的php文件，把所有注释生成api文档；第三个路径是你存放生成swagger.json的路径。

然后再看`http://localhost/swagger-ui/dist/index.html`, 是不是生成了API文档。 准备工作都做好了, 那就写代码注释就行了, 注释怎么写? 参考官方文档http://zircote.com/swagger-php/annotations.html

比如model的注释写法
```
/**
* @SWG\Model(
* id="vps",
* required="['type', 'hostname']",
*  @SWG\Property(name="hostname", type="string"),
*  @SWG\Property(name="label", type="string"),
*  @SWG\Property(name="type", type="string", enum="['vps', 'dedicated']")
* )
*/
class HostVps extends Host implements ResourceInterface
{
    // ...
}
```
控制器的注释写法
```
/**
 * @SWG\Resource(
 *  basePath="http://skyapi.dev",
 *  resourcePath="/vps",
 *  @SWG\Api(
 *   path="/vps",
 *   @SWG\Operation(
 *    method="GET",
 *    type="array",
 *    summary="Fetch vps lists",
 *    nickname="vps/index",
 *    @SWG\Parameter(
 *     name="expand",
 *     description="Models to expand",
 *     paramType="query",
 *     type="string",
 *     defaultValue="vps,os_template"
 *    )
 *   )
 *  )
 * )
 */
class VpsController extends Controller
{
    // ...
}
```
## 第四步：thinkphp中使用swagger-php

如果我们每次修改了api，还要手动执行第三步的代码，有些繁琐，那我们就在控制器中写一个方法，每次访问swagger-ui的时候自动执行，然后跳转到前台swagger界面中。

注意：在thinkphp的入口文件index.php中加入require './vendor/autoload.php';

下面是控制器里面的方法
```
$path = 'E:\wamp64\www\tp'; //你想要哪个文件夹下面的注释生成对应的API文档
$swagger = \Swagger\scan($path);
//header('Content-Type: application/json');
//echo $swagger;
$swagger_json_path = $path.'/swagger-docs/swagger.json';
$res = file_put_contents($swagger_path, $swagger);
if ($res == true) {
   $this->redirect('http://localhost/swagger-ui/dist/index.html');
}
```
到此完成了，具体swagger-php的注释使用方法，请打开安装好的组件目录,我的目录在`E:\wamp64\www\tp\vendor\zircote\swagger-php\Examples`，这里的php文件都是写好注释的，自己好好看下应该就可以使用了，实在不会还有度娘呢。O(∩_∩)O~
