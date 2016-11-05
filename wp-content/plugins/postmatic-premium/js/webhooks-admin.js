jQuery( document ).ready( function($) {
    
    // Load results div
    $( "#webhooks_urls_test" ).parent().append( '<div class="webhooks-test-results"></div>' );
    var $wrapper = $( ".webhooks-test-results" );
    var img = '<img src="/wp-admin/images/loading.gif" />';
    $( "#webhooks_urls_test" ).click( function() {
      var icons = '<p class="subscribe">'+img+'</p><p class="unsubscribe">'+img+'</p>';
      // Remove old results
      $wrapper.html( '' );
      
      // Get data
      var subscribe_url = $( "#prompt-settings-webhooks input[name='webhooks_urls[subscribe]']" ).val();
      var unsubscribe_url = $( "#prompt-settings-webhooks input[name='webhooks_urls[unsubscribe]']" ).val();
      var data = {
        name : "Test name",
        email: "test@example.com",
        subscription_type: "instant",
        event: "subscribe"
      } 
      
      // Send ajax for subscribe 
      if ( subscribe_url ) {          
        $( "<p>" ).addClass( "subscribe" ).html( img ).appendTo( $wrapper );
        $.ajax({
          type: "POST",
          url: subscribe_url,
          data: data,
          complete: function (results) {
                $( ".webhooks-test-results .subscribe" ).html( "<strong>"+postmatic_premium_admin_functions.subscribe_hook+" :</strong> "+postmatic_premium_admin_functions.test_sent+"." );
          }
        });
      } 
      // Send ajax for unsubscribe
      data.event = "unsubscribe"; 
      if ( unsubscribe_url ) {          
        $( "<p>" ).addClass( "unsubscribe" ).html( img ).appendTo( $wrapper );
        $.ajax({
          type: "POST",
          url: unsubscribe_url,
          data: data,
          complete: function (results) {
                $( ".webhooks-test-results .unsubscribe" ).html( "<strong>"+postmatic_premium_admin_functions.unsubscribe_hook+" :</strong> "+postmatic_premium_admin_functions.test_sent+"." );
          }
        });
      }
    })
})