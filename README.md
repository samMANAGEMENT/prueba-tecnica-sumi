Pregunta 1: Explica la diferencia entre first() y get() al usar Eloquent en Laravel.  
  -  Frist lo usuamos cuando solo necesitamos el primer dato de una consulta y Get cuando queremos todos los datos (Frist devuelve un único modelo y get() devuelve una colección)

Pregunta 2: ¿Cuál es la diferencia entre los componentes funcionales y los 
componentes de instancia en Vue.js?
  - Un compoenente funcional es un compoenente que cumple con solo una tarea especifica (no tiene ciclo de vida ni estado) y un compoenente de instancia es un compoenete que puede cambiar, recordar, consultar, traer o llamar otras funciones (Tiene estado y ciclo de vida)
    
Pregunta 3: Explica la diferencia entre las directivas v-if y v show en Vue.js. 
  - V-IF Lo puedes utilizar cuando que algo se muestre basandose en una condicion, ejemplo un error. (ACTUALIZA O CAMBIA EL DOM)

  - V-SHOW Lo podemos utilizar cuando quiero que siempre este en la plataforma y se muestre segun la accion del usuario, ejemplo abrir un modal (SOLO DISPLAY)

Pregunta 4: Enumera y explica brevemente los principales ganchos del ciclo de 
vida de un componente en Vue.js.  
  - beforeCreate:
      Se llama antes de que el componente sea creado. En este momento, aún no se pueden acceder a las propiedades reactivas ni a los eventos.
created:
      Se llama después de que el componente ha sido creado. Aquí puedes acceder a las propiedades reactivas y hacer llamadas a APIs, pero el DOM aún no se ha montado.
beforeMount:
      Se llama justo antes de que el componente sea montado en el DOM. Aquí puedes realizar configuraciones finales.
mounted:
      Se llama después de que el componente ha sido montado en el DOM. Este es un buen lugar para interactuar con elementos DOM directamente o realizar inicializaciones que requieren que el componente esté visible.
beforeUpdate:
      Se llama cuando los datos reactivos cambian, pero antes de que el DOM se re-renderice. Útil para realizar acciones previas a la actualización.
updated:
      Se llama después de que el DOM se ha actualizado. Puedes usarlo para realizar acciones en respuesta a cambios en los datos.
beforeDestroy:
      Se llama justo antes de que el componente sea destruido. Aquí puedes limpiar recursos, como eliminar timers o listeners.
destroyed:
      Se llama después de que el componente ha sido destruido. A este punto, ya no puedes acceder a las propiedades reactivas ni al DOM.

Pregunta 5: ¿Cuál es el propósito de los middlewares en Laravel y cómo se 
pueden usar en una aplicación? 
  - Es como un portero que controla quien ingresa a la aplicacion, ejemplo cuando tienes una plataforma con login y un usuario ingresa a una ruta sin haberse logueado el middleware lo que hace es enviarlo al login
