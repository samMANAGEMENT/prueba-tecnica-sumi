<template>
    <v-form ref="form" v-model="valid">
      <v-text-field 
        v-model="localTask.nombre" 
        label="Nombre" 
        :rules="[(v) => !!v || 'El nombre es requerido']" 
      />
      <v-textarea 
        v-model="localTask.descripcion" 
        label="Descripción" 
      />
      <v-text-field 
        v-model="localTask.dueDate" 
        label="Fecha de finalización" 
        type="date" 
      />
      <v-select 
        v-model="localTask.projectId" 
        :items="projects" 
        item-value="id" 
        item-text="nombre"
        label="Selecciona un Proyecto" 
        :rules="[(v) => !!v || 'El proyecto es requerido']" 
      />
      <v-select 
        v-model="localTask.user_id" 
        :items="usuarios" 
        item-value="id" 
        item-text="email"
        label="Selecciona un Usuario" 
        :rules="[(v) => !!v || 'El usuario es requerido']" 
      />
      <v-btn @click="submit" color="green">Actualizar Tarea</v-btn>
      <v-btn @click="$emit('close')" color="red">Cancelar</v-btn>
    </v-form>
  </template>
  
  <script>
  export default {
    props: { // TRAIGO  LOS DATOS DEL COMPONENTE PADRE EN PROPS REQUERIDOS

      task: {
        type: Object,
        required: true
      },
      projects: {
        type: Array,
        required: true
      },
      usuarios: {
        type: Array,
        required: true
      }
    },
    data() { //PERMITE EDITAR LA TAREA
      return {
        valid: false,
        localTask: { ...this.task }
      };
    },
    methods: { // CREA TASK Y EMITO UN UPDATE
      submit() {
        const taskToSubmit = {
          id: this.task.id,
          nombre: this.localTask.nombre,
          descripcion: this.localTask.descripcion,
          project_id: this.localTask.projectId,
          user_id: this.localTask.user_id,
          fecha_final: this.localTask.dueDate,
        };
  
        this.$emit('update', taskToSubmit);
      }
    },
    watch: { //ACTUALIZA TASK
      task: {
        handler(newVal) {
          this.localTask = { ...newVal };
        },
        deep: true
      }
    }
  }
  </script>
  
  <style scoped></style>
  