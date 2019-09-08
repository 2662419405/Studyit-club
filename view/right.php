<div class="fixedbar">
	<ul>
		<li class="business-consulting"  alt="点击这里给我发消息" title="点击这里给我发消息" onclick="fasong()">
			<i class="iconfont icon-business-consult">
				
			</i>
		</li>
		<li class="forum"  onclick="window.location.href='chat.php'">
			<a href="#">
				<i class="iconfont icon-official-forum">
					
				</i>
			</a>
		</li>
		<li class="contact-us"  onclick="window.location.href='setting.php'">
			<a href="#">
				<i class="iconfont icon-contact-us">
					
				</i>
			</a>
		</li>
		<li class="scroll-top" onclick="huiding()">
			<a href="setting.php">
				<i class="iconfont icon-scroll-top">
					
				</i>
			</a>
		</li>
	</ul>
</div>
<script>
   function huiding(){
       timer=setInterval(function(){
           var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
           var ispeed=Math.floor(-scrollTop/6);
           if(scrollTop<=5){
               clearInterval(timer);
           }
           document.documentElement.scrollTop=document.body.scrollTop=scrollTop+ispeed;
       },30)
       
   };
   
   function fasong(){
  window.open("http://wpa.qq.com/msgrd?v=3&uin=2662419405&site=qq&menu=yes");
   }
</script>