<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="<?=base_url('auth/signin')?>" method="post">
		
			<h1>Member Login</h1>		
			
			<div class="login-fields">
				 <?php if (isset($error) && !empty($error) ): ?>
	                <div class="alert alert-danger wow shake">
	                    <?= $error ?>
	                </div>
	            <?php elseif(isset($success)): ?>
	                <div class="alert alert-success wow shake">
	                    <?= $success ?>
	                </div>
	            <?php endif; ?>

	            <?php if (validation_errors()): ?>
	                <div class="alert alert-danger wow shake">
	                    <?php echo validation_errors(); ?>
	                </div>
	            <?php endif; ?>

				<p>Please provide your details</p>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" id="username" autocomplete="off" required name="username" value="" placeholder="Username" class="login username-field form-control" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" autocomplete="off" required name="password" value="" placeholder="Password" class="login password-field form-control"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>
									
				<button type="submit" class="button btn btn-success btn-large">Sign In</button>
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<div class="login-extra">
	<a href="/forget">Reset Password</a>
</div> <!-- /login-extra -->
