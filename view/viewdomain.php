<?php
include 'view/header.php';
include 'view/sidebar.php';
?>
				<div class="col-xs-12 col-sm-9">
					<ul class="nav nav-tabs">
						<li class="active" role="presentation">
							<a data-toggle="tab" href="#users">Users</a>
						</li>
						<li role="presentation">
							<a data-toggle="tab" href="#forwarders">Forwarders</a>
						</li>
						<li role="presentation">
							<a data-toggle="tab" href="#remove">Remove Domain</a>
						</li>

					</ul>

					<div class="tab-content">
						<div id="users" class="tab-pane fade in active">
							<h3>Users <span class="badge"><?php echo $userCount; ?></span></h3>
							<div class='list-group'>
								<a class='list-group-item' id="addAccount" href='#'><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add Mailbox</a>
								<span id="newAccount" class='list-group-item hidden' href='#'>
									<form method="post">
										<input type="hidden" name="domain" value="<?php echo $domain->domain; ?>">
										<div class="input-group form-group">
											<input type="text" name="username" class="form-control" placeholder="Recipient's username" aria-describedby="domain-addon">
											<span class="input-group-addon" id="domain-addon">@<?php echo $domain->domain; ?></span>
										</div>
										<div class="input-group form-group">
											<input type="password" class="form-control" name="password1" id="password1" placeholder="Password">
											<span class="input-group-btn">
												<button type="button" id="genPass" class="btn btn-info">Generate Password</button>
											</span>
										</div>
										<div class="form-group">
											<input type="password" class="form-control" name="password2" id="password2" placeholder="Repeat Password">
										</div>
										<div class="checkbox">
											<label>
												<input id='plainPass' type="checkbox"> Show Password
											</label>
										</div>
										<button type="submit" class="btn btn-default">Create Mailbox</button>
									</form>


								</span>
								<?php
								$userNumber = 0;
								foreach ($users as $u) {
									$userNumber += 1;
									echo "<a class='list-group-item usersettings' href='#userSettings{$userNumber}'>{$u->address}</a>";
									?>
									<span class='list-group-item hidden' id='userSettings<?php echo $userNumber; ?>'>
										<form method="post">
											<input type="hidden" name="updatePassword" value="<?php echo $u->address; ?>">
											<input type="hidden" name="username" value="<?php echo $u->address; ?>">
											<div class="input-group form-group">
												<input type="password" class="form-control" name="password1" id="password1-<?php echo $userNumber; ?>" placeholder="Password">
												<span class="input-group-btn">
													<button type="button" id="genPass-<?php echo $userNumber; ?>" class="btn btn-info genPass">Generate Password</button>
												</span>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" name="password2" id="password2-<?php echo $userNumber; ?>" placeholder="Repeat Password">
											</div>
											<div class="checkbox">
												<label>
													<input id='plainPass-<?php echo $userNumber; ?>' class="plainPass" type="checkbox"> Show Password
												</label>
											</div>
											<button type="submit" class="btn btn-default">Update Password</button>
										</form>
										<p>
										<form method="post">
											<div class="form-group">
												<input type="hidden" name="deleteUser" value="<?php echo $u->address; ?>">
												<button type="submit" class="btn btn-danger">Delete Mailbox</button>
											</div>
										</form>
										</p>
									</span>

									<?php
								}?>
							</div>
						</div>
						<div id="forwarders" class="tab-pane fade">
							<h3>Forwarders <span class="badge"><?php echo $forwardCount; ?></span></h3>
							<div class='list-group'>
								<a class='list-group-item' id="addForwarder" href='#'><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add Forwarder</a>
								<span id="newForwarder" class='list-group-item hidden' href='#'>
									<form method="post">
										<input type="hidden" name="domain" value="<?php echo $domain->domain; ?>">
										<input type="hidden" name="source" id="realSource" value="null">
										<div class="input-group form-group">
											<span class="input-group-btn">
												<div class="btn-group" role="group">
													<button type="button" id="sourceSet" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Source Address <span class="caret"></span></button>
													<ul class="dropdown-menu">
														<?php
														foreach($users as $u) {
															echo "<li><a class='sourceForward' href='#'>{$u->address}</a></li>";
														} ?>
													</ul>
												</div>
											</span>
											<input type="text" name="destination" class="form-control" placeholder="Destination Email Address" aria-describedby="forwarder-addon">
										</div>
										<button type="submit" class="btn btn-default">Create Forwarder</button>
									</form>
								</span>
								<?php
								$forwardNumber = 0;
								foreach ($forwarders as $f) {
									$forwardNumber += 1;
									echo "<form method='post'>";
									echo "<input type='hidden' name='forward_address' value='{$f->source}'>";
									echo "<span class='list-group-item forwardsettings'>{$f->source} <span class='glyphicon glyphicon-arrow-right' aria-hidden='true'></span> {$f->destination}

								<button type='submit' class='btn btn-xs btn-danger pull-right'>Remove</button>

</span>
</form>
";

								}?>
							</div>
						</div>
						<div id="remove" class="tab-pane fade">
							<h3>Remove Domain</h3>
							<p>Removing the domain will remove all mailboxes and emails stored on this domain.</p>
							<form class="form-inline" action="" method="get">
								<input type="hidden" name="remove" value="<?php echo $domain->domain; ?>">
								<button type="submit" class="btn btn-danger">Remove</button>
							</form>


						</div>
					</div>

				</div>
			</div>
		</div>

<?php
include 'view/footer.php';
?>
