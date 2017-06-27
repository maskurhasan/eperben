<?php
//session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
?>
  <div class="alert alert-block alert-success">
  	<button type="button" class="close" data-dismiss="alert">
  	<i class="ace-icon fa fa-times"></i>
  									</button>

  									<i class="ace-icon fa fa-check green"></i>

  									Selamat Datang
  									<strong class="green">
  										<?php echo $_SESSION['nm_Lengkap'] ?>

  									</strong>,
  	                 <?php echo $appName; ?>
  								</div>

                  <div class="row">
                  									<div class="col-sm-6">
                  										<div class="widget-box transparent" id="recent-box">
                  											<div class="widget-header">
                  												<h4 class="widget-title lighter smaller">
                  													<i class="ace-icon fa fa-rss orange"></i>DAFTAR KEGIATAN
                  												</h4>

                  												<div class="widget-toolbar no-border">
                  													<ul class="nav nav-tabs" id="recent-tab">
                  														<li class="active">
                  															<a data-toggle="tab" href="#task-tab">Kegiatan</a>
                  														</li>

                  														<li>
                  															<a data-toggle="tab" href="#member-tab">Agenda</a>
                  														</li>

                  														<li>
                  															<a data-toggle="tab" href="#comment-tab">Comments</a>
                  														</li>
                  													</ul>
                  												</div>
                  											</div>

                  											<div class="widget-body">
                  												<div class="widget-main padding-4">
                  													<div class="tab-content padding-8">
                  														<div id="task-tab" class="tab-pane active">

                  															<ul id="tasks" class="item-list">
                                                  <?php
                                                  if($_SESSION['UserLevel']==1) {
                                                    $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b
                                                                        WHERE a.id_Skpd = b.id_Skpd");
                                                  } else {
                                                    $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b
                                                                        WHERE a.id_Skpd = b.id_Skpd
                                                                        AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                                                  }
                                                  while($dt = mysql_fetch_array($sql)) {
                                                    $jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
                                                    $jns = $dt['Prioritas'];
                                                  ?>
                  																<li class="item-red clearfix">
                  																	<label class="inline">
                  																		<input type="checkbox" class="ace" />
                  																		<span class="lbl"> <?php echo $dt[Perihal] ?></span>
                  																	</label>

                  																	<div class="pull-right action-buttons">
                  																		<a href="#" class="blue">
                  																			<i class="ace-icon fa fa-pencil bigger-130"></i>
                  																		</a>

                  																		<span class="vbar"></span>

                  																		<a href="#" class="red">
                  																			<i class="ace-icon fa fa-trash-o bigger-130"></i>
                  																		</a>

                  																		<span class="vbar"></span>

                  																		<a href="#" class="green">
                  																			<i class="ace-icon fa fa-flag bigger-130"></i>
                  																		</a>
                  																	</div>
                  																</li>
                                                <?php
                                              }
                                                ?>

                  															</ul>
                  														</div>

                  														<div id="member-tab" class="tab-pane">
                  															<div class="clearfix">
                  																<div class="itemdiv memberdiv">
                  																	<div class="user">
                  																		<img alt="Bob Doe's avatar" src="assets/avatars/user.jpg" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Bob Doe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">20 min</span>
                  																		</div>

                  																		<div>
                  																			<span class="label label-warning label-sm">pending</span>

                  																			<div class="inline position-relative">
                  																				<button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">
                  																					<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                  																				</button>

                  																				<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                  																					<li>
                  																						<a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">
                  																							<span class="green">
                  																								<i class="ace-icon fa fa-check bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>

                  																					<li>
                  																						<a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">
                  																							<span class="orange">
                  																								<i class="ace-icon fa fa-times bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>

                  																					<li>
                  																						<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                  																							<span class="red">
                  																								<i class="ace-icon fa fa-trash-o bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>
                  																				</ul>
                  																			</div>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv memberdiv">
                  																	<div class="user">
                  																		<img alt="Joe Doe's avatar" src="assets/avatars/avatar2.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Joe Doe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">1 hour</span>
                  																		</div>

                  																		<div>
                  																			<span class="label label-warning label-sm">pending</span>

                  																			<div class="inline position-relative">
                  																				<button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">
                  																					<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                  																				</button>

                  																				<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                  																					<li>
                  																						<a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">
                  																							<span class="green">
                  																								<i class="ace-icon fa fa-check bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>

                  																					<li>
                  																						<a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">
                  																							<span class="orange">
                  																								<i class="ace-icon fa fa-times bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>

                  																					<li>
                  																						<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                  																							<span class="red">
                  																								<i class="ace-icon fa fa-trash-o bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>
                  																				</ul>
                  																			</div>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv memberdiv">
                  																	<div class="user">
                  																		<img alt="Jim Doe's avatar" src="assets/avatars/avatar.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Jim Doe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">2 hour</span>
                  																		</div>

                  																		<div>
                  																			<span class="label label-warning label-sm">pending</span>

                  																			<div class="inline position-relative">
                  																				<button class="btn btn-minier btn-yellow btn-no-border dropdown-toggle" data-toggle="dropdown" data-position="auto">
                  																					<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                  																				</button>

                  																				<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                  																					<li>
                  																						<a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">
                  																							<span class="green">
                  																								<i class="ace-icon fa fa-check bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>

                  																					<li>
                  																						<a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">
                  																							<span class="orange">
                  																								<i class="ace-icon fa fa-times bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>

                  																					<li>
                  																						<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                  																							<span class="red">
                  																								<i class="ace-icon fa fa-trash-o bigger-110"></i>
                  																							</span>
                  																						</a>
                  																					</li>
                  																				</ul>
                  																			</div>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv memberdiv">
                  																	<div class="user">
                  																		<img alt="Alex Doe's avatar" src="assets/avatars/avatar5.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Alex Doe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">3 hour</span>
                  																		</div>

                  																		<div>
                  																			<span class="label label-danger label-sm">blocked</span>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv memberdiv">
                  																	<div class="user">
                  																		<img alt="Bob Doe's avatar" src="assets/avatars/avatar2.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Bob Doe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">6 hour</span>
                  																		</div>

                  																		<div>
                  																			<span class="label label-success label-sm arrowed-in">approved</span>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv memberdiv">
                  																	<div class="user">
                  																		<img alt="Susan's avatar" src="assets/avatars/avatar3.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Susan</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">yesterday</span>
                  																		</div>

                  																		<div>
                  																			<span class="label label-success label-sm arrowed-in">approved</span>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv memberdiv">
                  																	<div class="user">
                  																		<img alt="Phil Doe's avatar" src="assets/avatars/avatar4.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Phil Doe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">2 days ago</span>
                  																		</div>

                  																		<div>
                  																			<span class="label label-info label-sm arrowed-in arrowed-in-right">online</span>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv memberdiv">
                  																	<div class="user">
                  																		<img alt="Alexa Doe's avatar" src="assets/avatars/avatar1.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Alexa Doe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">3 days ago</span>
                  																		</div>

                  																		<div>
                  																			<span class="label label-success label-sm arrowed-in">approved</span>
                  																		</div>
                  																	</div>
                  																</div>
                  															</div>

                  															<div class="space-4"></div>

                  															<div class="center">
                  																<i class="ace-icon fa fa-users fa-2x green middle"></i>

                  																&nbsp;
                  																<a href="#" class="btn btn-sm btn-white btn-info">
                  																	See all members &nbsp;
                  																	<i class="ace-icon fa fa-arrow-right"></i>
                  																</a>
                  															</div>

                  															<div class="hr hr-double hr8"></div>
                  														</div><!-- /.#member-tab -->

                  														<div id="comment-tab" class="tab-pane">
                  															<div class="comments">
                  																<div class="itemdiv commentdiv">
                  																	<div class="user">
                  																		<img alt="Bob Doe's Avatar" src="assets/avatars/avatar.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Bob Doe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="green">6 min</span>
                  																		</div>

                  																		<div class="text">
                  																			<i class="ace-icon fa fa-quote-left"></i>
                  																			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;
                  																		</div>
                  																	</div>

                  																	<div class="tools">
                  																		<div class="inline position-relative">
                  																			<button class="btn btn-minier bigger btn-yellow dropdown-toggle" data-toggle="dropdown">
                  																				<i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                  																			</button>

                  																			<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                  																				<li>
                  																					<a href="#" class="tooltip-success" data-rel="tooltip" title="Approve">
                  																						<span class="green">
                  																							<i class="ace-icon fa fa-check bigger-110"></i>
                  																						</span>
                  																					</a>
                  																				</li>

                  																				<li>
                  																					<a href="#" class="tooltip-warning" data-rel="tooltip" title="Reject">
                  																						<span class="orange">
                  																							<i class="ace-icon fa fa-times bigger-110"></i>
                  																						</span>
                  																					</a>
                  																				</li>

                  																				<li>
                  																					<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                  																						<span class="red">
                  																							<i class="ace-icon fa fa-trash-o bigger-110"></i>
                  																						</span>
                  																					</a>
                  																				</li>
                  																			</ul>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv commentdiv">
                  																	<div class="user">
                  																		<img alt="Jennifer's Avatar" src="assets/avatars/avatar1.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Jennifer</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="blue">15 min</span>
                  																		</div>

                  																		<div class="text">
                  																			<i class="ace-icon fa fa-quote-left"></i>
                  																			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;
                  																		</div>
                  																	</div>

                  																	<div class="tools">
                  																		<div class="action-buttons bigger-125">
                  																			<a href="#">
                  																				<i class="ace-icon fa fa-pencil blue"></i>
                  																			</a>

                  																			<a href="#">
                  																				<i class="ace-icon fa fa-trash-o red"></i>
                  																			</a>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv commentdiv">
                  																	<div class="user">
                  																		<img alt="Joe's Avatar" src="assets/avatars/avatar2.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Joe</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="orange">22 min</span>
                  																		</div>

                  																		<div class="text">
                  																			<i class="ace-icon fa fa-quote-left"></i>
                  																			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;
                  																		</div>
                  																	</div>

                  																	<div class="tools">
                  																		<div class="action-buttons bigger-125">
                  																			<a href="#">
                  																				<i class="ace-icon fa fa-pencil blue"></i>
                  																			</a>

                  																			<a href="#">
                  																				<i class="ace-icon fa fa-trash-o red"></i>
                  																			</a>
                  																		</div>
                  																	</div>
                  																</div>

                  																<div class="itemdiv commentdiv">
                  																	<div class="user">
                  																		<img alt="Rita's Avatar" src="assets/avatars/avatar3.png" />
                  																	</div>

                  																	<div class="body">
                  																		<div class="name">
                  																			<a href="#">Rita</a>
                  																		</div>

                  																		<div class="time">
                  																			<i class="ace-icon fa fa-clock-o"></i>
                  																			<span class="red">50 min</span>
                  																		</div>

                  																		<div class="text">
                  																			<i class="ace-icon fa fa-quote-left"></i>
                  																			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis &hellip;
                  																		</div>
                  																	</div>

                  																	<div class="tools">
                  																		<div class="action-buttons bigger-125">
                  																			<a href="#">
                  																				<i class="ace-icon fa fa-pencil blue"></i>
                  																			</a>

                  																			<a href="#">
                  																				<i class="ace-icon fa fa-trash-o red"></i>
                  																			</a>
                  																		</div>
                  																	</div>
                  																</div>
                  															</div>

                  															<div class="hr hr8"></div>

                  															<div class="center">
                  																<i class="ace-icon fa fa-comments-o fa-2x green middle"></i>

                  																&nbsp;
                  																<a href="#" class="btn btn-sm btn-white btn-info">
                  																	See all comments &nbsp;
                  																	<i class="ace-icon fa fa-arrow-right"></i>
                  																</a>
                  															</div>

                  															<div class="hr hr-double hr8"></div>
                  														</div>
                  													</div>
                  												</div><!-- /.widget-main -->
                  											</div><!-- /.widget-body -->
                  										</div><!-- /.widget-box -->
                  									</div><!-- /.col -->

                  									<div class="col-sm-6">
                  										<div class="widget-box">
                  											<div class="widget-header">
                  												<h4 class="widget-title lighter smaller">
                  													<i class="ace-icon fa fa-comment blue"></i>
                  													Conversation
                  												</h4>
                  											</div>

                  											<div class="widget-body">
                  												<div class="widget-main no-padding">
                  													<div class="dialogs">
                  														<div class="itemdiv dialogdiv">
                  															<div class="user">
                  																<img alt="Alexa's Avatar" src="assets/avatars/avatar1.png" />
                  															</div>

                  															<div class="body">
                  																<div class="time">
                  																	<i class="ace-icon fa fa-clock-o"></i>
                  																	<span class="green">4 sec</span>
                  																</div>

                  																<div class="name">
                  																	<a href="#">Alexa</a>
                  																</div>
                  																<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis.</div>

                  																<div class="tools">
                  																	<a href="#" class="btn btn-minier btn-info">
                  																		<i class="icon-only ace-icon fa fa-share"></i>
                  																	</a>
                  																</div>
                  															</div>
                  														</div>

                  														<div class="itemdiv dialogdiv">
                  															<div class="user">
                  																<img alt="John's Avatar" src="assets/avatars/avatar.png" />
                  															</div>

                  															<div class="body">
                  																<div class="time">
                  																	<i class="ace-icon fa fa-clock-o"></i>
                  																	<span class="blue">38 sec</span>
                  																</div>

                  																<div class="name">
                  																	<a href="#">John</a>
                  																</div>
                  																<div class="text">Raw denim you probably haven&#39;t heard of them jean shorts Austin.</div>

                  																<div class="tools">
                  																	<a href="#" class="btn btn-minier btn-info">
                  																		<i class="icon-only ace-icon fa fa-share"></i>
                  																	</a>
                  																</div>
                  															</div>
                  														</div>

                  														<div class="itemdiv dialogdiv">
                  															<div class="user">
                  																<img alt="Bob's Avatar" src="assets/avatars/user.jpg" />
                  															</div>

                  															<div class="body">
                  																<div class="time">
                  																	<i class="ace-icon fa fa-clock-o"></i>
                  																	<span class="orange">2 min</span>
                  																</div>

                  																<div class="name">
                  																	<a href="#">Bob</a>
                  																	<span class="label label-info arrowed arrowed-in-right">admin</span>
                  																</div>
                  																<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis.</div>

                  																<div class="tools">
                  																	<a href="#" class="btn btn-minier btn-info">
                  																		<i class="icon-only ace-icon fa fa-share"></i>
                  																	</a>
                  																</div>
                  															</div>
                  														</div>

                  														<div class="itemdiv dialogdiv">
                  															<div class="user">
                  																<img alt="Jim's Avatar" src="assets/avatars/avatar4.png" />
                  															</div>

                  															<div class="body">
                  																<div class="time">
                  																	<i class="ace-icon fa fa-clock-o"></i>
                  																	<span class="grey">3 min</span>
                  																</div>

                  																<div class="name">
                  																	<a href="#">Jim</a>
                  																</div>
                  																<div class="text">Raw denim you probably haven&#39;t heard of them jean shorts Austin.</div>

                  																<div class="tools">
                  																	<a href="#" class="btn btn-minier btn-info">
                  																		<i class="icon-only ace-icon fa fa-share"></i>
                  																	</a>
                  																</div>
                  															</div>
                  														</div>

                  														<div class="itemdiv dialogdiv">
                  															<div class="user">
                  																<img alt="Alexa's Avatar" src="assets/avatars/avatar1.png" />
                  															</div>

                  															<div class="body">
                  																<div class="time">
                  																	<i class="ace-icon fa fa-clock-o"></i>
                  																	<span class="green">4 min</span>
                  																</div>

                  																<div class="name">
                  																	<a href="#">Alexa</a>
                  																</div>
                  																<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>

                  																<div class="tools">
                  																	<a href="#" class="btn btn-minier btn-info">
                  																		<i class="icon-only ace-icon fa fa-share"></i>
                  																	</a>
                  																</div>
                  															</div>
                  														</div>
                  													</div>

                  													<form>
                  														<div class="form-actions">
                  															<div class="input-group">
                  																<input placeholder="Type your message here ..." type="text" class="form-control" name="message" />
                  																<span class="input-group-btn">
                  																	<button class="btn btn-sm btn-info no-radius" type="button">
                  																		<i class="ace-icon fa fa-share"></i>
                  																		Send
                  																	</button>
                  																</span>
                  															</div>
                  														</div>
                  													</form>
                  												</div><!-- /.widget-main -->
                  											</div><!-- /.widget-body -->
                  										</div><!-- /.widget-box -->
                  									</div><!-- /.col -->
                  								</div>

<?php
}
?>
