<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>miteAPI Examples</title>
	<link rel="stylesheet" href="stylesheets/foundation.css">
	<link rel="stylesheet" href="stylesheets/app.css">
	<script src="javascripts/modernizr.foundation.js"></script>
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	<div class="row">
		<div class="twelve columns">
			<h2>miteAPI Examples</h2>
			<p>Here you can test the access and responses of the mite api.</p>
			<hr />
		</div>
	</div>

	<form method="POST" action="" onsubmit="return false;">
	<div class="row">
		<div class="eight columns">
			<div class="row">
				<div class="twelve columns">
					<div class="panel">
						<label>
							<input type="text" name="api_endpoint" placeholder="https://YOURDOMAIN.mite.yo.lk/" />
						</label>
						<label>
							<input type="text" name="api_key" placeholder="API Key" />
						</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="twelve columns">
					<dl class="tabs">
						<dd class="active"><a href="#account">Account</a></dd>
						<dd><a href="#customers">Customers</a></dd>
						<dd><a href="#projects">Projects</a></dd>
						<dd><a href="#times">Times</a></dd>
						<dd><a href="#users">Users</a></dd>
					</dl>
				</div>
			</div>

			<div class="row">
				<div class="twelve columns">
					<ul class="tabs-content">
						<li class="active" id="accountTab">
							<p><a href="#" class="success button account-infos">Get my account infos</a></p>
						</li>
						<li id="customersTab">
							<p>Optional Parameters</p>
							<div class="row">
								<div class="four columns">
									<input type="text" name="c_filter" placeholder="Name" />
								</div>
								<div class="four columns">
									<input type="text" name="c_limit" placeholder="Limit" />
								</div>
								<div class="four columns">
									<input type="text" name="c_offset" placeholder="Offset" />
								</div>
							</div>
							<p><a href="#" class="success button customers">Get Customers</a></p>
						</li>
						<li id="projectsTab">
							<p>Optional Parameters</p>
							<div class="row">
								<div class="four columns">
									<input type="text" name="p_filter" placeholder="Name" />
								</div>
								<div class="four columns">
									<input type="text" name="p_limit" placeholder="Limit" />
								</div>
								<div class="four columns">
									<input type="text" name="p_offset" placeholder="Offset" />
								</div>
							</div>
							<p><a href="#" class="success button projects">Get Projects</a></p>
						</li>
						<li id="timesTab">
							<p><a href="#" class="success button times">Get last 5 time entries</a></p>
						</li>
						<li id="usersTab">
							<p>Optional Parameters</p>
							<div class="row">
								<div class="three columns">
									<input type="text" name="u_filter" placeholder="Name" />
								</div>
								<div class="three columns">
									<input type="text" name="u_email" placeholder="E-mail" />
								</div>
								<div class="three columns">
									<input type="text" name="u_limit" placeholder="Limit" />
								</div>
								<div class="three columns">
									<input type="text" name="u_offset" placeholder="Offset" />
								</div>
							</div>
							<p><a href="#" class="success button users">Get Users</a></p>
						</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="twelve columns">
					<div class="panel doit-content" style="display: none;">
					</div>
				</div>
			</div>
		</div>
		<div class="four columns">
			<h4>Getting Started</h4>
			<p>
				Please fill in your mite api credentials on the left. Then you can select between the different entities to test.
			</p>

			<h4>Resources</h4>
			<ul class="disc">
				<li><a href="https://github.com/hubeRsen/Mitey">Mitey Github Repository</a><br />This projects Github repository. Feel free to contribute.</li>
				<li><a href="http://twitter.com/hubeRsen">@hubeRsen</a><br />The creator of Mitey.</li>
				<li><a href="http://facturandum.com">facturandum</a><br />The app for which Mitey was initially created.</li>
			</ul>
		</div>
	</div>
	</form>



  <!-- Included JS Files (Uncompressed) -->
  <!--
  <script src="javascripts/modernizr.foundation.js"></script>
  <script src="javascripts/jquery.js"></script>
  <script src="javascripts/jquery.foundation.navigation.js"></script>
  <script src="javascripts/jquery.foundation.buttons.js"></script>
  <script src="javascripts/jquery.foundation.tabs.js"></script>
  <script src="javascripts/jquery.foundation.forms.js"></script>
  <script src="javascripts/jquery.foundation.tooltips.js"></script>
  <script src="javascripts/jquery.foundation.accordion.js"></script>
  <script src="javascripts/jquery.placeholder.js"></script>
  <script src="javascripts/jquery.foundation.alerts.js"></script>
  -->
  <!-- Included JS Files (Compressed) -->
  <script src="javascripts/foundation.js"></script>
  <!-- Initialize JS Plugins -->
  <script src="javascripts/app.js"></script>
</body>
</html>
