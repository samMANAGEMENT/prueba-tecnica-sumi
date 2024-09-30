<template>
    <v-card>
      <v-card-title>
        <span class="headline">Agregar Proyecto</span>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="valid">
          <v-text-field
            v-model="nombre"
            :rules="[rules.required]"
            label="Nombre del Proyecto"
            outlined
            color="primary"
            required
          />
          <v-textarea
            v-model="descripcion"
            :rules="[rules.required]"
            label="Descripción"
            outlined
            color="primary"
            required
            rows="4"
          />
          <v-text-field
            v-model="fecha_inicio"
            label="Fecha de Inicio"
            type="date"
            outlined
            color="primary"
            class="mt-3"
            required
          />
          <v-text-field
            v-model="fecha_final"
            label="Fecha Final"
            type="date"
            outlined
            color="primary"
            class="mt-3"
            required
          />
          <v-select
            v-model="estado_id"
            :items="estados"
            item-text="nombre"
            item-value="id"
            label="Estado del Proyecto"
            outlined
            color="primary"
            required
          />
          <v-select
            v-model="usuario_id"
            :items="usuarios"
            item-text="email"
            item-value="id"
            label="Usuario Asignado"
            outlined
            color="primary"
            required
          />
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="submit" color="success" dark>Crear Proyecto</v-btn>
        <v-btn @click="$emit('close')" color="grey" dark>Cerrar</v-btn>
      </v-card-actions>
    </v-card>
  </template>
  
  <script>
  export default {
    props: { //RECIBO USER Y ESTADO
      usuarios: Array,
      estados: Array,
    },
    data() { //REGLAS VALIDACION Y DATOS DEL FORM
      return {
        nombre: '',
        descripcion: '',
        fecha_inicio: '',
        fecha_final: '',
        estado_id: null,
        usuario_id: null,
        valid: false,
        rules: {
          required: v => !!v || 'Este campo es requerido',
        },
      };
    },
    methods: {
      submit() { //CREA, MANDA AL PADRE Y LIMPIA 
        const newProject = {
          nombre: this.nombre,
          descripcion: this.descripcion,
          fecha_inicio: this.fecha_inicio,
          fecha_final: this.fecha_final,
          estado_id: this.estado_id,
          user_id: this.usuario_id,
        };
        this.$emit('create', newProject);
        this.clearForm();
      },
      clearForm() {
        this.nombre = '';
        this.descripcion = '';
        this.fecha_inicio = '';
        this.fecha_final = '';
        this.estado_id = null;
        this.usuario_id = null;
      },
    }
  };
  </script>
  
  <style scoped>
  .v-card {
    max-width: 600px;
    margin: auto;
    border-radius: 12px;
  }
  </style>
  