## framework y paradigma

    Para el desarrollo del ejercicio hemos usado laravel en el backend con vue en el front end. Laravel es un framework orientado a mvc y vue es una libreria JavaScript multiparadigma

## Descripción
    - En el backend he usado un controlador llamado app/Matrix.php donde hago toda la lógica
    - La vista se llama resources/views/index.blade.php y la uso solo para cargar el componente codebox
    - El componente codebox fue realizado enteramente por mi en vue y es quien se encarga de validar que las queries del ejercicio
    estén bien formadas. El componente se encuentra en resources/assets/js/components/Codebox.vue
    -La libreria vuejs es cargada atraves de resources/assets/js/app.js
