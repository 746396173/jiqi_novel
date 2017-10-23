<?php 
/** 
 * ���»����ģ�� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */
class huodongModel extends Model
{

    function vote($params = array())
    {
        global $jieqiHonors;
        $this->addConfig('article', 'configs');
        $this->addConfig('article', 'right');
        $this->addConfig('system', 'vipgrade');
        $this->addLang('article', 'vote');
        $this->addLang('system', 'users');
        $jieqiConfigs['article'] = $this->getConfig('article', 'configs');
        jieqi_getconfigs('system', 'honors');
        $jieqiConfigs['vipgrade'] = $this->getconfig('system', 'vipgrade');
        $jieqiRight['article'] = $this->getConfig('article', 'right');
        $jieqiLang['system'] = $this->getLang('system');
        $jieqiLang['article'] = $this->getLang('article'); //�������԰����ø�ֵ
        if (!$article = $this->getArticle($params))
            return array(
                'stat' => "failed",
                'msg' => $jieqiLang['article']['article_not_exists']
            );
        //$this->printfail($jieqiLang['article']['article_not_exists']);//�ж������Ƿ����

        $auth = $this->getAuth();
        $users_handler = $this->getUserObject();//��ѯ�û��Ƿ����
        $users = $users_handler->get($auth['uid']);
        if (!is_object($users) || $users->getVar('groupid') == 1)
            return array(
                'stat' => "failed",
                'msg' => LANG_NO_USER
            );
        //$this->printfail(LANG_NO_USER);

        $honorid = jieqi_gethonorid($users->getVar('score'), $jieqiHonors);
        $maxvote = 0;//��ʼ������
        if ($honorid && isset($jieqiRight['article']['dayvotes']['honors'][$honorid]) && is_numeric($jieqiRight['article']['dayvotes']['honors'][$honorid])) $maxvote = intval($jieqiRight['article']['dayvotes']['honors'][$honorid]);//ÿ���Ͷ����Ʊ
        $vipgrade = jieqi_gethonorarray($users->getVar('isvip'), $jieqiConfigs['vipgrade']);//VIP�ȼ�����
        if (intval($vipgrade['setting']['tuijianpiao']) > 0) $maxvote += intval($vipgrade['setting']['tuijianpiao']);//VIP�ӳ�

        //��ѯ�Ѿ�ͶƱ��
        $this->db->init('statlog', 'statlogid', 'article');
        $this->db->setCriteria(new Criteria('uid', $auth['uid'], '='));
        $this->db->criteria->add(new Criteria('mid', 'vote', '='));
        $this->db->criteria->add(new Criteria('addtime', strtotime(date('Y-m-d', JIEQI_NOW_TIME)), '>='));
        $pollnum = $this->db->getsum('stat', $this->db->criteria);//�����Ѿ�ͶƱ��
        //�ύ����

        if ($this->submitcheck()) {// print_r($params);exit();
            if (!$params['nosubmitcheck']) {
                if ($params['checkcode'] != $_SESSION['jieqiCheckCode']) {
                    $this->printfail($jieqiLang['system']['error_checkcode']);
                }
            }
            if ($pollnum >= (int)$maxvote)
                return array(
                    'stat' => "failed",
                    'msg' => $jieqiLang['article']['vote_not']
                );
            //$this->printfail($jieqiLang['article']['vote_not']);
            if ($params['stat'] == 'all') $params['stat'] = (int)$maxvote - $pollnum;
            if ($pollnum + $params['stat'] > (int)$maxvote)
                return array(
                    'stat' => "failed",
                    'msg' => sprintf($jieqiLang['article']['vote_times_limit'], $maxvote - $pollnum)
                );
            //$this->printfail(sprintf($jieqiLang['article']['vote_times_limit'], $maxvote-$pollnum));
            if (!(int)$params['stat'])
                return array(
                    'stat' => "failed",
                    'msg' => LANG_ERROR_PARAMETER
                );
            //$this->printfail(LANG_ERROR_PARAMETER);

            //����ͶƱ��
            $jieqiConfigs['article']['dayvotes'] = intval($jieqiConfigs['article']['dayvotes']);
            if ($jieqiConfigs['article']['dayvotes'] > 0) {
                //��ѯ�Ѿ�ͶƱ��
                $this->db->init('statlog', 'statlogid', 'article');
                $this->db->setCriteria(new Criteria('uid', $auth['uid'], '='));
                $this->db->criteria->add(new Criteria('mid', 'vote', '='));
                $this->db->criteria->add(new Criteria('articleid', $article['articleid'], '='));
                $this->db->criteria->add(new Criteria('addtime', $this->getTime('day'), '>='));
                $bookpollnum = $this->db->getsum('stat', $this->db->criteria);//�����Ѿ��Ըñ���ͶƱ��
                if ($bookpollnum + $params['stat'] > $jieqiConfigs['article']['dayvotes'])
                    return array(
                        'stat' => "failed",
                        'msg' => sprintf($jieqiLang['article']['vote_book_times_limit'], $jieqiConfigs['article']['dayvotes'], $bookpollnum)
                    );
                //$this->printfail(sprintf($jieqiLang['article']['vote_book_times_limit'], $jieqiConfigs['article']['dayvotes'],$bookpollnum));
            }
            //��¼������־
            $package = $this->load('article', 'article');
            if ($package->addArticleStat($article['articleid'], $article['authorid'], 'vote', $params['stat'])) {
                if ($jieqiConfigs['article']['scoreuservote'] > 0) {
                    //�ӻ���
                    $users_handler->changeScore($auth['uid'], $jieqiConfigs['article']['scoreuservote'] * $params['stat'], true);
                }
                //д����
                if (!$params['pcontent']) {
                    $params['pcontent'] = "��д�úܺã����ߴ�������ˣ�Ͷ" . $params['stat'] . "���Ƽ�Ʊ����һ�£�";
                }
                $this->addReview($params);
                return array(
                    'stat' => "succ",
                    'msg' => sprintf($jieqiLang['article']['vote_success'], $maxvote, $pollnum + $params['stat'])
                );
                //$this->jumppage($article['url_module_articleinfo'], LANG_DO_SUCCESS, sprintf($jieqiLang['article']['vote_success'], $maxvote, $pollnum+$params['stat']));
            } else {
                return array(
                    'stat' => "failed",
                    'msg' => 'ͶƱʧ��'
                );
                //$this->printfail();
            }
        }
        return array(
            'egolds' => $users->getVar('egold', 'n'),
            'maxvote' => $maxvote,
            'pollnum' => $pollnum,
            'getscore' => $jieqiConfigs['article']['scoreuservote'],
            'article' => $article
        );
    }

