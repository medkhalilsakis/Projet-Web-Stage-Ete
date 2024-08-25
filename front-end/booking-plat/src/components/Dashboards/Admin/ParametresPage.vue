<template>
    <div class="container mt-4">
      <div class="card">
        <div class="card-header">
          <h3>Paramètres du compte</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 text-center">
              <img :src="userImage" alt="User Image" class="img-fluid rounded-circle" />
            </div>
            <div class="col-md-8">
              <h5>{{ user.nom }} {{ user.prenom }}</h5>
              <p><strong>Email:</strong> {{ user.email }}</p>
              <p><strong>Date de Naissance:</strong> {{ formatDate(user.date_naiss) }}</p>
              <p><strong>Nationalité:</strong> {{ user.nationalite }}</p>
              <p><strong>Genre:</strong> {{ user.genre === 'H' ? 'Homme' : 'Femme' }}</p>
              <button class="btn btn-warning btn-sm" @click="editUser">Modifier</button>
              <button class="btn btn-danger btn-sm" @click="deleteUser">Supprimer</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        user: JSON.parse(localStorage.getItem('user'))
      };
    },
    computed: {
      userImage() {
        return this.user.genre === 'H' ? 'https://i.imgur.com/uoEVFOO.png' : 'https://i.imgur.com/rY9l5m5.png';
      }
    },
    methods: {
      formatDate(dateString) {
        const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
        return new Date(dateString).toLocaleDateString('fr-FR', options);
      },
      editUser() {
        Swal.fire({
          title: 'Modifier les informations',
          html: `
            <input id="swal-input-nom" class="swal2-input" placeholder="Nom" value="${this.user.nom}">
            <input id="swal-input-prenom" class="swal2-input" placeholder="Prénom" value="${this.user.prenom}">
            <input id="swal-input-email" class="swal2-input" placeholder="Email" value="${this.user.email}">
            <input id="swal-input-password" type="password" class="swal2-input" placeholder="Nouveau mot de passe">
          `,
          focusConfirm: false,
          preConfirm: () => {
            const nom = Swal.getPopup().querySelector('#swal-input-nom').value;
            const prenom = Swal.getPopup().querySelector('#swal-input-prenom').value;
            const email = Swal.getPopup().querySelector('#swal-input-email').value;
            const password = Swal.getPopup().querySelector('#swal-input-password').value;
            return { nom, prenom, email, password }
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const { nom, prenom, email, password } = result.value;
            axios.put(`http://127.0.0.1:8000/api/users/${this.user.id}`, {
              nom,
              prenom,
              email,
              password
            })
            .then(response => {
              Swal.fire('Modifié !', 'Vos informations ont été modifiées avec succès.', 'success');
              localStorage.setItem('user', JSON.stringify(response.data.user));
              this.user = response.data.user; 
            })
            .catch(error => {
              console.error(error);
              Swal.fire('Erreur', 'Une erreur est survenue lors de la mise à jour de vos informations.', 'error');
            });
          }
        });
      },
      deleteUser() {
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: 'Vous ne pourrez pas annuler cette action !',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`http://127.0.0.1:8000/api/users/${this.user.id}`)
            .then(() => {
              Swal.fire('Supprimé !', 'Votre compte a été supprimé avec succès.', 'success')
                .then(() => {
                  localStorage.removeItem('user');
                  this.$router.push('/');
                });
            })
            .catch(error => {
              console.log(error);
              Swal.fire('Erreur', 'Une erreur est survenue lors de la suppression de votre compte.', 'error');
            });
        }
      });
    }
    }
  };
  </script>
  
  <style scoped>
  .card {
    background-color: #fff;
  }
  
  .card-header {
    background-color: #007bff; 
    color: #fff;
  }
  
  .img-fluid {
    width: 150px;
    height: 150px; 
  }
  
  .swal2-input {
    margin-top: 10px; 
  }
  </style>
  