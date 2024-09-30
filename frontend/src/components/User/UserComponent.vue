<template>
  <v-container fluid>
    <v-row justify="end" class="mb-4">
      <v-col>
        <v-btn @click="openCreateModal" color="green" dark>
          <v-icon left>mdi-plus</v-icon>Agregar Usuario
        </v-btn>
      </v-col>
    </v-row>

    <v-data-table :headers="headers" :items="users" item-key="id" class="elevation-1">
      <template v-slot:item="{ item }">
        <tr>
          <td>{{ item.nombre }}</td>
          <td>{{ item.correo }}</td>
          <td>
            <v-btn @click="openEditModal(item)" icon>
              <i class="fas fa-pencil-alt"></i>
              <span class="sr-only">Editar</span>
            </v-btn>
            <v-btn @click="deleteUser(item.id)" icon>
              <i class="fas fa-trash-alt"></i>
              <span class="sr-only">Borrar</span>
            </v-btn>
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-dialog v-model="createModal" max-width="600px">
      <create-user @close="createModal = false" @create="fetchUsers" />
    </v-dialog>

    <v-dialog v-model="editModal" max-width="600px">
      <edit-user v-if="selectedUser" :user="selectedUser" @close="editModal = false" @update="handleUserUpdate" />
    </v-dialog>
  </v-container>
</template>

<script>
import CreateUser from './AddUser.vue';
import EditUser from './EditUser.vue';
import '@fortawesome/fontawesome-free/css/all.css';
import '@mdi/font/css/materialdesignicons.css';

export default {
  components: {
    CreateUser,
    EditUser,
  },
  data() { // HEADER V-TABLE Y ESTADOS MODALES
    return {
      headers: [
        { text: 'Nombre', value: 'nombre' },
        { text: 'Correo', value: 'correo' },
        { text: 'Acciones', value: 'actions', sortable: false }
      ],
      users: [],
      createModal: false,
      editModal: false,
      selectedUser: null,
    };
  },
  created() { //CARGA USER
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/users/listar');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.users = data.map(user => ({
          id: user.id,
          nombre: user.name,
          correo: user.email,
        }));
      } catch (error) {
        console.error('Error al obtener usuarios:', error);
        this.users = [];
      }
    },

    openCreateModal() { 
      this.createModal = true;
      this.editModal = false;
      this.selectedUser = null; 
    },

    openEditModal(user) {
      this.selectedUser = user;
      this.createModal = false;
      this.editModal = true;
    },

    async deleteUser(id) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/users/eliminar/${id}`, {
          method: 'DELETE',
        });
        if (!response.ok) {
          const errorData = await response.json();
            alert(errorData.message || 'Error al eliminar el usuario.');
            return;
        }
        this.fetchUsers();
      } catch (error) {
        console.error('Error al eliminar usuario:', error);
        alert('Error al eliminar usuario.');
      }
    },

    handleUserUpdate(updatedUser) { //LLAMA UPDATE Y CIERRA MODAL
      this.updateUser(updatedUser);
      this.editModal = false;
    },
    async updateUser(updatedUser) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/users/actualizar/${updatedUser.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name: updatedUser.name,
            email: updatedUser.email,
          }),
        });

        if (response.status === 400) {
          const errorData = await response.json();
          console.error('Error de validación:', errorData);
          alert(errorData.error);
          return;
        }

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        this.fetchUsers();
      } catch (error) {
        console.error('Error al actualizar usuario:', error);
      }
    }
  }
};
</script>

<style scoped></style>
