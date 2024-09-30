<template>
  <v-card>
    <v-card-title>
      <span class="headline">Editar Proyecto</span>
    </v-card-title>
    <v-card-text>
      <v-form ref="form" v-model="valid">
        <v-text-field v-model="nombre" :rules="[rules.required]" label="Nombre del Proyecto" outlined color="primary"
          required />
        <v-textarea v-model="descripcion" :rules="[rules.required]" label="Descripción" outlined color="primary"
          required rows="4" />
        <v-text-field v-model="fecha_inicio" label="Fecha de Inicio" type="date" outlined color="primary" class="mt-3"
          required />
        <v-text-field v-model="fecha_final" label="Fecha Final" type="date" outlined color="primary" class="mt-3"
          required />
        <v-select v-model="estado_id" :items="estados.map(state => ({ text: state.nombre, value: state.id }))" outlined
          color="primary" required />
        <v-select v-model="usuario_id" :items="usuarios.map(user => ({ text: user.email, value: user.id }))"
          label="Usuario Asignado" outlined color="primary" required />
      </v-form>
    </v-card-text>
    <v-card-actions>
      <v-btn @click="submit" color="success" dark>Actualizar Proyecto</v-btn>
      <v-btn @click="$emit('close')" color="grey" dark>Cerrar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props: { //TRAJE USER Y ESTADOS EDITA PROJECT
    project: Object,
    usuarios: Array,
    estados: Array,
  },
  data() { //MUESTRA DATOS PARA EDITAR Y LAS REGLAS
    return {
      nombre: this.project.nombre,
      descripcion: this.project.descripcion,
      fecha_inicio: this.project.fecha_inicio,
      fecha_final: this.project.fecha_final,
      estado_id: this.project.estado_id,
      usuario_id: this.project.user_id,
      valid: false,
      rules: {
        required: v => !!v || 'Este campo es requerido',
      },
    };
  },
  methods: { //CREA EMITE AL PADRE 
    submit() {
      const userData = {
        id: this.user ? this.user.id : null,
        name: this.nombre,
        email: this.correo,
      };
      this.$emit(this.isEditing ? 'update' : 'create', userData);

      if (this.isEditing) {
        this.clearForm();
        this.$emit('close');
      }
    },
    clearForm() {
      this.nombre = '';
      this.correo = '';
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