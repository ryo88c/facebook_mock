    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '{$appId}',
          session : {$encodedSession}, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>


    <h1><a href="">php-sdk</a></h1>

    {if $me}
    <a href="{$logoutUrl}">
      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
    </a>
    {else}
    <div>
      Using JavaScript &amp; XFBML: <fb:login-button></fb:login-button>
    </div>
    <div>
      Without using JavaScript &amp; XFBML:
      <a href="{$loginUrl}">
        <img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
      </a>
    </div>
    {/if}

    <h3>Session</h3>
    {if $me}
    <pre>{php}print_r($session){/php}</pre>

    <h3>You</h3>
    <img src="https://graph.facebook.com/{$uid}/picture">
    {$me.name}

    <h3>Your User Object</h3>
    <pre>{php}print_r($me){/php}</pre>
    {else}
    <strong><em>You are not Connected.</em></strong>
    {/if}

    <h3>Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    {$naitik.name}