    function vipvote($params = array())
    {
        $this->addConfig('article', 'configs');
        $this->addLang('article', 'vipvote');
        $this->addLang('system', 'users');
        $this->addConfig('system', 'vipgrade');
        $jieqiConfigs['article'] = $this->getConfig('article', 'configs');
        $jieqiLang['system'] = $this->getLang('system');
        $jieqiLang['article'] = $this->getLang('article'); // �������԰����ø�ֵ
        $jieqiConfigs['vipgrade'] = $this->getconfig('system', 'vipgrade');

        if (!$article = $this->getArticle($params)) $this->printfail($jieqiLang['article']['article_not_exists']);//�ж������Ƿ����
        $auth = $this->getAuth();
        $users_handler = $this->getUserObject();//��ѯ�û��Ƿ����
        $users = $users_handler->get($auth['uid']);
        if (!is_object($users) || $users->getVar('groupid') == 1) $this->printfail(LANG_NO_USER);
        $monthstart = $this->getTime('month');

        $vipgrade = jieqi_gethonorarray($users->getVar('isvip'), $jieqiConfigs['vipgrade']);//VIP�ȼ�����
        $maxvote = 0;//��ʼ������
        if (in_array($users->getVar('groupid'), array(9, 10))) {
            $maxvote = 50;
        } elseif (!$this->checkisadmin()) {//������ǹ���Ա
            //��ѯ����
            if (intval($vipgrade['setting']['baodiyuepiao']) > 0) {
                if (isset($_SESSION['jieqiEgoldPreMonth'])) $egoldpremonth = $_SESSION['jieqiEgoldPreMonth'];
                else {
                    //��ѯ�����½���
                    $this->db->init('sale', 'saleid', 'article');
                    $this->db->setCriteria(new Criteria('accountid', $auth['uid'], '='));
                    $this->db->criteria->add(new Criteria('buytime', $this->getTime('premonth'), '>='));
                    $this->db->criteria->add(new Criteria('buytime', $monthstart, '<'));
                    $this->db->criteria->add(new Criteria('pricetype', 0));
                    $egoldpremonth = $this->db->getsum('saleprice', $this->db->criteria);//���¶����ܶ�
                    $this->db->init('statlog', 'statlogid', 'article');
                    $this->db->setCriteria(new Criteria('uid', $auth['uid'], '='));
                    $this->db->criteria->add(new Criteria('addtime', $this->getTime('premonth'), '>='));
                    $this->db->criteria->add(new Criteria('addtime', $monthstart, '<'));
                    $this->db->criteria->add(new Criteria('mid', 'reward', '='));
                    $egoldpremonth += $this->db->getsum('stat', $this->db->criteria);//�Ӵ����ܶ�
                    $_SESSION['jieqiEgoldPreMonth'] = $egoldpremonth;
                }
                //Ĭ��ÿ�±�����Ʊ��
                if ($egoldpremonth >= intval($jieqiConfigs['article']['vipvotes'])) $maxvote += $vipgrade['setting']['baodiyuepiao'];
            }
            //��ѯ������Ʊ
            if (intval($vipgrade['setting']['xiaofeiyuepiao']) > 0) {
                //��ѯ�����½���
                $this->db->init('sale', 'saleid', 'article');
                $this->db->setCriteria(new Criteria('accountid', $auth['uid'], '='));
                $this->db->criteria->add(new Criteria('buytime', $this->getTime('month'), '>='));
                $egoldmonth = $this->db->getsum('saleprice', $this->db->criteria);//���¶����ܶ�
                $maxvote += floor($egoldmonth / intval($jieqiConfigs['article']['vipvegold'])) * $vipgrade['setting']['xiaofeiyuepiao'];
            }
        } else $maxvote = 1000;
        //��ѯ�Ѿ�ͶƱ��
        $this->db->init('statlog', 'statlogid', 'article');
        $this->db->setCriteria(new Criteria('mid', 'vipvote', '='));
        $this->db->criteria->add(new Criteria('uid', $auth['uid'], '='));
        $this->db->criteria->add(new Criteria('addtime', $monthstart, '>='));
        $pollnum = $this->db->getsum('stat', $this->db->criteria);//�����Ѿ�ͶƱ��
        unset($this->db->criteria);
        $this->db->setCriteria(new Criteria('uid', $auth['uid'], '='));
        $this->db->criteria->add(new Criteria('mid', 'vipvote', '='));
        $this->db->criteria->add(new Criteria('articleid', $article['articleid'], '='));
        $this->db->criteria->add(new Criteria('addtime', $monthstart, '>='));
        $yitou = $this->db->getsum('stat', $this->db->criteria);//�����鵱����ͶƱ��
        //�ύ����
        if ($this->submitcheck()) {
            if ($article['permission'] < 1) {
                $this->printfail($jieqiLang['article']['vipvote_nosign']);
            }
            if (!$params['nosubmitcheck']) {
                if ($params['checkcode'] != $_SESSION['jieqiCheckCode']) {
                    return array(
                        'stat' => "failed",
                        'msg' => $jieqiLang['system']['error_checkcode']
                    );

                    //$this->printfail($jieqiLang['system']['error_checkcode']);
                }
            }
            if ($pollnum >= (int)$maxvote)
                return array(
                    'stat' => "failed",
                    'msg' => $jieqiLang['article']['vote_not']
                );
            //$this->printfail($jieqiLang['article']['vote_not']);
            if ($params['stat'] == 'all') $params['stat'] = (int)$maxvote - $pollnum;
            if ($pollnum + $params['stat'] > (int)$maxvote)
                return array(
                    'stat' => "failed",
                    'msg' => $jieqiLang['article']['vote_times_limit'] . ($maxvote - $pollnum),
                );
            //$this->printfail(sprintf($jieqiLang['article']['vote_times_limit'], $maxvote-$pollnum));
            if (!(int)$params['stat'])
                return array(
                    'stat' => "failed",
                    'msg' => LANG_ERROR_PARAMETER
                );
            //$this->printfail(LANG_ERROR_PARAMETER);
            //����ͶƱ��
            $jieqiConfigs['article']['monthvipvotes'] = 2;
            if ($jieqiConfigs['article']['monthvipvotes'] > 0) {
                //��ѯ�Ѿ�ͶƱ��
                $this->db->init('statlog', 'statlogid', 'article');
                $this->db->setCriteria(new Criteria('uid', $auth['uid'], '='));
                $this->db->criteria->add(new Criteria('mid', 'vipvote', '='));
                $this->db->criteria->add(new Criteria('articleid', $article['articleid'], '='));
                $this->db->criteria->add(new Criteria('addtime', $this->getTime('month'), '>='));
                $bookpollnum = $this->db->getsum('stat', $this->db->criteria);//�����Ѿ��Ըñ���ͶƱ��
                if ($bookpollnum + $params['stat'] > $jieqiConfigs['article']['monthvipvotes'])
                    return array(
                        'stat' => "failed",
                        'msg' => sprintf($jieqiLang['article']['vipvote_book_times_limit'], $jieqiConfigs['article']['monthvipvotes'], $bookpollnum)
                    );
                //$this->printfail(sprintf($jieqiLang['article']['vipvote_book_times_limit'], $jieqiConfigs['article']['monthvipvotes'],$bookpollnum));
            }

            //��¼������־
            $package = $this->load('article', 'article');
            if ($package->addArticleStat($article['articleid'], $article['authorid'], 'vipvote', $params['stat'])) {
                if ($jieqiConfigs['article']['scorevipvote'] > 0) {
                    //�ӻ���
                    $users_handler->changeScore($auth['uid'], $jieqiConfigs['article']['scorevipvote'] * $params['stat'], true);
                }
                //д����
                if (!$params['pcontent']) {
                    $params['pcontent'] = "��˼������ܲ�֧�֣�" . $params['stat'] . "����Ʊ���ϣ�ף������";
                }
                $this->addReview($params);
                return array(
                    'stat' => "succ",
                    'msg' => sprintf($jieqiLang['article']['vote_success'], $maxvote, $pollnum + $params['stat'])
                );
                //$this->jumppage($article['url_module_articleinfo'],LANG_DO_SUCCESS, sprintf($jieqiLang['article']['vote_success'], $maxvote, $pollnum+$params['stat']));
            } else {
                return array(
                    'stat' => "failed",
                    'msg' => 'ʧ����'
                );
                //$this->printfail();
            }
        }

        $result = array(
            'egolds' => $users->getVar('egold', 'n'),
            'maxvote' => $maxvote,
            'pollnum' => $pollnum,
            'getscore' => $jieqiConfigs['article']['scorevipvote'],
            'article' => $article,
            'yitou' => $yitou
        );

        return $result;
    }

