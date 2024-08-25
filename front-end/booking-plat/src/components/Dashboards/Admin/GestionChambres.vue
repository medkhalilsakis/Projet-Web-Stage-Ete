<template>
  <div class="container">
    <div class="search-bar">
      <label for="hebergement-select">Hébergement:</label>
      <select v-model="selectedHebergement" @change="fetchChambres" class="hebergement-select">
        <option v-for="hebergement in hebergements" :key="hebergement.code_hb" :value="hebergement.code_hb">
          {{ hebergement.code_hb }} - {{ hebergement.nom }}
        </option>
      </select>
    </div>

    <div v-if="chambres.length > 0" class="chambre-list">
      <h3>Chambres pour {{ selectedHebergement }}:</h3>
      <ul class="chambre-ul">
        <li v-for="chambre in chambres" :key="chambre.num_chambre" class="chambre-item">
          <div class="chambre-info">
            <strong>Chambre {{ chambre.num_chambre }}</strong>
            <p>{{ chambre.description }}</p>
            <p><span class="prix">{{ chambre.prix_par_nuit }}€/nuit</span></p>
            <div :style="{ color: chambre.disponibilite ? 'green' : 'red' }">
              {{ chambre.disponibilite ? 'Disponible' : 'Non disponible' }}
            </div>

            <div v-if="chambre.images && chambre.images.length > 0" class="chambre-images">
              <div v-for="image in chambre.images" :key="image.id" class="image-container">
                <img :src="imageUrl(image.path)" :alt="'Image of ' + chambre.num_chambre" class="chambre-image"/>
                <button class="btn delete-btn" @click="deleteImage(chambre.num_chambre, image.id)">
                  <img src="https://i.imgur.com/nKwRyAd.png" alt="Delete" class="delete-icon">
                </button>
              </div>
            </div>
            <div class="chambre-actions">
              <button @click="editChambre(chambre.num_chambre)" class="btn-edit">Edit</button>
              <button @click="deleteChambre(chambre.num_chambre)" class="btn-delete">Delete</button>
              <span>
              <button class="btn btn-success btn-sm action-btn" @click="triggerFileInput(chambre.num_chambre)">
              Add images
            </button>
            <input
              type="file"
              :id="'fileInput-' + chambre.num_chambre"
              @change="handleFileUpload($event, chambre.num_chambre)"
              style="display: none"
              multiple
            >
            </span>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div v-else class="no-chambres">
      <p>Aucune chambre trouvée pour cet hébergement.</p>
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
      selectedHebergement: '',
      chambres: [],
      selectedFiles: [],
    };
  },
  methods: {
    fetchHebergements() {
      fetch('http://127.0.0.1:8000/api/hebergements')
        .then(response => response.json())
        .then(data => {
          this.hebergements = data;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des hébergements:', error);
        });
    },
    fetchChambres() {
      if (this.selectedHebergement) {
        fetch(`http://127.0.0.1:8000/api/chambres/heb/${this.selectedHebergement}`)
          .then(response => response.json())
          .then(data => {
            this.chambres = data;
            this.chambres.forEach(chambre => {
              fetch(`http://127.0.0.1:8000/api/images/chambre/${chambre.num_chambre}`)
                .then(response => response.json())
                .then(images => {
                  chambre.images = images;
                })
                .catch(error => {
                  console.error('Erreur lors de la récupération des images:', error);
                });
            });
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des chambres:', error);
          });
      }
    },
    async editChambre(num_chambre) {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/chambres/${num_chambre}`);
    const chambre = response.data;

    const { value: formValues } = await Swal.fire({
      title: 'Modifier la chambre',
      html:
      `<div>
        <label for="swal-input2">Disponibilité :</label><br>
        <input type="radio" id="disponible" name="disponibilite" value="1" ${chambre.disponibilite ? 'checked' : ''}>
        <label for="disponible">Disponible</label><br>
        <input type="radio" id="non_disponible" name="disponibilite" value="0" ${!chambre.disponibilite ? 'checked' : ''}>
        <label for="non_disponible">Non disponible</label>
      </div>` +
        `<input type="number" step="0.01" id="swal-input3" class="swal2-input" placeholder="Prix par nuitée" value="${chambre.prix_par_nuit}">` +
        `<input type="number" id="swal-input4" class="swal2-input" placeholder="Nombre de personnes max" value="${chambre.nb_personnes_max}">` +
        `<textarea id="swal-input5" class="swal2-textarea" placeholder="Description">${chambre.description}</textarea>`,
      focusConfirm: false,
      preConfirm: () => {
        const disponibilite = document.querySelector('input[name="disponibilite"]:checked').value;
      return {
        disponibilite: disponibilite === '1',
          prix_par_nuit: document.getElementById('swal-input3').value,
          nb_personnes_max: document.getElementById('swal-input4').value,
          description: document.getElementById('swal-input5').value,
        }
      }
    });

    if (formValues) {
      const updatedValues = {
        disponibilite: formValues.disponibilite,
        prix_par_nuit: parseFloat(formValues.prix_par_nuit),
        nb_personnes_max: parseInt(formValues.nb_personnes_max, 10),
        description: formValues.description
      };


      await axios.put(`http://127.0.0.1:8000/api/chambres/${num_chambre}`, updatedValues);

      Swal.fire('Chambre mise à jour avec succès!', '', 'success');
      this.fetchChambres(); 
      
    }

  } catch (error) {
    console.error('Erreur lors de la modification de la chambre:', error);
    Swal.fire('Erreur lors de la mise à jour de la chambre.', '', 'error');
  }
},
    async deleteChambre(num_chambre) {
    try {
      const imagesExistResponse = await axios.get(`http://127.0.0.1:8000/api/images/existence2/${num_chambre}`);
      const hasImages = imagesExistResponse.data.exists;


      if (hasImages) {

        await axios.delete(`http://127.0.0.1:8000/api/images/deletebyID2/${num_chambre}`);
      }

      await axios.delete(`http://127.0.0.1:8000/api/chambres/${num_chambre}`);

      this.fetchChambres();

      alert('Chambre et images supprimées avec succès !');
    } catch (error) {
      console.error('Erreur lors de la suppression:', error);
      alert('Échec de la suppression.');
    }
  },
    openFileDialog(num_chambre) {
      this.$refs.fileInput.click();
      this.currentChambre = num_chambre; 
    },
    triggerFileInput(num_chambre) {
      this.currentNumCh = num_chambre;
      document.getElementById(`fileInput-${num_chambre}`).click();
    },
    handleFileUpload(event, num_chambre) {
      const files = Array.from(event.target.files);
      this.selectedFiles = files.filter(file => file.size <= 1024 * 1024);

      if (this.selectedFiles.length > 0) {
        this.uploadImages(num_chambre);
      } else {
        alert('Please select files that are less than 1MB.');
      }
    },
    async uploadImages(num_chambre) {
      if (this.selectedFiles.length === 0) {
        alert('Please select at least one valid image.');
        return;
      }

      for (let i = 0; i < this.selectedFiles.length; i++) {
        const formData = new FormData();
        formData.append('image', this.selectedFiles[i]);
        formData.append('num_chambre', num_chambre);

        try {
          const response = await axios.post('http://127.0.0.1:8000/api/images', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          });

          const chambre = this.chambres.find(c => c.num_chambre === num_chambre);
          if (chambre) {
            chambre.images.push({
              id: response.data.id,
              path: response.data.path
            });
          }
        } catch (error) {
          console.error('Error uploading image:', error);
          alert('Failed to upload image.');
        }
      }

      alert('Images uploaded successfully!');
      this.selectedFiles = [];
      this.fetchChambres();
    },
    imageUrl(path) {
      return `http://127.0.0.1:8000/storage/uploads/images/${path}`;
    },
    deleteImage(num_chambre, imageId) {
      fetch(`http://127.0.0.1:8000/api/images/deletebyID/${imageId}`, {
        method: 'DELETE',
      })
        .then(response => response.json())
        .then(() => {
        
          const chambre = this.chambres.find(c => c.num_chambre === num_chambre);
          if (chambre) {
            chambre.images = chambre.images.filter(image => image.id !== imageId);
          }
        })
        .catch(error => {
          console.error('Erreur lors de la suppression de l\'image:', error);
        });
    }
  },
  mounted() {
    this.fetchHebergements();
  }
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.search-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

