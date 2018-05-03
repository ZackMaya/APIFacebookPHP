<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Tus datos que son visibles</title>
  </head>
  <body>
       <div id="fb-root"></div>
  <!--Script para SDK facebook javascript-->
    <script>

      //Funcion Facebook para el SDK
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '2036494549945425',
          cookie     : true,
          xfbml      : true,
          version    : 'v2.8'
        });
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
      };

      	//Funcion facebook para el sdk
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.12&appId=2036494549945425&autoLogAppEvents=1';
		  fjs.parentNode.insertBefore(js, fjs);


		}(document, 'script', 'facebook-jssdk'));
       
		//Funcion para cambiar el estado
       function statusChangeCallback(response){
         if(response.status === 'connected'){
           console.log('Logged in and authenticated');
           setElements(true);
           testAPI();
         } else {
           console.log('Not authenticated');
           setElements(false);
         }
       }

       //Funcion para checar el estado si esta logueado o no
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }

      //Funcion para probar la Graph de facebook pasandole los campos de peticion GET
      function testAPI(){
        FB.api('/me?fields=name,email,birthday,location,age_range,address,education,interested_in,relationship_status,work,gender', function(response){
          if(response && !response.error){
            //console.log(response);
            buildProfile(response);
          }
          FB.api('/me/feed', function(response){
            if(response && !response.error){
              buildFeed(response);
            }
          });
        })
      }

      //funcion para mostrar el perfil facebook
      function buildProfile(user){


        let profile = `
          <h3>${user.name}</h3>
          <ul class="list-group">
            <li class="list-group-item">Id Usuario: ${user.id}</li>
            <li class="list-group-item">Email: ${user.email}</li>
            <li class="list-group-item">Birthday: ${user.birthday}</li>
            <li class="list-group-item">User ID: ${user.location.name}</li>
            <li class="list-group-item">Edad Minima: ${user.age_range.min}</li>
            <li class="list-group-item">Dirección: ${user.address}</li>
            <li class="list-group-item">Nivel estudios: ${user.education}</li>
            <li class="list-group-item">Intereses: ${user.interested_in}</li>
            <li class="list-group-item">Relacion: ${user.relationship_status}</li>
            <li class="list-group-item">Empleo: ${user.work}</li>
            <li class="list-group-item">Genero: ${user.gender}</li>
          </ul>
        `;
        document.getElementById('profile').innerHTML = profile;
      }

      //Funcion para mostrar los post
      function buildFeed(feed){
        let output = '<h3>Latest Posts</h3>';
        for(let i in feed.data){
          if(feed.data[i].message){
            output += `
              <div class="well">
                ${feed.data[i].message} <span>${feed.data[i].created_time}</span>
              </div>
            `;
          }
        }
        document.getElementById('feed').innerHTML = output;
      }


      //Funcion para bloquear y visualizar cuando esta logueado o no
      function setElements(isLoggedIn){
        if(isLoggedIn){
          document.getElementById('logout').style.display = 'block';
          document.getElementById('profile').style.display = 'block';
          document.getElementById('feed').style.display = 'block';
          document.getElementById('fb-btn').style.display = 'none';
          document.getElementById('heading').style.display = 'none';

        } else {
          document.getElementById('logout').style.display = 'none';
          document.getElementById('profile').style.display = 'none';
          document.getElementById('feed').style.display = 'none';
          document.getElementById('fb-btn').style.display = 'block';
          document.getElementById('heading').style.display = 'block';
        }
      }

      //Funcion de cerrar sesion
      function logout(){
        FB.logout(function(response){
          setElements(false);
        });
      }
    </script>

        <div class="navbar-header">
          <a class="navbar-brand" href="#">Tus datos visibles</a>
        </div>
        <!--Si hace click en cerrar-->
            <a id="logout" href="#" onclick="logout()">Logout</a></li>
           


            <fb:login-button
              id="fb-btn"
              class="btn btn-primary btn-lg"
              scope="public_profile,email,user_birthday,user_location,user_posts"
              onlogin="checkLoginState();">
            </fb:login-button>

    <div class="container">
      <h3 id="heading"></h3>
      <div id="profile"></div>
      <div id="feed"></div>
    </div>
  </body>
</html>