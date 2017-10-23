<?PHP

/*
	[QQ405214421������ѩ!] (C)2007-2012 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms
    Զ���ļ��ϴ�
	$RCSfile: url_upload.cs.php,v $
	$Revision: 1.0 $
	$Date: 2010/07/05 12:00:00 $
*/
class UrlUpload
{
    var $remote_file; # ���ϴ���Զ���ļ�
	var $local_dir;   # �ϴ��ļ�����ı���Ŀ¼
	var $local_isdir = true; #�Ƿ��������ļ���
	var $local_dirFormat = 'Y/m/d';  # �Զ������ļ��еĸ�ʽ
	var $local_file;  # �ϴ��ļ�����ı����ļ���[������Ϊԭʼ�ļ���]
	var $local_rename = true; #�Ƿ��������ļ�
	var $file_expan = 'jpg,jpeg,gif,png,bmp'; #�����ϴ��ļ�����չ��
	var $upfile_file_error = 0;
	
	function UrlUpload($remote_file,$file_expan ='')
	{
	    $this->remote_file = $remote_file;
		$this->file_expan  = !empty($file_expan) ? $file_expan : $this->file_expan;
	}
	/*
	param $local_dir  ͼƬ�洢�ı���Ŀ¼
	     $local_file ָ���ļ������棬�Ḳ������������
		 getfile($local_dir='./',$local_file ='')
	*/
	function upfile($local_dir='.',$local_file ='')
	{
		$this->local_dir     = empty($local_dir) ? '' : $local_dir.'/';
		$this->local_file    = $local_file;
		include_once(JIEQI_ROOT_PATH.'/lib/text/textfunction.php');
		$colary=array('repeat'=>2, 'referer'=>1,'charset'=>'image');
		$upfile_file_path = $this->getFilename();
		if(!jieqi_writefile($upfile_file_path, jieqi_urlcontents($this->remote_file,$colary))) $this -> upfile_file_error = 6;
		$fileinfo = @pathinfo($upfile_file_path);
        $up_file_return = array(
			"upfile_file_error"      => $this -> upfile_file_error,  //�ϴ�״̬
			"upfile_file_newname"    => $fileinfo['basename'],        //�ϴ�������ļ���
			"upfile_file_path"       => str_replace('\\', '/', realpath($upfile_file_path)),           //�ϴ����ڷ�������·��
			"upload_file_name"       => basename($this->remote_file),        //�ϴ��ļ���
			"upload_file_extname"    => $fileinfo['extension'],        //�ϴ��ļ���չ��
			"upload_file_size"       => filesize($upfile_file_path)            //�ϴ��ļ���С
		);
		return $up_file_return;
	}
	
	function getFilename()
	{
	    if($this->local_file!=''){
		   $filename = basename($this->local_file);
		   $this->local_dir.=str_replace($filename,'',$this->local_file);
		} else {
		   $file_type = explode(",", $this->file_expan);
		   $upload_file_extname = strtolower(substr(strrchr($this->remote_file,'.'),1));
		   if(in_array($upload_file_extname , $file_type) == false){
                // ���ϴ��ļ���չ��������Ҫ��
                $this -> upfile_file_error = 3;
           }
		   if($this->local_isdir) $this->local_dir=$this->local_dir.date($this->local_dirFormat,time())."/";
		   
		   if($this->local_rename){
		     $filename = date('his',time()).rand(1000,4).".$upload_file_extname";
		   } else {
		     $filename = basename($this->remote_file);
		   }
		}
		jieqi_createdir($this->local_dir, 0777, true);
		return $this->local_dir.$filename;
	}
}
?>