.search-bar label {
  font-size: 16px;
  font-weight: bold;
  color: #333;
}

.hebergement-select {
  width: 100%;
  padding: 10px;
  margin-left: 10px;
  font-size: 16px;
  border-radius: 4px;
  border: 1px solid #ddd;
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

.chambre-list {
  margin-top: 20px;
}

.chambre-ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.chambre-item {
  padding: 15px;
  margin-bottom: 10px;
  background-color: #fff;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
  position: relative;
}

.chambre-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.chambre-info {
  display: flex;
  flex-direction: column;
}

.chambre-info strong {
  font-size: 18px;
  color: #333;
}

.chambre-info p {
  margin: 5px 0;
  color: #666;
}

.prix {
  font-size: 16px;
  font-weight: bold;
  color: #27ae60;
}

.chambre-images {
  display: flex;
  gap: 10px;
  margin: 10px 0;
}

.chambre-image {
  width: 100px;
  height: 60px;
  object-fit: cover;
  border-radius: 4px;
}

.chambre-actions {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.chambre-actions button {
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  color: #fff;
  transition: background-color 0.3s;
}

.btn-edit {
  background-color: #3498db;
}

.btn-edit:hover {
  background-color: #2980b9;
}

.btn-delete {
  background-color: #e74c3c;
}

.btn-delete:hover {
  background-color: #c0392b;
}

.btn-add-images {
  background-color: #2ecc71;
}

.btn-add-images:hover {
  background-color: #27ae60;
}

.no-chambres {
  text-align: center;
  margin-top: 20px;
  font-size: 16px;
  color: #666;
}

.image-container {
  position: relative;
  display: inline-block;
}

.delete-btn {
  position: absolute;
  top: -10px;
  right: -10px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
}

.delete-icon {
  width: 20px;
  height: 20px;
}

.chambre-images {
  display: flex;
  gap: 10px;
  margin: 10px 0;
}
</style>
