<?php
//xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
/**
 * Ӧ������ļ� * @copyright   Copyright(c) 2014
 * @author      huliming* @version     1.0
 */
if(!defined('JIEQI_MODULE_NAME')) define('JIEQI_MODULE_NAME', 'system');
require dirname(__FILE__).'/global.php';
//require 'E:/wwwroot/system/app.php';
Application::run();
//����ļ���Ҫ����2���£���һ����ϵͳ�������࣬�ڶ������������ļ���Ȼ������run��������������������Ϊ������������2���ļ���ʲô���ݣ����ǽ�������������

//$data = xhprof_disable();   //������������

// xhprof_lib�����صİ���������Ŀ¼,�ǵý�Ŀ¼���������е�php������
//include_once "xhprof_lib/utils/xhprof_lib.php";
//include_once "xhprof_lib/utils/xhprof_runs.php";
//
//$objXhprofRun = new XHProfRuns_Default();
//$run_id = $objXhprofRun->save_run($data, "xhprof");
?>