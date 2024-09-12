document.addEventListener('DOMContentLoaded', function() {
    const ids = ['name', 'lastname', 'email'];
    ids.forEach(function(id) {
      const input = document.getElementById(id);
      if (input) {
        input.addEventListener('keypress', function(event) {
          const char = String.fromCharCode(event.keyCode || event.which);
  
          // Validación para nombres y apellidos (letras, espacios, y acentos)
          if (id === 'name' || id === 'lastname') {
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/.test(char)) {
              alert('Solo se permiten letras.');
              event.preventDefault();
            }
          } 
          // Validación para correo electrónico (letras, números, @, ., _, -)
          else if (id === 'email') {
            if (!/^[a-zA-Z0-9@._-]$/.test(char)) {
              alert('Solo se permiten letras y números');
              event.preventDefault();
            }
          }
        });
      }
    });
  });  


document.addEventListener('DOMContentLoaded', function() {
    const limits = {
        'name': 50,
        'lastname': 50,
        'email': 50,
        'passwordone': 30,
        'passwordtwo': 30,
    };

    const limitInputLengthWithAlert = (input, maxLength) => {
        if (input.value.length > maxLength) {
            alert(`Solo se permiten ${maxLength} caracteres en el campo.`);
            input.value = input.value.slice(0, maxLength);
        }
    };

    Object.keys(limits).forEach(function(id) {
        const inputElement = document.getElementById(id);
        if (inputElement) {
            inputElement.addEventListener('input', function() {
                limitInputLengthWithAlert(inputElement, limits[id]);
            });
        }
    });
});

