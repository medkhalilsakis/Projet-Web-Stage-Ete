<template>
    <div class="ajout-heberg">
      <h2>Ajouter un Hébergement</h2>
  
      <div v-if="successMessage" class="alert alert-success" role="alert">
        {{ successMessage }}
      </div>
  
      <div v-if="errorMessage" class="alert alert-danger" role="alert">
        {{ errorMessage }}
      </div>
  
      <form @submit.prevent="submitForm" class="form-container">
        <div class="form-row">
          <div class="form-group">
            <label for="code_hb">Code Hébergement</label>
            <input type="text" id="code_hb" v-model="formData.code_hb" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" v-model="formData.nom" class="form-control" required>
          </div>
        </div>
  
        <div class="form-row">
            <div class="form-group">
          <label for="type">Type</label>
          <select id="type" v-model="formData.type" class="form-control" required>
            <option value="" disabled selected>Choisir un type</option>
            <option value="hotel">Hôtel</option>
            <option value="maison">Maison</option>
            <option value="appartement">Appartement</option>
            <option value="villa">Villa</option>
          </select>
        </div>
          <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" v-model="formData.adresse" class="form-control" required>
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label for="nbr_de_chambres">Nombre de Chambres</label>
            <input type="number" id="nbr_de_chambres" v-model="formData.nbr_de_chambres" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="num_tel">Numéro de Téléphone</label>
            <input type="tel" id="num_tel" v-model="formData.num_tel" class="form-control">
          </div>
        </div>
  
        <div class="form-row">
          <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" v-model="formData.description" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="pts_forts">Points Forts (séparés par des virgules)</label>
            <textarea id="pts_forts" v-model="formData.pts_forts" class="form-control"></textarea>
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
  
  export default {
    data() {
      return {
        formData: {
          code_hb: '',
          nom: '',
          type: '',
          adresse: '',
          nbr_de_chambres: '',
          description: '',
          pts_forts: '',
          num_tel: '',
        },
        selectedFiles: [],
        images: [],
        successMessage: '',
        errorMessage: ''
      };
    },
    methods: {
      handleFileUpload(event) {
        const files = Array.from(event.target.files);
  
        this.selectedFiles = files.filter(file => {
          if (file.size <= 1024 * 1024) { 
            return true;
          } else {
            alert(`${file.name} est plus grand que 1MB et ne sera pas téléchargé.`);
            return false;
          }
        });
      },
  
      async uploadImages(code_hb) {
        if (this.selectedFiles.length === 0) {
          this.errorMessage = 'Veuillez sélectionner au moins une image valide.';
          return;
        }
  
        for (let i = 0; i < this.selectedFiles.length; i++) {
          const formData = new FormData();
          formData.append('image', this.selectedFiles[i]);
          formData.append('code_hb', code_hb);
  
          try {
            const response = await axios.post('http://127.0.0.1:8000/api/images', formData, {
              headers: {
                'Content-Type': 'multipart/form-data',
              },
            });
  
            const imagePath = this.imageUrl(response.data.path);
            this.images.push({
              name: response.data.name,
              url: imagePath
            });
  
          } catch (error) {
            console.error('Erreur lors du téléchargement de l\'image:', error);
            this.errorMessage = 'Échec du téléchargement de l\'image.';
          }
        }
        this.selectedFiles = [];
      },
  
      imageUrl(path) {
        return `http://127.0.0.1:8000/storage/uploads/images/${path}`;
      },
  
      async submitForm() {
        try {
          const response = await axios.post('http://127.0.0.1:8000/api/hebergements', this.formData);
          console.log(response.data);
          if (this.selectedFiles.length > 0) {
            await this.uploadImages(this.formData.code_hb);
          }
  
          this.successMessage = 'Hébergement ajouté avec succès.';
          this.errorMessage = '';
          this.resetForm();
        } catch (error) {
          console.error('Erreur lors de l\'ajout de l\'hébergement:', error);
          this.errorMessage = 'Une erreur est survenue lors de l\'ajout de l\'hébergement.';
          this.successMessage = '';
        }
      },
  
      resetForm() {
        this.formData = {
          code_hb: '',
          nom: '',
          type: '',
          adresse: '',
          nbr_de_chambres: '',
          description: '',
          pts_forts: '',
          num_tel: '',
        };
        this.selectedFiles = [];
        this.images = [];
      }
    }
  };
  </script>
  
  <style scoped>
  .ajout-heberg {
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
  