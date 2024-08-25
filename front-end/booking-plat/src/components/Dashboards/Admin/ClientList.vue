<template>
    <div class="container mt-4">
      <h1 class="mb-4">Liste des comptes clients</h1>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Email</th>
              <th>Date de Naissance</th>
              <th>Nationalité</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.nom }}</td>
              <td>{{ user.prenom }}</td>
              <td>{{ user.email }}</td>
              <td>{{ formatDate(user.date_naiss) }}</td>
              <td>{{ user.nationalite }}</td>
              <td>
                <button class="btn btn-warning btn-sm" @click="editUser(user)">Modifier</button>
                <button class="btn btn-danger btn-sm" @click="confirmDelete(user.id)">Supprimer</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        users: []
      };
    },
    created() {
      this.fetchUsers();
    },
    methods: {
      fetchUsers() {
        axios.get('http://127.0.0.1:8000/api/users')
          .then(response => {
            this.users = response.data;
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des utilisateurs:', error);
          });
      },
      formatDate(dateString) {
        const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
        return new Date(dateString).toLocaleDateString('fr-FR', options);
      },
      editUser(user) {
        Swal.fire({
          title: 'Modifier l\'utilisateur',
          html: `
            <input id="nom" class="swal2-input" placeholder="Nom" value="${user.nom}">
            <input id="prenom" class="swal2-input" placeholder="Prénom" value="${user.prenom}">
            <input id="email" class="swal2-input" placeholder="Email" value="${user.email}">
            <input id="date_naiss" class="swal2-input" placeholder="Date de Naissance" value="${user.date_naiss}">
            <input id="nationalite" class="swal2-input" placeholder="Nationalité" value="${user.nationalite}">
            <input id="password" type="password" class="swal2-input" placeholder="Nouveau mot de passe (laisser vide pour ne pas modifier)">
          `,
          focusConfirm: false,
          preConfirm: () => {
            return {
              nom: Swal.getPopup().querySelector('#nom').value,
              prenom: Swal.getPopup().querySelector('#prenom').value,
              email: Swal.getPopup().querySelector('#email').value,
              date_naiss: Swal.getPopup().querySelector('#date_naiss').value,
              nationalite: Swal.getPopup().querySelector('#nationalite').value,
              password: Swal.getPopup().querySelector('#password').value,
            };
          },
          confirmButtonText: 'Enregistrer',
          cancelButtonText: 'Annuler',
          showCancelButton: true,
          customClass: {
            container: 'swal-container',
            popup: 'swal-popup',
            title: 'swal-title',
            input: 'swal-input',
            confirmButton: 'swal-confirm',
            cancelButton: 'swal-cancel'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            axios.put(`http://127.0.0.1:8000/api/users/${user.id}`, result.value)
              .then(() => {
                Swal.fire('Modifié !', 'L\'utilisateur a été modifié avec succès.', 'success');
                this.fetchUsers(); 
              })
              .catch(error => {
                console.log(error);
                Swal.fire('Erreur', 'Une erreur est survenue lors de la modification de l\'utilisateur.', 'error');
              });
          }
        });
      },
      confirmDelete(id) {
        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: 'Vous ne pourrez pas annuler cette action !',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Oui, supprimer !',
          cancelButtonText: 'Annuler'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete(`http://127.0.0.1:8000/api/users/${id}`)
              .then(() => {
                Swal.fire('Supprimé !', 'L\'utilisateur a été supprimé avec succès.', 'success');
                this.fetchUsers(); 
              })
              .catch(error => {
                console.log(error);
                Swal.fire('Erreur', 'Une erreur est survenue lors de la suppression de l\'utilisateur.', 'error');
              });
          }
        });
      }
    }
  };
  </script>
  
  <style scoped>
  .table {
    background-color: #fff;
  }
  
  .table thead th {
    background-color: #007bff;
    color: #fff; 
  }
  
  .table tbody td {
    vertical-align: middle;
  }
  
  .btn {
    margin-right: 5px; 
  }
  
 
  .swal-container {
    font-family: Arial, sans-serif;
  }
  
  .swal-popup {
    padding: 20px;
  }
  
  .swal-title {
    font-size: 1.5em;
    font-weight: bold;
  }
  
  .swal-input {
    margin-bottom: 10px;
  }
  
  .swal-confirm {
    background-color: #007bff;
    border: none;
  }
  
  .swal-cancel {
    background-color: #6c757d;
    border: none;
  }
  </style>
  