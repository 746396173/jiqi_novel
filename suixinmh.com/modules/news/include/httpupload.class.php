<?php
        //�ļ��ϴ��࣬ʹ�÷���������Ҫ��
/*      if($_POST[Submit]){
     // require_once "upload_class.php";
      // ��file�������� Ĭ��Ϊfile
      $formname = "up_file";
      // �ϴ�����λ�ã�Ĭ��Ϊ��ǰ�ļ��С�./��
      $savepath = "../../../attachment";
      // �ϴ��ļ�Ҫ���mime���ͣ�Ĭ��Ϊtext,image
      $mimetype = "text,image,application,audio";
      // �ļ���չ��Ҫ��Ĭ��Ϊ��jpg,bmp,png,gif,jpeg��
      $fileextname = "doc,docx,xls,ppt,wps,zip,rar,txt,jpg,jpeg,gif,bmp,swf,png";
      // �ļ���СҪ��Ĭ��Ϊ512000 ��500K��
      $maxsize = 1024000;
      // �Ƿ���������0Ϊ����������1Ϊ��������Ĭ��Ϊ1
      $filerename = 1;
      // �����������ļ���
      $savedir = date('Y/md', time());
      // �����ò������������ļ�����ʱ�Ƿ񸲸� 0Ϊ�����ǣ�1Ϊ���ǲ��ϴ���2Ϊ���������ϴ�
      $overwrite = 1;
      $upload = new http_upload($formname, $savepath, $mimetype , $fileextname, $maxsize, $filerename, $savedir, $overwrite);
	  //$upload->__set("upload_filename",$savepath."/2010/0423/aa.jpg");
      $up = $upload -> upfile();
      // �ϴ����
      echo("�ϴ�����ֵ��" . $up[upfile_file_error] . "<br>");
      echo("ԭ�ļ���Ϊ��" . $up[upload_file_name] . "<br>");
      echo("���ļ���Ϊ��" . $up[upfile_file_newname] . "<br>");
      echo("�ϴ�������·����" . realpath($up[upfile_file_path]) . "<br>");
      echo("�ļ�mime����Ϊ��" . $up[upload_mime_types] . "<br>");
      echo("�ļ���չ����" . $up[upload_file_extname] . "<br>");
      echo("���ļ�������ʱ���ǽ����" . $up[upload_file_overwrite] . "<br>");
      echo("�ļ���С��" . $up[upload_file_size] . "<br>");
      }
	  //echo basename('/2010/0423/201004230401539482.doc');
      if($up[upload_file_size] == ""){
      echo("<form id=\"form\" name=\"form\" method=\"post\" action=\"\" enctype=\"multipart/form-data\">");
      echo("<input name=\"up_file\" type=\"file\" id=\"up_file\" />");
      echo("<input type=\"submit\" name=\"Submit\" value=\"�ύ\" />");
      echo("</form>");
      }   */
class HttpUpload{
  
    // ����������
    var $upload_formname = 'file';
    
    // �ϴ�·��
    var $upload_savepath = './';
    
    // �ϴ�mime����
    var $upload_mimetype = 'text,image,application,audio';
    
    // �ϴ�����
    var $upload_fileextname = 'doc,docx,xls,ppt,wps,zip,rar,txt,jpg,jpeg,gif,bmp,swf,png';
    
    // �����ļ���С/2MB
    var $upload_maxsize;
    
    // ָ���ļ��� Ϊ�յ�ʱ����������Ϊ�ļ���
    var $upload_filename;
    
    // �ϴ��ļ��Ƿ������� 0Ϊ�� 1Ϊ��
    var $upload_filerename = true;
    
    // �ļ��洢Ŀ¼
    var $upload_savedir;
    
    // �������
    var $upfile_file_error = 0;
	
    // �����ò������������ļ�����ʱ�Ƿ񸲸� 0Ϊ�����ǣ�1Ϊ���ǲ��ϴ���2Ϊ���������ϴ�
    var $upload_overwrite = 0;

///////////////////�ڲ����в���///////////////////////
	//�ϴ�������
	var $upload_file;
   
    // �ϴ��ļ�����
    var $upload_file_name;	 

    // �ϴ��ļ���չ��
    var $upload_file_extname;
	
	// �ϴ��ļ���ʱ�ļ�����λ��
    var $upload_file_tmpname;

	// ��ȡ�ϴ��ļ�mime���
    var $upload_mime_types,$upload_mime_type;

	// ��ȡ�ϴ��ļ���С
    var $upload_file_size;
			
	function __set($sttribName,$value)
	{
	   $this->$sttribName=$value;
	}
	
	function __get($sttribName)
	{
	   return $this->$sttribName;
	}
	
