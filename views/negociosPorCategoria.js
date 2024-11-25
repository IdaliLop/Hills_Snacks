verificar_sesion();
function verificar_sesion(){
    fetch('../Controllers/UsuarioClienteController.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'funcion=verificar_sesion'
  })
  .then(response => {
      console.log('Response:', response);  
      return response.json();  
  })
  .then(data => {
      console.log('Data:', data);
      if (data.id) {
          document.getElementById('login-link').style.display = 'none';
          console.log("login");
          console.log("Hay una sesion activa");
      }
      else{
          console.log("No hay una sesion activa");
          window.location.href = 'login.html';

      }
  })
  .catch(error => console.log('Error:', error));
  }
