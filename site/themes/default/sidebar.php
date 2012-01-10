<?php
global $giraffe;
?>
<div class="span6">
	<div class="sidebar">
		<div class="well">
			<ul>
				<?php 
				while ($row = $post_list->fetch_assoc()) {
					?>
					<li><a href="<?php echo $giraffe->request_handler->site_url("page/show/".$row["slug"]); ?>" title="<?php echo $row["title"]; ?>"><?php echo $row["title"]; ?></a></li>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
</div>