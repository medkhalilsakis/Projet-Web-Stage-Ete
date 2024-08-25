<template>
  <div>
    <div class="banner">
      <img src="https://static.vecteezy.com/system/resources/previews/000/358/274/original/vector-hotel-online-booking-banner.jpg" alt="Banner Image">
    </div>

    <div class="d-flex justify-content-between card-container">
      <div class="card mb-3" id="card1">
        <div class="card-header">Chambres Disponibles</div>
        <div class="card-body">
          <h5 class="card-title">{{ availableRooms }}</h5>
          <p class="card-text">Nombre de chambres actuellement disponibles.</p>
        </div>
      </div>

      <div class="card mb-3" id="card2">
        <div class="card-header">Réservations Effectuées</div>
        <div class="card-body">
          <h5 class="card-title">{{ clientReservations }}</h5>
          <p class="card-text">Nombre de réservations effectuées par vous.</p>
        </div>
      </div>

      <div class="card mb-3" id="card3">
        <div class="card-header">Total des Utilisateurs</div>
        <div class="card-body">
          <h5 class="card-title">{{ totalUsers }}</h5>
          <p class="card-text">Nombre total d'utilisateurs enregistrés.</p>
        </div>
      </div>
    </div>

    <div class="offer-section">
      <h3>Dernière Offre</h3>
      <div v-if="latestOffer" class="offer-card">
        <div class="row g-0">
          <div class="col-md-4">
            <img :src="latestOffer.image" class="img-fluid rounded-start offer-image" alt="Offre Image">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h4 class="card-title">{{ latestOffer.titre }}</h4>
              <hr>
              <p class="card-text">{{ latestOffer.description }}</p>
              <p class="card-text">
                <strong>Date Début:</strong> {{ latestOffer.date_deb }}<br>
                <strong>Date Fin:</strong> {{ latestOffer.date_fin }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <p v-else>Aucune offre disponible.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      availableRooms: 0,
      clientReservations: 0,
      totalUsers: 0,
      latestOffer: null,
    };
  },
  methods: {
    fetchAvailableRooms() {
      axios.get('http://127.0.0.1:8000/api/chambres')
        .then(response => {
          const rooms = response.data;
          this.availableRooms = rooms.filter(room => room.disponibilite === true).length;
        })
        .catch(error => {
          console.error("Erreur lors de la récupération des chambres disponibles:", error);
        });
    },
    fetchClientReservations() {
      const user = JSON.parse(localStorage.getItem('user'));
      const idcard = user ? user.IDCARD : null;

      if (idcard) {
        axios.get(`http://127.0.0.1:8000/api/reservations/client/${idcard}`)
          .then(response => {
            this.clientReservations = response.data.reservations.length;
          })
          .catch(error => {
            console.error("Erreur lors de la récupération des réservations du client:", error);
          });
      } else {
        console.error("IDCARD non trouvé dans le localStorage.");
      }
    },
    fetchTotalUsers() {
      axios.get('http://127.0.0.1:8000/api/users')
        .then(response => {
          this.totalUsers = response.data.length;
        })
        .catch(error => {
          console.error("Erreur lors de la récupération du nombre total d'utilisateurs:", error);
        });
    },
    fetchLatestOffer() {
      axios.get('http://127.0.0.1:8000/api/offres')
        .then(response => {
          const offers = response.data;
          if (offers.length > 0) {
            const sortedOffers = offers.sort((a, b) => new Date(b.date_fin) - new Date(a.date_fin));
            this.latestOffer = sortedOffers[0];
          }
        })
        .catch(error => {
          console.error("Erreur lors de la récupération des offres:", error);
        });
    }
  },
  mounted() {
    this.fetchAvailableRooms();
    this.fetchClientReservations();
    this.fetchTotalUsers();
    this.fetchLatestOffer();
  }
};
</script>

<style scoped>
.banner {
  width: 100%;
  height: 200px;
  margin-bottom: 20px;
  background-color: #f8f9fa;
  display: flex;
  justify-content: center;
  align-items: center;
}

.banner img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.card-container {
  margin: 20px 0;
}

#card1 {
  background-color: #ffcc00; 
  color: #000;
}

#card2 {
  background-color: #4CAF50;
  color: #fff;
}

#card3 {
  background-color: #2196F3; 
  color: #fff;
}

.card-header {
  font-weight: bold;
  font-size: 1.2em;
}

.card-body {
  padding: 15px;
}

.card-title {
  font-size: 2em;
  margin-bottom: 10px;
}

.card-text {
  font-size: 1em;
}

.offer-section {
  margin-top: 30px;
  width: 100%;
}

.offer-card {
  display: flex;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  overflow: hidden;
}

.offer-card .row {
  width: 100%;
}

.offer-image {
  background-image: cover;
  width: 100%;
  height: auto;
  object-fit: cover;
}

.card-body {
  padding: 15px;
}

.card-title {
  font-size: 1.5em;
}

.card-text {
  font-size: 1em;
}
</style>
