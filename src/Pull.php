<?php
namespace Bee\Deploy;

use GuzzleHttp\Client;

/**
 * 从远程服务拉取配置
 *
 * @package Bee\Deploy
 */
class Pull
{
    /**
     * @var array
     */
    protected $server = [];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $path = '';

    /**
     * Pull constructor.
     *
     * @param array $server
     * @param $path
     */
    public function __construct(array $server, $path)
    {
        $this->server = $server;
        $this->path   = $path;
    }

    /**
     * 执行
     *
     * @param $env
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function run($env)
    {
        // 获取指定配置元数据
        $config = $this->getMate($env);

        // 获取具体配置项，生成生成配置文件
        foreach ($config as $key => $item) {
            $name    = $item['name'];
            $mapping = [];

            foreach ($item['mapping'] as $type => $id) {
                $mapping[$type] = $this->getItem($id);
            }

            $this->build($name, $mapping);
        }
    }

    /**
     * 获取元数据
     *
     * @param $alias
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getMate($alias)
    {
        $client = new Client(
            [
                // Base URI is used with relative requests
                'base_uri' => $this->server['host'],
                // You can set any number of default request options.
                'timeout'  => 2.0,
            ]
        );

        $response = $client->request(
            'GET',
            "/runtime/mate/{$alias}",
            [
                'headers' => ['token' => $this->server['token']],
            ]
        );

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * 获取指定项数据
     *
     * @param $alias
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getItem($alias)
    {
        $client = new Client(
            [
                // Base URI is used with relative requests
                'base_uri' => $this->server['host'],
                // You can set any number of default request options.
                'timeout'  => 2.0,
            ]
        );

        $response = $client->request(
            'GET',
            "/runtime/item/{$alias}",
            [
                'headers' => ['token' => $this->server['token']],
            ]
        );

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * 获取并构建配置文件
     *
     * @param $name
     * @param $mapping
     */
    private function build($name, array $mapping)
    {
        // 创建runtime目录
        is_dir($this->path) or mkdir($this->path, 0755);

        $config = [];

        foreach ($mapping as $key => $item) {
            $path    = explode('.', $key);
            $pointer = &$config;

            foreach ($path as $level) {
                if (!isset($pointer[$level])) {
                    $pointer[$level] = [];
                }

                $pointer = &$pointer[$level];
            }

            $pointer = $item;
        }

        $filename = $this->path . '/' . $name;
        $content  = '<?php return ' . var_export($config, true) . ';';
        file_put_contents($filename, $content);
    }
}