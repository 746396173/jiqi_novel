<?php 
/**
 * �ϴ��ļ��Զ�����
 * @author liuxiangbin
 * @create 2015-03-25 15:27:15
 */
class MyUpload {
	 /**
     * Ĭ���ϴ�����
     * @var array
     */
    private $config = array(
        'mimes'         =>  array('text','image','application','audio'), //�����ϴ����ļ�MiMe����
        'maxSize'       =>  2097152, //�ϴ����ļ���С���� (0-��������)
        'exts'          =>  array('doc','docx','xls','ppt','wps','zip','rar','txt','jpg','jpeg','gif','bmp','swf','png'), //�����ϴ����ļ���׺
        'autoSub'       =>  true, //�Զ���Ŀ¼�����ļ�
        'subName'       =>  array('date', 'Ymd'), //��Ŀ¼������ʽ��[0]-��������[1]-�������������ʹ������
        'rootPath'      =>  JIEQI_ROOT_PATH, //�����·��
        'savePath'      =>  '/attachment/', //����·��
        'saveName'      =>  array('uniqid', ''), //�ϴ��ļ���������[0]-��������[1]-�������������ʹ������
        'saveExt'       =>  '', //�ļ������׺������ʹ��ԭ��׺
        'replace'       =>  true, //����ͬ���Ƿ񸲸�
        'hash'          =>  true, //�Ƿ�����hash����
        'callback'      =>  false, //����ļ��Ƿ���ڻص���������ڷ����ļ���Ϣ����
        'driver'        =>  'local', // �ļ��ϴ�����
        'driverConfig'  =>  array(), // �ϴ���������
    );

    /**
     * �ϴ�������Ϣ
     * @var string
     */
    private $error = ''; //�ϴ�������Ϣ

    /**
     * �ϴ�����ʵ��
     * @var Object
     */
    private $uploader;

    /**
     * ʹ�� $this->name ��ȡ����
     * @param  string $name ��������
     * @return multitype    ����ֵ
     */
    public function __get($name) {
        return $this->config[$name];
    }

