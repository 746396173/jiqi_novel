<?php
/**
 * ����Զ������������ģ�ͣ����漰���ݿ⣬����������չ
 * @auther by: liuxiangbin
 * @createtime : 2014-12-17
 */

class bookpackagesortModel extends Model {
    
    /**
     * ��õ�ǰ�����Ӧ����
     * @param type $params
     */
    public function get_bosort($params) {
        $this->addConfig('article', 'bookpackage');
        $bpSort = $this->getConfig('article', 'bookpackage');
//        $this->dump($bpSort);
        return $bpSort;
    }
}