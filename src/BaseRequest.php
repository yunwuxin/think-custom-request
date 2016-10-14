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
     * @param string $uri URL地址
     * @param string $method 请求类型
     * @param array $params 请求参数
     * @param array $cookie
     * @param array $files
     * @param array $server
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