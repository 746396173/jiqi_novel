<?php
/**
 * ���ݳ��½�ģ��
 * @author chengyuan  2014-9-12
 *
 */
class chapterModel extends Model{
	/**
	 * Ĭ��
	 * @param unknown $params
	 * 2014-8-27 ����3:24:40
	 */
	public function main($params = array()){}
	/**
	 * �ײ��������
	 * @param unknown $msg
	 */
	private function msg($msg){
		$sapi = php_sapi_name();
		if($sapi == 'cgi-fcgi'){
			echo str_pad($msg,1024*64);
		}else{
			if($this->first_out){
				echo str_repeat(' ',4096);
				$this->first_out = false;
			}
			echo $msg;
		}
		ob_flush();
		flush();
	}
	/**
	 * ʹ�����ݳ���Ϊ��������Դ�����ͬ���麣���ͨ�����½����������ݳء�
	 * <p>
	 * �����ӿڰ������ͷ��ࣺ���ͣ�չʾ���ɼ���
	 * <p>
	 * �������ͺͲɼ���ʹ��my_xxx�Զ����࣬������չʾ������
	 * @param unknown $channleid	����id
	 * @param unknown $aid			��������id����
	 * 2014-8-27 ����3:25:48
	 */
	public function synchronization($channleid,$paidArray){
		define ( 'JIEQI_USE_GZIP', '0' );
		ini_set ( 'zlib.output_compression', 0 );
		ini_set ( 'implicit_flush', 1 );
		ob_start ();
		ob_end_flush ();
		ob_implicit_flush ();
		@set_time_limit ( 0 );
		@session_write_close ();
		$channelLib = $this->load('channel', 'pooling');
		$channel = $channelLib->get($channleid,true);
		if($channel['type'] != 1){//չʾ �������Զ�����
			$apiLib = $this->load($channel['url'],'pooling');
		}
		if(!interface_exists('iSynchronization')){
			include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iSynchronization.php');//ͬ���ӿ�
		}
// 		$implements = class_implements($apiLib);//api�Զ�����ʵ�ֵĽӿ�
		$articleLib = $this->load ( 'article', 'article' );
		//��ȡ���ݳ����£�
		//ѭ����ͬ���½ڣ��½����ݴ洢�����ݿ���
		$paids = implode(",", $paidArray);
		$plArts = $this->db->selectsql ('select * from ' . jieqi_dbprefix ( "pooling_article" ) . " where  paid in (" .$paids.')');
		//ͬ���½�
		foreach($plArts as $k=>$v){
			$synchronization  = false;
			if($v['setting']){
				eval('$setting = '.$v['setting'].';');//�ַ���ת����,�ϴ�ͬ����¼��Ϣ
			}else{
				$setting = array();
			}
			$plChapters = $this->db->selectsql ('select * from ' . jieqi_dbprefix ( "pooling_chapter" ) . " where  paid = " .$v["paid"]);//�������ͬ���½�
			if(!$setting['lastchapterid'] && $plChapters && count($plChapters)>0){
				//�쳣��û���ϴε�ͬ��λ��
				$this->msg("�޷�ͬ����".$v["articlename"]."û���ϴε�ͬ��λ�ã�����ϵ����Ա��");
				continue;
			}
			if(!$plChapters){
				$synchronization  = true;
			}
			$this->msg("<table border=1><caption>{$v["articlename"]}->ͬ����</caption><tr><th>��</th><th>����</th><th>����</th><th>ͬ�����</th></tr>");
			$articleLib->instantPackage ( $v['articleid'] );
			$this->db->init('chapter', 'chapterid', 'article');
			//��ѯ�½�
			$this->db->setCriteria ( new Criteria ( 'articleid', $v['articleid'] ) );
			$this->db->criteria->add ( new Criteria ( 'display',0) );
// 			$this->db->criteria->add ( new Criteria ( 'size',0,'>') );
			$this->db->criteria->setSort ( 'chapterorder' );
			$this->db->criteria->setOrder ( 'ASC' );
			$this->db->queryObjects ();
			$i = 0;
			while ( $chapter = $this->db->getObject () ) {
				//ͬ����jieqi_pooling_chapter
				if($synchronization){
					$i++;
					$plchapter = array();
					$plchapter['paid'] = $v['paid'];
					$plchapter['articleid'] = $chapter->getVar ( 'articleid' );
					$plchapter['chapterid'] = $chapter->getVar ( 'chapterid' );
					$plchapter['channelid'] = $channleid;
					$plchapter['chaptername'] = trim($chapter->getVar ('chaptername','n'));
					$plchapter['chapterorder'] = $chapter->getVar ( 'chapterorder' );
					$plchapter['content'] = @$articleLib->getContent ( $chapter->getVar ( 'chapterid' ) );//�½�����
					$plchapter['size'] = $chapter->getVar ( 'size' );
					$plchapter['chaptertype'] = $chapter->getVar ( 'chaptertype' );
					$plchapter['adddate'] = JIEQI_NOW_TIME;//�½�ͬ��ʱ���ʱ���
					// 				$plchapter['pushdate'] = 0;//���͵�ʱ��
					$plchapter['isvip'] = $chapter->getVar ( 'isvip' );
					$plchapter['split'] = 0;
					$plchapter['description'] = '';
					if($apiLib instanceof iSynchronization) {//�Ƿ�ʵ��iSynchronization interface
						$apiLib->handlePoolChapter($plchapter);
					}
					$this->db->init('chapter', 'pcid', 'pooling');
					$this->db->add($plchapter);

					//ͬ��һ�£�jieqi_pooling_article ����һ��״̬
					$this->db->init('article', 'paid', 'pooling');
					//setting�Ǽ�¼ͬ��������
					//lastvolumeid��lastvolume��lastchapterid��lastchapter ��¼���͵�״̬
					//ͬ��״̬
					$newSetting = array();
					$newSetting['lastchapterid'] = $chapter->getVar ( 'chapterid' );//���ͬ��λ��
					if($chapter->getVar ( 'chaptertype' ) == 1){//volume
						$newSetting['lastvolumeid'] = $chapter->getVar ( 'chapterid' );
						$newSetting['lastvolume'] = $chapter->getVar ( 'chaptername' );
					}else{//chapter
// 						$newSetting['lastchapterid'] = $chapter->getVar ( 'chapterid' );
						$newSetting['lastchapter'] = $chapter->getVar ( 'chaptername' );
					}
					if($setting['daychapter']){
						$newSetting['daychapter'] = $setting['daychapter'];
					}
					$v['setting'] = $this->arrayeval($newSetting);
					$this->db->edit($v['paid'],$v);
					$type = $plchapter['chaptertype'] ? '��' : '�½�';
					$this->msg("<tr><td>{$i}</td><td>{$plchapter['chaptername']}</td><td>{$type}</td><td>ok</td></tr>");
				}else{
					if($setting['lastchapterid'] && $setting['lastchapterid'] == $chapter->getVar ( 'chapterid' )){
						$synchronization = true;//��λ�ϴ�ͬ����λ�ã�����һ���½ڿ�ʼͬ��
					}
					continue;
				}
			}
			if($i == 0){
				$this->msg('<tr><td colspan=4>�Ѿ�������</td></tr>');
			}
			$this->msg("</table>ͬ������");
		}
	}
	/**
	 * ���ݳ����£��½��б�
	 * @param unknown $channleid	����Id
	 * @param unknown $paid			���ݳ�����Id
	 * @return multitype:string NULL unknown [article,channel,chapters]
	 * 2014-9-12 ����11:37:36
	 */
	public function chapterList($channleid,$paid){
		$data = array();
		$chapters = $this->db->selectsql ('select pcid,chaptertype,chaptername,adddate from ' . jieqi_dbprefix ( "pooling_chapter" ) . " where  paid = " .$paid.' order by chapterorder');
		$data['chapters'] = $chapters;
		$this->db->init('article', 'paid', 'pooling');
		$data['article'] = $this->db->get ($paid);
		$this->db->init('channel', 'channelid', 'pooling');
		$data['channel'] = $this->db->get ($channleid);
		$data['JIEQI_NOW_TIME'] = JIEQI_NOW_TIME;
		return $data;
	}
	/**
	 * ��ȡ�½���Ϣ��msgbox������ύ���ͣ�ajax������$chapterΪjson��ʽ�����ǰ̨��
	 * @param unknown $cid	���ݳ��½�Id
	 * 2014-9-12 ����11:42:32
	 */
	public function getChapter($cid){
		$this->db->init('chapter', 'pcid', 'pooling');
		$chapter = $this->db->get ($cid);
		$this->msgbox('',$chapter);
	}
	/**
	 * ����һ���½ڣ�����$pcidָ�����½ں���
	 * @param unknown $pcid				���ݳ��½�Id
	 * @param unknown $chaptername		���ݳ��½�����
	 * @param unknown $content			���ݳ��½�����
	 * @param unknown $insertChapterName	������½�����
	 * @param unknown $insertContent		������½�����
	 * 2014-9-12 ����2:29:07
	 */
	public function insertChapter($pcid,$chaptername,$content,$insertChapterName,$insertContent){
		$this->db->init('chapter', 'pcid', 'pooling');
		//1�����޸ĵ��½�
		$this->editChapter($pcid, $chaptername, $content,false);
		//2��������chapterorder���������½ڡ�
		//��������chapterorder+1
		$chapter = $this->db->get ($pcid);
		$this->db->updatetable ( 'pooling_chapter', array (
				'chapterorder' => '++'
		), 'paid = ' . $chapter ['paid'] . ' and chapterorder > ' . $chapter['chapterorder'] );
		$chapter['pcid'] = '';
		$chapter['chapterid'] = 0;
		$chapter['chaptername'] = $insertChapterName;
		$chapter['content'] = $insertContent;
		$chapter['chapterorder'] =intval($chapter['chapterorder'])+1;
		$chapter['adddate'] = JIEQI_NOW_TIME;
		$chapter['size'] = jieqi_strlen ($insertContent);
		$this->db->add($chapter);
		$this->jumppage('','','');
	}
	/**
	 * �޸��½�
	 * @param unknown $pcid
	 * @param unknown $chaptername
	 * @param unknown $content
	 * @param string $jump
	 * 2014-9-12 ����2:27:09
	 */
	public function editChapter($pcid,$chaptername,$content,$jump=true){
		$this->db->init('chapter', 'pcid', 'pooling');
		if($content){
			$this->db->edit ($pcid,array("chaptername"=>$chaptername,'content'=>$content,'size'=>jieqi_strlen ($content)));
		}else{
			$this->db->edit ($pcid,array("chaptername"=>$chaptername));
		}
		if($jump == true){
			$this->jumppage('','','');
		}
	}
	/**
	 * ɾ���½�
	 * @param unknown $pcid
	 * 2014-9-12 ����2:33:23
	 */
	public function delete($pcid){
		$this->db->init('chapter', 'pcid', 'pooling');
		if($chapter = $this->db->get ($pcid)){
			$this->db->delete($pcid);
			$this->db->updatetable ( 'pooling_chapter', array (
					'chapterorder' => '--'
			), 'paid = ' . $chapter ['paid'] . ' and chapterorder > ' . $chapter['chapterorder'] );
			//��������
			$this->jumppage('','','');
		}
	}

























}
?>