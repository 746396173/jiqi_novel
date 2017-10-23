<?php
/**
 * �����ϴ�������
 * @author huliming  2015-04-21
 *
 */
class MyPostbook extends JieqiObject {

     public $fh;           //�ļ������ľ��
	 public $article;      //����������ݵ�����
	 public $ending = '\n';//��������ľ��
	 public $volumestart = '@@@';//�־�ı��
	 public $chapterstart = '###';//�½ڵı��
	 //��ʼ������
	 public function init($filename){
		 if(is_file($filename)) $this->fp = fopen($filename, 'r'); //�ļ� 
		 else return false;
	 }
	 
	 //������������
	 public function getArticles(){
	     include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
		 $line = 1;
		 $i = 0;
		 while (!feof($this->fp)) {
		     $temp = stream_get_line($this->fp, 65535, "\n");
		     $tempstr = trim(is_utf8($temp) ? jieqi_utf82gb($temp) : $temp); 
			 if(!$tempstr) continue;
			 else{
			     if($line==1) $this->article['articlename'] = str_replace('������','',$tempstr);
				 elseif($line==2) $this->article['author'] = str_replace('���ߣ�','',$tempstr);
				 elseif($line==3) $this->article['intro'] = str_replace('��飺','',$tempstr);
				 else{//�����½�
				     if(strpos($tempstr, $this->volumestart) === 0){
					    $chaptername = str_replace($this->volumestart,'',$tempstr);
						if(!$chaptername) continue;
					    $i++;
					    $this->article['chapters'][$i]['chaptername'] = $chaptername;
						$this->article['chapters'][$i]['chaptertype'] = 1;
					 }elseif(strpos($tempstr, $this->chapterstart) === 0){
					    $chaptername = str_replace($this->chapterstart,'',$tempstr);
						if(!$chaptername) continue;
					    $i++;
					    $this->article['chapters'][$i]['chaptername'] = $chaptername;
						$this->article['chapters'][$i]['chaptertype'] = 0;
					 }else{
					    if(!isset($this->article['chapters'][$i]['chaptername'])){//��Լ����ܵĻ���
						    $this->article['intro'].= "\r\n".$tempstr;
						}else{
							if($this->article['chapters'][$i]['chaptercontent']){
								$this->article['chapters'][$i]['chaptercontent'].= "\r\n".$tempstr;
							}else $this->article['chapters'][$i]['chaptercontent'].= $tempstr;
						}
					 }
				 }
			 }
			 $line++;
		 }
		 return $this->article;
	 }
}
?>