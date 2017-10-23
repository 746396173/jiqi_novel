<?php
/**
 * @author        huliming
 * @datetime   
 * @version        1.0.0
 */

/**
 * Short descr��ption.
 *
 * Detail descr��ption
 * @author      
 * @version      1.0
 * @copyright   
 * @access       public
 */
class Tree
{
    /**
     * Descr��ption
     * @var      
     * @since     1.0
     * @access    private
     */
    var $data    = array();
   
    /**
     * Descr��ption
     * @var      
     * @since     1.0
     * @access    private
     */
    var $child    = array(-1=>array());
   
    /**
     * Descr��ption
     * @var      
     * @since     1.0
     * @access    private
     */
    var $layer    = array(-1=>-1);
	//©����setNode����
    var $layerno    = array();
    /**
     * Descr��ption
     * @var      
     * @since     1.0
     * @access    private
     */
    var $parent    = array();

    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function Tree ($value)
    {
        $this->setNode(0, -1, $value);
    } // end func

    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function setNode ($id, $parent, $value)
    {
        $parent = $parent?$parent:0;

        $this->data[$id]            = $value;
        //$this->child[$id]            = array();
        $this->child[$parent][]        = $id;
        $this->parent[$id]            = $parent;
        if (!isset($this->layer[$parent]))
        {
            $this->layerno[$id] = $parent;
        }
        //else
        //{
            $this->layer[$id] = $this->layer[$parent] + 1;
        //}
    } // end func
   
    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function getList (&$tree, $root= 0)
    {
	    if(!isset($this->child[$root])) return false;
        foreach ($this->child[$root] as $key=>$id)
        {
            $tree[] = $id;

            if ($this->child[$id]) $this->getList($tree, $id);
        }
    } // end func

    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function getValue ($id)
    {
        return $this->data[$id];
    } // end func

    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function getLayer ($id, $space = false)
    {
	    if(!is_array($space)){
			return $space?str_repeat($space, $this->layer[$id]):$this->layer[$id];
		}else{
		    return $space?str_repeat($space[$this->layer[$id]-1], $this->layer[$id]-1):$this->layer[$id];
		}
    } // end func

    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function getParent ($id)
    {
        return $this->parent[$id];
    } // end func
   
    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function getParents ($id)
    {
        while ($this->parent[$id] != -1)
        {
            $id = $parent[$this->layer[$id]] = $this->parent[$id];
        }

        ksort($parent);
        reset($parent);

        return $parent;
    } // end func
   
    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function getChild ($id)
    {
        return $this->child[$id];
    } // end func

   
    /**
     * Short descr��ption.
     *
     * Detail descr��ption
     * @param      none
     * @global     none
     * @since      1.0
     * @access     private
     * @return     void
     * @update     date time
    */
    function getChilds ($id = 0)
    {
	    if($this->layerno) {//��TREE��setNode˳�����ʱ��ִ��©����setNode
		    foreach($this->layerno as $k=>$v){
			    $this->layer[$k] = $this->layer[$v] + 1;
			}
		}
        $child = array($id);
        $this->getList($child, $id);

        return $child;
    } // end func
} // end class
?>