    public function __set($name,$value){
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
            if($name == 'driverConfig'){
                //�ı��������ú������ϴ�����
                //ע�⣺����ѡ�ı�����Ȼ���ٸı���������
                $this->setDriver(); 
            }
        }
    }

    public function __isset($name){
        return isset($this->config[$name]);
    }

    /**
     * ��ȡ���һ���ϴ�������Ϣ
     * @return string ������Ϣ
     */
    public function getError(){
        return $this->error;
    }

    /**
     * �ϴ������ļ�
     * @param  array  $file �ļ�����
     * @return array        �ϴ��ɹ�����ļ���Ϣ
     */
    public function uploadOne($file){
        $info = $this->upload(array($file));
        return $info ? $info[0] : $info;
    }

    /**
     * �ϴ��ļ�
     * @param �ļ���Ϣ���� $files ��ͨ���� $_FILES����
     */
    public function upload($driver='local', $files='') {
//  	print_r($_FILES);
//		echo '<br />';
//		print_r($this->config);die;
    	$this->setDriver($driver);
//  	var_dump($this->config);die;
        if('' === $files){
            $files  =   $_FILES;
        }
        if(empty($files)){
            $this->error = 'û���ϴ����ļ���';
            return false;
        }
//		print_r($this->rootPath);die;
        $this->uploader->rootPath=$this->rootPath;
        /* ����ϴ���Ŀ¼ */
        //if(!$this->uploader->checkRootPath($this->rootPath)){
            //$this->error = $this->uploader->getError();
           // return false;
        //}

        /* ����ϴ�Ŀ¼ */
        if(!$this->uploader->checkSavePath($this->savePath)){
            $this->error = $this->uploader->getError();
            return false;
        }

        /* �����Ⲣ�ϴ��ļ� */
        $info    =  array();
		
        // ���ϴ��ļ�������Ϣ����
        $files   =  $this->dealFiles($files);    
        foreach ($files as $key => $file) {
            $file['name']  = strip_tags($file['name']);
            if(!isset($file['key']))   $file['key']    =   $key;
			
			/* ��ȡ�ϴ��ļ���mime���� */
			$tmp_type = explode('/', $file['type']);
			$file['type'] = $tmp_type[0];
			
            /* ��ȡ�ϴ��ļ���׺�������ϴ��޺�׺�ļ� */
            $file['ext']    =   pathinfo($file['name'], PATHINFO_EXTENSION);

            /* �ļ��ϴ���� */
            if (!$this->check($file)){
                continue;
            }

            /* ��ȡ�ļ�hash */
            if($this->hash){
                $file['md5']  = md5_file($file['tmp_name']);
                $file['sha1'] = sha1_file($file['tmp_name']);
            }

            /* ���ûص���������ļ��Ƿ���� */
//          $data = call_user_func($this->callback, $file);
//          if( $this->callback && $data ){
//              if ( file_exists('.'.$data['path'])  ) {
//                  $info[$key] = $data;
//                  continue;
//              }elseif($this->removeTrash){
//                  call_user_func($this->removeTrash,$data);//ɾ��������
//              }
//          }

            /* ���ɱ����ļ��� */
            $savename = $this->getSaveName($file);
            if(false == $savename){
                continue;
            } else {
                $file['savename'] = $savename;
            }

            /* ��Ⲣ������Ŀ¼ */
            $subpath = $this->getSubPath($file['name']);
            if(false === $subpath){
                continue;
            } else {
                $file['savepath'] = $this->savePath . $subpath;
            }

            /* ��ͼ���ļ������ϸ��� */
            $ext = strtolower($file['ext']);
            if(in_array($ext, array('gif','jpg','jpeg','bmp','png','swf'))) {
                $imginfo = getimagesize($file['tmp_name']);
                if(empty($imginfo) || ($ext == 'gif' && empty($imginfo['bits']))){
                    $this->error = '�Ƿ�ͼ���ļ���';
                    continue;
                }
            }

            /* �����ļ� ����¼����ɹ����ļ� */
            if ($this->uploader->save($file,$this->replace)) {
                unset($file['error'], $file['tmp_name']);
                $info[$key] = $file;
            } else {
                $this->error = $this->uploader->getError();
            }
        }

        return empty($info) ? false : $info;
    }

    /**
     * ת���ϴ��ļ��������Ϊ��ȷ�ķ�ʽ
     * @access private
     * @param array $files  �ϴ����ļ�����
     * @return array
     */
    private function dealFiles($files) {
        $fileArray  = array();
        $n          = 0;
        foreach ($files as $key=>$file){
            if(is_array($file['name'])) {
                $keys       =   array_keys($file);
                $count      =   count($file['name']);
                for ($i=0; $i<$count; $i++) {
                    $fileArray[$n]['key'] = $key;
                    foreach ($keys as $_key){ ;
                    }
                    $n++;
                }
            }else{
               $fileArray = $files;
               break;
            }
        }
       return $fileArray;
    }

    /**
     * �����ϴ�����
     * @param string $driver ��������
     * @param array $config ��������     
     */
    private function setDriver($driver = null){
        $class = !is_null($driver) ? $driver : 'local';
		if ('ftp'===$class) $this->rootPath = '';
		require(JIEQI_ROOT_PATH.'/lib/upload/'.$class.'.php');
        $this->uploader = new $class($this->config['driverConfig']);
        if(!$this->uploader){
            E("�������ϴ�������{$name}");
        }
    }

    /**
     * ����ϴ����ļ�
     * @param array $file �ļ���Ϣ
     */
    private function check($file) {
        /* �ļ��ϴ�ʧ�ܣ����������� */
        if ($file['error']) {
            $this->error($file['error']);
            return false;
        }

        /* ��Ч�ϴ� */
        if (empty($file['name'])){
            $this->error = 'δ֪�ϴ�����';
        }

        /* ����Ƿ�Ϸ��ϴ� */
        if (!is_uploaded_file($file['tmp_name'])) {
            $this->error = '�Ƿ��ϴ��ļ���';
            return false;
        }

        /* ����ļ���С */
        if (!$this->checkSize($file['size'])) {
            $this->error = '�ϴ��ļ���С������';
            return false;
        }

        /* ����ļ�Mime���� */
        //TODO:FLASH�ϴ����ļ���ȡ����mime���Ͷ�Ϊapplication/octet-stream
        if (!$this->checkMime($file['type'])) {
            $this->error = '�ϴ��ļ�MIME���Ͳ�����';
            return false;
        }

        /* ����ļ���׺ */
        if (!$this->checkExt($file['ext'])) {
            $this->error = '�ϴ��ļ���׺������';
            return false;
        }

        /* ͨ����� */
        return true;
    }


    /**
     * ��ȡ���������Ϣ
     * @param string $errorNo  �����
     */
    private function error($errorNo) {
        switch ($errorNo) {
            case 1:
                $this->error = '�ϴ����ļ������� php.ini �� upload_max_filesize ѡ�����Ƶ�ֵ��';
                break;
            case 2:
                $this->error = '�ϴ��ļ��Ĵ�С������ HTML ���� MAX_FILE_SIZE ѡ��ָ����ֵ��';
                break;
            case 3:
                $this->error = '�ļ�ֻ�в��ֱ��ϴ���';
                break;
            case 4:
                $this->error = 'û���ļ����ϴ���';
                break;
            case 6:
                $this->error = '�Ҳ�����ʱ�ļ��У�';
                break;
            case 7:
                $this->error = '�ļ�д��ʧ�ܣ�';
                break;
            default:
                $this->error = 'δ֪�ϴ�����';
        }
    }

    /**
     * ����ļ���С�Ƿ�Ϸ�
     * @param integer $size ����
     */
    private function checkSize($size) {
        return !($size > $this->maxSize) || (0 == $this->maxSize);
    }

    /**
     * ����ϴ����ļ�MIME�����Ƿ�Ϸ�
     * @param string $mime ����
     */
    private function checkMime($mime) {
        return empty($this->config['mimes']) ? true : in_array(strtolower($mime), $this->mimes);
    }

    /**
     * ����ϴ����ļ���׺�Ƿ�Ϸ�
     * @param string $ext ��׺
     */
    private function checkExt($ext) {
        return empty($this->config['exts']) ? true : in_array(strtolower($ext), $this->exts);
    }

    /**
     * �����ϴ��ļ���������ȡ�ñ����ļ���
     * @param string $file �ļ���Ϣ
     */
    private function getSaveName($file) {
//  	echo '<pre>';
//  	var_dump($this->saveName);
//		echo '<pre />';
//		die;
        $rule = $this->saveName;
        if (empty($rule)) { //�����ļ�������
            /* ���pathinfo�����ļ���BUG */
            $filename = substr(pathinfo("_{$file['name']}", PATHINFO_FILENAME), 1);
            $savename = $filename;
        } elseif (is_string($rule) || is_numeric($rule)) {
            $savename = $rule;
        } else {
        	$savename = $this->getName($rule, $file['name']);
        	if(empty($savename)){
                $this->error = '�ļ������������';
                return false;
            }
        }

        /* �ļ������׺��֧��ǿ�Ƹ����ļ���׺ */
        $ext = empty($this->config['saveExt']) ? $file['ext'] : $this->saveExt;

        return $savename . '.' . $ext;
    }

    /**
     * ��ȡ��Ŀ¼������
     * @param array $file  �ϴ����ļ���Ϣ
     */
    private function getSubPath($filename) {
        $subpath = '';
        $rule    = $this->subName;
        if ($this->autoSub && !empty($rule)) {
            $subpath = $this->getName($rule, $filename) . '/';

            if(!empty($subpath) && !$this->uploader->mkdir($this->savePath . $subpath)){
                $this->error = $this->uploader->getError();
                return false;
            }
        }
        return $subpath;
    }

    /**
     * ����ָ���Ĺ����ȡ�ļ���Ŀ¼����
     * @param  array  $rule     ����
     * @param  string $filename ԭ�ļ���
     * @return string           �ļ���Ŀ¼����
     */
    private function getName($rule, $filename){
        $name = '';
        if(is_array($rule)){ //�������
            $func     = $rule[0];
            $param    = (array)$rule[1];
            foreach ($param as &$value) {
               $value = str_replace('__FILE__', $filename, $value);
            }
            $name = call_user_func_array($func, $param);
        } elseif (is_string($rule)){ //�ַ�������
            if(function_exists($rule)){
                $name = call_user_func($rule);
            } else {
                $name = $rule;
            }
        }
        return $name;
    }
}