    function reward($params = array())
    {
        global $jieqiSetting;
        jieqi_getconfigs('article', 'reward_item', 'jieqiSetting');
        $item = intval($params['item']);

        $reward_pic = $jieqiSetting['article']['reward_item'][$item]['pic'];
        $reward_name = $jieqiSetting['article']['reward_item'][$item]['name'];
        $reward_price = $jieqiSetting['article']['reward_item'][$item]['price'];

        $this->addConfig('article', 'configs');
        $this->addLang('article', 'article');
        $this->addLang('system', 'users');
        $jieqiConfigs['article'] = $this->getConfig('article', 'configs');
        $jieqiLang['system'] = $this->getLang('system');
        $jieqiLang['article'] = $this->getLang('article'); //�������԰����ø�ֵ
        if (!$article = $this->getArticle($params)) $this->printfail($jieqiLang['article']['article_not_exists']);//�ж������Ƿ����
        $auth = $this->getAuth();
        $users_handler = $this->getUserObject();//��ѯ�û��Ƿ����
        $users = $users_handler->get($auth['uid']);
        if (!is_object($users) || $users->getVar('groupid') == 1) $this->printfail(LANG_NO_USER);
        //��ѯ�Ѿ����͵Ľ��
        $this->db->init('statlog', 'statlogid', 'article');
        $this->db->setCriteria(new Criteria('mid', 'reward', '='));
        $this->db->criteria->add(new Criteria('uid', $auth['uid'], '='));
        $this->db->criteria->add(new Criteria('articleid', $params['aid'], '='));
        $pollnum = $this->db->getsum('stat', $this->db->criteria);//�Ѿ�����
        //�ύ����

        if ($this->submitcheck()) {
            if (!$params['nosubmitcheck']) {
                if ($params['checkcode'] != $_SESSION['jieqiCheckCode']) {
                    $this->printfail($jieqiLang['system']['error_checkcode']);
                }
            }


            $need_egold = intval($params['num'] * $reward_price);

            if ((int)$need_egold > (int)$users->getVar('egold', 'n')) {
                if (JIEQI_MODULE_NAME == 'wap') {
                    $url = $this->geturl('wap', 'pay');
                } else {
                    $url = $this->geturl('pay', 'home');
                }
                $this->printfail(sprintf($jieqiLang['article']['money_notenough'], $users->getVar('egold', 'n') . ' ' . JIEQI_EGOLD_NAME, $url));
            }
            if (!$need_egold) $this->printfail(LANG_ERROR_PARAMETER);
            //��¼������־

            $package = $this->load('article', 'article');
            if ($package->addArticleStat($article['articleid'], $article['authorid'], 'reward', $need_egold)) {
                $score = ceil($need_egold * 0.2); //���ͽ���20%�������
                if ($score > 0) {
                    //�ӻ���
                    $users_handler->changeScore($auth['uid'], $score, true);
                }
                $users_handler->payout($users->getVar('uid', 'n'), $need_egold);
                //д����
                if (!$params['pcontent']) {
                    $params['pcontent'] = "�Ȿ��̫���ˣ�����" . $params['num'] . "��" . $reward_name . "��ϣ���������Ӿ��ʣ�";
                }
                $this->addReview($params);
                $this->jumppage($article['url_module_articleinfo'], LANG_DO_SUCCESS, $jieqiLang['article']['batch_reward_success']);
            } else {
                $this->printfail();
            }
        }


        return array(
            'egolds' => $users->getVar('egold', 'n'),
            'pollnum' => $pollnum,
            'getscore' => $jieqiConfigs['article']['scorevipvote'],
            'article' => $article,
            'reward_item' => $jieqiSetting['article']['reward_item'],
            'reward_pic' => $reward_pic,
            'reward_name' => $reward_name,
            'reward_price' => $reward_price,
            'reward_id' => $item
        );
    }

