<?php
/**
 * FTP�ϴ�����
 */
class ftp {
    /**
     * �ϴ��ļ���Ŀ¼
     * @var string
     */
    public $rootPath;

    /**
     * �����ϴ�������Ϣ
     * @var string
     */
    private $error = ''; //�ϴ�������Ϣ

    /**
     * FTP����
     * @var resource
     */
    private $link;

    private $config = array(
        'host'     => '', //������
        'port'     => 21, //�˿�
        'timeout'  => 90, //��ʱʱ��
        'username' => '', //�û���
        'password' => '', //����
    );

    /**
     * ���캯�������������ϴ���·��
     * @param array  $config FTP����
     */
    public function __construct($config = null){
        /* Ĭ��FTP���� */
        if (!is_null($config) && !empty($config)) {
        	$this->config = array_merge($this->config, $config);
        }
        

        /* ��¼FTP������ */
        if(!$this->login()){
            throw new Exception($this->error);
        }
    }

    /**
     * ����ϴ���Ŀ¼
     * @param string $rootpath   ��Ŀ¼
     * @return boolean true-���ͨ����false-���ʧ��
     */
    public function checkRootPath($rootpath){
        /* ���ø�Ŀ¼ */
        $this->rootPath = ftp_pwd($this->link) . '/' . ltrim($rootpath, '/');
        if(!@ftp_chdir($this->link, $this->rootPath)){
            $this->error = '�ϴ���Ŀ¼�����ڣ�';
            return false;
        }
        return true;
    }

    /**
     * ����ϴ�Ŀ¼
     * @param  string $savepath �ϴ�Ŀ¼
     * @return boolean          �������true-ͨ����false-ʧ��
     */
    public function checkSavePath($savepath){
        /* ��Ⲣ����Ŀ¼ */
        if (!$this->mkdir($savepath)) {
            return false;
        } else {
            //TODO:���Ŀ¼�Ƿ��д
            return true;
        }
    }

    /**
     * ����ָ���ļ�
     * @param  array   $file    ������ļ���Ϣ
     * @param  boolean $replace ͬ���ļ��Ƿ񸲸�
     * @return boolean          ����״̬��true-�ɹ���false-ʧ��
     */
    public function save($file, $replace=true) {
        $filename = $this->rootPath . $file['savepath'] . $file['savename'];

        /* ������ͬ���ļ� */
           if (!$replace && is_file($filename)) {
               $this->error = '����ͬ���ļ�' . $file['savename'];
               return false;
           }

        /* �ƶ��ļ� */
        if (!ftp_put($this->link, $filename, $file['tmp_name'], FTP_BINARY)) {
            $this->error = '�ļ��ϴ��������';
            return false;
        }
        return true;
    }

    /**
     * ����Ŀ¼
     * @param  string $savepath Ҫ����������
     * @return boolean          ����״̬��true-�ɹ���false-ʧ��
     */
    public function mkdir($savepath){
        $dir = $this->rootPath . $savepath;
        if(ftp_chdir($this->link, $dir)){
            return true;
        }

        if(ftp_mkdir($this->link, $dir)){
            return true;
        } elseif($this->mkdir(dirname($savepath)) && ftp_mkdir($this->link, $dir)) {
            return true;
        } else {
            $this->error = "Ŀ¼ {$savepath} ����ʧ�ܣ�";
            return false;
        }
    }

    /**
     * ��ȡ���һ���ϴ�������Ϣ
     * @return string ������Ϣ
     */
    public function getError(){
        return $this->error;
    }

    /**
     * ��¼��FTP������
     * @return boolean true-��¼�ɹ���false-��¼ʧ��
     */
    private function login(){
        extract($this->config);
        $this->link = ftp_connect($host, $port, $timeout);
        if($this->link) {
            if (ftp_login($this->link, $username, $password)) {
               return true;
            } else {
                $this->error = "�޷���¼��FTP��������username - {$username}";
            }
        } else {
            $this->error = "�޷����ӵ�FTP��������{$host}";
        }
        return false;
    }

    /**
     * �������������ڶϿ���ǰFTP����
     */
    public function __destruct() {
        ftp_close($this->link);
    }

}
