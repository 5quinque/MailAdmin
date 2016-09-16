				<div id="sidebar" class="col-xs-6 col-sm-3 sidebar-offcanvas">
					<div class="panel panel-default">
						<div class="panel-heading">Domains <span class="badge"><?php echo $domainCount; ?></span></div>
						<div class="panel-body">
							<div class="list-group">
								<?php
								foreach ($domains as $d) {
									$active = '';

									if (isset($_GET['domain'])) {
										if ($_GET['domain'] == $d->domain) {
											$active = 'active';
										}
									}

									echo "<a class='list-group-item {$active}' href='?domain={$d->domain}'>{$d->domain}</a>";
								}?>
							</div> <!-- list-group -->
						</div> <!-- panel-body -->
					</div> <!-- panel -->
				</div>	<!-- sidebar -->

