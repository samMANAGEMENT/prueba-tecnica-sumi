<template>
    <v-form ref="form" v-model="valid">
        <v-text-field v-model="task.nombre" label="Nombre" :rules="[(v) => !!v || 'El nombre es requerido']" />
        <v-textarea v-model="task.descripcion" label="Descripción" />
        <v-text-field v-model="task.dueDate" label="Fecha de finalización" type="date" />
        <v-select 
            v-model="task.projectId" 
            :items="projects" 
            item-value="id" 
            item-text="nombre"
            label="Selecciona un Proyecto" 
            :rules="[(v) => !!v || 'El proyecto es requerido']" 
        />
        <v-select 
            v-model="task.user_id"
            :items="usuarios" 
            item-value="id" 
            item-text="name" 
            label="Selecciona un Usuario" 
            :rules="[(v) => !!v || 'El usuario es requerido']" 
        />
        <v-btn @click="submit" color="green">Crear Tarea</v-btn>
        <v-btn @click="$emit('close')" color="red">Cancelar</v-btn>
    </v-form>
</template>

<script>
export default { //PROP REQUERIDO
    props: { 
        projects: {
            type: Array,
            required: true
        },
        usuarios: { 
            type: Array,
            required: true
        }
    },
    data() { //VALID Y TASK PARA DATOS
        return {
            valid: false,
            task: {
                nombre: '',
                descripcion: '',
                dueDate: '',
                projectId: '',
                user_id: '' 
            },
        };
    },
    methods: { //VALIDA QUE LA FECHA FINAL SEA MAYOR A LA INCIAL
        submit() {
            const fechaInicio = new Date().toISOString().slice(0, 10);
            const fechaFinal = this.task.dueDate;
            if (new Date(fechaFinal) <= new Date(fechaInicio)) {
                alert('La fecha de finalización debe ser posterior a la fecha de inicio.');
                return;
            }

            const taskToSubmit = {
                nombre: this.task.nombre,
                descripcion: this.task.descripcion,
                project_id: this.task.projectId,
                user_id: this.task.user_id,
                fecha_inicio: fechaInicio,
                fecha_final: fechaFinal,
            };
            this.$emit('submit', taskToSubmit);
            this.task = { nombre: '', descripcion: '', dueDate: '', projectId: '', user_id: '' }; 
        }
    }
}
</script>

<style scoped></style>
