<template>
  <v-container fluid>
    <v-row justify="end" class="mb-4">
      <v-col>
        <v-btn @click="openModal" color="green" dark>
          <v-icon left>mdi-plus</v-icon>Agregar Proyecto
        </v-btn>
      </v-col>
    </v-row>

    <v-data-table :headers="headers" :items="projects" item-key="id" class="elevation-1">
      <template v-slot:item="{ item }">
        <tr>
          <td>{{ item.nombre }}</td>
          <td>{{ item.descripcion }}</td>
          <td>{{ item.estado }}</td>
          <td>{{ item.usuario }}</td>
          <td>
            <v-btn @click="openEditModal(item)" icon>
              <i class="fas fa-pencil-alt"></i>
              <span class="sr-only">Editar</span>
            </v-btn>
            <v-btn @click="deleteProject(item.id)" icon>
              <i class="fas fa-trash-alt"></i>
              <span class="sr-only">Borrar</span>
            </v-btn>
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-dialog v-model="modal" max-width="600px">
      <add-project @close="modal = false" @create="createProject" :usuarios="usuarios" :estados="estados" />
    </v-dialog>

    <v-dialog v-model="editModal" max-width="600px">
      <edit-project
        v-if="selectedProject"
        :project="selectedProject"
        :usuarios="usuarios"
        :estados="estados"
        @close="editModal = false"
        @update="updateProject"
      />
    </v-dialog>
  </v-container>
</template>

<script>
import AddProject from './AddProject.vue';
import EditProject from './EditProject.vue';
import '@fortawesome/fontawesome-free/css/all.css';
import '@mdi/font/css/materialdesignicons.css';

export default {
  components: {
    AddProject,
    EditProject,
  },
  data() { //CABECERA DE LA V-TABLE Y ESTADOS DEL MODAL
    return {
      headers: [
        { text: 'Nombre', value: 'nombre' },
        { text: 'Descripción', value: 'descripcion' },
        { text: 'Estado', value: 'estado' },
        { text: 'Usuario Asignado', value: 'usuario' },
        { text: 'Acciones', value: 'actions', sortable: false }
      ],
      projects: [],
      modal: false,
      editModal: false,
      selectedProject: null,
      usuarios: [],
      estados: [],
    };
  },
  created() { //SE CARGAN PROYECTOS, USER, Y STATE DE API
    this.fetchProjects();
    this.fetchUsers();
    this.fetchStates();
  },
  methods: {
    async fetchProjects() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/projects/listar');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        if (Array.isArray(data)) {
          this.projects = data.map(project => ({
            id: project.id,
            nombre: project.nombre,
            descripcion: project.descripcion,
            estado: project.state_relation.nombre || 'No especificado',
            usuario: project.user_relation.email || 'No especificado',
          }));
        }
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
        this.usuarios = data;
      } catch (error) {
        console.error('Error al obtener usuarios:', error);
      }
    },

    async fetchStates() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/state/listar');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.estados = data.map(state => ({ id: state.id, nombre: state.nombre }));
      } catch (error) {
        console.error('Error al obtener estados:', error);
      }
    },

    openModal() { //ABRE MODAL CREAR
      this.modal = true;
    },

    openEditModal(project) { //ABRE MODAL EDITA
      this.selectedProject = project;
      this.editModal = true;
    },

    async createProject(newProject) {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/projects/crear', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(newProject),
        });
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.fetchProjects();
        this.modal = false;
      } catch (error) {
        console.error('Error al crear proyecto:', error);
      }
    },

    async updateProject(updatedProject) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/projects/actualizar/${updatedProject.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(updatedProject),
        });
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.fetchProjects();
        this.editModal = false;
      } catch (error) {
        console.error('Error al actualizar proyecto:', error);
      }
    },

    async deleteProject(id) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/projects/eliminar/${id}`, {
          method: 'DELETE',
        });
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.fetchProjects();
      } catch (error) {
        console.error('Error al eliminar proyecto:', error);
      }
    }
  }
};
</script>

<style scoped></style>