    function HttpUpload($formname, $savepath, $mimetype, $fileextname, $maxsize, $filerename, $datedir, $overwrite){
        // Ĭ�ϱ�file��������Ϊfile
        if(isset($formname))  $this->__set("formname",$formname);
        // Ĭ���ϴ�·��Ϊ��ǰĿ¼
        if(isset($savepath)) $this->__set("upload_savepath",$savepath);

        // Ĭ���ϴ��ļ�mime����Ϊtext��image
        if(isset($mimetype)) $this->__set("upload_mimetype",$mimetype);

        // Ĭ����չ��Ϊjpg,gif,bmp,png,jpeg
        if(isset($fileextname)) $this->__set("upload_fileextname",$fileextname);

        // Ĭ���ϴ��ļ���СΪ500K
        if(isset($maxsize)) $this->__set("upload_maxsize",$maxsize);
		else $this->__set("upload_maxsize",1024*1024*2);

        // Ĭ��Ϊ�������ϴ��ļ���
        if(isset($uploatype)) $this->__set("upload_filerename",$filerename);

        // ��ʼ����Ϊ0
		$this->__set("upfile_file_error",0);
        // Ĭ�����ļ��ϴ��½��������ļ���
        if(isset($datedir)) $this->__set("upload_savedir",$datedir);
		else $this->__set("upload_savedir",date('y/m/d', time()));

        // Ĭ�����ļ��ϴ���ʹ�ò��������ļ���ʱ����������Ϊ0
        if(isset($overwrite)) $this->__set("upload_overwrite",$overwrite);
        
        // �������ϴ���չ�������ı��ַ���תΪ����
        $this -> upload_fileextname = strtolower($this -> upload_fileextname);
        $this -> upload_fileextname = explode(",", $this -> upload_fileextname);
        $this -> upload_fileextname = array_unique($this -> upload_fileextname);
        // �������ϴ��ļ�mime����ı��ַ���תΪ����
        $this -> upload_mimetype = strtolower($this -> upload_mimetype);
        $this -> upload_mimetype = explode(",", $this -> upload_mimetype);
        $this -> upload_mimetype = array_unique($this -> upload_mimetype);

        // ��ȡ�ϴ��ļ���Ϣ
        $this-> upload_file = $_FILES[$this -> formname];

        // ��ȡ�ϴ��ļ�����
        $this-> upload_file_name = $this-> upload_file[name];
        // ��ȡ�ϴ��ļ���չ��
        $this-> upload_file_extname = strtolower(pathinfo($this-> upload_file_name, PATHINFO_EXTENSION));
        // ��ȡ�ϴ��ļ���ʱ�ļ�����λ��
        $this-> upload_file_tmpname = $this-> upload_file[tmp_name];
        // ��ȡ�ϴ��ļ�mime���
        $this-> upload_mime_types = $this-> upload_file['type'];
        $upload_mime_type = explode("/", $this-> upload_mime_types);
        $this-> upload_mime_type = $upload_mime_type[0];
        // ��ȡ�ϴ��ļ���С
        $this-> upload_file_size = $this-> upload_file[size];

    }
	
