<template>
  <div class="search-container">
    <h2>Recherche des Hébergements</h2>
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Rechercher un hébergement..."
      @input="filterHebergements"
      class="search-input"
    />

    <div v-if="filteredHebergements.length">
      <ul class="hebergements-list">
        <li v-for="heb in filteredHebergements" :key="heb.code_hb" class="hebergement-card">
          <div class="hebergement-details">
            <h3 class="hebergement-title">{{ heb.nom }}</h3>
            <p><strong>Type :</strong> {{ heb.type }}</p>
            <p><strong>Description :</strong> <small>{{ heb.description }}</small></p>
            <p><strong>Adresse :</strong> {{ heb.adresse }}</p>
            <p><strong>Nombre de chambres :</strong> {{ heb.nbr_de_chambres }}</p>
            <p><strong>Téléphone :</strong> {{ heb.num_tel }}</p>
            <div v-if="heb.images && heb.images.length" class="image-gallery">
              <img 
                v-for="img in heb.images" 
                :key="img.id" 
                :src="`http://127.0.0.1:8000/storage/uploads/images/${img.path}`" 
                :alt="heb.nom" 
                class="hebergement-image"
                @click="enlargeImage($event)"
              />
            </div>
          </div>
          <div class="hebergement-actions">
            <button class="check-availability-button" @click="openReservationPopup(heb)">Réserver maintenant</button>
          </div>
        </li>
      </ul>
    </div>
    <div v-else>
      <p>Aucun hébergement ne correspond à votre recherche.</p>
    </div>

    <!-- Image modal -->
    <div v-if="enlargedImageSrc" class="image-modal" @click="closeImage">
      <img :src="enlargedImageSrc" class="modal-image" />
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      hebergements: [],
      filteredHebergements: [],
      searchQuery: '',
      enlargedImageSrc: null,
    };
  },
  methods: {
    async fetchHebergements() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/hebergements');
        this.hebergements = response.data;

        for (let heb of this.hebergements) {
          const imagesResponse = await axios.get(`http://127.0.0.1:8000/api/images/${heb.code_hb}`);
          heb.images = imagesResponse.data;

          const chambresResponse = await axios.get(`http://127.0.0.1:8000/api/chambres/heb/${heb.code_hb}`);
          const chambres = chambresResponse.data;
          heb.chambres_disponibles = chambres.filter((chambre) => chambre.disponibilite).length;
        }

        this.filteredHebergements = this.hebergements;
      } catch (error) {
        console.error('Erreur lors de la récupération des hébergements ou des chambres:', error);
      }
    },
    filterHebergements() {
      const query = this.searchQuery.toLowerCase();
      this.filteredHebergements = this.hebergements.filter((heb) => {
        return (
          heb.nom.toLowerCase().includes(query) ||
          heb.type.toLowerCase().includes(query) ||
          heb.description.toLowerCase().includes(query)
        );
      });
    },
    enlargeImage(event) {
      this.enlargedImageSrc = event.target.src;
    },
    closeImage() {
      this.enlargedImageSrc = null;
    },
    openReservationPopup(heb) {
      Swal.fire({
        title: 'Vérifier la disponibilité',
        html: `
          <input type="date" id="date_arr" class="swal2-input" placeholder="Date d'arrivée">
          <input type="date" id="date_dep" class="swal2-input" placeholder="Date de départ">
          <input type="number" id="nbr_adultes" class="swal2-input" placeholder="Nombre d'adultes">
          <input type="number" id="nbr_enfants" class="swal2-input" placeholder="Nombre d'enfants">
          <input type="number" id="nbr_chambres" class="swal2-input" placeholder="Nombre de chambres">
        `,
        focusConfirm: false,
        preConfirm: () => {
          const date_arr = document.getElementById('date_arr').value;
          const date_dep = document.getElementById('date_dep').value;
          const nbr_adultes = document.getElementById('nbr_adultes').value;
          const nbr_enfants = document.getElementById('nbr_enfants').value;
          const nbr_chambres = document.getElementById('nbr_chambres').value;

          if (!date_arr || !date_dep || !nbr_adultes || !nbr_enfants || !nbr_chambres) {
            Swal.showValidationMessage('Tous les champs sont requis');
            return;
          }

          return {
            date_arr,
            date_dep,
            nbr_adultes,
            nbr_enfants,
            nbr_chambres
          };
        }
      }).then((result) => {
        if (result.isConfirmed) {
          this.verifyAvailability(result.value, heb);
        }
      });
    },
    async verifyAvailability(data, heb) {
      const { date_arr, date_dep, nbr_adultes, nbr_enfants, nbr_chambres } = data;
      console.log(date_arr, date_dep);
      try {
        const chambresResponse = await axios.get(`http://127.0.0.1:8000/api/chambres/heb/${heb.code_hb}`);
        const chambres = chambresResponse.data;

        const total_personnes = parseInt(nbr_adultes) + parseInt(nbr_enfants);
        const chambresDisponibles = chambres.filter((chambre) => {
          return chambre.disponibilite &&
            (total_personnes / nbr_chambres) <= chambre.nb_personnes_max;
        });

        if (chambresDisponibles.length) {
          let roomListHtml = '<ul>';
          chambresDisponibles.forEach(chambre => {
            roomListHtml += `
              <li>
                <input type="checkbox" id="chambre_${chambre.num_chambre}" data-prix="${chambre.prix_par_nuit}" class="chambre-checkbox">
                <label for="chambre_${chambre.num_chambre}">
                  Chambre ${chambre.num_chambre} - Max: ${chambre.nb_personnes_max} personnes - ${chambre.prix_par_nuit}€ / nuit
                </label>
              </li>`;
          });
          roomListHtml += '</ul>';

          Swal.fire({
            title: 'Chambres Disponibles',
            html: `
              ${roomListHtml}
              <p><strong>Total: </strong><span id="total_prix">0</span>€</p>
            `,
            confirmButtonText: 'Réserver',
            preConfirm: () => {
              const checkboxes = document.querySelectorAll('.chambre-checkbox:checked');
              const selectedChambres = Array.from(checkboxes).map(checkbox => {
                return {
                  num_chambre: checkbox.id.split('_')[1],
                  prix_par_nuit: parseFloat(checkbox.dataset.prix)
                };
              });
              if (!selectedChambres.length) {
                Swal.showValidationMessage('Veuillez sélectionner au moins une chambre.');
                return;
              }

              const dateArr = new Date(data.date_arr);
              const dateDep = new Date(data.date_dep);
              const nbrNuits = (dateDep - dateArr) / (1000 * 3600 * 24);

              return {
                selectedChambres,
                total: selectedChambres.reduce((sum, chambre) => sum + chambre.prix_par_nuit * nbrNuits, 0),
                nbrNuits
              };
            }
          }).then((result) => {
            if (result.isConfirmed) {
              this.finalizeReservation(result.value, data, heb);
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Aucune chambre disponible',
            text: 'Aucune chambre ne correspond aux critères sélectionnés.',
          });
        }
      } catch (error) {
        console.error('Erreur lors de la vérification des disponibilités:', error);
        Swal.fire({
          icon: 'error',
          title: 'Erreur',
          text: 'Une erreur est survenue lors de la vérification des disponibilités. Veuillez réessayer.',
        });
      }
    },
    async finalizeReservation({ selectedChambres, total, nbrNuits }, data, heb) {
  let roomPricingHtml = '<ul>';
  selectedChambres.forEach(chambre => {
    roomPricingHtml += `<li>Chambre ${chambre.num_chambre}: ${chambre.prix_par_nuit}€ / nuit * ${nbrNuits} nuits</li>`;
  });
  roomPricingHtml += `</ul><p>Total: ${total}€</p>`;

  Swal.fire({
    title: 'Confirmer la réservation',
    html: roomPricingHtml,
    showCancelButton: true,
    confirmButtonText: 'Confirmer',
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const user = JSON.parse(localStorage.getItem('user'));
        const clientIDCard = user ? user.IDCARD : null; 

        for (const chambre of selectedChambres) {
          const prixTotal = chambre.prix_par_nuit * nbrNuits;

          await axios.post('http://127.0.0.1:8000/api/reservations/', {
            client: clientIDCard,
            date_arr: data.date_arr,
            date_dep: data.date_dep,
            nbr_adultes: data.nbr_adultes,
            nbr_enfants: data.nbr_enfants,
            nbr_chambres: 1,
            code_hb: heb.code_hb,
            num_chambre: chambre.num_chambre,
            prix_total: prixTotal,
          });

          await axios.put(`http://127.0.0.1:8000/api/chambres/${chambre.num_chambre}`, {
            disponibilite: 0
          });
        }

        Swal.fire({
          icon: 'success',
          title: 'Réservation réussie',
          text: 'Votre réservation a été confirmée avec succès.',
        });
      } catch (error) {
        console.error('Erreur lors de la réservation:', error);
        Swal.fire({
          icon: 'error',
          title: 'Erreur',
          text: 'Une erreur est survenue lors de la réservation. Veuillez réessayer.',
        });
      }
    }
  });
}

  },
  async created() {
    await this.fetchHebergements();
  },
};
</script>

<style scoped>
.search-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f0f4f8;
  border-radius: 10px;
}

.search-input {
  width: 100%;
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.hebergements-list {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.hebergement-card {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
}

.hebergement-details {
  margin-bottom: 15px;
}

.hebergement-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.image-gallery {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.hebergement-image {
  width: 120px;
  height: 80px;
  object-fit: cover;
  border-radius: 6px;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.hebergement-image:hover {
  transform: scale(1.1);
}

.hebergement-actions {
  text-align: right;
}

.check-availability-button {
  background-color: #007bff;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.check-availability-button:hover {
  background-color: #0056b3;
}

.image-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.modal-image {
  max-width: 90%;
  max-height: 90%;
  border-radius: 10px;
}
</style>