    function cuigeng($params = array())
    {
        return array(
            'article' => $this->getArticle($params)
        );
    }

    function reviews($params = array())
    {
        //�ύ����
        if ($this->submitcheck()) {
            $reviewsObj = $this->model('reviews', 'article');
            $reviewsObj->add($params);
        }
        return array(
            'article' => $this->getArticle($params)
        );
    }

    function addReview($params)
    {
        global $jieqiConfigs;
        //д����
        if (!$params['pcontent']) {
            $params['pcontent'] = "��д�������������Ŷ����";
        }

        $plen = strlen($params['pcontent']);
        if ($plen >= $jieqiConfigs['article']['minreviewsize'] && (!$jieqiConfigs['article']['maxreviewsize'] || $plen <= $jieqiConfigs['article']['maxreviewsize'])) {
            $reviews = $this->load('reviews', 'article');
            $reviews->addReview($params);
        }
    }

    /**
     * ��¼�û��Ƿ��ղ�aid�鼮
     * @author chengyuan 2015-6-4 ����4:20:31
     * @param unknown $aid �鼮id
     * @return json
     */
    function asyncBookcaseState($aid)
    {
        $auth = $this->getAuth();
        if ($aid && $auth['uid'] > 0) {
            $this->db->init('bookcase', 'caseid', 'article');
            $this->db->setCriteria();
            $this->db->criteria->add(new Criteria('userid', $auth['uid']));
            $this->db->criteria->add(new Criteria('articleid', $aid));
            $this->db->queryObjects();
            $state = $this->db->getObject() ? 'true' : 'false';
            $this->msgwin('', $state);
        }
    }

