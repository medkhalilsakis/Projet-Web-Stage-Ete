<template>
    <div class="reservations-container">
      <h2>Mes Réservations</h2>
      <div v-if="reservations.length === 0" class="no-reservations">
        <p>Aucune réservation trouvée.</p>
      </div>
      <div v-else class="reservations-list">
        <div v-for="reservation in reservations" :key="reservation.id_resv" class="reservation-card">
          <div class="card-header">
            <h3>{{ hebergementNames[reservation.code_hb] || reservation.code_hb }} - Chambre {{ reservation.num_chambre }}</h3>
          </div>
          <div class="card-body">
            <p><strong>Date d'arrivée:</strong> {{ formatDate(reservation.date_arr) }}</p>
            <p><strong>Date de départ:</strong> {{ formatDate(reservation.date_dep) }}</p>
            <p><strong>Nombre d'adultes:</strong> {{ reservation.nbr_adultes }}</p>
            <p><strong>Nombre d'enfants:</strong> {{ reservation.nbr_enfants }}</p>
            <p><strong>Prix total:</strong> {{ reservation.prix_total }} TND</p>
          </div>
  
          <div class="card-footer">
            <button @click="deleteReservation(reservation)" class="btn btn-danger">Supprimer</button>
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
        reservations: [],
        hebergementNames: {}
      };
    },
    mounted() {
      this.fetchReservations();
    },
    methods: {
      async fetchReservations() {
        try {
          const user = JSON.parse(localStorage.getItem('user'));
          const clientIDCard = user ? user.IDCARD : null;
          
          if (clientIDCard) {
            const response = await axios.get(`http://127.0.0.1:8000/api/reservations/client/${clientIDCard}`);
            if (response.data && response.data.reservations) {
              this.reservations = response.data.reservations;
  
              this.reservations.forEach(reservation => {
                this.fetchHebergementName(reservation.code_hb);
              });
  
            } else {
              console.error("Aucune réservation trouvée dans la réponse.");
            }
          } else {
            console.error("IDCARD not found in localStorage.");
          }
        } catch (error) {
          console.error("Erreur lors de la récupération des réservations:", error);
        }
      },
      async fetchHebergementName(code_hb) {
        if (!this.hebergementNames[code_hb]) {
          try {
            const response = await axios.get(`http://127.0.0.1:8000/api/hebergements/${code_hb}`);
            if (response.data && response.data.nom) {
                this.hebergementNames[code_hb] = response.data.nom;
            } else {
              console.error("Nom d'hébergement non trouvé dans la réponse.");
            }
          } catch (error) {
            console.error("Erreur lors de la récupération du nom de l'hébergement:", error);
          }
        }
      },
      formatDate(dateStr) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateStr).toLocaleDateString('fr-FR', options);
      },

      async deleteReservation(reservation) {
  const result = await Swal.fire({
    title: 'Êtes-vous sûr?',
    text: 'Vous ne pourrez pas revenir en arrière!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Oui, supprimer!',
    cancelButtonText: 'Annuler'
  });

  if (result.isConfirmed) {
    console.log(reservation.id_resv, reservation.num_chambre);
    try {
      await axios.delete(`http://127.0.0.1:8000/api/reservations/${reservation.id_resv}`);
      
      await axios.put(`http://127.0.0.1:8000/api/chambres/dispo/${reservation.num_chambre}`, {
        disponibilite: true
      });
      
      Swal.fire('Supprimé!', 'Votre réservation a été supprimée et la disponibilité de la chambre a été mise à jour.', 'success');
      
      this.fetchReservations(); 
      
    } catch (error) {
      Swal.fire('Erreur', 'Une erreur est survenue lors de la suppression de la réservation ou de la mise à jour de la disponibilité de la chambre.', 'error');
      console.error("Erreur lors de la suppression de la réservation ou de la mise à jour de la disponibilité:", error);
    }
  }
}

    }
  };
  </script>
  
  
  <style scoped>
  .reservations-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  }
  
  h2 {
    text-align: center;
    color: #333;
  }
  
  .no-reservations {
    text-align: center;
    color: #777;
  }
  
  .reservations-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  
  .reservation-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s ease-in-out;
  }
  
  .reservation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }
  
  .card-header {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
  }
  
  .card-body {
    padding: 15px;
    color: #555;
  }
  
  .card-body p {
    margin: 5px 0;
  }
  
  .card-body strong {
    color: #333;
  }

  .card-footer {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  background-color: #f1f1f1;
  border-top: 1px solid #ddd;
}

.btn {
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-primary {
  background-color: #007bff;
  color: white;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
}

.btn:hover {
  opacity: 0.8;
}
  </style>
  