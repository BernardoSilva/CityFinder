<div class="app-container">
	<ul class="listview">
		<?php
			foreach ($list_continents as $row) {
				?>
  				<li class="">
		  			<a data-type="continent" data-name="<?php echo $row->continent; ?>" href=""><?php echo $row->continent; ?></a>
		  			<script type="text/javascript">
		  				worldApp.addContinent("<?php echo $row->continent; ?>");
		  			</script>
		  		</li>		
				<?php
			}
		?>
	</ul>
</div>
	  	
	  	