    /**
     * �Զ������ǩ
     * <p>
     * goodnum ���ղ�+1
     * <p>
     * �����Զ�goodnum+1
     * @author chengyuan 2015-6-3 ����2:49:40
     * @param unknown $aid
     * @param unknown $cid
     */
    function autoAddBookCase($aid, $cid)
    {
        $_USER = $this->getAuth();
        $bookcaseModel = $this->model('bookcase', 'article');
        //addBookmark ��������
        $result = $bookcaseModel->addBookmark($_USER['uid'], $_USER['username'], $aid, $cid);
        if ($result > 1) {
            //�����ֶ�goodnum+1
            $package = $this->load('article', 'article');
            $this->addLang('article', 'bookcase');
            $jieqiLang['article'] = $this->getLang('article');
            $package->addArticleStat($aid, 0, 'autogoodnum');//������Զ���
            $this->msgwin(LANG_DO_SUCCESS, $jieqiLang['article']['add_chaptermark_success']);
        }
    }

    function addBookCase($params)
    {
        global $jieqiModules;
        global $jieqiHonors;

        $this->addConfig('article', 'configs');
        $this->addLang('article', 'article');
        $this->addLang('article', 'bookcase');
        $this->addLang('system', 'honors');
        $this->addConfig('article', 'right');
        $jieqiConfigs['article'] = $this->getConfig('article', 'configs');
        $jieqiLang['article'] = $this->getLang('article'); //�������԰����ø�ֵ
        $jieqiRight['article'] = $this->getConfig('article', 'right');
        $users_handler = $this->getUserObject();
        $maxnum = $jieqiConfigs['article']['maxbookmarks'];
        $honorid = jieqi_gethonorid($_SESSION['jieqiUserScore'], $jieqiHonors);
        if ($honorid && isset($jieqiRight['article']['maxbookmarks']['honors'][$honorid]) && is_numeric($jieqiRight['article']['maxbookmarks']['honors'][$honorid])) {
            $maxnum = intval($jieqiRight['article']['maxbookmarks']['honors'][$honorid]);
        }
        $_USER = $this->getAuth();
        if (!$article = $this->getArticle($params)) $this->printfail($jieqiLang['article']['article_not_exists']);//�ж������Ƿ����
        $this->db->init('bookcase', 'caseid', 'article');
        $this->db->setCriteria();
        $this->db->criteria->add(new Criteria('userid', $_USER['uid'], '='));
        $cot = $this->db->getCount($this->db->criteria);
        if (!empty($params['cid']) && !empty($params['aid'])) {
            $bookcaseModel = $this->model('bookcase', 'article');
            $result = $bookcaseModel->addBookmark($_USER['uid'], $_USER['username'], $params['aid'], $params['cid']);
            if ($result == 1) {
                $this->printfail($jieqiLang['article']['add_chaptermark_failure']);
            } elseif ($result == 2) {
                //��ǩ����
                $this->jumppage($this->geturl(JIEQI_MODULE_NAME, 'reader', "SYS=aid={$params['aid']}&cid={$params['cid']}"), LANG_DO_SUCCESS, $jieqiLang['article']['add_chaptermark_success']);
                //$this->msgwin(LANG_DO_SUCCESS, $jieqiLang['article']['add_chaptermark_success']);
            } elseif ($result == 3) {
                //��ǩ����
                $this->jumppage($this->geturl(JIEQI_MODULE_NAME, 'reader', "SYS=aid={$params['aid']}&cid={$params['cid']}"), LANG_DO_SUCCESS, $jieqiLang['article']['add_chaptermark_success']);
            }
        } elseif (!empty($params['aid']) && empty($params['cid'])) {
            $this->db->criteria->add(new Criteria('articleid', $params['aid'], '='));
            $this->db->queryObjects();
            $bookcase = $this->db->getObject();
            unset($this->db->criteria);
            if ($bookcase) { //�Ѿ������
                $this->printfail($jieqiLang['article']['article_has_incase']);
            } else {
                $bookcase['joindate'] = JIEQI_NOW_TIME;
                $bookcase['lastvisit'] = JIEQI_NOW_TIME;
                $bookcase['flag'] = 0;

            }
            $bookcase['articleid'] = $article['articleid'];
            $bookcase['articlename'] = $article['articlename'];
            $bookcase['userid'] = $_USER['uid'];
            $bookcase['username'] = $_USER['username'];
            $bookcase['chapterid'] = 0;
            $bookcase['chaptername'] = '';
            $bookcase['chapterorder'] = 0;
            $this->db->init('bookcase', 'caseid', 'article');
            if (!$this->db->add($bookcase)) {
                $this->printfail($jieqiLang['article']['add_articlemark_failure']);
            } else {
                //������־
                $package = $this->load('article', 'article');
                if ($package->addArticleStat($article['articleid'], $article['authorid'], 'goodnum')) {
                    if ($jieqiConfigs['article']['addcasescore'] > 0) {
                        //����
                        $users_handler->changeScore($_USER['uid'], $jieqiConfigs['article']['addcasescore'], true);
                    }
                }
            }
            $this->jumppage($article['url_module_articleinfo'], LANG_DO_SUCCESS, $jieqiLang['article']['add_articlemark_success']);
        } else {
            $this->printfail($jieqiLang['article']['article_not_exists']);
        }
    }