    function upfile(){

        // ��ȡ�ϴ��ļ�����
        $upload_file_name =  $this-> upload_file_name;
        // ��ȡ�ϴ��ļ���չ��
        $upload_file_extname = $this-> upload_file_extname;
        // ��ȡ�ϴ��ļ���ʱ�ļ�����λ��
        $upload_file_tmpname = $this-> upload_file_tmpname;
        // ��ȡ�ϴ��ļ�mime���
        $upload_mime_type = $this-> upload_mime_type;
        // ��ȡ�ϴ��ļ���С
        $upload_file_size = $this-> upload_file_size;

        // �����ļ��ϴ���ʼ����
        if($this-> upload_file){
		
            if($upload_file_size > $this -> upload_maxsize){
                // ���ϴ��ļ���С�������ֵ
                $this -> upfile_file_error = 1;
            }
            
            if(in_array($upload_mime_type , $this -> upload_mimetype) == false){
                // ���ϴ��ļ�mime���ʹ���
                $this -> upfile_file_error = 2;
             }
            
            if(in_array($upload_file_extname , $this -> upload_fileextname) == false){
                // ���ϴ��ļ���չ��������Ҫ��
                $this -> upfile_file_error = 3;
            }
			
			$upload_max_filesize = str_replace('M', '', ini_get("upload_max_filesize"));
			$post_max_size = str_replace('M', '', ini_get("post_max_size"));
			if($upload_max_filesize*1024*1024 < $this-> upload_file_size || $post_max_size*1024*1024 < $this-> upload_file_size ){
			    // �ϴ����ļ�������   php.ini   ��   upload_max_filesize and post_max_size  ѡ�����Ƶ�ֵ
                $this -> upfile_file_error = 4;
			}
			
            // ���ϴ�����Ϊ0��ʱ��ʼ���²���
            if($this -> upfile_file_error == 0){
			   $upfile_file_newname = strtolower($upload_file_name);
			   if(!isset($this->upload_filename)){
						// ��ʼ�ж��ϴ��ļ��д��ڣ�����������
						$this -> createdir($this -> upload_savepath);
						// �����洢�ļ���
						if($this -> upload_savedir){
							$upfile_file_path = $this -> upload_savepath . "/" . $this -> upload_savedir;
							$upfile_file_path = $this -> createdir($upfile_file_path);
						}
						// �ж��Ƿ��������ļ�������
						if($this -> upload_filerename == 1){
 							$upfile_file_newname = date("his") .$this->random(). "." . $upload_file_extname;
						}
						
						//�ϴ��ļ�·��
						$upfile_file_path = $upfile_file_path . "/" . $upfile_file_newname;
						// �ϴ��ļ���ָ��λ��
						if($this -> upload_filerename){
							// ������Ϊ�������ļ���ʱֱ���ϴ���ָ��λ��
							$upload_file_overwrite = 0;
								if(@move_uploaded_file($upload_file_tmpname, $upfile_file_path) == false){
								   $this -> upfile_file_error = 6;
								}
						}else{
							// ������Ϊ���������ļ����ж��ļ��Ƿ����
							   if(@file_exists($upload_file_tmpname, $upfile_file_path) == true){
								// ���ļ�����
								   if($this -> upload_overwrite == 0){
										// ����������
										$upload_file_overwrite = 2;
										continue;
									}
									if($this -> upload_overwrite == 1){
										// ��������
										$upload_file_overwrite = 3;
										// ��ɾ��ԭ���ļ�
										@unlink(realpath($upload_file_tmpname, $upfile_file_path));
										if(@move_uploaded_file($upload_file_tmpname, $upfile_file_path) == false){
											$this -> upfile_file_error = 6;
										}
									}
									if($this -> upload_overwrite == 2){
										// ������Ϊ���������ϴ�
										$upload_file_overwrite = 4;
										if(@move_uploaded_file($upload_file_tmpname, $upfile_file_path) == false){
											$this -> upfile_file_error = 6;
										}
									}
							  }else{
								// ���ļ�������
								$upload_file_overwrite = 1;
								if(@move_uploaded_file($upload_file_tmpname, $upfile_file_path) == false){
									$this -> upfile_file_error = 6;
								}
							 }
						 }
				   } else {
				        $upfile_file_path = $this->upload_filename;
				        if(is_file(realpath($upfile_file_path))) @unlink(realpath($upfile_file_path));
						if(@move_uploaded_file($upload_file_tmpname, $upfile_file_path) == false){
							$this -> upfile_file_error = 6;
						}
						$upfile_file_newname = basename($this->upload_filename);
				   }
                }
                $up_file_return = array(
					"upfile_file_error"      => $this -> upfile_file_error,  //�ϴ�״̬
					"upfile_file_newname"    => $upfile_file_newname,        //�ϴ�������ļ���
					"upfile_file_path"       => str_replace('\\', '/', realpath($upfile_file_path)),           //�ϴ����ڷ�������·��
					"upload_file_name"       => $upload_file_name,           //�ϴ��ļ���
					//"upload_file_url"      => $upload_file_name,
					"upload_mime_types"      => $this->upload_mime_types,    //�ϴ��ļ���������
					"upload_mime_type"       => $upload_mime_type,           //�ϴ��ļ�����
					"upload_file_extname"    => $upload_file_extname,        //�ϴ��ļ���չ��
					"upload_file_overwrite"  => $upload_file_overwrite,      //�ļ���д״̬
					"upload_file_size"       => $upload_file_size            //�ϴ��ļ���С
				);
				
            }
			if(is_file($upfile_file_path)) @chmod($upfile_file_path, 0777);
			return $up_file_return; // ����ֵ
        }
		//����Ŀ¼
		function createdir($dir='')
		{
				if (!is_dir($dir))
				{
						$temp = explode('/',$dir);
						$cur_dir = '';
						for($i=0;$i<count($temp);$i++)
						{
							  $cur_dir .= $temp[$i].'/';
							  if (!is_dir($cur_dir))
							  {
									  @mkdir($cur_dir,0777);
							  }
						}
				}
				return $dir;
		}
        //���������
		function random($chars='123456789',$length=4)
		{
			$hash = '';
			//$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
			$max = strlen($chars) - 1;
			mt_srand((double)microtime()*1000000);
			for($i = 0; $i < $length; $i++)
			{
				$hash .= $chars[mt_rand(0, $max)];
			}
			return $hash;
		 }

    }
?>
