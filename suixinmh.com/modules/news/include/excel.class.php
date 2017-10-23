<?php
/**
* excel������
*
* ʹ�÷���
$excel=new Excel();
* //���ñ��룺
*$excel->setEncode("utf-8","gb2312"); //�����ת�룬����дһ�����ɣ�����$excel->setEncode("utf-8","utf-8");
* //���ñ�����
* $titlearr=array("a","b","c","d");
* //����������
* $contentarr=array(
* 1=>array("ab","ac","ad","ae"),
* 2=>array("abc","acc","adc","aec"),
* 3=>array("abd","acd","add","aed"),
* 4=>array("abe","ace","ade","aee"),
* );
* $excel->getExcel($titlearr,$contentarr,"abc");
*/
/*$excel=new Excel();
 //���ñ��룺
$excel->setEncode("utf-8","gb2312"); //�����ת�룬����дһ�����ɣ�����$excel->setEncode("utf-8","utf-8");
//���ñ�����
$titlearr=array("a","b","c","d");
//����������
$contentarr=array(
1=>array("ab","ac","ad","ae"),
2=>array("abc","acc","adc","aec"),
3=>array("abd","acd","add","aed"),
4=>array("abe","ace","ade","aee"),
);
$excel->getExcel($titlearr,$contentarr,"abc");*/
class Excel {
	var $inEncode; //һ����ҳ�����
 
	var $outEncode; //һ����Excel�ļ��ı���
 
	function __construct(){
 
	}
	/**
	*���ñ���
	*/
	function setEncode($incode,$outcode){
		$this->inEncode=$incode;
 
		$this->outEncode=$outcode;
	}
	/**
	*����Excel�ı�����
	*/
	function setTitle($titlearr){
		$title="";
		foreach($titlearr as $v){
			if($this->inEncode!=$this->outEncode){
				$title.=iconv($this->inEncode,$this->outEncode,$v)."\t";
			}
			else{
				$title.=$v."\t";
			}
		}
		$title.="\n";
		return $title;
	}
	/**
	*����Excel����
	*/
	function setRow($array){
		$content="";
		foreach($array as $k => $v){
			foreach($v as $vs){
				if($this->inEncode!=$this->outEncode){
					$content.=iconv($this->inEncode,$this->outEncode,$vs)."\t";
				}
				else{
					$content.=$vs."\t";
				}
			}
			$content.="\n";
		}
		return $content;
	}
	/**
	*���ɲ��Զ�����Excel
	* $titlearr ����������
	* $array ��������
	* $filename �ļ����� (Ϊ�գ��ѵ�ǰ����Ϊ����)
	*/
	function getExcel($titlearr,$array,$filename=''){
		if($filename==''){
			$filename=date("Y-m-d");
		}
		$title=$this->setTitle($titlearr);
		$content=$this->setRow($array);
		$p_new_lines = array("\r\n", "\n", "\r","\r\n", "<pre>","</pre>","<br>","</br>","<br/>"); 
		$p_change_line_in_excel_cell = '<br style="mso-data-placement:same-cell;" />';
		//$content = str_replace( $p_new_lines,$p_change_line_in_excel_cell,$content);
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=".$filename.".xls");
		echo $title;
		echo $content;
	}
}
?>