<div class="re_teacher_page">
	<div id="page">
		<a href="?pageNum=1&can=<?php echo $id;?>&paidao=<?php echo $paidao;?>&zhikan=<?php echo $kan;?>">首页</a>
		<a href="?pageNum=<?php echo $pageNum==1?1:($pageNum-1)?>&can=<?php echo $id;?>&paidao=<?php echo $paidao;?>&zhikan=<?php echo $kan;?>">上一页</a>
		<a href="#" class="page_teacher">
			<?php echo $pageNum?>
		</a>
		<a href="?pageNum=<?php echo $pageNum==$yeshu?$yeshu:($pageNum+1)?>&can=<?php echo $id;?>&paidao=<?php echo $paidao;?>&zhikan=<?php echo $kan;?>">下一页</a>
		<a href="?pageNum=<?php echo $yeshu?>&can=<?php echo $id;?>&paidao=<?php echo $paidao;?>&zhikan=<?php echo $kan;?>">尾页</a>
		<p class="pageWork">
			共
			<b><?php echo $yeshu?></b> 页
			<b><?php echo $toutal?></b> 条数据
		</p>
	</div>
</div>