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
			<h2>Regions</h2>
			<p><a class="btn primary" href="<?php echo $url;?>/region/create">Create new region &raquo;</a></p>
			<table id="post_table" class="bordered-table zebra-striped">
				<thead>
					<tr>
						<th>id</th>
						<th>site</th>
						<th>name</th>
						<th>content</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					while ($row = $region_list->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row["id"]; ?></td>
							<td><?php echo $row["site"]; ?></td>
							<td><?php echo $row["name"]; ?></td>
							<td><?php echo substr(htmlspecialchars($row["content"]),0,50); ?></td>
							<td>
								<a href="/<?php the_siteinfo("base"); ?>region/edit/<?php echo $row["id"]; ?>" title="Edit post">Edit</a>
								<a href="/<?php the_siteinfo("base"); ?>region/delete/<?php echo $row["id"]; ?>" onclick="return confirm('Do you really want to delete this region?')" title="Delete region">X</a>
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