    function getArticle($params = array())
    {
        $this->db->init('article', 'articleid', 'article');
        $this->db->setCriteria(new Criteria('articleid', $params['aid']));
        if ($article = $this->db->get($this->db->criteria)) {
            $package = $this->load('article', 'article');
            return $package->article_vars($article);
        } else {
            return false;
        }
    }

    function lunpan($params)
    {
        $auth = $this->getAuth();
        $uid = $auth['uid'];
        if ($params['action']) {
            if ($this->is_first($uid) || $this->get_user_activity_num($uid, 2017) && $this->dec_user_activity_num($uid, 2017)) {
                $reward_id = $this->get_lunpan_reward();
                $msg = $this->lunpan_reward($uid, $reward_id);
                if ($msg) {
                    $arr=array(
                        'stat'=>'succ',
                        'times'=> $this->get_user_activity_num($uid, 2017),
                        'num'=>$reward_id,
                        'msg'=>iconv("gbk","utf-8",$msg)
                    );

                }
                else {
                    $arr=array(
                        'stat'=>"failed",
                        'msg'=>iconv("gbk","utf-8",'ϵͳ��æ�����Ժ�����')
                    );
                }
            }
            else {
                $arr=array(
                    'stat'=>"failed",
                    'msg'=>iconv("gbk","utf-8",'������ת�����Ѿ������ˣ����������ɣ���ϸ������㡰�����')
                );
            }
            echo json_encode($arr);
            exit();
        }
        else {
            $params['list']=$this->get_lunpan_rewardlist();
            if ($this->is_first($uid)) {
                $times=$this->get_user_activity_num($uid,2017)+1;
            }
            else {
                $times=$this->get_user_activity_num($uid,2017);
            }
            $params['times']=$times;
            return $params;
        }
    }

