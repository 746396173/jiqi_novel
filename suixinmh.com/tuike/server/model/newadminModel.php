<?php 
  /** 
   * ϵͳ����->�û������ * @copyright   Copyright(c) 2014 
   * @author      gaoli* @version     1.0 
   */ 
  class newadminModel extends Model{
    //login form
    public function main($params){
      $data=array();
      return $data;
    }

    /**
     * ��ȡȫ������Ӫ��Ա
     * @return [type] [description]
     */
    public function getNewList(){
      $this->db->init('users','uid','tuike');
      $this->db->setCriteria(new Criteria('groupid',7));
      $this->db->criteria->setFields('uid,uname');
      $this->db->queryObjects();
      $arr=array();
      while($v=$this->db->getRow()){
        $arr[]=$v;
      }
      return $arr;
    } 



    /**
     * ��Ӫ�Ķ����б�
     * @param  array   $params       [description]
     * @param  [type]  $custompage   [description]
     * @param  boolean $emptyonepage [description]
     * @return [type]                [description]
     */
    public function newadminOrderList($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){

      if(!isset($params['limit']))$params['limit']=10;
      if (!$params['page']) $params['page'] = 1;
      $params['start']=($params['page'] - 1) * $params['limit'];
      
      /* ���� */ 
      $this->db->setCriteria( );
      if( isset($params['uid']) && $params['uid']>0 ){
        $this->db->criteria->add( new Criteria('o.uid',intval($params['uid'])) );
      }


      if( isset($params['t1'],$params['t2']) ){
        $t1=strtotime($params['t1']);
        $t2=strtotime($params['t2'].' 23:59:59');
        if( $t1<$t2 ){
          $this->db->criteria->add( new Criteria('o.addtime',$t1,'>=') );
          $this->db->criteria->add( new Criteria('o.addtime',$t2,'<=') );
        }else{
          unset( $params['t1'],$params['t2'] );
        }
      }

      /* ��ȡ���� */
      $this->db->criteria->setLimit($params['limit']);
      $this->db->criteria->setStart($params['start']);
      /* ���� */
      $this->db->criteria->setSort($params['orderS']);
      $this->db->criteria->setOrder($params['sort']);
      /* �����ִ�� */
      $q = jieqi_dbprefix('tuike_orderqd').' o LEFT JOIN '.jieqi_dbprefix('tuike_users').' u ON o.uid=u.uid'; 
      $this->db->criteria->setTables($q);
      $this->db->criteria->setFields(" o.id,u.uname,o.addtime,o.company,o.fee,o.fans,o.notes,is_settle,money,o.ordersn");
      
      // define('JIEQI_DEBUG_MODE',1);

      $this->db->queryObjects();

      /* �������� */
      $ar=array();
      while($row=$this->db->getRow()){
        $ar[]=$row;
      }

      // var_dump( $this->db->sqllog('ret') );
      // die();
           

      /* ��ҳ */
      if ($params['pageShow']) {

        $this->setVar('totalcount', $this->db->getCount($this->db->criteria));
        $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);
        $this->jumppage->emptyonepage = $emptyonepage;
        if ($custompage) $this->setVar('custompage', $custompage);
      }
      return $ar;
    }


    /**
     * �������������״̬
     * @param array $params [description]
     */
    public function setPa($params=array()){

      $ty=isset($params['ty'])?trim($params['ty']):'';
      $id=isset($params['id'])?intval($params['id']):0;

      switch($ty){
        case 'settle' :

          $sql='SELECT count(*) FROM '.jieqi_dbprefix('tuike_orderqd').' WHERE id="'.$id.'" AND is_settle=1 ';
          $count=$this->db->getField($this->db->query($sql));
          if( $count !== '0' )$this->pritnfail('��Ϣ����ȷ��');

          $sql="UPDATE ".jieqi_dbprefix('tuike_orderqd').' SET `is_settle`="1",`money`=`fee` WHERE id="'.$id.'"';
          $this->db->query($sql);

          if( $this->db->getAffectedRows() > 0 ){// �޸��Ƿ�ɹ�
            $this->msgwin('���óɹ���');
          }else{
            $this->printfail('����ʧ�ܣ�');
          }

          break;
        case 'cancel_settle' :

          $sql='SELECT count(*) FROM '.jieqi_dbprefix('tuike_orderqd').' WHERE id="'.$id.'" AND is_settle=0 ';
          $count=$this->db->getField($this->db->query($sql));
          if( $count !== '0' )$this->pritnfail('��Ϣ����ȷ��');

          $sql="UPDATE ".jieqi_dbprefix('tuike_orderqd').' SET `is_settle`="0",`money`="0" WHERE id="'.$id.'"';
          $this->db->query($sql);

          if( $this->db->getAffectedRows() > 0 ){// �޸��Ƿ�ɹ�
            $this->msgwin('���óɹ���');
          }else{
            $this->printfail('����ʧ�ܣ�');
          }

          break;
        default:
          $this->printfail('��Ϣ����ȷ��');
      }

    }


    /**
     * �����б�
     * @return [type] [description]
     */
    public function downxls($params){

      /* ���� */ 
      $this->db->setCriteria( );
      if( isset($params['uid']) && $params['uid']>0 ){
        $this->db->criteria->add( new Criteria('o.uid',intval($params['uid'])) );
      }

      if( isset($params['t1'],$params['t2']) ){
        $t1=strtotime($params['t1']);
        $t2=strtotime($params['t2'].' 23:59:59');
        if( $t1<$t2 ){
          $this->db->criteria->add( new Criteria('o.addtime',$t1,'>=') );
          $this->db->criteria->add( new Criteria('o.addtime',$t2,'<=') );
        }else{
          unset( $params['t1'],$params['t2'] );
        }
      }

      /* ��ȡ���� */
      $this->db->criteria->setLimit(1000);
      /* ���� */
      $this->db->criteria->setSort($params['orderS']);
      $this->db->criteria->setOrder($params['sort']);

      /* �����ִ�� */
      $q = jieqi_dbprefix('tuike_orderqd').' o LEFT JOIN '.jieqi_dbprefix('tuike_users').' u ON o.uid=u.uid'; 
      $this->db->criteria->setTables($q);
      $this->db->criteria->setFields(" o.id,u.uname,o.addtime,o.company,o.fee,o.fans,o.notes,is_settle,money,o.ordersn");
      
      // define('JIEQI_DEBUG_MODE',1);
      $this->db->queryObjects();


      /* �������� */
      $str='

<style>
.xl71
  {mso-style-parent:style0;
  mso-number-format:"0";
  text-align:center;
  color:windowtext;
  font-size:12.0pt;
  font-weight:700;
  font-family:΢���ź�, sans-serif;
  mso-font-charset:134;
  border:.5pt solid windowtext;}
</style>

      <table class="tb" >
              <thead>
                <tr style="height: 40px"> 
                    <th class="all_border" style="font-size: 16pt; font-family: ����;" colspan="8"> ����ƽ̨-�����б� </th> 
                </tr> 
                <tr>
                  <th>����id</th>
                  <th>��Ӫ</th>
                  <th>ʱ��</th>
                  <th>��˾��</th>
                  <th>�ܼ�</th>
                  <th>�����ܼ�</th>
                  <th>��˿��</th>
                  <th class="rightborder">��ע</th>
                </tr>
              </thead>
              <tbody>';

      while($row=$this->db->getRow()){
          $str.='<tr>
            <td class="xl71" x:num="'.$row['ordersn'].'">'.$row['ordersn'].'</td>
            <td>'.$row['uname'].' </td>
            <td>'.date('Y-m-d H:i:s',$row['addtime']).' </td>
            <td>'.$row['company'].' </td>
            <td>'.$row['fee'].' </td>
            <td>'.($row['is_settle']==1?$row['money']:'δ����').' </td>
            <td>'.$row['fans'].' </td>
            <td class="rightborder">'.$row['notes'].' </td>
          </tr>
        </tr>';
      }
      $str.='</tbody></table>';
      $str='<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"> <head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> <!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name></x:Name><x:WorksheetOptions><x:Selected/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--> <style type="text/css"> .td{width: 120px; } .gdtjContainer .tb tr{text-align: center; vertical-align: middle; } .gdtjContainer .tb th{border-left: 0.5pt solid #000; border-bottom: 0.5pt solid #000; text-align: center; font-weight: normal; font-size: 10pt; middle: ;; height:30px; } .gdtjContainer .header th {font-size: 12pt; } .gdtjContainer .tb tr .noleftborder {border-left: none; } .gdtjContainer .tb tr .rightborder {border-right: 0.5pt solid #000; } .gdtjContainer .tb td{border-left: 0.5pt solid #000; border-bottom: 0.5pt solid #000; text-align: center; font-weight: normal; font-size: 10pt; middle: ;; height:30px; }.all_border{border: 0.5pt solid #000; } </style> </head> <body> <div class="gdtjContainer"> '.$str.' </div> </body> </html>';
      $str=iconv('GBK', 'UTF-8//IGNORE',$str);

      $file_name='/themes/server/file/ziyunpingtai.xls';
      $file_path=JIEQI_ROOT_PATH_APP.$file_name;
      $file_url=JIEQI_URL.$file_name;

      $back=file_put_contents($file_path,$str);
      if( $back ){
        die(json_encode(array('status'=>'OK','url'=>$file_url)));
      }else{

        https_request_recod_new('',array('type'=>'error_server','msg'=>'��Ӫ��������ʧ�ܣ�'));
        jump_fail('�����ļ�ʧ�ܣ�');
      }




    }





/*--------not_run------------------------------------------------------------------------------------------------------------------*/
/*--------not_run------------------------------------------------------------------------------------------------------------------*/







} 
?>