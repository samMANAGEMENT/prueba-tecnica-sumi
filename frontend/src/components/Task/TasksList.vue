<template>
  <v-container fluid>
    <v-row justify="end" class="mb-4">
      <v-col>
        <v-btn @click="dialog = true" color="green" dark>
          <v-icon left>mdi-plus</v-icon>Agregar Tarea
        </v-btn>
      </v-col>
    </v-row>

    <v-data-table :headers="headers" :items="tasks" item-key="id" class="elevation-1">
      <template v-slot:item="{ item }">
        <tr>
          <td>{{ item.nombre || 'Sin nombre' }}</td>
          <td>{{ item.descripcion || 'Sin descripción' }}</td>
          <td>{{ item.dueDate || 'No especificada' }}</td>
          <td>{{ item.projectName || 'Sin proyecto' }}</td>
          <td>{{ item.userName || 'Sin usuario' }}</td>
          <td>{{ item.estado || 'Sin estado' }}</td>
          <td>
            <v-btn @click="openEditModal(item)" icon>
              <i class="fas fa-pencil-alt"></i>
              <span class="sr-only">Editar</span>
            </v-btn>
            <v-btn @click="deleteTask(item.id)" icon>
              <i class="fas fa-trash-alt"></i>
              <span class="sr-only">Borrar</span>
            </v-btn>
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-dialog v-model="dialog" max-width="600">
      <v-card>
        <v-card-title>
          <span class="headline">Agregar Nueva Tarea</span>
        </v-card-title>
        <v-card-text>
          <AddTask @submit="createTask" @close="dialog = false" :projects="projects" :usuarios="usuarios" />
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="editDialog" max-width="600">
      <v-card>
        <v-card-title>
          <span class="headline">Editar Tarea</span>
        </v-card-title>
        <v-card-text>
          <EditTask :task="selectedTask" :projects="projects" :usuarios="usuarios" :states="states" @update="updateTask"
            @close="editDialog = false" />
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import AddTask from './AddTask.vue';
import EditTask from './EditTask.vue';

export default {
  components: {
    AddTask,
    EditTask,
  },
  data() {
    return {
      headers: [
        { text: 'Nombre', value: 'nombre' },
        { text: 'Descripción', value: 'descripcion' },
        { text: 'Fecha de finalización', value: 'dueDate' },
        { text: 'Proyecto', value: 'projectName' },
        { text: 'Usuario', value: 'userName' },
        { text: 'Estado', value: 'estado' },
        { text: 'Acciones', value: 'actions', sortable: false },
      ],
      tasks: [],
      dialog: false,
      editDialog: false,
      selectedTask: null,
      projects: [],
      usuarios: [],
      states: [],
    };
  },
  created() {
    this.fetchTasks();
    this.fetchProjects();
    this.fetchUsers();
    this.fetchStates();
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/task/listar');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        if (Array.isArray(data)) {
          this.tasks = data.map(task => ({
            id: task.id,
            nombre: task.nombre || 'Sin nombre',
            descripcion: task.descripcion || 'Sin descripción',
            dueDate: task.fecha_final || 'No especificada',
            projectName: task.project || 'Sin proyecto',
            userName: task.user || 'Sin usuario',
            estado: task.estado || 'Sin estado',
          }));
        }
      } catch (error) {
        console.error('Error al obtener tareas:', error);
        this.tasks = [];
      }
    },
    async fetchProjects() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/projects/listar');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.projects = data;
      } catch (error) {
        console.error('Error al obtener proyectos:', error);
        this.projects = [];
      }
    },
    async fetchUsers() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/users/listar');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.usuarios = data; // Asigna la lista de usuarios
      } catch (error) {
        console.error('Error al obtener usuarios:', error);
        this.usuarios = [];
      }
    },
    async createTask(task) {
      console.log('Datos enviados a la API:', task);
      try {
        const response = await fetch('http://127.0.0.1:8000/api/task/crear', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(task),
        });

        if (!response.ok) {
          throw new Error(`Error al crear tarea: ${response.status}`);
        }

        this.fetchTasks();
        this.dialog = false;
      } catch (error) {
        console.error('Error al crear la tarea:', error);
      }
    },
    openEditModal(item) { // TRAE LA TAREA PARA EDITAR
      this.selectedTask = { ...item };
      this.selectedTask.estadoId = item.state_id;
      this.editDialog = true;
    },
    async updateTask(updatedTask) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/task/actualizar/${updatedTask.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(updatedTask),
        });

        if (!response.ok) {
          throw new Error(`Error al actualizar tarea: ${response.status}`);
        }

        this.fetchTasks();
        this.editDialog = false;
      } catch (error) {
        console.error('Error al actualizar la tarea:', error);
      }
    },
    async fetchStates() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/state/listar');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.states = data; // Asegúrate de tener una propiedad states en el data()
      } catch (error) {
        console.error('Error al obtener estados:', error);
        this.states = [];
      }
    },
    async deleteTask(id) {
      console.log('Eliminando tarea con ID:', id);
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/task/eliminar/${id}`, {
          method: 'DELETE',
        });

        if (!response.ok) {
          throw new Error(`Error al eliminar tarea: ${response.status}`);
        }

        this.fetchTasks();
      } catch (error) {
        console.error('Error al eliminar la tarea:', error);
      }
    }
  }
};
</script>

<style scoped></style>
