/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//����ϵͳ BY huliming 2010-11-18
//    ������
//     CreateVote(Max,Def)            ����ƽ���������� MaxΪ�ܹ��������ǣ�DefΪĬ�Ϸ���
//     AddContent(sNA)             ���ƽ������sNA
//     GradeVoteImage1             ����ͼƬһ
//     GradeVoteImage2             ����ͼƬ��
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
var WindowVote = new GradeVote();
function GradeVote() {
     this.VoteMaxStar=1;
     this.VoteCounter=1;
     this.VoteContent=new Array();
     this.GradeVoteImage1=siteurl+"/modules/news/images/mood/mark.gif";
     this.GradeVoteImage2=siteurl+"/modules/news/images/mood/unmark.gif";
	 this.Moodid=1;
	 this.ContentId=0;
	 this.MouseEvent=true;

     this.AddContent=function (sNA) {
          this.VoteContent["_"+this.VoteCounter]=sNA;
          this.VoteCounter++;
     }
     /*������������*/
     this.CreateVote=function (MaxStar,DefaultStar) {
          var i=1,j=1;
          var VoteImgHTML="";
          this.VoteMaxStar=MaxStar;
          for (i=1;i<=MaxStar;i++) {
               VoteImgHTML+="<img id=\"_GradeVoteID"+i+"\" src=\""+(j<=DefaultStar ? this.GradeVoteImage1 : this.GradeVoteImage2)+"\" border=\"0\" onMouseOver=\"WindowVote.HitVote('"+i+"');\" onClick=\"WindowVote.VoteSubmit('"+i+"');\" style=\"cursor:pointer\">";
               j++;
          }
		  document.getElementById("GradeVoteScore").innerHTML=this.VoteScoreContent(DefaultStar);
          if (document.getElementById("GradeVoteArea")!=null) {
               document.getElementById("GradeVoteArea").innerHTML=VoteImgHTML;
          }
          else {
               alert("Object not found!!");
          }
     }
     /*���ֵȼ�����*/
     this.VoteScoreContent=function (sID) {
          var VoteContent=this.VoteContent["_"+sID];
          if (VoteContent=="undefined" || VoteContent==null) VoteContent="Not defined!!";
          return VoteContent;
     }
     /*���ŵ�������*/
     this.HitVote=function (sID) {
		 if(this.MouseEvent==false) return false;
          var i=1;
          for (i=1;i<=sID;i++) {
               document.getElementById("_GradeVoteID"+i).src=this.GradeVoteImage1;
          }
          document.getElementById("GradeVoteScore").innerHTML=this.VoteScoreContent(sID);
          sID++;
          for (i=sID;i<=this.VoteMaxStar;i++) {
               document.getElementById("_GradeVoteID"+i).src=this.GradeVoteImage2;
          }
     }
     /*�ύ����*/
     this.VoteSubmit=function (sID) {
          if(this.MouseEvent==false) return false;
		  var url = siteurl+'/modules/news/mood.php?moodid='+this.Moodid+'&contentid='+this.ContentId+'&vote_id='+sID;
		  GData.getpage(url, function(data){
				if(data.total!=undefined){
					var avg = data.avg;
					var avgs = avg.split('.');
					$('#gradevote_avg1').html(avgs[0]);
					$('#gradevote_avg2').html('.'+avgs[1]);
					$('#gradevote_total').html(data.total);
					WindowVote.MouseEvent=false;
					//alert('�������ύ!');
				}else alert('�벻Ҫ�ظ�����!');
		  });
     }
}