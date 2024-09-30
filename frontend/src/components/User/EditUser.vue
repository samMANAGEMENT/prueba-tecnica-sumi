<template>
    <v-card>
      <v-card-title>
        <span class="headline">{{ isEditing ? 'Editar Usuario' : 'Agregar Usuario' }}</span>
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
        <v-btn @click="submit" color="success" dark>{{ isEditing ? 'Actualizar Usuario' : 'Crear Usuario' }}</v-btn>
        <v-btn @click="$emit('close')" color="grey" dark>Cerrar</v-btn>
      </v-card-actions>
    </v-card>
  </template>
  
  <script>
  export default {
    props: { //TRAIGO DEL PADRE USER (VALIDA EDIT)
      user: {
        type: Object,
        default: null,
      },
    },
    data() {
      return { //PROPIEDADES FORM Y RULES
        nombre: '',
        correo: '',
        valid: false,
        rules: {
          required: v => !!v || 'Este campo es requerido',
          email: v => /.+@.+\..+/.test(v) || 'Correo no válido',
        },
      };
    },
    computed: { // DEPTERMINA ESTA EDITANDO USER
      isEditing() {
        return this.user !== null;
      },
    },
    watch: { //CARGA O LIMPIA
      user: {
        immediate: true,
        handler(newUser) {
          if (newUser) {
            this.nombre = newUser.nombre;
            this.correo = newUser.correo;
          } else {
            this.clearForm();
          }
        },
      },
    },
    methods: { //EVENTO PARA CREAR USER 
      submit() {
        const userData = {
          id: this.user ? this.user.id : null,
          name: this.nombre, 
          email: this.correo,
        };
        this.$emit(this.isEditing ? 'update' : 'create', userData);
        this.clearForm();
      },
      clearForm() {
        this.nombre = ''; 
        this.correo = '';
      },
    },
  };
  </script>
  
  <style scoped></style>
  