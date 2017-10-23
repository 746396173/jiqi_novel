<?php
/**
 *	��ģ��
 * @copyright   Copyright(c) 2014
 * @author      chengyuan* @version     1.0
 */
class volumeModel extends Model{
		/**
		 * �༭����ͼ
		 * @param  $vId		��ID
		 * @return string	 form html
		 */
		function editVolumeForm($vId){
			//�����Զ�����
			jieqi_getconfigs('article', 'authorblocks', 'jieqiBlocks');
			$articleLib =  $this->load('article',false);
			$data =  $articleLib->editChapterView($vId,1);
			return $data;
		}
		/**
		 * �޸ľ�
		 * @param  $aid		����id
		 * @param  $volume	��,����=[vid,volumename,manual,articleid]
		 */
		function editVolume($volume){
			$articleLib =  $this->load('article',false);
			$article = $articleLib->isExists($volume['articleid']);
			$articleLib->canedit($article);

			$this->db->init('chapter','chapterid','article');
			if(!$chapter = $this->db->get($volume['chapterid'])){
			    if($param['chaptertype']==1) $typename=$articleLib->jieqiLang['article']['volume_name'];
				else $typename=$articleLib->jieqiLang['article']['chapter_name'];
				$this->printfail(sprintf($articleLib->jieqiLang['article']['chapter_volume_notexists'], $typename));
			}
			//�������������ֻ���޸Ķ�Сʱ�ڵ�����
			$auth = $this->getAuth();
			if($article['authorid']==$auth['uid']){
			    $canedittime = 7200;
			    if(JIEQI_NOW_TIME-$chapter['postdate']>$canedittime && (!$chapter['display'] || $chapter['display']==2)){
				     $this->printfail(sprintf($articleLib->jieqiLang['article']['chapter_2hours_edit'], $canedittime/3600));
				}
			}

			$articleLib->updateVolume($article,$volume);
			$this->jumppage ( $this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid=' . $article ['articleid'] ), LANG_DO_SUCCESS, $articleLib->jieqiLang ['article'] ['volume_edit_success'] );
		}
		/**
		 * ����¾��form,������
		 * @param  $aid		����id
		 * @return string	form htlm
		 */
		function addVolumeForm($aid){
			global $jieqiLang,$jieqiConfigs,$jieqiPower;
			$articleLib =  $this->load('article',false);
			jieqi_loadlang('article', 'article');
			$article = $articleLib->isExists($aid);
			//���Ȩ��
			jieqi_getconfigs('article', 'power');
			//�����������Ȩ��
			//print_r($jieqiPower['article']['manageallarticle']);
			$canedit = $articleLib->canedit($aid,$jieqiPower['article']['manageallarticle']);
			if(!$canedit) jieqi_printfail($jieqiLang['article']['noper_manage_article']);
			jieqi_getconfigs('article', 'configs');
			//�����������(��������)
			jieqi_getconfigs('article', 'authorblocks', 'jieqiBlocks');
			include_once(JIEQI_ROOT_PATH.'/lib/html/formloader.php');
			$chapter_form = new JieqiThemeForm($jieqiLang['article']['add_volume'], 'newvolume',$this->getUrl('article','volume','SYS=method=newVolume&aid='.$aid));
			$chapter_form->addElement(new JieqiFormLabel($jieqiLang['article']['table_article_articlename'], '<a href="'.$this->geturl('article','article','SYS=method=articleManage&aid='.$aid).'">'.$article['articlename'].'</a>'));

			$this->db->init('chapter','chapterid','article');
			$this->db->setCriteria();
			$this->db->criteria->add(new Criteria('articleid',$aid, '='));
			$this->db->criteria->add(new Criteria('chaptertype','1', '='));
			$this->db->criteria->setSort('chapterorder');
			$this->db->criteria->setOrder('ASC');
			$this->db->queryObjects();
			$tmpvar='';
			while($v = $this->db->getObject()){
				$tmpvar.=$v->getVar('chaptername').'<br />';
			}
			$chapter_form->addElement(new JieqiFormLabel($jieqiLang['article']['this_article_colume'], $tmpvar));
			$chapter_form->addElement(new JieqiFormText($jieqiLang['article']['add_new_volume'], 'chaptername', 50, 50), true);
			$chapter_form->addElement(new JieqiFormTextArea('˵��', 'volumemanual', '', 5, 50));
			$chapter_form->addElement(new JieqiFormHidden('formhash',form_hash()));
			$chapter_form->addElement(new JieqiFormButton('&nbsp;', 'dosubmit', LANG_SUBMIT, 'submit'));
			$addForm = "<br />".$chapter_form->render(JIEQI_FORM_MIsDDLE)."<br />";
			return $addForm;

		}


		/**
		 * �����
		 * @param $id	��id
		 * @param $volumeName	������
		 */
        function saveVolume($aid,$previousVolume, $volumeName,$volumemanual,$postdate){
        	$articleLib =  $this->load('article','article');
			$article=$articleLib->isExists($aid);
			$articleLib->canedit($article);
			$errtext='';
			//������
			if (strlen($volumeName)==0) $errtext .= $articleLib->jieqiLang['article']['need_colume_title'].'<br />';
			if(empty($errtext)) {
				$articleLib->saveVolume($article,$previousVolume,$volumeName,$volumemanual,$postdate);
				//�ض���
				$url = $this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid='.$aid);
				$this->jumppage($url,LANG_DO_SUCCESS, LANG_DO_SUCCESS);
			}else{
				$this->printfail($errtext);
			}
        }
}

?>