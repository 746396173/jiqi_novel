<?php
/**
 * Created by PhpStorm.
 * User: ludianjun
 * Date: 15/12/31
 * Time: ����4:12
 */
class MyRedis {

    public $redis;

    /**
     * @param string $host
     * @param int $post
     */
    public function __construct($host = JIEQI_REDIS_HOST, $port = JIEQI_REDIS_PORT) {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
        return $this->redis;
    }

    /**
     * ����ֵ  ����һ���ַ���
     * @param string $key KEY����
     * @param string $value  ����ֵ
     * @param int $timeOut ʱ��  0��ʾ�޹���ʱ��
     */
    public function set($key, $value, $timeOut=0) {
        $retRes = $this->redis->set($key, $value);
        if ($timeOut > 0)
            $this->redis->expire($key, $timeOut);
        return $retRes;
    }

    /*
     * ����һ������(���򼯺�)
     * @param string $key ����Y����
     * @param string|array $value  ֵ
     */
    public function sadd($key,$value){
        return $this->redis->sadd($key,$value);
    }

    /*
     * ����һ������(���򼯺�)
     * @param string $key ��������
     * @param string|array $value  ֵ
     */
    public function zadd($key,$value){
        return $this->redis->zadd($key,$value);
    }

    /**
     * ȡ���϶�ӦԪ��
     * @param string $setName ��������
     */
    public function smembers($setName){
        return $this->redis->smembers($setName);
    }

    /**
     * ����һ���б�(�Ƚ���ȥ������ջ)
     * @param sting $key KEY����
     * @param string $value ֵ
     */
    public function lpush($key,$value){
        return $this->redis->LPUSH($key,$value);
    }

    /**
     * ����һ���б�(�Ƚ���ȥ�����ƶ���)
     * @param sting $key KEY����
     * @param string $value ֵ
     */
    public function rpush($key,$value){
        return $this->redis->rpush($key,$value);
    }
    /**
     * ��ȡ�����б����ݣ���ͷ��βȡ��
     * @param sting $key KEY����
     * @param int $head  ��ʼ
     * @param int $tail     ����
     */
    public function lranges($key,$head,$tail){
        return $this->redis->lrange($key,$head,$tail);
    }

    /**
     * HASH����
     * @param string $tableName  ������key
     * @param string $key            �ֶ�����
     * @param sting $value          ֵ
     */
    public function hset($tableName,$field,$value){
        return $this->redis->hset($tableName,$field,$value);
    }

    public function hget($tableName,$field){
        return $this->redis->hget($tableName,$field);
    }


    /**
     * ���ö��ֵ
     * @param array $keyArray KEY����
     * @param string|array $value ��ȡ�õ�������
     * @param int $timeOut ʱ��
     */
    public function sets($keyArray, $timeout) {
        if (is_array($keyArray)) {
            $retRes = $this->redis->mset($keyArray);
            if ($timeout > 0) {
                foreach ($keyArray as $key => $value) {
                    $this->redis->expire($key, $timeout);
                }
            }
            return $retRes;
        } else {
            return "Call  " . __FUNCTION__ . " method  parameter  Error !";
        }
    }

    /**
     * ͨ��key��ȡ����
     * @param string $key KEY����
     */
    public function get($key) {
        $result = $this->redis->get($key);
        return $result;
    }

    /**
     * ͬʱ��ȡ���ֵ
     * @param ayyay $keyArray ��key��ֵ
     */
    public function gets($keyArray) {
        if (is_array($keyArray)) {
            return $this->redis->mget($keyArray);
        } else {
            return "Call  " . __FUNCTION__ . " method  parameter  Error !";
        }
    }

    /**
     * ��ȡ����key��������ֵ
     */
    public function keyAll() {
        return $this->redis->keys('*');
    }

    /**
     * ɾ��һ������key
     * @param string $key ɾ��KEY������
     */
    public function del($key) {
        return $this->redis->delete($key);
    }

    /**
     * ͬʱɾ�����key����
     * @param array $keyArray KEY����
     */
    public function dels($keyArray) {
        if (is_array($keyArray)) {
            return $this->redis->del($keyArray);
        } else {
            return "Call  " . __FUNCTION__ . " method  parameter  Error !";
        }
    }

    /**
     * ��������
     * @param string $key KEY����
     */
    public function increment($key) {
        return $this->redis->incr($key);
    }

    /**
     * �����Լ�
     * @param string $key KEY����
     */
    public function decrement($key) {
        return $this->redis->decr($key);
    }


    /**
     * �ж�key�Ƿ����
     * @param string $key KEY����
     */
    public function isExists($key){
        return $this->redis->exists($key);
    }

    /**
     * ������- ���ҽ���newkey������ʱ����key��Ϊnewkey ����newkey����ʱ��ᱨ��ŶRENAME
     *  �� rename��һ��������ֱ�Ӹ��£����ڵ�ֵҲ��ֱ�Ӹ��£�
     * @param string $Key KEY����
     * @param string $newKey ��key����
     */
    public function updateName($key,$newKey){
        return $this->redis->RENAMENX($key,$newKey);
    }

    /**
     * ��ȡKEY�洢��ֵ����
     * none(key������) int(0)  string(�ַ���) int(1)   list(�б�) int(3)  set(����) int(2)   zset(����) int(4)    hash(��ϣ��) int(5)
     * @param string $key KEY����
     */
    public function dataType($key){
        return $this->redis->type($key);
    }


    /**
     * �������
     */
    public function flushAll() {
        return $this->redis->flushAll();
    }

    /**
     * ����redis����
     * redis�зǳ���Ĳ�������������ֻ��װ��һ����
     * �����������Ϳ���ֱ�ӵ���redis������
     * eg:$redis->redisOtherMethods()->keys('*a*')   keys����û��
     */
    public function redisOtherMethods() {
        return $this->redis;
    }

    public function hIncrBy($key, $hashKey, $value) {
        return $this->redis->hIncrBy( $key, $hashKey, $value );
    }
}