// JavaScript Document
function setTab(m,n){
var tli=document.getElementById("menu"+m).getElementsByTagName("li"); /*��ȡѡ���LI����*/
var mli=document.getElementById("main"+m).getElementsByTagName("ul"); /*��ȡ����ʾ�������*/
for(i=0;i<tli.length;i++){
  tli[i].className=i==n?"hover":""; /*����ѡ���LI�������ʽ�������ѡ��������ʹ��.hover��ʽ*/
  mli[i].style.display=i==n?"block":"none"; /*ȷ����������ʾ��һ������*/
}
}