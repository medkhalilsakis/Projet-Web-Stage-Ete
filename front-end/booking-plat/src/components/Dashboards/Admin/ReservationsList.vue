<template>
    <div class="container mt-4">
      <div class="card">
        <div class="card-header">
          <h3>Liste des Réservations</h3>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-5">
              <label for="hebergement-select" class="form-label">Hébergement</label>
              <select id="hebergement-select" class="form-select" v-model="selectedHebergement" @change="fetchChambres">
                <option value="">Sélectionner un hébergement</option>
                <option v-for="hebergement in hebergements" :key="hebergement.code_hb" :value="hebergement.code_hb">
                  {{ hebergement.code_hb }} - {{ hebergement.nom }}
                </option>
              </select>
            </div>
            <div class="col-md-5">
              <label for="chambre-select" class="form-label">Chambre</label>
              <select id="chambre-select" class="form-select" v-model="selectedChambre">
                <option value="">Sélectionner une chambre</option>
                <option v-for="chambre in chambres" :key="chambre.num_chambre" :value="chambre.num_chambre">
                  {{ chambre.num_chambre }}
                </option>
              </select>
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary w-100" @click="fetchReservations">Recherche</button>
            </div>
          </div>
  
          <div v-if="reservations.length > 0">
            <table class="table">
              <thead>
                <tr>
                  <th>ID Réservation</th>
                  <th>ID Card</th>
                  <th>Nom Client</th>
                  <th>Date d'arrivée</th>
                  <th>Date de départ</th>
                  <th>Nombre d'adultes</th>
                  <th>Nombre d'enfants</th>
                  <th>Prix Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="reservation in reservations" :key="reservation.id_resv">
                  <td>{{ reservation.id_resv }}</td>
                  <td>{{ reservation.client }}</td>
                  <td>{{ clients[reservation.client]?.nom || 'Inconnu' }} {{ clients[reservation.client]?.prenom || '' }}</td>

                  <td>{{ formatDate(reservation.date_arr) }}</td>
                  <td>{{ formatDate(reservation.date_dep) }}</td>
                  <td>{{ reservation.nbr_adultes }}</td>
                  <td>{{ reservation.nbr_enfants }}</td>
                  <td>{{ reservation.prix_total }} €</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else>
            <p>Aucune réservation trouvée pour cet hébergement et cette chambre.</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
        return {
        selectedHebergement: '',
        selectedChambre: '',
        reservations: [],
        clients: {}, 
        hebergements: [], 
        chambres: [] 
    };
  },
    created() {
      this.fetchHebergements();
    },
    methods: {
      async fetchHebergements() {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/hebergements');
          this.hebergements = response.data;
        } catch (error) {
          console.error('Erreur lors de la récupération des hébergements', error);
        }
      },
      async fetchChambres() {
        if (this.selectedHebergement) {
          try {
            const response = await axios.get(`http://127.0.0.1:8000/api/chambres/heb/${this.selectedHebergement}`);
            this.chambres = response.data;
            this.selectedChambre = ''; 
            this.fetchReservations(); 
          } catch (error) {
            console.error('Erreur lors de la récupération des chambres', error);
          }
        } else {
          this.chambres = []; 
          this.fetchReservations();
        }
      },
      async fetchReservations() {
  if (this.selectedHebergement && this.selectedChambre) {
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/reservations/${this.selectedHebergement}/chambre/${this.selectedChambre}`);
      const data = await response.json();
      if (response.ok) {
        this.reservations = data.reservations;
        await this.fetchClients();
      } else {
        this.reservations = [];
        alert(data.message); 
      }
    } catch (error) {
      console.error('Erreur lors de la récupération des réservations:', error);
      this.reservations = [];
    }
  } else {
    alert('Veuillez sélectionner un hébergement et une chambre.');
  }
        },

        async fetchClients() {
  try {
    const clientRequests = this.reservations.map(async (reservation) => {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/users/${reservation.client}`);
        if (response.data.status === 200) {
          return { id: reservation.client, data: response.data.data };
        } else {
          console.error(`Erreur lors de la récupération du client ${reservation.client}: ${response.data.message}`);
          return { id: reservation.client, data: null }; 
        }
      } catch (error) {
        console.error(`Erreur lors de la récupération du client ${reservation.client}:`, error);
        return { id: reservation.client, data: null }; 
      }
    });

    const clientResponses = await Promise.all(clientRequests);

    this.clients = clientResponses.reduce((acc, { id, data }) => {
      if (data) {
        acc[id] = data; 
      }
      return acc;
    }, {});
  } catch (error) {
    console.error('Erreur lors de la récupération des clients:', error);
  }
}
,


      formatDate(dateString) {
        const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
        return new Date(dateString).toLocaleDateString('fr-FR', options);
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
  
  .table thead th {
    background-color: #007bff;
    color: #fff;
  }
  </style>
  