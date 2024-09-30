<template>
    <v-card>
      <v-card-title>
        <span class="headline">Agregar Usuario</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="valid">
          <v-text-field
            v-model="nombre"
            :rules="[rules.required]"
            label="Nombre"
            outlined
            color="primary"
            required
          />
          <v-text-field
            v-model="correo"
            :rules="[rules.required, rules.email]"
            label="Correo"
            outlined
            color="primary"
            required
          />
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="submit" color="success" dark>Crear Usuario</v-btn>
        <v-btn @click="$emit('close')" color="grey" dark>Cerrar</v-btn>
      </v-card-actions>
    </v-card>
  </template>
  
  <script>
  export default {
    data() { //DEFINO DATOS DEL FORM Y REGLAS
      return {
        nombre: '',
        correo: '',
        valid: false,
        rules: {
          required: v => !!v || 'Este campo es requerido',
          email: v => /.+@.+\..+/.test(v) || 'Correo no válido',
        },
      };
    },
    methods: { //ENVIA DATOS NEW USER
      async submit() {
        const newUser = {
          name: this.nombre,
          email: this.correo,
        };
        try {
          const response = await fetch('http://127.0.0.1:8000/api/users/crear', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(newUser),
          });
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          this.$emit('create');
          this.clearForm();
          this.$emit('close'); 
        } catch (error) {
          console.error('Error al crear usuario:', error);
        }
      },
      clearForm() {
        this.name = '';
        this.correo = '';
      },
    }
  };
  </script>
  
  <style scoped></style>
  