    private function get_user_activity_num($uid,$hid) {
        $sql="select * from jieqi_system_activity where uid=$uid and hid=$hid";
        $res=$this->db->query($sql);
        $row=$this->db->getRow($res);
        if ($row) {
            return $row['num'];
        }
        else {
            return 0;
        }
    }

    private  function dec_user_activity_num($uid,$hid) {
        $sql="update jieqi_system_activity set num=num-1 where uid=$uid and hid=$hid and num>=1";
        $this->db->query($sql);
        return $this->db->getAffectedRows();
    }

    private function get_lunpan_reward() {
        $key=rand(0,9999);
        if ($key<1000) {
            return 1;
        }
        if ($key<1500) {
            return 2;
        }
        if ($key<2500) {
            return 3;
        }
        if ($key<6500) {
            return 4;
        }
        if ($key<6700) {
            return 5;
        }
        if ($key<7700) {
            return 6;
        }
        if ($key<7800) {
            return 7;
        }
        if ($key<10000) {
            return 8;
        }
    }

    private function add_user_activity_num($uid,$hid) {
        $num=$this->get_user_activity_num($uid,$hid);
        if ($num===false) {
            $sql="insert into jieqi_system_activity (uid,hid,num) values('$uid','$hid',1)";
            $num=1;
        }
        else {
            $sql="update jieqi_system set num=num+1 where uid=$uid and hid=$hid";
            $num=$num+1;
        }

        return $num;
    }

    private function is_first($uid) {
        $time=strtotime(date("Y-m-d"));
        $sql="select * from jieqi_system_lunpan where uid=$uid and time>=$time limit 1";
        $r1=$this->db->query($sql);
        if ($this->db->getRow($r1)) {
            return false;
        }
        else {
            return true;
        }
    }

    private function lunpan_reward($uid,$reward_id) {
        $auth=$this->getAuth();
        $uname=addslashes($auth['useruname']);
        $gift=0;
        $addnum=0;
        switch($reward_id) {
            case 1:$msg="лл����";break;
            case 2:$gift=1888;$addnum=0;$msg="��ϲ{$uname}������1888��ȯ";break;
            case 3:$gift=0;$addnum=1;$msg="��ϲ{$uname}����������һ��";break;
            case 4:$gift=88;$addnum=0;$msg="��ϲ{$uname}������88��ȯ";break;
            case 5:$msg="��ϲ{$uname}�����˽𼦹���";break;
            case 6:$gift=666;$addnum=0;$msg="��ϲ{$uname}������666��ȯ";break;
            case 7:$msg="��ϲ{$uname}�����˰��깫��";break;
            case 8:$gift=168;$addnum=0;$msg="��ϲ{$uname}������168��ȯ";break;
        }
        if ($gift>0) {
            $users_handler =  $this->getUserObject();
            $ret=$users_handler->income($auth['uid'], $gift, 1, 0, 0);
            if (!$ret) {
                $this->printfail('������ȯʧ��');
                exit();
            }
        }
        if ($addnum) {
            $this->add_user_activity_num($uid,2017);
        }

        $time=time();
        $sql="insert into jieqi_system_lunpan (uid,time,reward_num,msg ) values('$uid','$time','$reward_id','$msg')";
        $this->db->query($sql);
        return $msg;
    }

