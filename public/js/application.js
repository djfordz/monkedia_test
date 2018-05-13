$(function() {
  // frontend validation for the register page.
  if (window.location.pathname == '/register' || window.location.pathname == '/register/post') {
      // get items from DOM
      let username, pass, email, buttons = [].slice.call(document.querySelectorAll('button')), inputs = [].slice.call(document.querySelectorAll('input'));

      // assign variables, and register buttons.
      inputs.forEach(function(value) {
          console.log(value.id)
          switch (value.id) {
              case 'username' : username = value;
              break;
              case 'password' : password = value;
              break;
              case 'email' : email = value;
              break;
          }
      });

      buttons.forEach(function(value) {
          switch (value.id) {
              case 'register-btn' : register(value);
              break;
          }
      });

      // do validation, not allowing to submit until validation passes.
      function register(btn) {
          var nameflag, passflag, emailflag;
          btn.addEventListener('click', function(event) {
              nameflag = check(username);
              passflag = check(password);
              emailflag = check(email);
              console.log(nameflag);
              console.log(passflag);
              console.log(emailflag);
              if (!(nameflag && passflag && emailflag))
                  event.preventDefault();
          });
      }

       //regex yay!
      function check(el) {
          var nameCheck =  /^(?=.*[a-z])(?!.*[!@#$%^&*()_+]).+$/g, pwCheck = /^(?=.*[a-zA-Z\W])(?=.*\d{2,}).+$/g, emailCheck = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/g, flag = false, len = el.value.length;
          switch (el.id) {
              case 'username': flag = nameCheck.test(el.value) ? true : false;
                               return message(el, flag);
               break;
              case 'password': flag = (pwCheck.test(el.value) && len > 3 && len < 46) ? true : false;
                               return message(el, flag);
               break;
              case 'email': flag = (emailCheck.test(el.value) && len < 36) ? true : false;
                                 return  message(el, flag);
               break;
               default : return false;
          }
      }
      // messages for validation.
      function message(el, bool) {
          var children = el.parentNode.childNodes;
          children.forEach(function(v) {
              if (v.class === 'error-message') {
                  v.parentNode.removeChild(v);
              }
          });
          if (!bool) {
              switch (el.id) {
                  case 'username' : nameNode =  document.createElement('p');
                  nameNode.class = 'error-message';
                  nameNode.style.color = 'red';
                  nameNode.innerHTML = '* Username is invalid. Must contain at least 1 lower case letter. Cannot contain special characters.';
                  el.parentNode.appendChild(nameNode);
                  return false;
                  break;
                  case 'password' : passNode = document.createElement('p');
                  passNode.class = 'error-message';
                  passNode.style.color = 'red';
                  passNode.innerHTML = '* Password is invalid. must contain at least 2 numbers and be 4 to 45 characters in length.';
                  el.parentNode.appendChild(passNode);
                  return false;
                  break;
                  case 'email': numNode = document.createElement('p');
                  numNode.class = 'error-message';
                  numNode.style.color = 'red';
                  numNode.innerHTML = '* Email is invalid. must be less than 36 characters and contain @ and .';
                  el.parentNode.appendChild(numNode);
                  return false;
                  break;
              }
          } else {
              return true;
          }
      }

  }
}(jQuery));
