<?php 
/**
 * upload��local��ʽ������
*/
class local {
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
     * ���캯�������������ϴ���·��
     */
    public function __construct($config = null){

    }

    /**
     * ����ϴ���Ŀ¼
     * @param string $rootpath   ��Ŀ¼
     * @return boolean true-���ͨ����false-���ʧ��
     */
    public function checkRootPath($rootpath){
        if(!(is_dir($rootpath) && is_writable($rootpath))){
            $this->error = '�ϴ���Ŀ¼�����ڣ��볢���ֶ�����:'.$rootpath;
            return false;
        }
        $this->rootPath = $rootpath;
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
            /* ���Ŀ¼�Ƿ��д */
            if (!is_writable($this->rootPath . $savepath)) {
                $this->error = '�ϴ�Ŀ¼ ' . $savepath . ' ����д��';
                return false;
            } else {
                return true;
            }
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
        if (!move_uploaded_file($file['tmp_name'], $filename)) {
            $this->error = '�ļ��ϴ��������';
            return false;
        }
        chmod($filename, 0777);
        return true;
    }

    /**
     * ����Ŀ¼
     * @param  string $savepath Ҫ����������
     * @return boolean          ����״̬��true-�ɹ���false-ʧ��
     */
    public function mkdir($savepath){
        $dir = $this->rootPath . $savepath;
        if(is_dir($dir)){
            return true;
        }

        if(mkdir($dir, 0777, true)){
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
}
