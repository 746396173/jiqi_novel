function radioShow(){
	var myradio=document.getElementsByName("myradio");  //��ȡ��ǩ��Ϊmyradio�ı�ǩ
	var div=document.getElementById("c").getElementsByTagName("div");
	for(i=0;i<div.length;i++){
	if(myradio[i].checked){
	div[i].style.display="block";
	}
	else{
	div[i].style.display="none";
	}
	}
	}