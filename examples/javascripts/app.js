(function($){
  $(function(){
    $(document).foundationAlerts();
    $(document).foundationAccordion();
    $(document).tooltips();
    $('input, textarea').placeholder();
    $(document).foundationButtons();
    $(document).foundationNavigation();
    $(document).foundationCustomForms();
    $(document).foundationTabs({callback:$.foundation.customForms.appendCustomMarkup});

    $(document).ready(function(){
    	$('.account-infos').click(function(){
    		$('.doit-content').hide().load('doit.php', {method: 'account', api_endpoint: $('input[name=api_endpoint]').val(), api_key: $('input[name=api_key]').val()}).fadeIn();
    		return false;
    	});
    	$('.customers').click(function(){
    		$('.doit-content').hide().load('doit.php', {
    			method: 'customers',
    			api_endpoint: $('input[name=api_endpoint]').val(),
    			api_key: $('input[name=api_key]').val(),
    			name: $('input[name=c_filter]').val(),
    			limit: $('input[name=c_limit]').val(),
    			offset: $('input[name=c_offset]').val()
    		}).fadeIn();
    		return false;
    	});
    	$('.projects').click(function(){
    		$('.doit-content').hide().load('doit.php', {
    			method: 'projects',
    			api_endpoint: $('input[name=api_endpoint]').val(),
    			api_key: $('input[name=api_key]').val(),
    			name: $('input[name=p_filter]').val(),
    			limit: $('input[name=p_limit]').val(),
    			offset: $('input[name=p_offset]').val()
    		}).fadeIn();
    		return false;
    	});
    	$('.times').click(function(){
    		$('.doit-content').hide().load('doit.php', {
    			method: 'times',
    			api_endpoint: $('input[name=api_endpoint]').val(),
    			api_key: $('input[name=api_key]').val()
    		}).fadeIn();
    		return false;
    	});
    	$('.grouped_times').click(function(){
    		$('.doit-content').hide().load('doit.php', {
    			method: 'grouped_times',
    			api_endpoint: $('input[name=api_endpoint]').val(),
    			api_key: $('input[name=api_key]').val()
    		}).fadeIn();
    		return false;
    	});
    	$('.users').click(function(){
    		$('.doit-content').hide().load('doit.php', {
    			method: 'users',
    			api_endpoint: $('input[name=api_endpoint]').val(),
    			api_key: $('input[name=api_key]').val(),
    			name: $('input[name=u_filter]').val(),
    			email: $('input[name=u_email]').val(),
    			limit: $('input[name=u_limit]').val(),
    			offset: $('input[name=u_offset]').val()
    		}).fadeIn();
    		return false;
    	});
    	$('.services').click(function(){
    		$('.doit-content').hide().load('doit.php', {
    			method: 'services',
    			api_endpoint: $('input[name=api_endpoint]').val(),
    			api_key: $('input[name=api_key]').val(),
    			name: $('input[name=s_filter]').val(),
    			limit: $('input[name=s_limit]').val(),
    			offset: $('input[name=s_offset]').val()
    		}).fadeIn();
    		return false;
    	});
    });
  });
})(jQuery);
