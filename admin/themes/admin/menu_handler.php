<?php
get_header();
$url = get_siteInfo("url");
global $giraffe;
?>
<div class="container-fluid">
	<?php get_sidebar(); ?>
	<div class="content">	
	<div class="row">
		<div class="span16">
			<h2>Menu handler</h2>
			<p><a class="btn primary" href="<?php echo $url;?>/menuhandler/create">Create new Link &raquo;</a></p>
			<table id="table" class="bordered-table zebra-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>Site</th>
						<th>Title</th>
						<th>Url</th>
						<th>Anchor</th>
						<th>Group</th>
						<th>Priority</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					while ($row = $list->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row["id"]; ?></td>
							<td><?php echo $row["site"]; ?></td>
							<td><?php echo $row["title"]; ?></td>
							<td><?php echo $row["url"]; ?></td>
							<td><?php echo $row["anchor"]; ?></td>
							<td><?php echo $row["menu_group"]; ?></td>
							<td><?php echo $row["menu_priority"]; ?></td>
							<td>
								<a href="/<?php the_siteinfo("base"); ?>menuhandler/edit/<?php echo $row["id"]; ?>" title="Edit post">Edit</a>
								<a href="/<?php the_siteinfo("base"); ?>menuhandler/delete/<?php echo $row["id"]; ?>" onclick="return confirm('Do you really want to delete this Link?')" title="Delete post">X</a>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php get_footer(); ?>