    private function get_lunpan_rewardlist() {
        $sql="select * from jieqi_system_lunpan order by id desc limit 10";
        $res=$this->db->query($sql);
        $infolist=array();
        while ($row=$this->db->getRow($res)) {
            $infolist[]=array('info'=>$row['msg']);
        }
        return $infolist;
    }


    function dati($params) {
        $qlist=array(
            1=>array('2017-01-28','2017����ʲô�ꣿ','����','ţ��','����','����','c'),
            2=>array('2017-01-29','�����ĸ��Ǳ�վ����ȷ���ƣ�','���鷻','���鷿','�鷿��','�鷿��','a'),
            3=>array('2017-01-30','����һ�β�������Ů�������ƽ�ʲô��','������','����','Ļ����','����','d'),
            4=>array('2017-01-31','�����Ǹ���ɡ���Ů�������ƽ�ʲô��','ľ����','������','Ļ����','����','a'),
            5=>array('2017-02-01','���й��²��ǡ��������塷�е�һ����','����é®','�������','����׹Ǿ�','��԰������','c'),
            6=>array('2017-02-02','��ңԶ�Ķ�����һ�����������׸��еĸ�ʣ�','������Ӱ','���Ĵ���','��������','�ҵ����','b'),
            7=>array('2017-02-03','�ҹ��Ĺ�����','����','����','ƹ����','��ë��','c'),
            8=>array('2017-02-04','�������꣬���Ǽ���ʱ��Ҫ˵���������ա���ʲô��˼��','�����','��������','���','��ϲ����','b')
        );
        $date=date("Y-m-d");
        $params['id']=0;
        foreach($qlist as $id=>$q) {
            if ($q[0]==$date) {
                $params['id']=$id;
            }
        }

        $id=$params['id'];
        $q=$qlist[$id];
        if ($q[0]!=$date) {
            $params['errmsg']='������ʱû�д�����������ע���ǵĻ���棬лл';
            $params['succ']=0;
            $params['action']=1;
            return $params;
        }
        $auth=$this->getAuth();
        $uid=$auth['uid'];


        $time=strtotime(date("Y-m-d"));
        $sql="select * from jieqi_system_dati where uid=$uid and time>=$time";
        $r=$this->db->query($sql);
        if ($this->db->getRow($r)) {
            $params['errmsg']='�������Ѿ�������ˣ�����������';
            $params['succ']=0;
            $params['action']=1;
            return $params;
        }
        $params['question']=$q[1];
        $params['c1']=$q[2];
        $params['c2']=$q[3];
        $params['c3']=$q[4];
        $params['c4']=$q[5];
        $answer=$q[6];

        if ($params['action']) {
            if ($params['pay']==$answer) {
                $gift=rand(30,50);
                $params['succ']=1;
                $params['answer']=$answer;
                $params['gift']=$gift;
                $users_handler =  $this->getUserObject();
                $ret=$users_handler->income($auth['uid'], $gift, 1, 0, 0);
                if (!$ret) {
                    $this->printfail('������ȯʧ��');
                    exit();
                }
            }
            else{
                $params['answer']=$answer;
                switch($answer) {
                    case 'a':$params['answer'].=",".$q[2];break;
                    case 'b':$params['answer'].=",".$q[3];break;
                    case 'c':$params['answer'].=",".$q[4];break;
                    case 'd':$params['answer'].=",".$q[5];break;
                }
                $params['succ']=0;
            }
            $id=intval($id);
            $time=time();
            $stat=$params['succ'];
            $sql="insert into jieqi_system_dati(uid,qid,time,gift,stat) values('$uid','$id','$time','$gift','$stat')";
            $this->db->query($sql);
        }
        $params['num']=round(time()/23456);

        return $params;
    }
} 

?>