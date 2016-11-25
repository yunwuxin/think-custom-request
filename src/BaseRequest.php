<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
namespace think;

/**
 * Class BaseRequest
 *
 * @method string domain($domain = null) 获取当前包含协议的域名
 * @method string url($url = null) 获取当前完整URL 包括QUERY_STRING
 * @method string baseUrl($url = null) 获取当前URL 不含QUERY_STRING
 * @method string baseFile($file = null) 获取当前执行的文件 SCRIPT_NAME
 * @method string root($root = null) 获取URL访问根地址
 * @method string pathinfo() 获取当前请求URL的pathinfo信息（含URL后缀）
 * @method string path() 获取当前请求URL的pathinfo信息\(不含URL后缀\)
 * @method string ext() 当前URL的访问后缀
 * @method string time($float = false) 获取当前请求的时间
 * @method string type() 当前请求的资源类型
 * @method string mimeType($type, $val = '') 当前请求的资源类型
 * @method string method($method = false) 当前的请求类型
 * @method boolean isGet() 是否为GET请求
 * @method boolean isPost() 是否为POST请求
 * @method boolean isPut() 是否为PUT请求
 * @method boolean isDelete() 是否为DELETE请求
 * @method boolean isHead() 是否为HEAD请求
 * @method boolean isPatch() 是否为PATCH请求
 * @method boolean isOptions() 是否为OPTIONS请求
 * @method boolean isCli() 是否为cli
 * @method boolean isCgi() 是否为cgi
 * @method mixed param($name = '', $default = null, $filter = null) 设置获取获取当前请求的参数
 * @method mixed route($name = '', $default = null, $filter = null) 设置获取获取路由参数
 * @method mixed get($name = '', $default = null, $filter = null) 设置获取获取GET参数
 * @method mixed post($name = '', $default = null, $filter = null) 设置获取获取POST参数
 * @method mixed put($name = '', $default = null, $filter = null) 设置获取获取PUT参数
 * @method mixed delete($name = '', $default = null, $filter = null) 设置获取获取DELETE参数
 * @method mixed patch($name = '', $default = null, $filter = null) 设置获取获取PATCH参数
 * @method mixed request($name = '', $default = null, $filter = null) 获取request变量
 * @method mixed session($name = '', $default = null, $filter = null) 获取session数据
 * @method mixed cookie($name = '', $default = null, $filter = null) 获取cookie参数
 * @method mixed server($name = '', $default = null, $filter = null) 获取server参数
 * @method null|array|\think\File file($name = '') 获取上传的文件信息
 * @method mixed env($name = '', $default = null, $filter = null) 获取环境变量
 * @method string header($name = '', $default = null) 设置或者获取当前的Header
 * @method mixed input($data = [], $name = '', $default = null, $filter = null) 获取变量 支持过滤和默认值
 * @method mixed filter($filter = null) 设置或获取当前的过滤规则
 * @method void filterExp(&$value) 过滤表单中的表达式
 * @method boolean has($name, $type = 'param', $checkEmpty = false) 是否存在某个请求参数
 * @method mixed only($name, $type = 'param') 获取指定的参数
 * @method mixed except($name, $type = 'param') 排除指定参数获取
 * @method boolean isSsl() 当前是否ssl
 * @method boolean isAjax($ajax = false) 当前是否Ajax请求
 * @method boolean isPjax($pjax = false) 当前是否Pjax请求
 * @method mixed ip($type = 0, $adv = false) 获取客户端IP地址
 * @method boolean isMobile() 检测是否使用手机访问
 * @method string scheme() 当前URL地址中的scheme参数
 * @method string query() 当前请求URL地址中的query参数
 * @method string host() 当前请求的host
 * @method string port() 当前请求URL地址中的port参数
 * @method string protocol() 当前请求 SERVER_PROTOCOL
 * @method string remotePort() 当前请求 REMOTE_PORT
 * @method array routeInfo($route = []) 获取当前请求的路由信息
 * @method array dispatch($dispatch = null) 设置或者获取当前请求的调度信息
 * @method string module($module = null) 设置或者获取当前的模块名
 * @method string controller($controller = null) 设置或者获取当前的控制器名
 * @method string action($action = null) 设置或者获取当前的操作名
 * @method string langset($lang = null) 设置或者获取当前的语言
 * @method string getContent() 设置或者获取当前请求的content
 * @method string getInput() 获取当前请求的php://input
 * @method string token($name = '__token__', $type = 'md5') 生成请求令牌
 * @method mixed cache($key, $expire = null) 读取或者设置缓存
 * @method array getCache() 读取缓存设置
 * @method mixed bind($name, $obj = null) 设置当前请求绑定的对象实例 *
 */
abstract class BaseRequest
{
    /**
     * @var static 对象实例
     */
    protected static $instance;

    /**
     * @var \think\Request
     */
    protected $request;

    /**
     * 禁止外部实例化
     */
    protected function __construct()
    {

    }

    /**
     * 获取单例
     * @param array $options
     * @return static
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        self::$instance->setRequest($options);
        return self::$instance;
    }

    /**
     * 设置Request对象
     * @param array $options
     */
    private function setRequest($options = [])
    {
        $this->request = \think\Request::instance($options);
    }

    /**
     * 创建一个URL请求
     * @access public
     * @param string $uri    URL地址
     * @param string $method 请求类型
     * @param array  $params 请求参数
     * @param array  $cookie
     * @param array  $files
     * @param array  $server
     * @param string $content
     * @return static
     */
    public static function create($uri, $method = 'GET', $params = [], $cookie = [], $files = [], $server = [], $content = null)
    {
        \think\Request::create($uri, $method, $params, $cookie, $files, $server, $content);
        return self::instance();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->request, $name], $arguments);
    }

    public function __set($name, $value)
    {
        $this->request->$name = $value;
    }

    public function __get($name)
    {
        return $this->request->$name;
    }

    public function __isset($name)
    {
        return isset($this->request->$name);
    }
}