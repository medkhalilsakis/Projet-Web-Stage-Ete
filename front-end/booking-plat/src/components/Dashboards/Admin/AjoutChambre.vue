<template>
    <div class="ajout-chambre">
      <h2>Ajouter une Chambre</h2>
  
      <div v-if="successMessage" class="alert alert-success" role="alert">
        {{ successMessage }}
      </div>
  
      <div v-if="errorMessage" class="alert alert-danger" role="alert">
        {{ errorMessage }}
      </div>
  
      <form @submit.prevent="submitForm" class="form-container">
        <div class="form-row">
          <div class="form-group">
            <label for="num_chambre">Numéro de Chambre</label>
            <input type="text" id="num_chambre" v-model="formData.num_chambre" class="form-control" required>
          </div>
          <div class="form-group">
          <label for="code_hb">Hébergement</label>
          <select id="code_hb" v-model="formData.code_hb" class="form-control" required>
            <option value="" disabled selected>Choisir un hébergement</option>
            <option v-for="hebergement in hebergements" :key="hebergement.code_hb" :value="hebergement.code_hb">
              {{ hebergement.nom }}
            </option>
          </select>
        </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label for="disponibilite">Disponibilité</label>
            <select id="disponibilite" v-model="formData.disponibilite" class="form-control" required>
              <option value="" disabled selected>Choisir une disponibilité</option>
              <option value="1">Disponible</option>
              <option value="0">Non Disponible</option>
            </select>
          </div>
          <div class="form-group">
            <label for="prix_par_nuit">Prix par Nuit</label>
            <input type="number" id="prix_par_nuit" v-model="formData.prix_par_nuit" class="form-control" step="0.01" required>
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label for="nb_personnes_max">Nombre de Personnes Maximum</label>
            <input type="number" id="nb_personnes_max" v-model="formData.nb_personnes_max" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" v-model="formData.description" class="form-control"></textarea>
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label for="images">Images</label>
            <input type="file" id="images" class="form-control" multiple @change="handleFileUpload">
          </div>
        </div>
  
        <button type="submit" class="btn btn-primary">Ajouter</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        formData: {
          num_chambre: '',
          code_hb: '',
          disponibilite: '',
          prix_par_nuit: '',
          nb_personnes_max: '',
          description: ''
        },
        hebergements: [],
        selectedFiles: [],
        successMessage: '',
        errorMessage: ''
      };
    },
    methods: {
      async fetchHebergements() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/hebergements');
        this.hebergements = response.data; 
      } catch (error) {
        console.error('Erreur lors de la récupération des hébergements:', error);
        this.errorMessage = 'Une erreur est survenue lors de la récupération des hébergements.';
      }
    },

      handleFileUpload(event) {
        const files = Array.from(event.target.files);
  
        this.selectedFiles = files.filter(file => {
          if (file.size <= 1024 * 1024) { 
            return true;
          } else {
            Swal.fire('Erreur', `${file.name} est plus grand que 1MB et ne sera pas téléchargé.`, 'error');
            return false;
          }
        });
      },
  
      async uploadImages(num_chambre) {
        if (this.selectedFiles.length === 0) {
          this.errorMessage = 'Veuillez sélectionner au moins une image valide.';
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
  
            console.log(response.data);
          } catch (error) {
            console.error('Erreur lors du téléchargement de l\'image:', error);
            this.errorMessage = 'Échec du téléchargement de l\'image.';
          }
        }
        this.selectedFiles = [];
      },
  
      async submitForm() {
        try {
          const response = await axios.post('http://127.0.0.1:8000/api/chambres', this.formData);
          console.log(response.data);
  
          if (this.selectedFiles.length > 0) {
            await this.uploadImages(this.formData.num_chambre);
          }
  
          this.successMessage = 'Chambre ajoutée avec succès.';
          this.errorMessage = '';
          this.resetForm();
        } catch (error) {
          console.error('Erreur lors de l\'ajout de la chambre:', error);
          this.errorMessage = 'Une erreur est survenue lors de l\'ajout de la chambre.';
          this.successMessage = '';
        }
      },
  
      resetForm() {
        this.formData = {
          num_chambre: '',
          code_hb: '',
          disponibilite: '',
          prix_par_nuit: '',
          nb_personnes_max: '',
          description: ''
        };
        this.selectedFiles = [];
      }
    },
    mounted() {
      this.fetchHebergements();
    }
  };
  </script>
  
  <style scoped>
  .ajout-chambre {
    max-width: 900px;
    margin: 40px auto;
    padding: 30px;
    background: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  }
  
  h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 2rem;
    color: #333;
  }
  
  .form-container {
    display: flex;
    flex-direction: column;
  }
  
  .form-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  
  .form-group {
    flex: 0 0 48%;
  }
  
  .form-control {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
  }
  
  textarea.form-control {
    resize: none;
    height: 100px;
  }
  
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 12px 20px;
    color: white;
    border-radius: 6px;
    font-size: 1.2rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
  }
  </style>
  